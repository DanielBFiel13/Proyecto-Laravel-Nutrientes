<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DishController extends Controller
{
    // Listar platos
    public function index()
    {
        $dishes = Dish::where('user_id', Auth::id())->get();
        return view('dishes.index', compact('dishes'));
    }

    // Mostrar formulario de creación
    public function create()
    {
        // Necesitamos todos los ingredientes disponibles
        // para que el usuario pueda elegirlos en el formulario
        $products = Product::whereNull('user_id')
            ->orWhere('user_id', Auth::id())
            ->orderBy('name')
            ->get();

        return view('dishes.create', compact('products'));
    }

    // Guardar el plato y sus ingredientes
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'products' => 'required|array',
            'amounts' => 'required|array',
        ]);

        // Crear el Plato
        $dish = Dish::create([
            'name' => $request->name,
            'user_id' => Auth::id(),
        ]);

        // Asociar los ingredientes y sus cantidades
        // Recorremos los productos que envió el formulario
        $products = $request->input('products');
        $amounts = $request->input('amounts');

        for ($i = 0; $i < count($products); $i++) {
            // Si el producto tiene ID y cantidad, lo guardamos
            if (!empty($products[$i]) && !empty($amounts[$i])) {
                $dish->products()->attach($products[$i], [
                    'amount' => $amounts[$i]
                ]);
            }
        }

        return redirect()->route('dishes.index');
    }

    public function destroy(Dish $dish)
    {
        if ($dish->user_id !== Auth::id()) {
            abort(403);
        }

        $dish->delete(); // Esto borrará también las relaciones en la tabla pivote automáticamente
        return redirect()->route('dishes.index');
    }
}
