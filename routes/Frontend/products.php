<?php
Route::get('/products-list', '\App\Http\Controllers\Frontend\ProductsController@index')
    ->name('product.index');

/*Route::get('/category/{slug?}', '\App\Http\Controllers\Frontend\BlogsController@category')
    ->name('product.category');

Route::get('/product/{slug}', '\App\Http\Controllers\Frontend\BlogsController@single')
    ->name('product.single');*/