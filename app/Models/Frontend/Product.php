<?php

namespace App\Models\Frontend;

use App\Models\Admin\Product as AdminProduct;
use Illuminate\Http\Request;

class Product extends AdminProduct
{

	public static function getFrontListing(Request $request, $where = [],$select = [])
    {
    	$orderBy = $request->get('sort') ? $request->get('sort') : 'products.id';
    	$direction = $request->get('direction') ? $request->get('direction') : 'desc';
    	$page = $request->get('page') ? $request->get('page') : 1;
    	$limit =  $request->get('limit') ? $request->get('limit') : self::$paginationLimit;
    	$offset = ($page - 1) * $limit;
    	
    	$listing = Product::select( $select ?  $select : [
	    		'products.*',
                'owner.first_name as owner_first_name',
                'owner.last_name as owner_last_name'
	    	])
            ->distinct()
            ->with([
                'categories' => function($query) {
                    $query->select(['product_categories.id', 'product_categories.name']);
                }
            ])
            ->leftJoin('admins as owner', 'owner.id', '=', 'products.created_by')
            ->orderBy($orderBy, $direction);

	    if(!empty($where))
	    {
	    	foreach($where as $query => $values)
	    	{
	    		if(is_array($values))
                    $listing->whereRaw($query, $values);
                elseif(!is_numeric($query))
                    $listing->where($query, $values);
                else
                    $listing->whereRaw($values);
	    	}
	    }

	    if($page !== null && $page !== "" && $limit !== null && $limit !== "")
	    {
	    	$listing->offset($offset);
	    	$listing->limit($limit);
	    }
        
	    $listing = $listing->paginate($limit);

	    return $listing;
    }

}