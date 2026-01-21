<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis Pedidos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @forelse($pedidos as $pedido)
                        <div class="border rounded-lg p-4 mb-4 hover:shadow-md transition">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h3 class="font-semibold text-lg">Pedido #{{ $pedido->id }}</h3>
                                    <p class="text-sm text-gray-600">{{ $pedido->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                                <span class="px-3 py-1 text-sm rounded 
                                    @if($pedido->estado == 'pendiente') bg-yellow-100 text-yellow-800
                                    @elseif($pedido->estado == 'en_preparacion') bg-blue-100 text-blue-800
                                    @elseif($pedido->estado == 'entregado') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ $pedido->estado_formateado }}
                                </span>
                            </div>

                            <div class="border-t pt-3">
                                <div class="grid grid-cols-2 gap-4 text-sm mb-3">
                                    <div>
                                        <span class="text-gray-600">Productos:</span>
                                        <ul class="mt-1">
                                            @foreach($pedido->detalles as $detalle)
                                                <li>{{ $detalle->producto->nombre }} x{{ $detalle->cantidad }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Entrega:</span>
                                        <p class="mt-1">{{ $pedido->direccion_entrega }}</p>
                                    </div>
                                </div>

                                <div class="flex justify-between items-center pt-3 border-t">
                                    <span class="text-xl font-bold text-blue-600">Total: S/. {{ number_format($pedido->total, 2) }}</span>
                                    <a href="{{ route('cliente.pedidos.show', $pedido) }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                        Ver Detalle
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 text-gray-500">
                            <p class="text-lg mb-4">No tienes pedidos aún</p>
                            <a href="{{ route('cliente.catalogo') }}" class="inline-block px-6 py-3 bg-blue-500 text-white rounded hover:bg-blue-600">
                                Ver Catálogo
                            </a>
                        </div>
                    @endforelse

                    <div class="mt-6">
                        {{ $pedidos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
