<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Nuevo Ingrediente') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('products.store') }}" method="POST">
                        @csrf

                        {{-- Nombre y Categoría --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Nombre del Alimento</label>
                                <input type="text" name="name" required class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700">Categoría</label>
                                <select name="category_id" required class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <hr class="my-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Información Nutricional (por 100g)</h3>

                        {{-- Macros Principales --}}
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Calorías (kcal)</label>
                                <input type="number" step="0.01" name="calories" required class="w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Proteínas (g)</label>
                                <input type="number" step="0.01" name="protein" required class="w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Carbohidratos (g)</label>
                                <input type="number" step="0.01" name="carbohydrates" required class="w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Grasa Total (g)</label>
                                <input type="number" step="0.01" name="fat" required class="w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                        </div>

                        {{-- Detalles de Grasas --}}
                        <div class="bg-gray-50 p-4 rounded-md mb-4">
                            <h4 class="text-sm font-bold text-gray-500 mb-2">Desglose de Grasas</h4>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <div>
                                    <label class="text-xs">Saturadas</label>
                                    <input type="number" step="0.01" name="saturated_fat" value="0" class="w-full text-sm rounded-md border-gray-300">
                                </div>
                                <div>
                                    <label class="text-xs">Monoinsaturadas</label>
                                    <input type="number" step="0.01" name="monounsaturated_fat" value="0" class="w-full text-sm rounded-md border-gray-300">
                                </div>
                                <div>
                                    <label class="text-xs">Poliinsaturadas</label>
                                    <input type="number" step="0.01" name="polyunsaturated_fat" value="0" class="w-full text-sm rounded-md border-gray-300">
                                </div>
                                <div>
                                    <label class="text-xs text-red-600">Trans</label>
                                    <input type="number" step="0.01" name="trans_fat" value="0" class="w-full text-sm rounded-md border-gray-300">
                                </div>
                            </div>
                        </div>

                        {{-- Otros --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Fibra (g)</label>
                                <input type="number" step="0.01" name="fiber" value="0" class="w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Colesterol (mg)</label>
                                <input type="number" step="0.01" name="cholesterol" value="0" class="w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Sodio (mg)</label>
                                <input type="number" step="0.01" name="sodium" value="0" class="w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                                Guardar Producto
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>