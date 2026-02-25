
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;


Route::prefix('api')->group(function () {

    // Rotta per ottenere i dati CO2
    Route::get('/co2', [ProductController::class, 'co2']);
    
    // Rotta per ottenere il totale di CO2 salvato
    Route::get('/total-co2-saved', [ProductController::class, 'getTotalCo2Saved']);
    
    // Rotta per creare un nuovo prodotto
    Route::post('/products', [ProductController::class, 'create']);  
    
    // Rotta per eliminare un prodotto
    Route::delete('/products', [ProductController::class, 'delete']);
    
    // Rotta per leggere tutti i prodotti
    Route::get('/products', [ProductController::class, 'read']);
    
    // Rotta per aggiornare un prodotto
    Route::put('/products/{id}', [ProductController::class, 'update']);

    Route::post('/orders', [OrderController::class, 'create']);
    
    Route::delete('/orders/{id}', [OrderController::class, 'delete']);
    
    Route::get('/orders', [OrderController::class, 'read']);
    
    Route::put('/orders/{id}', [OrderController::class, 'update']);
});
