<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\productImages;
use App\Traits\generalTrait;

class ProdctController extends Controller
{
    use generalTrait;


    ######################### Start Product Task ########################
    public function addimage(Request $request){
        productImages::create([
            'image'          => $request->image,
            'product_id'    => $request->product_id,
        ]);

        return $this->returnSuccessMessage('Product Image Add Successfully' );
    }


    public function activeProduct(Request $request){

            Product::where('id', $request->id)->update(['active'=> 1]);
            return $this->returnSuccessMessage('Product Updated Successfully' );
    }

    public function stopProduct(Request $request){

            Product::where('id', $request->id)->update(['active'=> 0]);
            return $this->returnSuccessMessage('Product Updated s Successfully' );
    }


    public function showActiveProduct(){

            $products = Product::where('active', 1)->get();
            return $this->returnData('products', $products );
    }


    public function showStopProduct(){
        
            $products = Product::where('active', 0)->get();
            return $this->returnData('products', $products );
    }



    public function showHighPrice(){
        
            $products = Product::where('price', '>', 100)->get();
            return $this->returnData('products', $products );
    }


    public function showLowPrice(){
        
            $products = Product::where('price', '<', 100)->get();
            return $this->returnData('products', $products );
    }


    public function CategoryNotHasProducts(){
        $category =  Category::whereDoesntHave('products')->get();
        return $this->returnData('category', $category );
    }


    public function CategoryHasHighProducts(){
        $category =  Category::whereHas('products', function($query){
            $query->where('price', '>', 100);
        })->get();
        return $this->returnData('category', $category );
    }


    public function CategoryHasLowProducts(){
        $category =  Category::whereHas('products', function($query){
            $query->where('price', '<', 100);
        })->get();
        return $this->returnData('category', $category );
    }


    public function CategoryWithProducts(){
        $category =  Category::with('products')->get();

        foreach ($category as $categories){
            return response()->json([
            'status'    => true,
            'errNum'    => 'S000',
            'Category Name'     => $categories->name,
            'Category Image'    => $categories->image,
            'Category Active'   => $categories->active,
            'products'  => $categories->products,
        ]);
        }
    }



    public function ActiveCategoryWithActiveProducts(){
        $category =  Category::where('active', 1)->whereHas('products', function($query){
            $query->where('active',  1);
        })->get();
        foreach ($category as $categories){
            return response()->json([
            'status'    => true,
            'errNum'    => 'S000',
            'Category Name'     => $categories->name,
            'Category Image'    => $categories->image,
            'Category Active'   => $categories->active,
            'products'  => $categories->products,
        ]);
        }
    }

    ######################### End Product Task ########################
}
