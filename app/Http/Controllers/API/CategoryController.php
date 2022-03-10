<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Traits\generalTrait;

class CategoryController extends Controller
{
    use generalTrait;


    public function activeCategory(Request $request){

            Category::where('id', $request->id)->update(['active'=> 1]);
            return $this->returnSuccessMessage('Category Updated Successfully' );
    }

    public function stopCategory(Request $request){

            Category::where('id', $request->id)->update(['active'=> 0]);
            return $this->returnSuccessMessage('Category Updated Successfully' );
    }


    public function showActiveCategory(){

            $categories = Category::where('active', 1)->get();
            return $this->returnData('categories', $categories );
    }

    public function showStopCategory(){

            $categories = Category::where('active', 0)->get();
            return $this->returnData('categories', $categories );
    }
}
