<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestión de Platos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- CABECERA --}}
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">
                            @hasrole('admin')
                                Listado Global de Recetas
                            @else
                                Mis Recetas Guardadas
                            @endhasrole
                        </h3>
                        <a href="{{ route('dishes.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded flex items-center shadow">
                            🍽️ Cocinar Nuevo Plato
                        </a>
                    </div>

                    <hr class="mb-6">

                    {{-- LISTA DE PLATOS --}}
                    @if($dishes->isEmpty())
                        <div class="text-center py-12 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                            <p class="text-gray-500 mb-4 text-lg">No hay platos registrados.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($dishes as $dish)
                                {{-- TARJETA DE PLATO --}}
                                <div class="border border-gray-200 rounded-xl p-5 bg-white shadow-sm hover:shadow-md transition duration-200 flex flex-col justify-between h-full relative">
                                    
                                    {{-- Nombre e Ingredientes --}}
                                    <div>
                                        <div class="flex justify-between items-start mb-1">
                                            <h3 class="font-bold text-xl text-blue-900 leading-tight">{{ $dish->name }}</h3>
                                            <span class="text-xs font-semibold bg-blue-100 text-blue-800 px-2.5 py-0.5 rounded-full whitespace-nowrap">
                                                {{ $dish->products->count() }} ingr.
                                            </span>
                                        </div>

                                        {{-- Mostrar autor si soy Admin y el plato no es mío --}}
                                        @if(Auth::user()->hasRole('admin') && $dish->user_id !== Auth::id())
                                            <div class="mb-2 text-xs text-gray-500 italic">
                                                👤 Autor: {{ $dish->user->name ?? 'Desconocido' }}
                                            </div>
                                        @endif
                                        
                                        <ul class="text-sm text-gray-600 mb-4 list-disc list-inside h-24 overflow-y-auto pr-2 mt-2">
                                            @foreach($dish->products as $product)
                                                <li class="truncate">
                                                    <span class="font-medium text-gray-800">{{ $product->pivot->amount }}g</span> 
                                                    {{ $product->name }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>

                                    {{-- TOTALES NUTRICIONALES --}}
                                    <div class="pt-4 border-t border-gray-100 mt-2">
                                        <div class="text-center mb-3">
                                            <span class="text-2xl font-extrabold text-gray-800">{{ $dish->total_calories }}</span>
                                            <span class="text-xs font-bold text-gray-500 uppercase tracking-wide">kcal</span>
                                        </div>
                                        
                                        <div class="grid grid-cols-3 gap-2 text-center text-xs">
                                            <div class="bg-red-50 p-2 rounded-lg">
                                                <div class="font-bold text-red-700 text-sm">{{ $dish->total_fat }}g</div>
                                                <div class="text-red-400 font-medium scale-90">Grasas</div>
                                            </div>
                                            <div class="bg-green-50 p-2 rounded-lg">
                                                <div class="font-bold text-green-700 text-sm">{{ $dish->total_protein }}g</div>
                                                <div class="text-green-400 font-medium scale-90">Prot.</div>
                                            </div>
                                            <div class="bg-yellow-50 p-2 rounded-lg">
                                                <div class="font-bold text-yellow-700 text-sm">{{ $dish->total_carbs }}g</div>
                                                <div class="text-yellow-400 font-medium scale-90">Carbs</div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- BOTÓN BORRAR --}}
                                    {{-- Visible si soy el dueño O si soy Admin --}}
                                    @if($dish->user_id === Auth::id() || Auth::user()->hasRole('admin'))
                                        <div class="mt-4 flex justify-end">
                                            <form action="{{ route('dishes.destroy', $dish) }}" method="POST" onsubmit="return confirm('¿Borrar esta receta?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-xs text-red-500 hover:text-red-700 underline font-bold">
                                                    🗑️ Eliminar Receta
                                                </button>
                                            </form>
                                        </div>
                                    @endif

                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>