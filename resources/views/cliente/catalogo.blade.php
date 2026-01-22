<x-app-layout>
    <x-slot name="header">
        <div style="background: linear-gradient(135deg, #1FB9A2 0%, #83D7D0 100%);" class="-mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8 py-8">
            <div class="max-w-7xl mx-auto text-center">
                <h1 class="text-4xl font-bold text-white mb-2">🍦 Bienvenido a Heladería Santa Rosa</h1>
                <p class="text-white/90 text-lg">Los mejores helados artesanales de la ciudad</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12" style="background-color: #ECCFD8;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Barra de búsqueda y filtros -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 p-6">
                <form method="GET" action="{{ route('cliente.catalogo') }}" class="flex flex-col md:flex-row gap-4">
                    <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar helado..." 
                           class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <select name="categoria" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Todas las categorías</option>
                        @foreach($categorias as $cat)
                            <option value="{{ $cat }}" {{ request('categoria') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                        Buscar
                    </button>
                </form>
            </div>

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

            <!-- Grid de productos -->
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($productos as $producto)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        @if($producto->imagen)
                            <img src="{{ asset('storage/productos/' . $producto->imagen) }}" alt="{{ $producto->nombre }}" 
                                 class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-400">Sin imagen</span>
                            </div>
                        @endif
                        
                        <div class="p-4">
                            <h3 class="font-semibold text-lg mb-2">{{ $producto->nombre }}</h3>
                            @if($producto->categoria)
                                <span class="inline-block px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded mb-2">
                                    {{ $producto->categoria }}
                                </span>
                            @endif
                            <p class="text-gray-600 text-sm mb-2 line-clamp-2">{{ $producto->descripcion }}</p>
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-2xl font-bold text-blue-600">S/. {{ number_format($producto->precio, 2) }}</span>
                                <span class="text-sm text-gray-500">Stock: {{ $producto->stock }}</span>
                            </div>
                            
                            @if($producto->stock > 0)
                                @auth
                                    <form action="{{ route('cliente.carrito.agregar', $producto) }}" method="POST">
                                        @csrf
                                        <div class="flex gap-2">
                                            <input type="number" name="cantidad" value="1" min="1" max="{{ $producto->stock }}" 
                                                   class="w-20 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                            <button type="submit" class="flex-1 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                                Agregar
                                            </button>
                                        </div>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="block w-full px-4 py-2 bg-green-500 text-white text-center rounded hover:bg-green-600">
                                        Iniciar sesión para comprar
                                    </a>
                                @endauth
                            @else
                                <button disabled class="w-full px-4 py-2 bg-gray-300 text-gray-500 rounded cursor-not-allowed">
                                    Agotado
                                </button>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 text-gray-500">
                        No se encontraron productos disponibles
                    </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $productos->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
