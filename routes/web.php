
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
// use Illuminate\Support\Facades\Cookie;

// $csrfToken = Cookie::getToken();

Route::prefix('api')->group(function () {

    // Rotta per ottenere i dati CO2
    Route::get('/co2', [ProductController::class, 'co2']);
    
    // Rotta per ottenere il totale di CO2 salvato
    Route::get('/total-co2-saved', [ProductController::class, 'getTotalCo2Saved']);
    
    // Rotta per leggere tutti i prodotti
    Route::get('/products', [ProductController::class, 'read']);
        
    Route::get('/orders', [OrderController::class, 'read']);
    
});
