<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Frontend\Product;
use App\Models\Admin\ProductCategory;
use App\Http\Controllers\Frontend\AppController;

class ProductsController extends AppController
{
	function __construct()
	{
		parent::__construct();
	}

    function index(Request $request)
    {
    	$where = [];

    	if($request->get('search'))
    	{
    		$search = $request->get('search');
    		$search = '%' . $search . '%';
    		$where['(
	    		products.name LIKE ? 
	    	)'] = [$search];
    	}
    	if($request->get('category_id'))
    	{
    		$catId = $request->get('category_id');
    		$where['products.category_id = ?'] = [$catId];
    	}
    	
    	$listing = Product::getFrontListing($request, $where);

    	$filters = $this->filters($request);

    	return view(
    		"frontend/products/index", 
    		[
    			'listing' => $listing,
    			'categories' => $filters['categories'],
    		]
    	);
    }

    function filters(Request $request)
    {
    	
		$categories = [];
		$catIds = Product::distinct()->pluck('category_id')->toArray();
		if($catIds)
		{
	    	$categories = ProductCategory::getAll(
	    		[
	    			'product_categories.id',
	    			'product_categories.name',
	    			
	    		],
	    		[
	    			'product_categories.id in ('.implode(',', $catIds).')'
	    		],
	    	);
	    }
    	return [
    		'categories' => $categories,
    	];
    }
}
