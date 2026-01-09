<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cocinar Nuevo Plato') }} 🍳
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('dishes.store') }}" method="POST">
                        @csrf

                        {{-- Nombre del Plato --}}
                        <div class="mb-6">
                            <label class="block font-medium text-sm text-gray-700">Nombre del Plato</label>
                            <input type="text" name="name" placeholder="Ej: Pollo con Arroz y Verduras" required 
                                   class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                        </div>

                        <hr class="my-6">
                        
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Ingredientes</h3>
                            <button type="button" id="add-ingredient-btn" 
                                    class="bg-green-500 hover:bg-green-600 text-white text-sm font-bold py-2 px-3 rounded">
                                + Añadir Ingrediente
                            </button>
                        </div>

                        {{-- Contenedor donde se añadirán las filas --}}
                        <div id="ingredients-container" class="space-y-4">
                            {{-- Fila Inicial (Obligatoria al menos una) --}}
                            <div class="ingredient-row flex gap-4 items-end bg-gray-50 p-3 rounded">
                                <div class="flex-grow">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Producto</label>
                                    <select name="products[]" required class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                                        <option value="">-- Selecciona un ingrediente --</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}">
                                                {{ $product->name }} ({{ $product->calories }} kcal/100g)
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="w-32">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Gramos</label>
                                    <input type="number" name="amounts[]" placeholder="Ej: 100" required 
                                           class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                                </div>

                                <div>
                                    {{-- El botón de eliminar de la primera fila está deshabilitado o oculto --}}
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end mt-8">
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 font-bold">
                                Guardar Plato
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    {{-- Script para añadir/quitar filas --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('ingredients-container');
            const addBtn = document.getElementById('add-ingredient-btn');

            // Plantilla de la fila que vamos a clonar
            // Usamos la primera fila como base
            const rowTemplate = container.querySelector('.ingredient-row').cloneNode(true);
            
            // Limpiamos los valores de la plantilla para que al clonar salgan vacíos
            rowTemplate.querySelector('select').value = '';
            rowTemplate.querySelector('input').value = '';
            
            // Añadimos el botón de borrar a la plantilla (que la primera no tenía)
            const removeBtnHtml = `
                <button type="button" class="remove-row-btn text-red-500 hover:text-red-700 font-bold px-2 py-1">
                    🗑️
                </button>
            `;
            // Insertamos el botón de borrar en el último div vacío de la plantilla
            rowTemplate.lastElementChild.innerHTML = removeBtnHtml;

            // Click en "Añadir Ingrediente"
            addBtn.addEventListener('click', function() {
                const newRow = rowTemplate.cloneNode(true);
                container.appendChild(newRow);
            });

            // Delegación para borrar filas (porque los botones se crean dinámicamente)
            container.addEventListener('click', function(e) {
                if (e.target.closest('.remove-row-btn')) {
                    e.target.closest('.ingredient-row').remove();
                }
            });
        });
    </script>
</x-app-layout>