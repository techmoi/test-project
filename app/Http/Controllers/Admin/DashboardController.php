<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Admin\Product;

class DashboardController extends AppController
{
	function __construct()
	{
		parent::__construct();
	}

    function index(Request $request)
    {
    	$select =  [
            'products.name',
            'products.price',
            'products.created_at',
        ];

        $limit = 6;
        $orderBy = 'products.created_at desc';
        $product = Product::getAll($select, orderBy :$orderBy, limit:$limit);

        return view("admin/dashboard/dashboard",[
            'product' =>$product 
        ]);
    }
}
