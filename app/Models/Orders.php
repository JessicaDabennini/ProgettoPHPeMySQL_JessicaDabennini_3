<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = 'orders';

    public $timestamps = false;

    protected $fillable = [
        'sales_date',
        'destination_country',
        'product_id',
        'quantity',
    ];

    // Relazione con Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Metodo statico per query con filtri
    public static function tableJoin($startDate = null, $endDate = null, $country = null, $product = null)
    {
        $query = self::with('product')
            ->select('orders.sales_date', 'orders.destination_country', 'orders.product_id', 'orders.quantity', 'products.product_name', 'products.co2_saved')
            ->join('products', 'orders.product_id', '=', 'products.id');

        if ($startDate) {
            $query->where('orders.sales_date', '>=', $startDate);
        }
        if ($endDate) {
            $query->where('orders.sales_date', '<=', $endDate);
        }
        if ($country) {
            $query->where('orders.destination_country', $country);
        }
        if ($product) {
            $query->where('products.product_name', 'like', "%$product%");
        }

        return $query->get();
    }

    // Metodo statico per totale CO2 con filtri
    public static function getTotalCo2Saved($startDate = null, $endDate = null, $country = null, $product = null)
    {
        $orders = self::tableJoin($startDate, $endDate, $country, $product);

        return $orders->sum(function ($order) {
            return $order->quantity * $order->co2_saved;
        });
    }
}