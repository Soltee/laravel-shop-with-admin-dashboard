<?php

namespace App\Http\Controllers\Administrator;

use App\Categories;
use App\Subcategories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoriesController extends Controller
{
    
	public function index()
	{
		$categories = Categories::latest()->get();
		return response()->json(['categories' => $categories], 200);
	}

    public function getCategories()
    {
        $category = request()->category;
        if($category){
            $subcategories = Subcategories::where('category_id', $category)->rderBy('name')->get();
            return response()->json([
                'subcategories' => $subcategories
            ], 200);
        } else {
            $categories = Categories::orderBy('name')->with('subcategories')->get();
            return response()->json([
                'categories' => $categories
            ], 200);
        }
        
    }

    public function store(Request $request)
    {
    	// dd($request->all());
    	$data = $this->validate($request, [
    		'name' => ['string', 'min:3']
    	]);

    	$category = Categories::create([
    		'name' => $data['name']
    	]);

    	return response()->json(['category' => $category], 201);
    }
}
