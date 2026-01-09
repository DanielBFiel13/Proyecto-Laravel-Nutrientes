<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Dish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    public function index()
    {
        // Obtenemos todos los menús del usuario ordenados por fecha
        $menus = Menu::where('user_id', Auth::id())
            ->with('dish.products')
            ->orderBy('date', 'desc')
            ->get();

        // Agrupamos por fecha para mostrarlo ordenado "Por Días"
        // Esto crea una estructura tipo: ['2023-10-01' => [Plato A, Plato B], '2023-10-02' => ...]
        $groupedMenus = $menus->groupBy('date');

        return view('menus.index', compact('groupedMenus'));
    }

    public function create()
    {
        // Para el formulario, necesitamos la lista de platos del usuario
        $dishes = Dish::where('user_id', Auth::id())->get();
        return view('menus.create', compact('dishes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'dish_id' => 'required|exists:dishes,id',
        ]);

        Menu::create([
            'user_id' => Auth::id(),
            'dish_id' => $request->dish_id,
            'date' => $request->date,
        ]);

        return redirect()->route('menus.index');
    }

    public function destroy(Menu $menu)
    {
        if ($menu->user_id !== Auth::id()) {
            abort(403);
        }

        $menu->delete();
        return redirect()->route('menus.index');
    }
}