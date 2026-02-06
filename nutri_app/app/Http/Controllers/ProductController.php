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
        // CAMBIO: Lógica para roles
        // Si el usuario tiene el rol 'admin', recuperamos TODOS los productos
        if (auth()->user()->hasRole('admin')) {
            $products = Product::all();
        } else {
            // Si es usuario normal, mantenemos la lógica antigua:
            // Ver productos globales (user_id null) O los suyos propios
            $products = Product::whereNull('user_id')
                ->orWhere('user_id', auth()->id())
                ->get();
        }

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
        // Validamos que los datos sean correctos
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
        // CAMBIO: Seguridad basada en Permisos de Spatie
        // Verificamos si el usuario tiene el permiso explícito de 'borrar productos'.
        // El Admin SÍ lo tiene. El Usuario Normal NO lo tiene.
        if (!auth()->user()->can('borrar productos')) {
            abort(403, 'No tienes permiso para eliminar productos.');
        }

        // Si pasa el control anterior (es admin), eliminamos el producto.
        $product->delete();
        
        return redirect()->route('products.index')->with('success', 'Producto eliminado.');
    }
}