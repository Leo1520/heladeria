<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Confirmar Pedido') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Resumen del Pedido -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Resumen del Pedido</h3>
                    <div class="space-y-2">
                        @foreach($carrito as $item)
                            <div class="flex justify-between text-sm">
                                <span>{{ $item['nombre'] }} x{{ $item['cantidad'] }}</span>
                                <span>S/. {{ number_format($item['precio'] * $item['cantidad'], 2) }}</span>
                            </div>
                        @endforeach
                        <div class="border-t pt-2 flex justify-between font-bold text-lg">
                            <span>TOTAL:</span>
                            <span class="text-blue-600">S/. {{ number_format($total, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Formulario de Entrega -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Datos de Entrega</h3>
                    <form action="{{ route('cliente.pedidos.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="direccion_entrega" class="block text-sm font-medium text-gray-700">Dirección de Entrega *</label>
                            <textarea name="direccion_entrega" id="direccion_entrega" rows="3" required
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('direccion_entrega', auth()->user()->direccion) }}</textarea>
                            @error('direccion_entrega')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="referencia_direccion" class="block text-sm font-medium text-gray-700">Referencia</label>
                            <input type="text" name="referencia_direccion" id="referencia_direccion" value="{{ old('referencia_direccion') }}"
                                   placeholder="Ej: Casa azul, frente al parque"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div class="mb-4">
                            <label for="telefono_contacto" class="block text-sm font-medium text-gray-700">Teléfono de Contacto *</label>
                            <input type="text" name="telefono_contacto" id="telefono_contacto" value="{{ old('telefono_contacto', auth()->user()->telefono) }}" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('telefono_contacto')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="metodo_pago" class="block text-sm font-medium text-gray-700">Método de Pago *</label>
                            <select name="metodo_pago" id="metodo_pago" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="efectivo">Efectivo</option>
                                <option value="transferencia">Transferencia Bancaria</option>
                                <option value="tarjeta">Tarjeta</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="notas" class="block text-sm font-medium text-gray-700">Notas Adicionales</label>
                            <textarea name="notas" id="notas" rows="2"
                                      placeholder="Instrucciones especiales para tu pedido"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('notas') }}</textarea>
                        </div>

                        <div class="flex gap-3">
                            <a href="{{ route('cliente.carrito.index') }}" class="flex-1 px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 text-center">
                                Volver al Carrito
                            </a>
                            <button type="submit" class="flex-1 px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 font-semibold">
                                Confirmar Pedido
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
