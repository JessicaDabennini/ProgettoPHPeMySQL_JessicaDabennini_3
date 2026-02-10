<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders; 

class OrderController extends Controller
{
    public function create(Request $request)
    {
        // Validazione dei dati della richiesta
        $request->validate([
            'sales_date' => 'required|date',
            'destination_country' => 'required|string',
            'product_id' => 'required|integer',
            'quantity' => 'required|integer',
        ]);

        // Crea un nuovo ordine usando Eloquent
        $order = Orders::create($request->only(['sales_date', 'destination_country', 'product_id', 'quantity']));

        return response()->json(["status" => 201, "message" => "Order created successfully."], 201);
    }

    public function delete($id)
    {
        $order = Orders::find($id);

        if ($order) {
            $order->delete();
            return response()->json(["response" => "Order has been deleted"], 200);
        }

        return response()->json(["response" => "Order not found."], 404);
    }

    public function read()
    {
        $orders = Orders::all();

        if ($orders->isNotEmpty()) {
            return response()->json(["orders" => $orders], 200);
        }

        return response()->json(["message" => "No orders found."], 404);
    }

    public function update(Request $request, $id)
    {
        $order = Orders::find($id);

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        // Validazione dei dati della richiesta
        $request->validate([
            'sales_date' => 'sometimes|required|date',
            'destination_country' => 'sometimes|required|string',
            'product_id' => 'sometimes|required|integer',
            'quantity' => 'sometimes|required|integer',
        ]);

        // Aggiorna gli attributi dell'ordine
        $order->update($request->only(['sales_date', 'destination_country', 'product_id', 'quantity']));

        return response()->json(['message' => 'Order updated successfully'], 200);
    }
}
