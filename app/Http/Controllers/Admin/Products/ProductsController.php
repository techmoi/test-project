<?php

namespace App\Http\Controllers\Admin\Products;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Admin\Admin;
use App\Models\Admin\Product;
use App\Models\Admin\ProductCategory;
use App\Http\Controllers\Admin\AppController;

class ProductsController extends AppController
{
	function __construct()
	{
		parent::__construct();
	}

    function index(Request $request)
    {
    	$where = [];
    	
    	$listing = Product::getListing($request, $where);
    	return view(
    		"admin/products/index", 
    		[
    			'listing' => $listing,
    		]
    	);
    }

    function add(Request $request)
    {
    	if($request->isMethod('post'))
    	{
    		$data = $request->toArray();
    		unset($data['_token']);

    		$validator = Validator::make(
	            $request->toArray(),
	            [
	                'name' => 'required|unique:products,name',
	                'category_id' => 'required'
	            ]
	        );

	        if(!$validator->fails())
	        {
	        	
	        	$product = Product::create($data);
	        	if($product)
	        	{
	        		$request->session()->flash('success', 'Product created successfully.');
	        		return redirect()->route('admin.products');
	        	}
	        	else
	        	{
	        		$request->session()->flash('error', 'Product could not be save. Please try again.');
		    		return redirect()->back()->withErrors($validator)->withInput();
	        	}
		    }
		    else
		    {
		    	$request->session()->flash('error', 'Please provide valid inputs.');
		    	return redirect()->back()->withErrors($validator)->withInput();
		    }
		}
	    
	    $categories = ProductCategory::getAll(['product_categories.id','product_categories.name']);

	    return view("admin/products/add", [
			'categories' => $categories
		]);
    }

    function edit(Request $request, $id)
    {
    	$product = Product::get($id);
    	if($product)
    	{
	    	if($request->isMethod('post'))
	    	{
	    		$data = $request->toArray();
	    		$validator = Validator::make(
		            $request->toArray(),
		            [
		                'name' => [
		                	'required',
		                	Rule::unique('products')->ignore($product->id)
		                ],
		                'price' => 'required',
		            ]
		        );

		        if(!$validator->fails())
		        {
		        	unset($data['_token']);
		        	
		        	if(Product::modify($id, $data))
		        	{
		        		$request->session()->flash('success', 'Product updated successfully.');
		        		return redirect()->route('admin.products');
		        	}
		        	else
		        	{
		        		$request->session()->flash('error', 'Product could not be save. Please try again.');
			    		return redirect()->back()->withErrors($validator)->withInput();
		        	}
			    }
			    else
			    {
			    	$request->session()->flash('error', 'Please provide valid inputs.');
			    	return redirect()->back()->withErrors($validator)->withInput();
			    }
			}

			$categories = ProductCategory::getAll(['product_categories.id','product_categories.name']);

			return view("admin/products/edit", [
    			'product' => $product,
    			'categories' => $categories
    		]);
		}
		else
		{
			abort(404);
		}
    }

    function delete(Request $request, $id)
    {
    	$product = Product::find($id);
    	if($product->delete())
    	{
    		$request->session()->flash('success', 'Product deleted successfully.');
    		return redirect()->route('admin.products');
    	}
    	else
    	{
    		$request->session()->flash('error', 'Product could not be delete.');
    		return redirect()->route('admin.products');
    	}
    }

}
