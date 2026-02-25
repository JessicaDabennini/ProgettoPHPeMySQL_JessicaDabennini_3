<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Orders; 

class ProductController extends Controller
{
    /**
     * GET /api/co2
     * Visualizza i dati CO2 con filtri
     */
    public function co2(Request $request)
    {
        $orders = Orders::tableJoin(
            $request->start_date,
            $request->end_date,
            $request->country,
            $request->product
        );

        $data = $orders->map(function ($order) {
            return [
                'sales_date' => $order->sales_date,
                'destination_country' => $order->destination_country,
                'product_name' => $order->product_name,
                'quantity' => $order->quantity,
                'co2_saved_per_unit' => $order->co2_saved,
                'total_co2_saved' => $order->quantity * $order->co2_saved,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $data,
            'total_records' => $data->count()
        ]);
    }

    /**
     * GET /api/total-co2-saved
     * Visualizza il totale CO2 risparmiato
     */
    public function getTotalCo2Saved(Request $request)
    {
        $totalCo2Saved = Orders::getTotalCo2Saved(
            $request->start_date,
            $request->end_date,
            $request->country,
            $request->product
        );

        return response()->json([
            'success' => true,
            'total_co2_saved_kg' => $totalCo2Saved,
            'filters' => [
                'start_date' => $request->start_date ?? 'non specificato',
                'end_date' => $request->end_date ?? 'non specificato',
                'country' => $request->country ?? 'non specificato',
                'product' => $request->product ?? 'non specificato',
            ]
        ]);
    }

    // ... altri metodi (create, read, update, delete)
}