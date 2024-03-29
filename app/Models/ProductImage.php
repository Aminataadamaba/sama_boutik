<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;
    // protected $fillable = [
    //     'product_id',
    //     'image',
    //     'sort_order',
    // ];

    // public function product()
    // {
    //     return $this->belongsTo(Product::class);
    // }
    protected $fillable = ['product_id', 'image']; // Assurez-vous que 'image' est incluse dans $fillable


}
