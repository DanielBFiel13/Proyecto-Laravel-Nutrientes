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
        // CAMBIO: Lógica de Roles
        if (auth()->user()->hasRole('admin')) {
            // El admin ve TODO (y cargamos la relación 'user' para mostrar el autor)
            $dishes = Dish::with(['products', 'user'])->get();
        } else {
            // El usuario normal solo ve lo suyo
            $dishes = Dish::where('user_id', Auth::id())
                ->with('products')
                ->get();
        }

        return view('dishes.index', compact('dishes'));
    }

    // Mostrar formulario de creación
    public function create()
    {
        // CAMBIO: Si es admin, puede usar cualquier ingrediente de la BD
        if (auth()->user()->hasRole('admin')) {
            $products = Product::orderBy('name')->get();
        } else {
            // Lógica normal para usuarios
            $products = Product::whereNull('user_id')
                ->orWhere('user_id', Auth::id())
                ->orderBy('name')
                ->get();
        }

        return view('dishes.create', compact('products'));
    }

    // Guardar el plato (Esto no cambia mucho, el admin también puede cocinar)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'products' => 'required|array',
            'amounts' => 'required|array',
        ]);

        $dish = Dish::create([
            'name' => $request->name,
            'user_id' => Auth::id(),
        ]);

        $products = $request->input('products');
        $amounts = $request->input('amounts');

        for ($i = 0; $i < count($products); $i++) {
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
        // CAMBIO: Seguridad de borrado
        // Permitimos borrar SI: Es el dueño DEL PLATO ... O ... Es Admin
        if ($dish->user_id !== Auth::id() && !auth()->user()->hasRole('admin')) {
            abort(403, 'No tienes permiso para eliminar esta receta.');
        }

        $dish->delete();
        return redirect()->route('dishes.index');
    }
}
