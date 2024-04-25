<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ClientAuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PieceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\RepairController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ShoppingController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:client')->get('/client/user', function () {
    $user = Auth::guard('client')->user();
    return response()->json($user);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {
    //Rutas de categorías
    Route::middleware(['ability:categories-write,root'])->group(function () {
        Route::put('/categories/{id}/state/{state}', [CategoryController::class, 'state']); //No está en uso por ahora
        Route::put('/categories/state', [CategoryController::class, 'inactive']);
        Route::delete('/categories', [CategoryController::class, 'destroy']);
        Route::resource('categories', CategoryController::class)->only([
            'store', 'update'
        ]);
    });
    Route::middleware(['ability:categories-read,root'])->group(function () {
        Route::get('/categories', [CategoryController::class, 'index']);
    });

    //Rutas de clientes
    Route::middleware(['ability:clients-write,root'])->group(function () {
        Route::put('/clients/{id}/state/{state}', [ClientController::class, 'state']);
        Route::put('/clients/state', [ClientController::class, 'inactive']);
        Route::delete('/clients', [ClientController::class, 'destroy']);
        Route::resource('clients', ClientController::class)->only([
            'store'
        ]);
    });
    Route::middleware(['ability:clients-read,root'])->group(function () {
        Route::get('/clients', [ClientController::class, 'index']);
    });

    //Rutas de proveedores
    Route::middleware(['ability:providers-write,root'])->group(function () {
        Route::delete('/providers', [ProviderController::class, 'destroy']);
        Route::resource('providers', ProviderController::class)->only([
            'store', 'update'
        ]);
    });
    Route::middleware(['ability:providers-read,root'])->group(function () {
        Route::get('/providers', [ProviderController::class, 'index']);
    });


    //Rutas de productos
    Route::middleware(['ability:products-write,root'])->group(function () {
        Route::put('/products/{id}/state/{state}', [ProductController::class, 'state']); //No está en uso por ahora
        Route::put('/products/{id}/offer', [ProductController::class, 'offer']);
        Route::delete('/products/{id}/offer', [ProductController::class, 'unoffer']);
        Route::put('/products/state', [ProductController::class, 'inactive']);
        Route::delete('/products', [ProductController::class, 'destroy']);
        Route::resource('products', ProductController::class)->only([
            'store', 'update'
        ]);
        Route::delete('/images/{id}', [ImageController::class, 'destroy']);
    });
    Route::middleware(['ability:products-read,root'])->group(function () {
        Route::get('/products', [ProductController::class, 'index']);
    });
    Route::get('/products/popular', [ProductController::class, 'popular']);

    //Rutas de inventario
    Route::middleware(['ability:pieces-write,root'])->group(function () {
        Route::delete('/pieces', [PieceController::class, 'destroy']);
        Route::resource('pieces', PieceController::class)->only([
            'store', 'update'
        ]);
    });
    Route::middleware(['ability:pieces-read,root'])->group(function () {
        Route::get('/pieces', [PieceController::class, 'index']);
    });

    //Ruta de unidades de medidas
    Route::resource('units', UnitController::class)->only([
        'index', 'store', 'update'
    ]);

    //Rutas de ventas
    Route::middleware(['ability:sales-write,root'])->group(function () {
        Route::put('/sales/undelivered', [SaleController::class, 'undelivered']);
        Route::put('/sales/delivered', [SaleController::class, 'delivered']);
        Route::delete('/sales', [SaleController::class, 'destroy']);
        Route::resource('sales', SaleController::class)->only([
            'store'
        ]);
    });
    Route::middleware(['ability:sales-read,root'])->group(function () {
        Route::get('/sales', [SaleController::class, 'index']);
    });
    Route::get('/sales/latest', [SaleController::class, 'latest']);
    Route::get('/sales/compare', [SaleController::class, 'lastTwoMonths']);

    //Rutas de compras
    Route::middleware(['ability:shopping-write,root'])->group(function () {
        Route::delete('/shopping', [ShoppingController::class, 'destroy']);
        Route::resource('shopping', ShoppingController::class)->only([
            'store'
        ]);
    });
    Route::middleware(['ability:shopping-read,root'])->group(function () {
        Route::get('/shopping', [ShoppingController::class, 'index']);
    });

    //Ruta del taller
    Route::middleware(['ability:repairs-write,root'])->group(function () {
        Route::put('/repairs/{id}/state', [RepairController::class, 'state']);
        Route::put('/repairs/ready', [RepairController::class, 'ready']);
        Route::delete('/repairs', [RepairController::class, 'destroy']);
        Route::resource('repairs', RepairController::class)->only([
            'store', 'update'
        ]);
    });
    Route::middleware(['ability:repairs-read,root'])->group(function () {
        Route::get('/repairs', [RepairController::class, 'index']);
    });
    Route::get('/repairs/latest', [RepairController::class, 'latest']);

    //Rutas de administradores
    Route::middleware(['ability:users-write,root'])->group(function () {
        Route::put('/users/{id}/state/{state}', [UserController::class, 'state']);
        Route::put('/users/state', [UserController::class, 'inactive']);
        Route::delete('/users', [UserController::class, 'destroy']);
        Route::resource('users', UserController::class)->only([
            'store', 'update'
        ]);
    });
    Route::middleware(['ability:users-read,root'])->group(function () {
        Route::get('/users', [UserController::class, 'index']);
    });
    Route::get('/permissions', [PermissionController::class, 'index']);

    //Rutas de reseñas
    Route::middleware(['ability:reviews-write,root'])->group(function () {
        Route::put('/reviews/unconfirmed', [ReviewController::class, 'unconfirmed']);
        Route::put('/reviews/confirmed', [ReviewController::class, 'confirmed']);
        Route::delete('/reviews', [ReviewController::class, 'destroy']);
        Route::resource('reviews', ReviewController::class)->only([
            'store', 'update'
        ]);
    });
    Route::middleware(['ability:reviews-read,root'])->group(function () {
        Route::get('/reviews', [ReviewController::class, 'index']);
    });

    //Rutas de cotizaciones
    Route::middleware(['ability:quotations-write,root'])->group(function () {
        Route::delete('/quotations', [QuotationController::class, 'destroy']);
        Route::resource('quotations', QuotationController::class)->only([
            'store', 'update'
        ]);
    });
    Route::middleware(['ability:quotations-read,root'])->group(function () {
        Route::get('/quotations', [QuotationController::class, 'index']);
    });

    Route::get('/chats/apikey', function () {
        return response(json_encode([
            'chat' => env('CHAT_API_KEY'),
            'pusher' => env('PUSHER_APP_KEY')
        ]));
    });

    Route::get('/events/{month}', [EventController::class, 'index']);
    Route::resource('events', EventController::class)->only(['store']);
});

Route::post('/client/login', [ClientAuthController::class, 'authenticate']);
Route::post('/client/signin', [ClientController::class, 'store']);
