<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use Illuminate\Http\Request;

class AdminPedidoController extends Controller
{
    /**
     * Mostrar todos los pedidos
     */
    public function index(Request $request)
    {
        $query = Pedido::with(['user', 'detalles.producto'])->latest();
        
        // Filtrar por estado si se proporciona
        if ($request->has('estado') && $request->estado != '') {
            $query->where('estado', $request->estado);
        }
        
        $pedidos = $query->paginate(15);
        
        return view('admin.pedidos.index', compact('pedidos'));
    }

    /**
     * Mostrar detalle de un pedido
     */
    public function show(Pedido $pedido)
    {
        $pedido->load(['user', 'detalles.producto']);
        return view('admin.pedidos.show', compact('pedido'));
    }

    /**
     * Actualizar el estado de un pedido
     */
    public function updateEstado(Request $request, Pedido $pedido)
    {
        $request->validate([
            'estado' => ['required', 'in:pendiente,en_preparacion,entregado,cancelado']
        ]);
        
        $pedido->update([
            'estado' => $request->estado
        ]);
        
        return redirect()->route('admin.pedidos.show', $pedido)
            ->with('success', 'Estado del pedido actualizado exitosamente.');
    }
}
