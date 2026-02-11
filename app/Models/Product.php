<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Specify the table name if it's not the plural form of the model name
    protected $table = 'products';

    // Define the fillable properties
    protected $fillable = [
        'product_name',
        'co2_saved',
    ];

    // You can define relationships if needed
    public function orders()
    {
        return $this->hasMany(Orders::class);
    }
}


