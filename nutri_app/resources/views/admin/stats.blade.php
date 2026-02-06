<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📊 Panel de Estadísticas
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Grid de 3 tarjetas --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- Tarjeta 1: Productos --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center border-l-4 border-blue-500">
                    <h3 class="text-gray-500 text-lg font-medium">Ingredientes</h3>
                    <p class="text-4xl font-bold text-gray-800 mt-2">{{ $totalProducts }}</p>
                    <span class="text-sm text-blue-500">en base de datos</span>
                </div>

                {{-- Tarjeta 2: Platos --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center border-l-4 border-green-500">
                    <h3 class="text-gray-500 text-lg font-medium">Recetas</h3>
                    <p class="text-4xl font-bold text-gray-800 mt-2">{{ $totalDishes }}</p>
                    <span class="text-sm text-green-500">cocinadas por usuarios</span>
                </div>

                {{-- Tarjeta 3: Menús --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center border-l-4 border-indigo-500">
                    <h3 class="text-gray-500 text-lg font-medium">Días Planificados</h3>
                    <p class="text-4xl font-bold text-gray-800 mt-2">{{ $totalMenus }}</p>
                    <span class="text-sm text-indigo-500">en calendarios</span>
                </div>

            </div>

            <div class="mt-8 text-center">
                <a href="{{ route('products.index') }}" class="text-indigo-600 hover:text-indigo-900 underline">
                    &larr; Volver al listado
                </a>
            </div>

        </div>
    </div>
</x-app-layout>