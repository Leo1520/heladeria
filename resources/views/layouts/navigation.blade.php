<nav x-data="{ open: false }" style="background: linear-gradient(135deg, #1FB9A2 0%, #83D7D0 100%); margin: 0; padding: 0;" class="fixed top-0 left-0 w-full z-50 border-b border-white/20 shadow-lg">
    <!-- Primary Navigation Menu -->
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" style="margin-top: 0;">
        <div class="flex justify-between items-center h-20 w-full">
            <div class="flex items-center gap-10">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <img src="{{ asset('img/logoPrincipal.png') }}" alt="Heladería Santa Rosa" class="h-16 w-auto">
                        <span class="text-white font-bold text-2xl hidden sm:block drop-shadow-lg">Santa Rosa</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-6 sm:flex items-center">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home') || request()->routeIs('cliente.catalogo')" class="text-white hover:text-pink-200">
                        {{ __('Catálogo') }}
                    </x-nav-link>
                    
                    @auth
                        @if(auth()->user()->isCliente())
                            <x-nav-link :href="route('cliente.carrito.index')" :active="request()->routeIs('cliente.carrito.*')" class="text-white hover:text-pink-200">
                                {{ __('Mi Carrito') }}
                            </x-nav-link>
                            <x-nav-link :href="route('cliente.pedidos.index')" :active="request()->routeIs('cliente.pedidos.*')" class="text-white hover:text-pink-200">
                                {{ __('Mis Pedidos') }}
                            </x-nav-link>
                        @elseif(auth()->user()->isAdmin())
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="text-white hover:text-pink-200">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.productos.index')" :active="request()->routeIs('admin.productos.*')" class="text-white hover:text-pink-200">
                                {{ __('Productos') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.pedidos.index')" :active="request()->routeIs('admin.pedidos.*')" class="text-white hover:text-pink-200">
                                {{ __('Pedidos') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-white/30 text-sm leading-4 font-medium rounded-md text-white hover:bg-white/10 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
                @else
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}" class="text-white hover:text-pink-200 font-semibold">Iniciar sesión</a>
                        <a href="{{ route('register') }}" style="background-color: #D03994;" class="hover:opacity-90 text-white font-bold py-2 px-6 rounded-full shadow-lg transition">Registrarse</a>
                    </div>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                @guest
                    <div class="flex items-center space-x-3 mr-2">
                        <a href="{{ route('login') }}" class="text-sm text-white hover:text-pink-200 font-semibold">Login</a>
                        <a href="{{ route('register') }}" style="background-color: #D03994;" class="text-sm hover:opacity-90 text-white font-bold py-1 px-3 rounded-full">Registro</a>
                    </div>
                @endguest
                
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:bg-white/10 focus:outline-none focus:bg-white/10 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home') || request()->routeIs('cliente.catalogo')">
                {{ __('Catálogo') }}
            </x-responsive-nav-link>
            
            @auth
                @if(auth()->user()->isCliente())
                    <x-responsive-nav-link :href="route('cliente.carrito.index')" :active="request()->routeIs('cliente.carrito.*')">
                        {{ __('Mi Carrito') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('cliente.pedidos.index')" :active="request()->routeIs('cliente.pedidos.*')">
                        {{ __('Mis Pedidos') }}
                    </x-responsive-nav-link>
                @elseif(auth()->user()->isAdmin())
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.productos.index')" :active="request()->routeIs('admin.productos.*')">
                        {{ __('Productos') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.pedidos.index')" :active="request()->routeIs('admin.pedidos.*')">
                        {{ __('Pedidos') }}
                    </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        @auth
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
        @else
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4 space-y-2">
                <a href="{{ route('login') }}" class="block text-gray-700 hover:text-gray-900">Iniciar Sesión</a>
                <a href="{{ route('register') }}" class="block text-gray-700 hover:text-gray-900">Registrarse</a>
            </div>
        </div>
        @endauth
    </div>
</nav>
