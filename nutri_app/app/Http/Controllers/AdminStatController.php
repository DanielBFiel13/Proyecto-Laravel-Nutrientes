<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Dish;
use App\Models\Menu;

class AdminStatController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalDishes = Dish::count();
        $totalMenus = Menu::count(); 

        return view('admin.stats', compact('totalProducts', 'totalDishes', 'totalMenus'));
    }
}