<x-app-layout>
    <x-slot name="header">
        <div style="background: linear-gradient(135deg, #1FB9A2 0%, #83D7D0 100%);" class="px-4 sm:px-6 lg:px-8 py-6 shadow-lg">
            <div class="max-w-7xl mx-auto flex justify-between items-center flex-wrap gap-4">
                <div>
                    <h2 class="font-bold text-3xl text-white leading-tight drop-shadow-lg">🛒 Mi Carrito</h2>
                    <p class="text-white/90 text-sm mt-1">Revisa tus productos antes de finalizar</p>
                </div>
                <a href="{{ route('cliente.catalogo') }}" class="text-white font-bold py-2 px-6 rounded-full shadow-lg hover:shadow-xl transition-all" style="background-color: #D03994;">
                    ← Seguir Comprando
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="border-2 text-white px-6 py-4 rounded-lg mb-4 shadow-lg" style="background-color: #1FB9A2; border-color: #83D7D0;">
                    ✓ {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border-2 border-red-400 text-red-700 px-6 py-4 rounded-lg mb-4 shadow-lg">
                    ✗ {{ session('error') }}
                </div>
            @endif

            @if(empty($carrito))
                <div class="bg-white/80 backdrop-blur overflow-hidden shadow-xl sm:rounded-2xl p-12 text-center">
                    <div class="text-8xl mb-4">🛒</div>
                    <h3 class="mt-4 text-2xl font-bold" style="color: #1FB9A2;">Tu carrito está vacío</h3>
                    <p class="mt-2 text-gray-600 text-lg">Agrega deliciosos helados desde nuestro catálogo</p>
                    <a href="{{ route('cliente.catalogo') }}" class="mt-8 inline-block text-white font-bold py-3 px-8 rounded-full shadow-lg hover:shadow-xl transition-all" style="background-color: #D03994;">
                        Ver Catálogo 🍦
                    </a>
                </div>
            @else
                <div class="bg-white/80 backdrop-blur overflow-hidden shadow-xl sm:rounded-2xl">
                    <div class="p-6">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead style="background-color: #ECCFD8;">
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-bold uppercase" style="color: #819985;">Producto</th>
                                    <th class="px-6 py-4 text-left text-sm font-bold uppercase" style="color: #819985;">Precio</th>
                                    <th class="px-6 py-4 text-left text-sm font-bold uppercase" style="color: #819985;">Cantidad</th>
                                    <th class="px-6 py-4 text-left text-sm font-bold uppercase" style="color: #819985;">Subtotal</th>
                                    <th class="px-6 py-4 text-left text-sm font-bold uppercase" style="color: #819985;">Acciones</th>
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
                                                <button type="submit" class="text-red-600 hover:text-red-800 font-semibold hover:underline">🗑️ Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr style="background: linear-gradient(135deg, #1FB9A2 0%, #83D7D0 100%);">
                                    <td colspan="3" class="px-6 py-4 text-right font-bold text-lg text-white">TOTAL:</td>
                                    <td class="px-6 py-4 font-bold text-2xl text-white">S/. {{ number_format($total, 2) }}</td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="mt-6 flex justify-between items-center">
                            <form action="{{ route('cliente.carrito.vaciar') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-6 py-2 bg-red-500 hover:bg-red-600 text-white font-bold rounded-lg shadow-lg transition-all" onclick="return confirm('¿Vaciar el carrito?')">
                                    🗑️ Vaciar Carrito
                                </button>
                            </form>

                            <a href="{{ route('cliente.pedidos.create') }}" class="text-white font-bold py-3 px-8 rounded-full shadow-lg hover:shadow-xl transition-all text-lg" style="background-color: #D03994;">
                                Finalizar Pedido 🎉
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
