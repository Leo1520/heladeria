<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Administrador') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <!-- Total Ventas -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-600 text-sm">Total Ventas</div>
                    <div class="text-3xl font-bold text-blue-600">
                        S/. {{ number_format(\App\Models\Pedido::sum('total'), 2) }}
                    </div>
                </div>

                <!-- Pedidos Pendientes -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-600 text-sm">Pedidos Pendientes</div>
                    <div class="text-3xl font-bold text-yellow-600">
                        {{ \App\Models\Pedido::where('estado', 'pendiente')->count() }}
                    </div>
                </div>

                <!-- Total Productos -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-600 text-sm">Total Productos</div>
                    <div class="text-3xl font-bold text-green-600">
                        {{ \App\Models\Producto::count() }}
                    </div>
                </div>

                <!-- Clientes Registrados -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-600 text-sm">Clientes</div>
                    <div class="text-3xl font-bold text-purple-600">
                        {{ \App\Models\User::where('rol', 'cliente')->count() }}
                    </div>
                </div>
            </div>

            <!-- Accesos rápidos -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Gestión de Productos -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Gestión de Productos</h3>
                    <div class="space-y-2">
                        <a href="{{ route('admin.productos.index') }}" class="block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 text-center">
                            Ver Todos los Productos
                        </a>
                        <a href="{{ route('admin.productos.create') }}" class="block px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 text-center">
                            Agregar Nuevo Producto
                        </a>
                    </div>
                </div>

                <!-- Gestión de Pedidos -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Gestión de Pedidos</h3>
                    <div class="space-y-2">
                        <a href="{{ route('admin.pedidos.index') }}" class="block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 text-center">
                            Ver Todos los Pedidos
                        </a>
                        <a href="{{ route('admin.pedidos.index', ['estado' => 'pendiente']) }}" class="block px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-center">
                            Ver Pedidos Pendientes
                        </a>
                    </div>
                </div>
            </div>

            <!-- Productos más vendidos -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mt-6">
                <h3 class="text-lg font-semibold mb-4">Productos Más Vendidos</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Producto</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Categoría</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Vendidos</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php
                                $masVendidos = \App\Models\DetallePedido::with('producto')
                                    ->select('producto_id', \DB::raw('SUM(cantidad) as total_vendido'))
                                    ->groupBy('producto_id')
                                    ->orderBy('total_vendido', 'desc')
                                    ->take(5)
                                    ->get();
                            @endphp
                            @forelse($masVendidos as $detalle)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $detalle->producto->nombre }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $detalle->producto->categoria }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $detalle->total_vendido }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $detalle->producto->stock }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">No hay ventas registradas</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
