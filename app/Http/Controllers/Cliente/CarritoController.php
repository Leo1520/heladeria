<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;

class CarritoController extends Controller
{
    /**
     * Mostrar el carrito de compras
     */
    public function index()
    {
        $carrito = session()->get('carrito', []);
        $total = 0;
        
        foreach ($carrito as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }
        
        return view('cliente.carrito', compact('carrito', 'total'));
    }

    /**
     * Agregar producto al carrito
     */
    public function agregar(Request $request, Producto $producto)
    {
        $request->validate([
            'cantidad' => ['required', 'integer', 'min:1', 'max:' . $producto->stock]
        ]);
        
        if (!$producto->disponible || $producto->stock < 1) {
            return back()->with('error', 'El producto no está disponible.');
        }
        
        $carrito = session()->get('carrito', []);
        
        // Si el producto ya existe en el carrito, actualizar cantidad
        if (isset($carrito[$producto->id])) {
            $nuevaCantidad = $carrito[$producto->id]['cantidad'] + $request->cantidad;
            
            if ($nuevaCantidad > $producto->stock) {
                return back()->with('error', 'No hay suficiente stock disponible.');
            }
            
            $carrito[$producto->id]['cantidad'] = $nuevaCantidad;
        } else {
            // Agregar nuevo producto al carrito
            $carrito[$producto->id] = [
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'precio' => $producto->precio,
                'cantidad' => $request->cantidad,
                'imagen' => $producto->imagen,
            ];
        }
        
        session()->put('carrito', $carrito);
        
        return back()->with('success', 'Producto agregado al carrito.');
    }

    /**
     * Actualizar cantidad de producto en el carrito
     */
    public function actualizar(Request $request, Producto $producto)
    {
        $request->validate([
            'cantidad' => ['required', 'integer', 'min:1', 'max:' . $producto->stock]
        ]);
        
        $carrito = session()->get('carrito', []);
        
        if (isset($carrito[$producto->id])) {
            $carrito[$producto->id]['cantidad'] = $request->cantidad;
            session()->put('carrito', $carrito);
        }
        
        return back()->with('success', 'Carrito actualizado.');
    }

    /**
     * Eliminar producto del carrito
     */
    public function eliminar(Producto $producto)
    {
        $carrito = session()->get('carrito', []);
        
        if (isset($carrito[$producto->id])) {
            unset($carrito[$producto->id]);
            session()->put('carrito', $carrito);
        }
        
        return back()->with('success', 'Producto eliminado del carrito.');
    }

    /**
     * Vaciar el carrito completo
     */
    public function vaciar()
    {
        session()->forget('carrito');
        return back()->with('success', 'Carrito vaciado.');
    }
}
