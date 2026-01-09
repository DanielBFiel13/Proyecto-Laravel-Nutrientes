<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Mi Calendario Nutricional') }}
            </h2>
            <a href="{{ route('menus.create') }}"
                class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow">
                + Añadir Comida al Diario
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if($groupedMenus->isEmpty())
                <div class="text-center py-12 bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="text-6xl mb-4">📅</div>
                    <p class="text-gray-500 text-lg">Tu calendario está vacío.</p>
                    <p class="text-sm text-gray-400 mt-2">Usa el botón de arriba para registrar tu primera comida.</p>
                </div>
            @else
                {{-- Recorremos los días (vienen agrupados por fecha desde el controlador) --}}
                @foreach($groupedMenus as $date => $menusDelDia)

                    {{-- CÁLCULO DE TOTALES DIARIOS --}}
                    {{-- Sumamos los macros de todos los platos de este día --}}
                    @php
                        $dailyCals = $menusDelDia->sum(fn($m) => $m->dish->total_calories);
                        $dailyProt = $menusDelDia->sum(fn($m) => $m->dish->total_protein);
                        $dailyFat = $menusDelDia->sum(fn($m) => $m->dish->total_fat);
                        $dailyCarb = $menusDelDia->sum(fn($m) => $m->dish->total_carbs);
                    @endphp

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8 border border-gray-200">
                        {{-- Resumen de Macros --}}
                        <div class="bg-gray-50 p-4 border-b flex justify-between items-center flex-wrap gap-4">
                            <div>
                                <h3 class="text-lg font-bold text-gray-800 capitalize flex items-center gap-2">
                                    📅 {{ \Carbon\Carbon::parse($date)->locale('es')->isoFormat('dddd, D [de] MMMM') }}
                                </h3>
                                <span class="text-xs text-gray-500 pl-8 block">{{ $menusDelDia->count() }} comidas
                                    registradas</span>
                            </div>

                            {{-- Barra de Totales del Día --}}
                            <div class="flex gap-3 text-sm">
                                <div class="text-center px-3 py-1 bg-white rounded border border-gray-200 shadow-sm">
                                    <span class="block font-extrabold text-gray-800">{{ number_format($dailyCals, 0) }}</span>
                                    <span class="text-xs text-gray-500 uppercase">Kcal</span>
                                </div>
                                <div class="text-center px-2 py-1">
                                    <span class="block font-bold text-green-600">{{ number_format($dailyProt, 1) }}g</span>
                                    <span class="text-xs text-green-600">Prot</span>
                                </div>
                                <div class="text-center px-2 py-1">
                                    <span class="block font-bold text-red-600">{{ number_format($dailyFat, 1) }}g</span>
                                    <span class="text-xs text-red-600">Grasas</span>
                                </div>
                                <div class="text-center px-2 py-1">
                                    <span class="block font-bold text-yellow-600">{{ number_format($dailyCarb, 1) }}g</span>
                                    <span class="text-xs text-yellow-600">Carbs</span>
                                </div>
                            </div>
                        </div>

                        {{-- LISTA DE PLATOS DEL DÍA --}}
                        <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($menusDelDia as $menu)
                                <div
                                    class="border rounded-lg p-3 flex justify-between items-center hover:bg-gray-50 transition group">

                                    {{-- Información del plato --}}
                                    <div class="overflow-hidden">
                                        <div class="font-bold text-blue-900 truncate">{{ $menu->dish->name }}</div>
                                        <div class="text-xs text-gray-500 truncate">
                                            @foreach($menu->dish->products->take(3) as $prod)
                                                {{ $prod->name }},
                                            @endforeach
                                            {{ $menu->dish->products->count() > 3 ? '...' : '' }}
                                        </div>
                                    </div>

                                    {{-- Calorías y Botón de Borrar --}}
                                    <div class="text-right flex items-center gap-4 pl-4">
                                        {{-- Calorías del plato --}}
                                        <div class="whitespace-nowrap">
                                            <span class="font-bold text-gray-700">{{ $menu->dish->total_calories }}</span>
                                            <span class="text-xs text-gray-500">kcal</span>
                                        </div>

                                        {{-- Botón de borrar --}}
                                        <form action="{{ route('menus.destroy', $menu) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-gray-300 hover:text-red-500 transition p-1 rounded-full hover:bg-red-50"
                                                title="Quitar del calendario">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @endif

        </div>
    </div>
</x-app-layout>