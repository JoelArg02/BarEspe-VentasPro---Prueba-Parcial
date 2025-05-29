<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'stock',
        'category_id',
        'image_base64',
    ];

    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class);
    }

    public function sales()
    {
        return $this->belongsToMany(Sale::class, 'sale_product')
                    ->withPivot('quantity', 'unit_price')
                    ->withTimestamps();
    }


}
