<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    // Specify the table name if it's not the plural form of the model name
    protected $table = 'orders';

    // Define the fillable properties
    protected $fillable = [
        'sales_date',
        'destination_country',
        'product_id',
        'quantity',
    ];

    // Define relationships if needed
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // You can create a method to get total CO2 saved
    public function getTotalCo2Saved()
    {
        return $this->with('product')
            ->selectRaw('SUM(quantity * product.co2_saved) as total_co2_saved')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->value('total_co2_saved');
    }

    // You can create a method for table join
    public function tableJoin($startDate, $endDate, $country, $product)
    {
        $query = $this->with('product')
            ->select('sales_date', 'destination_country', 'product_id', 'quantity', 'products.product_name')
            ->join('products', 'orders.product_id', '=', 'products.id');

        if ($startDate) {
            $query->where('sales_date', '>=', $startDate);
        }
        if ($endDate) {
            $query->where('sales_date', '<=', $endDate);
        }
        if ($country) {
            $query->where('destination_country', $country);
        }
        if ($product) {
            $query->where('products.product_name', $product);
        }

        return $query->get();
    }
}
