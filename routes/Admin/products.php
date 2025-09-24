<?php
Route::get('/products', '\App\Http\Controllers\Admin\Products\ProductsController@index')
    ->name('admin.products');

Route::get('/product/add', '\App\Http\Controllers\Admin\Products\ProductsController@add')
    ->name('admin.products.add');

Route::post('/product/add', '\App\Http\Controllers\Admin\Products\ProductsController@add')
    ->name('admin.products.add');

Route::get('/product/{id}/view', '\App\Http\Controllers\Admin\Products\ProductsController@view')
    ->name('admin.products.view');

Route::get('/product/{id}/edit', '\App\Http\Controllers\Admin\Products\ProductsController@edit')
    ->name('admin.products.edit');

Route::post('/product/{id}/edit', '\App\Http\Controllers\Admin\Products\ProductsController@edit')
    ->name('admin.products.edit');

Route::post('/product/bulkActions/{action}', '\App\Http\Controllers\Admin\Products\ProductsController@bulkActions')
    ->name('admin.products.bulkActions');

Route::get('/product/{id}/delete', '\App\Http\Controllers\Admin\Products\ProductsController@delete')
    ->name('admin.products.delete');


/*** Categories **/
Route::get('/product/categories', '\App\Http\Controllers\Admin\Products\ProductCategoriesController@index')
    ->name('admin.products.categories');

Route::get('/product/category/add', '\App\Http\Controllers\Admin\Products\ProductCategoriesController@add')
    ->name('admin.products.categories.add');

Route::post('/product/category/add', '\App\Http\Controllers\Admin\Products\ProductCategoriesController@add')
    ->name('admin.products.categories.add');

Route::get('/product/category/{id}/edit', '\App\Http\Controllers\Admin\Products\ProductCategoriesController@edit')
    ->name('admin.products.categories.edit');

Route::post('/product/category/{id}/edit', '\App\Http\Controllers\Admin\Products\ProductCategoriesController@edit')
    ->name('admin.products.categories.edit');

Route::get('/product/category/{id}/view', '\App\Http\Controllers\Admin\Products\ProductCategoriesController@view')
    ->name('admin.products.categories.view');

Route::post('/product/category/bulkActions/{action}', '\App\Http\Controllers\Admin\Products\ProductCategoriesController@bulkActions')
    ->name('admin.products.categories.bulkActions');

Route::get('/product/category/{id}/delete', '\App\Http\Controllers\Admin\Products\ProductCategoriesController@delete')
    ->name('admin.products.categories.delete');