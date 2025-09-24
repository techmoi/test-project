<?php

namespace App\Models\Admin;

use App\Models\AppModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Libraries\FileSystem;
use Illuminate\Support\Str;
use App\Libraries\General;
use App\Models\Admin\Setting;

class Product extends AppModel
{
    protected $table = 'products';
    protected $primaryKey = 'id';

    use SoftDeletes;
   
    public function categories()
    {
        return $this->hasOne(ProductCategory::class,'id','category_id');
    }

    public function owner()
    {
        return $this->belongsTo(Admin::class, 'created_by', 'id');
    }

    public static function getListing(Request $request, $where = [])
    {
    	$orderBy = $request->get('sort') ? $request->get('sort') : 'products.id';
    	$direction = $request->get('direction') ? $request->get('direction') : 'desc';
    	$page = $request->get('page') ? $request->get('page') : 1;
    	$limit = self::$paginationLimit;
    	$offset = ($page - 1) * $limit;
    	
    	$listing = Product::select([
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

	    // Put offset and limit in case of pagination
	    if($page !== null && $page !== "" && $limit !== null && $limit !== "")
	    {
	    	$listing->offset($offset);
	    	$listing->limit($limit);
	    }
        
	    $listing = $listing->paginate($limit);

	    return $listing;
    }

    /**
    * To get all records
    * @param $where
    * @param $orderBy
    * @param $limit
    */
    public static function getAll($select = [], $where = [], $orderBy = 'products.id desc', $limit = null)
    {
    	$listing = Product::orderByRaw($orderBy);

    	if(!empty($select))
    	{
    		$listing->select($select);
    	}
    	else
    	{
    		$listing->select([
    			'products.*'
    		]);	
    	}

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
	    
	    if($limit !== null && $limit !== "")
	    {
	    	$listing->limit($limit);
	    }

	    $listing = $listing->get();

	    return $listing;
    }

    /**
    * To get single record by id
    * @param $id
    */
    public static function get($id)
    {
    	$record = Product::where('id', $id)
            ->with([
                'categories' => function($query) {
                    $query->select(['product_categories.id', 'product_categories.name']);
                },
                'owner' => function($query) {
                    $query->select(['id', 'first_name', 'last_name']);
                },
            ])
            ->first();
            
	    return $record;
    }

    /**
    * To insert
    * @param $where
    * @param $orderBy
    */
    public static function create($data)
    {
    	$product = new Product();

    	foreach($data as $k => $v)
    	{
    		$product->{$k} = $v;
    	}

        $product->created_by = AdminAuth::getLoginId();

	    if($product->save())
	    {
            if(isset($data['title']) && $data['title'])
            {
                $product->slug = Str::slug($product->title) . '-' . General::encode($product->id);
                $product->save();
            }

	    	return $product;
	    }
	    else
	    {
	    	return null;
	    }
    }

    /**
    * To update
    * @param $id
    * @param $where
    */
    public static function modify($id, $data)
    {
    	$product = Product::find($id);
    	foreach($data as $k => $v)
    	{
    		$product->{$k} = $v;
    	}
        
	    if($product->save())
	    {
            if(isset($data['title']) && $data['title'])
            {
                $product->slug = Str::slug($product->title) . '-' . General::encode($product->id);
                $product->save();
            }

	    	return $product;
	    }
	    else
	    {
	    	return null;
	    }
    }

    /**
    * To delete
    * @param $id
    */
    public static function remove($id)
    {
    	$product = Product::find($id);
    	return $product->delete();
    }


   
}