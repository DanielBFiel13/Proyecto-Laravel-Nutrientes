<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Planificar Comida') }} 📅
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('menus.store') }}" method="POST">
                        @csrf

                        {{-- 1. Elegir la Fecha --}}
                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700">¿Cuándo vas a comer?</label>
                            <input type="date" name="date" required value="{{ date('Y-m-d') }}"
                                   class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                        </div>

                        {{-- 2. Elegir el Plato (de los que ya has creado) --}}
                        <div class="mb-6">
                            <label class="block font-medium text-sm text-gray-700">¿Qué plato?</label>
                            <select name="dish_id" required class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                                @foreach($dishes as $dish)
                                    <option value="{{ $dish->id }}">
                                        {{ $dish->name }} ({{ $dish->total_calories }} kcal)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 font-bold">
                                Añadir al Menú
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>