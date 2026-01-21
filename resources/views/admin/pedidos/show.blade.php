<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalle del Pedido #') }}{{ $pedido->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Información del Cliente -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Información del Cliente</h3>
                    <div class="space-y-2 text-sm">
                        <p><strong>Nombre:</strong> {{ $pedido->user->name }}</p>
                        <p><strong>Email:</strong> {{ $pedido->user->email }}</p>
                        <p><strong>Teléfono:</strong> {{ $pedido->telefono_contacto }}</p>
                    </div>
                </div>

                <!-- Información de Entrega -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Información de Entrega</h3>
                    <div class="space-y-2 text-sm">
                        <p><strong>Dirección:</strong> {{ $pedido->direccion_entrega }}</p>
                        @if($pedido->referencia_direccion)
                            <p><strong>Referencia:</strong> {{ $pedido->referencia_direccion }}</p>
                        @endif
                        <p><strong>Método de Pago:</strong> {{ ucfirst($pedido->metodo_pago) }}</p>
                    </div>
                </div>

                <!-- Información del Pedido -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Estado del Pedido</h3>
                    <form action="{{ route('admin.pedidos.updateEstado', $pedido) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <select name="estado" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 mb-3">
                            <option value="pendiente" {{ $pedido->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="en_preparacion" {{ $pedido->estado == 'en_preparacion' ? 'selected' : '' }}>En Preparación</option>
                            <option value="entregado" {{ $pedido->estado == 'entregado' ? 'selected' : '' }}>Entregado</option>
                            <option value="cancelado" {{ $pedido->estado == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                        </select>
                        <button type="submit" class="w-full px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            Actualizar Estado
                        </button>
                    </form>
                    <div class="mt-4 text-sm">
                        <p><strong>Fecha:</strong> {{ $pedido->created_at->format('d/m/Y H:i') }}</p>
                        <p><strong>Total:</strong> <span class="text-lg font-bold">S/. {{ number_format($pedido->total, 2) }}</span></p>
                    </div>
                </div>
            </div>

            <!-- Detalles del Pedido -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Productos del Pedido</h3>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Producto</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Precio Unit.</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cantidad</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($pedido->detalles as $detalle)
                                <tr>
                                    <td class="px-6 py-4">{{ $detalle->producto->nombre }}</td>
                                    <td class="px-6 py-4">S/. {{ number_format($detalle->precio_unitario, 2) }}</td>
                                    <td class="px-6 py-4">{{ $detalle->cantidad }}</td>
                                    <td class="px-6 py-4">S/. {{ number_format($detalle->subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                            <tr class="bg-gray-50 font-bold">
                                <td colspan="3" class="px-6 py-4 text-right">TOTAL:</td>
                                <td class="px-6 py-4">S/. {{ number_format($pedido->total, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>

                    @if($pedido->notas)
                        <div class="mt-4 p-4 bg-yellow-50 rounded">
                            <strong>Notas del cliente:</strong><br>
                            {{ $pedido->notas }}
                        </div>
                    @endif

                    <div class="mt-6">
                        <a href="{{ route('admin.pedidos.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                            Volver a la Lista
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
