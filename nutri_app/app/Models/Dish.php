<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    protected $fillable = [
        'name',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Un plato tiene muchos ingredientes (productos)
    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('amount')->withTimestamps();
    }

    public function getNutrientTotal($nutrient)
    {
        $total = 0;

        foreach ($this->products as $product) {

            $grams = $product->pivot->amount;
            $value = $product->$nutrient;

            $total += ($grams / 100) * $value;
        }

        return round($total, 1); // Devolvemos el total con 1 decimal
    }

    // Atajos para que la Vista pueda pedir los datos fácilmente

    // Esto permite usar $dish->total_calories en el HTML
    public function getTotalCaloriesAttribute()
    {
        return $this->getNutrientTotal('calories');
    }

    public function getTotalProteinAttribute()
    {
        return $this->getNutrientTotal('protein');
    }

    public function getTotalFatAttribute()
    {
        return $this->getNutrientTotal('fat');
    }

    public function getTotalCarbsAttribute()
    {
        return $this->getNutrientTotal('carbohydrates');
    }
}
