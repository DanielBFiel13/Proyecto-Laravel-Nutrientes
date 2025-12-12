<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'bedca_id',
        'category_id',
        'user_id',
        'calories',
        'fat',
        'saturated_fat',
        'cholesterol',
        'polyunsaturated_fat',
        'monounsaturated_fat',
        'trans_fat',
        'carbohydrates',
        'fiber',
        'protein',
        'sodium',
    ];
    // Relación: Pertenece a una Categoría
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relación: Pertenece a un Usuario (puede ser null si es público)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación: Pertenece a muchos Platos
    public function dishes()
    {
        return $this->belongsToMany(Dish::class)->withPivot('amount');
    }
}
