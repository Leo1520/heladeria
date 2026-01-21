<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use App\Models\DetallePedido;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    /**
     * Mostrar historial de pedidos del cliente
     */
    public function index()
    {
        $pedidos = Pedido::where('user_id', auth()->id())
            ->with('detalles.producto')
            ->latest()
            ->paginate(10);
        
        return view('cliente.pedidos.index', compact('pedidos'));
    }

    /**
     * Mostrar formulario para crear pedido
     */
    public function create()
    {
        $carrito = session()->get('carrito', []);
        
        if (empty($carrito)) {
            return redirect()->route('cliente.catalogo')
                ->with('error', 'Tu carrito está vacío.');
        }
        
        $total = 0;
        foreach ($carrito as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }
        
        return view('cliente.pedidos.create', compact('carrito', 'total'));
    }

    /**
     * Procesar y crear el pedido
     */
    public function store(Request $request)
    {
        $request->validate([
            'direccion_entrega' => ['required', 'string', 'max:500'],
            'referencia_direccion' => ['nullable', 'string', 'max:255'],
            'telefono_contacto' => ['required', 'string', 'max:20'],
            'notas' => ['nullable', 'string', 'max:1000'],
            'metodo_pago' => ['required', 'in:efectivo,transferencia,tarjeta'],
        ]);
        
        $carrito = session()->get('carrito', []);
        
        if (empty($carrito)) {
            return redirect()->route('cliente.catalogo')
                ->with('error', 'Tu carrito está vacío.');
        }
        
        try {
            DB::beginTransaction();
            
            $total = 0;
            
            // Validar stock de todos los productos
            foreach ($carrito as $item) {
                $producto = Producto::find($item['id']);
                
                if (!$producto || !$producto->disponible) {
                    throw new \Exception("El producto {$item['nombre']} ya no está disponible.");
                }
                
                if ($producto->stock < $item['cantidad']) {
                    throw new \Exception("No hay suficiente stock de {$item['nombre']}. Stock disponible: {$producto->stock}");
                }
                
                $total += $producto->precio * $item['cantidad'];
            }
            
            // Crear el pedido
            $pedido = Pedido::create([
                'user_id' => auth()->id(),
                'estado' => 'pendiente',
                'total' => $total,
                'direccion_entrega' => $request->direccion_entrega,
                'referencia_direccion' => $request->referencia_direccion,
                'telefono_contacto' => $request->telefono_contacto,
                'notas' => $request->notas,
                'metodo_pago' => $request->metodo_pago,
            ]);
            
            // Crear detalles del pedido y reducir stock
            foreach ($carrito as $item) {
                $producto = Producto::find($item['id']);
                
                DetallePedido::create([
                    'pedido_id' => $pedido->id,
                    'producto_id' => $producto->id,
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $producto->precio,
                    'subtotal' => $producto->precio * $item['cantidad'],
                ]);
                
                // Reducir el stock
                $producto->decrement('stock', $item['cantidad']);
            }
            
            DB::commit();
            
            // Vaciar el carrito
            session()->forget('carrito');
            
            return redirect()->route('cliente.pedidos.show', $pedido)
                ->with('success', '¡Pedido realizado exitosamente! Número de pedido: ' . $pedido->id);
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Mostrar detalle de un pedido específico
     */
    public function show(Pedido $pedido)
    {
        // Verificar que el pedido pertenece al usuario autenticado
        if ($pedido->user_id !== auth()->id()) {
            abort(403, 'No tienes permiso para ver este pedido.');
        }
        
        $pedido->load('detalles.producto');
        
        return view('cliente.pedidos.show', compact('pedido'));
    }
}
