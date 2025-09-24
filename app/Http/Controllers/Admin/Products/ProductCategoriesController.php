<?php

namespace App\Http\Controllers\Admin\Products;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Admin\Admin;
use App\Models\Admin\ProductCategory;
use App\Http\Controllers\Admin\AppController;

class ProductCategoriesController extends AppController
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
    			product_categories.title LIKE ? 
    			or 
    			parent.title LIKE ? 
    			or 
    			concat(owner.first_name," ",owner.last_name) LIKE ? 
    			or 
    			owner.last_name LIKE ?
    		)'] = [$search, $search, $search, $search];
    	}

    	if($request->get('created_on'))
    	{
    		$createdOn = $request->get('created_on');
    		if(isset($createdOn[0]) && !empty($createdOn[0]))
    			$where['product_categories.created_at >= ?'] = [
    				date('Y-m-d 00:00:00', strtotime($createdOn[0]))
    			];
    		if(isset($createdOn[1]) && !empty($createdOn[1]))
    			$where['product_categories.created_at <= ?'] = [
    				date('Y-m-d 23:59:59', strtotime($createdOn[1]))
    			];
    	}

    	if($request->get('category'))
    	{
    		$parentIds = $request->get('category');
    		$parentIds = implode(',', $parentIds);
    		$where[] = 'product_categories.parent_id IN ('.$parentIds.')';
    	}

    	if($request->get('admins'))
    	{
    		$admins = $request->get('admins');
    		$admins = $admins ? implode(',', $admins) : 0;
    		$where[] = 'product_categories.created_by IN ('.$admins.')';
    	}

    	$listing = ProductCategory::getListing($request, $where);


    
		/** Filter Data **/
		$filters = $this->filters($request);
    	/** Filter Data **/

    	return view(
    		"admin/products/categories/index", 
    		[
    			'listing' => $listing,
    			'admins' => $filters['admins']
    		]
    	);
    }

    function filters(Request $request)
    {

		$admins = [];
		$adminIds = ProductCategory::distinct()->whereNotNull('created_by')->pluck('created_by')->toArray();
		if($adminIds)
		{
	    	$admins = Admin::getAll(
	    		[
	    			'admins.id',
	    			'admins.first_name',
	    			'admins.last_name',
	    			'admins.status',
	    		],
	    		[
	    			'admins.id in ('.implode(',', $adminIds).')'
	    		],
	    		'concat(admins.first_name, admins.last_name) desc'
	    	);
	    }
    	return [
	    	'admins' => $admins
    	];
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
	                'name' => 'required|unique:product_categories,name'
	            ]
	        );

	        if(!$validator->fails())
	        {
	        	$category = ProductCategory::create($data);

	        	if($category)
	        	{
	        		$request->session()->flash('success', 'Product category created successfully.');
	        		return redirect()->route('admin.products.categories');
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

	    return view("admin/products/categories/add");
    }

    function edit(Request $request, $id)
    {
    	$category = ProductCategory::get($id);

    	if($category)
    	{
	    	if($request->isMethod('post'))
	    	{
	    		$data = $request->toArray();

	    		
	    		$validator = Validator::make(
		            $request->toArray(),
		            [
		                'name' => [
		                	'required',
		                	Rule::unique('product_categories')->ignore($category->id)
		                ]
		            ]
		        );

		        if(!$validator->fails())
		        {
		        	unset($data['_token']);
	        		
	        		/** IN CASE OF SINGLE UPLOAD **/
		        	if(isset($data['image']) && $data['image'])
		        	{
		        		$oldImage = $category->image;
		        	}
		        	else
		        	{
		        		unset($data['image']);
		        		
		        	}
		        	
		        	if(ProductCategory::modify($id, $data))
		        	{
		        		$request->session()->flash('success', 'Product category updated successfully.');
		        		return redirect()->route('admin.products.categories');
		        	}
		        	else
		        	{
		        		$request->session()->flash('error', 'Product category could not be save. Please try again.');
			    		return redirect()->back()->withErrors($validator)->withInput();
		        	}
			    }
			    else
			    {
			    	$request->session()->flash('error', 'Please provide valid inputs.');
			    	return redirect()->back()->withErrors($validator)->withInput();
			    }
			}

		    return view("admin/products/categories/edit", [
		    		'category' => $category
	    		]);
		}
		else
		{
			abort(404);
		}
    }

    function delete(Request $request, $id)
    {
    	$admin = ProductCategory::find($id);
    	if($admin->delete())
    	{
    		$request->session()->flash('success', 'Product category deleted successfully.');
    		return redirect()->route('admin.products.categories');
    	}
    	else
    	{
    		$request->session()->flash('error', 'Product category could not be delete.');
    		return redirect()->route('admin.products.categories');
    	}
    }

   
}
