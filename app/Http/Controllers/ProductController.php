<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Orders; 
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
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

public function create(Request $request)
{
    // Validazione dei dati della richiesta
    $request->validate([
        'product_name' => 'required|string',
        'co2_saved' => 'required|numeric',
    ]);

    $product = Product::create($request->toArray());

    return response()->json([
        "status" => 201,
        "message" => "Product created successfully."
    ], 201);
}

public function delete(Request $request)
{
    $request->validate(['id' => 'required|integer']);

    $product = Product::find($request->id);

    if ($product) {
        $product->delete();
        return response()->json(["response" => "Product has been deleted"], 200);
    }

    return response()->json(["response" => "Product not found."], 404);
}

public function read()
{
    $products = Product::all();

    if ($products->isEmpty()) {
        return response()->json([
            'success' => false,
            'message' => 'Nessun prodotto trovato'
        ], 404);
    }

    return response()->json([
        'success' => true,
        'data' => $products->toArray()
    ], 200);
}

public function update(Request $request, $id)
{
    $product = Product::find($id);

    if (!$product) {
        return response()->json(['error' => 'Product not found'], 404);
    }

    $request->validate([
        'product_name' => 'sometimes|required|string',
        'co2_saved' => 'sometimes|required|numeric',
    ]);

    $product->update($request->toArray());

    return response()->json(['message' => 'Product updated successfully'], 200);
}
}