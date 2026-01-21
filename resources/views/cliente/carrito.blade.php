<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Mi Carrito de Compras') }}
            </h2>
            <a href="{{ route('cliente.catalogo') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                Seguir Comprando
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            @if(empty($carrito))
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-12 text-center">
                    <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <h3 class="mt-4 text-xl font-semibold text-gray-700">Tu carrito está vacío</h3>
                    <p class="mt-2 text-gray-500">Agrega productos desde nuestro catálogo</p>
                    <a href="{{ route('cliente.catalogo') }}" class="mt-6 inline-block px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                        Ver Catálogo
                    </a>
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Producto</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Precio</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cantidad</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($carrito as $item)
                                    <tr>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                @if($item['imagen'])
                                                    <img src="{{ asset('storage/productos/' . $item['imagen']) }}" alt="{{ $item['nombre'] }}" class="w-16 h-16 object-cover rounded mr-4">
                                                @endif
                                                <span>{{ $item['nombre'] }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">S/. {{ number_format($item['precio'], 2) }}</td>
                                        <td class="px-6 py-4">
                                            <form action="{{ route('cliente.carrito.actualizar', $item['id']) }}" method="POST" class="flex items-center gap-2">
                                                @csrf
                                                @method('PATCH')
                                                <input type="number" name="cantidad" value="{{ $item['cantidad'] }}" min="1" 
                                                       class="w-20 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                                <button type="submit" class="text-blue-600 hover:text-blue-900">Actualizar</button>
                                            </form>
                                        </td>
                                        <td class="px-6 py-4 font-semibold">S/. {{ number_format($item['precio'] * $item['cantidad'], 2) }}</td>
                                        <td class="px-6 py-4">
                                            <form action="{{ route('cliente.carrito.eliminar', $item['id']) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="bg-gray-50">
                                    <td colspan="3" class="px-6 py-4 text-right font-bold text-lg">TOTAL:</td>
                                    <td class="px-6 py-4 font-bold text-xl text-blue-600">S/. {{ number_format($total, 2) }}</td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="mt-6 flex justify-between items-center">
                            <form action="{{ route('cliente.carrito.vaciar') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600" onclick="return confirm('¿Vaciar el carrito?')">
                                    Vaciar Carrito
                                </button>
                            </form>

                            <a href="{{ route('cliente.pedidos.create') }}" class="px-6 py-3 bg-green-500 text-white rounded-lg hover:bg-green-600 font-semibold">
                                Procesar Pedido
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
