<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use App\Traits\generalTrait;
use App\Employee;
use App\Client;
use App\Category;
use App\Product;
use App\ShoppingCart;
use Illuminate\Support\Facades\Hash;
use Auth;
use JWTAuth;

class ClientController extends Controller
{
    //
    use generalTrait;

    public function login(Request $request){
        $rules = [
            "email"     => "required",
            "password"  => "required",
        ];

        $validator = Validator::make($request->all(), $rules);
        $active_status = Client::select('active')->where('email', '=',$request->email)->get();
        foreach($active_status as $status){
            $active = $status->active;
        }

        if($active  == 1){
            $creditionals = $request -> only(['email', 'password']);

            $token = Auth::guard('client-api')->attempt($creditionals);
            $client = Auth::guard('client-api')->user();
            $client -> api_token = $token;

            if(!$token)
                return $this->returnError('E002', 'UserName or password is Incorrect');

            //return token
            return $this->returnData('client', $client);
        }else{
            return $this->returnError('E001', 'Account Not Active');
        }
    }


    public function logout(Request $request){
        $token = $request->token;
        if($token){
            JWTAuth::setToken($token)->invalidate();
            return $this->returnSuccessMessage('Client Logout Successfully');
        }else{
            return $this->returnError('', 'Something Incorrect');
        }
    }



    public function buy(Request $request){
        $shop = ShoppingCart::find($request->id)->get();
        if($shop){
            ShoppingCart::where('id', $request->id)->update(['buy'=>1]);
            return $this->returnSuccessMessage('S000', 'Shopping Cart buyed Successfully');
        }else{
            return $this->returnError('E002', 'Shopping Cart Not Found');
        }
    }



    public function addProductToShoppingCart(Request $request){

        $shopcart = ShoppingCart::create([
            'client_id' => $request->client_id,
            'product_id'=> $request->product_id,
            'number_ofProduct'=>$request->number_ofProduct,
            'totalPrice'=> $request->totalPrice,
            'buy'       => $request->buy,
        ]);
        return $this->returnData('shoppingcart', $shopcart);
    }


    public function deleteShoppingCart(Request $request){
        $shop = ShoppingCart::find($request->id)->get();
        if($shop){
            ShoppingCart::where('id', $request->id)->delete();
            return $this->returnSuccessMessage('S000', 'Shopping Cart Deleted Successfully');
        }else{
            return $this->returnError('E002', 'Shopping Cart Not Found');
        }
    }


    public function showShoppingCart(Request $request){
        $shop = ShoppingCart::find($request->id);
        if($shop)
            return $this->returnData('shoppingCart', $shop);
        else
            return $this->returnError('E002', 'Shopping Cart Not Found');
    }


    public function sendMail(){
        $user = null;
        \Mail::to('mabdalneeam@gmail.com')->send(new \App\Mail\NewMail($user));
        return $this->returnSuccessMessage('S000', 'Mail Sent Successfully');
    }
}
