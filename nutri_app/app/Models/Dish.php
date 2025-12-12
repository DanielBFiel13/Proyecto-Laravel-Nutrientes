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
        return $this->belongsToMany(Product::class)->withPivot('amount');
    }
}
