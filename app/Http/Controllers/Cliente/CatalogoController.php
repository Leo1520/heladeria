<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;

class CatalogoController extends Controller
{
    /**
     * Mostrar catálogo de productos
     */
    public function index(Request $request)
    {
        $query = Producto::disponibles();
        
        // Filtrar por categoría si se proporciona
        if ($request->has('categoria') && $request->categoria != '') {
            $query->where('categoria', $request->categoria);
        }
        
        // Buscar por nombre
        if ($request->has('buscar') && $request->buscar != '') {
            $query->where('nombre', 'like', '%' . $request->buscar . '%');
        }
        
        $productos = $query->paginate(12);
        
        // Obtener categorías únicas para el filtro
        $categorias = Producto::distinct()->pluck('categoria');
        
        return view('cliente.catalogo', compact('productos', 'categorias'));
    }

    /**
     * Mostrar detalle de un producto
     */
    public function show(Producto $producto)
    {
        return view('cliente.producto', compact('producto'));
    }
}
