<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Listado de Alimentos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Mis Ingredientes y Base de Datos</h3>    

                        <div class="flex gap-3">
                        <a href="{{ route('menus.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded flex items-center">
                        Ver Calendario
                        </a>                        
                        <a href="{{ route('dishes.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded flex items-center">
                        + Crear Plato
                        </a>
                        
                        <a href="{{ route('products.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center">
                        + Nuevo Producto
                        </a>
                        </div>
                    </div>   
                    {{-- Tabla de Productos --}}
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-sm">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="p-3 border-b-2 font-bold">Nombre</th>
                                    {{-- Energía --}}
                                    <th class="p-3 border-b-2">Calorías</th>
                
                                    {{-- Macro: Grasas --}}
                                    <th class="p-3 border-b-2">Grasa Total</th>
                                    <th class="p-3 border-b-2 text-xs text-gray-500">Sat.</th>
                                    <th class="p-3 border-b-2 text-xs text-gray-500">Mono.</th>
                                    <th class="p-3 border-b-2 text-xs text-gray-500">Poli.</th>
                                    <th class="p-3 border-b-2 text-red-500">Trans</th> {{-- Destacamos Trans --}}
                                    <th class="p-3 border-b-2">Colesterol</th>

                                    {{-- Otros Macros --}}
                                    <th class="p-3 border-b-2">Carbohidratos</th>
                                    <th class="p-3 border-b-2">Fibra</th>
                                    <th class="p-3 border-b-2">Proteínas</th>
                                    <th class="p-3 border-b-2">Sodio</th>
                                    {{-- Acciones --}}
                                    <th class="p-3 border-b-2">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr class="hover:bg-gray-50 border-b">
                                        <td class="p-3 font-medium">{{ $product->name }}</td>
                    
                                        {{-- Energía --}}
                                        <td class="p-3">{{ $product->calories }} kcal</td>

                                        {{-- Grasas (Desglose) --}}
                                        <td class="p-3 font-semibold">{{ $product->fat }} g</td>
                                        <td class="p-3 text-gray-600">{{ $product->saturated_fat }} g</td>
                                        <td class="p-3 text-gray-600">{{ $product->monounsaturated_fat }} g</td>
                                        <td class="p-3 text-gray-600">{{ $product->polyunsaturated_fat }} g</td>
                                        <td class="p-3 text-red-600 font-bold">{{ $product->trans_fat }} g</td>
                                        <td class="p-3">{{ $product->cholesterol }} mg</td>

                                        {{-- Otros --}}
                                        <td class="p-3">{{ $product->carbohydrates }} g</td>
                                        <td class="p-3">{{ $product->fiber }} g</td>
                                        <td class="p-3 font-semibold text-blue-600">{{ $product->protein }} g</td>
                                        <td class="p-3">{{ $product->sodium }} mg</td>
                                        {{-- Acciones --}}
                                        <td class="p-3">
                                            @if($product->user_id === Auth::id())
                                                <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres borrar este ingrediente?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700 font-bold">
                                                        🗑️ Borrar
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-gray-400 text-xs italic">Global</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>