<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {

        $products = Product::whereNull('user_id')
            ->orWhere('user_id', auth()->id())
            ->get();

        return view('products.index', compact('products'));
    }

    // Función para mostrar el formulario
    public function create()
    {
        // Obtenemos todas las categorías para el desplegable
        $categories = Category::all();

        return view('products.create', compact('categories'));
    }

    // Función para guardar el producto en la BD
    public function store(Request $request)
    {
        // Validamos que los datos sean correctos (que no vengan vacíos y sean números)
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'calories' => 'required|numeric',
            'fat' => 'required|numeric',
            'saturated_fat' => 'nullable|numeric',
            'monounsaturated_fat' => 'nullable|numeric',
            'polyunsaturated_fat' => 'nullable|numeric',
            'trans_fat' => 'nullable|numeric',
            'cholesterol' => 'nullable|numeric',
            'carbohydrates' => 'required|numeric',
            'fiber' => 'nullable|numeric',
            'protein' => 'required|numeric',
            'sodium' => 'nullable|numeric',
        ]);

        // Asignamos el producto al usuario actual
        $validated['user_id'] = Auth::id();

        // Rellenamos los campos vacíos con 0 por defecto
        $validated['trans_fat'] = $validated['trans_fat'] ?? 0;

        // Guardamos en la Base de Datos
        Product::create($validated);

        // Volvemos a la lista
        return redirect()->route('products.index');
    }

    public function destroy(Product $product)
    {
        // Solo borrar si el producto es del usuario
        if ($product->user_id !== Auth::id()) {
            abort(403, 'No puedes borrar ingredientes de la base de datos global.');
        }

        $product->delete();
        return redirect()->route('products.index')->with('success', 'Producto eliminado.');
    }
}
