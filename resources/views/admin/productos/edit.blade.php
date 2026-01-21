<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Producto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.productos.update', $producto) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Nombre -->
                        <div class="mb-4">
                            <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre del Producto *</label>
                            <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $producto->nombre) }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            @error('nombre')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Descripción -->
                        <div class="mb-4">
                            <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                            <textarea name="descripcion" id="descripcion" rows="3" 
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('descripcion', $producto->descripcion) }}</textarea>
                        </div>

                        <!-- Precio y Stock -->
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="precio" class="block text-sm font-medium text-gray-700">Precio (S/.) *</label>
                                <input type="number" step="0.01" name="precio" id="precio" value="{{ old('precio', $producto->precio) }}" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            </div>
                            <div>
                                <label for="stock" class="block text-sm font-medium text-gray-700">Stock *</label>
                                <input type="number" name="stock" id="stock" value="{{ old('stock', $producto->stock) }}" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            </div>
                        </div>

                        <!-- Categoría, Sabor, Tamaño -->
                        <div class="grid grid-cols-3 gap-4 mb-4">
                            <div>
                                <label for="categoria" class="block text-sm font-medium text-gray-700">Categoría</label>
                                <select name="categoria" id="categoria" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Seleccionar</option>
                                    <option value="Cremosos" {{ old('categoria', $producto->categoria) == 'Cremosos' ? 'selected' : '' }}>Cremosos</option>
                                    <option value="Frutales" {{ old('categoria', $producto->categoria) == 'Frutales' ? 'selected' : '' }}>Frutales</option>
                                    <option value="Premium" {{ old('categoria', $producto->categoria) == 'Premium' ? 'selected' : '' }}>Premium</option>
                                    <option value="Individual" {{ old('categoria', $producto->categoria) == 'Individual' ? 'selected' : '' }}>Individual</option>
                                </select>
                            </div>
                            <div>
                                <label for="sabor" class="block text-sm font-medium text-gray-700">Sabor</label>
                                <input type="text" name="sabor" id="sabor" value="{{ old('sabor', $producto->sabor) }}" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="tamano" class="block text-sm font-medium text-gray-700">Tamaño</label>
                                <input type="text" name="tamano" id="tamano" value="{{ old('tamano', $producto->tamano) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>

                        <!-- Imagen actual -->
                        @if($producto->imagen)
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Imagen Actual</label>
                                <img src="{{ asset('storage/productos/' . $producto->imagen) }}" alt="{{ $producto->nombre }}" class="w-32 h-32 object-cover rounded">
                            </div>
                        @endif

                        <!-- Nueva imagen -->
                        <div class="mb-4">
                            <label for="imagen" class="block text-sm font-medium text-gray-700">Nueva Imagen (opcional)</label>
                            <input type="file" name="imagen" id="imagen" accept="image/*" 
                                   class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            <span class="text-xs text-gray-500">Formatos: JPG, PNG, GIF. Máximo 2MB.</span>
                        </div>

                        <!-- Disponible -->
                        <div class="mb-4">
                            <label class="flex items-center">
                                <input type="checkbox" name="disponible" value="1" {{ old('disponible', $producto->disponible) ? 'checked' : '' }} 
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">Producto disponible</span>
                            </label>
                        </div>

                        <!-- Botones -->
                        <div class="flex items-center justify-end space-x-3">
                            <a href="{{ route('admin.productos.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                                Cancelar
                            </a>
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                Actualizar Producto
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
