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
    // Validazione dei parametri della richiesta
    $request->validate([
        'start_date' => 'required|date',
        'end_date' => 'required|date',
        'country' => 'required|string',
        'product' => 'required|string',
    ]);

    // Esegui la query usando Eloquent
    $orders = Orders::tableJoin($request->start_date, $request->end_date, $request->country, $request->product);

    // Prepara la risposta
    return response()->json($orders->toArray());
}

public function getTotalCo2Saved()
{
    $totalCo2Saved = Orders::getTotalCo2Saved(); 

    return response()->json([
        "total_co2_saved" => json_encode($totalCo2Saved) . " Kg"
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