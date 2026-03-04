 <?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

Route::post('/products', [ProductController::class, 'create']);  

Route::post('/orders', [OrderController::class, 'create']);

Route::delete('/products', [ProductController::class, 'delete']);

Route::delete('/orders/{id}', [OrderController::class, 'delete']);

Route::put('/orders/{id}', [OrderController::class, 'update']);

Route::put('/products/{id}', [ProductController::class, 'update']);


