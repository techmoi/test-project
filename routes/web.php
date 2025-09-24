<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function(){

    Route::get('/', function () {
        return view('welcome');
    });
   
    include "Admin/auth.php";
    include "Frontend/products.php";

});


Route::prefix('admin')->middleware(['adminAuth'])->group(function () {
    include "Admin/dashboard.php";
    include "Admin/products.php";
    
});

Route::middleware(['userAuth'])->group(function () {    
    
});

if(isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] != 'localhost')
{
    Route::fallback(function () {
        abort(404);
    });

    Route::any('{url}', function(){
        return redirect('/');
    })->where('url', '.*');
}