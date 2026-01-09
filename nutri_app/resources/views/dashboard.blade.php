<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel Principal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- ALIMENTOS (Ingredientes) --}}
                <a href="{{ route('products.index') }}" class="block transform transition hover:scale-105 duration-300">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg h-full border-l-4 border-blue-500">
                        <div class="p-6 text-gray-900 flex flex-col items-center text-center">
                            <div class="text-5xl mb-4">🍎</div>
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Base de Alimentos</h3>
                            <p class="text-sm text-gray-500 mb-4">
                                Consulta calorías y macros de ingredientes o añade los tuyos propios.
                            </p>
                            <span class="text-blue-600 font-semibold text-sm">Ver Ingredientes &rarr;</span>
                        </div>
                    </div>
                </a>

                {{-- MIS RECETAS (Platos) --}}
                <a href="{{ route('dishes.index') }}" class="block transform transition hover:scale-105 duration-300">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg h-full border-l-4 border-green-500">
                        <div class="p-6 text-gray-900 flex flex-col items-center text-center">
                            <div class="text-5xl mb-4">🍳</div>
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Mis Recetas</h3>
                            <p class="text-sm text-gray-500 mb-4">
                                Crea platos combinando ingredientes y calcula sus macros totales.
                            </p>
                            <span class="text-green-600 font-semibold text-sm">Cocinar Platos &rarr;</span>
                        </div>
                    </div>
                </a>

                {{-- CALENDARIO (Menú) --}}
                <a href="{{ route('menus.index') }}" class="block transform transition hover:scale-105 duration-300">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg h-full border-l-4 border-indigo-500">
                        <div class="p-6 text-gray-900 flex flex-col items-center text-center">
                            <div class="text-5xl mb-4">📅</div>
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Mi Diario</h3>
                            <p class="text-sm text-gray-500 mb-4">
                                Planifica tus comidas diarias y controla tu consumo total.
                            </p>
                            <span class="text-indigo-600 font-semibold text-sm">Ver Calendario &rarr;</span>
                        </div>
                    </div>
                </a>

            </div>
        </div>
    </div>
</x-app-layout>
