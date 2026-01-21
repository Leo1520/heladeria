<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalle del Pedido #') }}{{ $pedido->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Estado del Pedido -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-semibold">Estado del Pedido</h3>
                        <p class="text-sm text-gray-600">Realizado el {{ $pedido->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <span class="px-4 py-2 text-lg rounded 
                        @if($pedido->estado == 'pendiente') bg-yellow-100 text-yellow-800
                        @elseif($pedido->estado == 'en_preparacion') bg-blue-100 text-blue-800
                        @elseif($pedido->estado == 'entregado') bg-green-100 text-green-800
                        @else bg-red-100 text-red-800 @endif">
                        {{ $pedido->estado_formateado }}
                    </span>
                </div>
            </div>

            <!-- Información de Entrega -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 p-6">
                <h3 class="text-lg font-semibold mb-4">Información de Entrega</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-600">Dirección:</p>
                        <p class="font-medium">{{ $pedido->direccion_entrega }}</p>
                        @if($pedido->referencia_direccion)
                            <p class="text-gray-600 mt-2">Referencia:</p>
                            <p class="font-medium">{{ $pedido->referencia_direccion }}</p>
                        @endif
                    </div>
                    <div>
                        <p class="text-gray-600">Teléfono de Contacto:</p>
                        <p class="font-medium">{{ $pedido->telefono_contacto }}</p>
                        <p class="text-gray-600 mt-2">Método de Pago:</p>
                        <p class="font-medium">{{ ucfirst($pedido->metodo_pago) }}</p>
                    </div>
                </div>
                @if($pedido->notas)
                    <div class="mt-4 p-3 bg-yellow-50 rounded">
                        <p class="text-sm font-medium">Notas:</p>
                        <p class="text-sm">{{ $pedido->notas }}</p>
                    </div>
                @endif
            </div>

            <!-- Detalles del Pedido -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Productos</h3>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Producto</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Precio</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cantidad</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($pedido->detalles as $detalle)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            @if($detalle->producto->imagen)
                                                <img src="{{ asset('storage/productos/' . $detalle->producto->imagen) }}" alt="{{ $detalle->producto->nombre }}" class="w-12 h-12 object-cover rounded mr-3">
                                            @endif
                                            <span>{{ $detalle->producto->nombre }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">S/. {{ number_format($detalle->precio_unitario, 2) }}</td>
                                    <td class="px-6 py-4">{{ $detalle->cantidad }}</td>
                                    <td class="px-6 py-4 font-semibold">S/. {{ number_format($detalle->subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                            <tr class="bg-gray-50 font-bold">
                                <td colspan="3" class="px-6 py-4 text-right text-lg">TOTAL:</td>
                                <td class="px-6 py-4 text-xl text-blue-600">S/. {{ number_format($pedido->total, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('cliente.pedidos.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                    Volver a Mis Pedidos
                </a>
                @if($pedido->estado == 'entregado')
                    <a href="{{ route('cliente.catalogo') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                        Hacer Nuevo Pedido
                    </a>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
