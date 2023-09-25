<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


// // image 

// Route::get('/images/{filename}', function ($filename) {
//     $imageUrl = Storage::url('public/images/' . $filename);
//     $mimeType = Storage::mimeType('public/images/' . $filename);
//     return response($imageUrl, 200)->header('Content-Type', $mimeType);
//   });

Route::group(
    [
        'namespace' => 'App\Http\Controllers',
        'middleware' => 'api',
    ],
    function () {

        // dashboard or admin  routes 
        Route::group(
            [
                'prefix' => 'dashboard',
            ],
            function () {
                // auth
                Route::post('login', 'AuthController@AdminLogin');
                Route::get('logout', 'AuthController@logout')->middleware(['auth:sanctum','AdminMiddleware']);


                // categories
                Route::apiResource('categories', CategoryController::class)->middleware(['auth:sanctum','AdminMiddleware']);

                // products
                Route::apiResource('products', ProductController::class)->middleware(['auth:sanctum','AdminMiddleware']);
                Route::get('products/search/{name}', 'ProductController@searchName')->middleware(['auth:sanctum','AdminMiddleware']);
                
                // customers
                Route::apiResource('customers', CustomerController::class)->only('index')->middleware(['auth:sanctum','AdminMiddleware']);

                // orders
                Route::apiResource('orders', OrderController::class)->middleware(['auth:sanctum','AdminMiddleware']);
                Route::get('orders/search/{number}', 'OrderController@searchNumber')->middleware(['auth:sanctum','AdminMiddleware']);


            }
        );



        Route::group(
            [
                'prefix' => 'site',
            ],
            function () {

                // Auth 
                Route::post('register', 'AuthController@UserRegister');
                Route::post('login', 'AuthController@UserLogin');
                Route::get('logout', 'AuthController@logout')->middleware('auth:sanctum'); 

                //order 
                Route::apiResource('orders', OrderController::class)->only('store')->middleware(['auth:sanctum']);

                // products
                Route::apiResource('products', ProductController::class)->only(['show', 'index'])->middleware(['auth:sanctum']);
                Route::get('products/search/{name}', 'ProductController@searchName')->middleware(['auth:sanctum']);
                
            }
        );


    }
);