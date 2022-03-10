<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\generalTrait;
use App\Admin;
use App\Employee;
use App\Client;
use App\Category;
use App\Product;
use Illuminate\Support\Facades\Hash;
use Auth;
use JWTAuth;

class AdminController extends Controller
{
    use generalTrait;


    public function login(Request $request){
        $rules = [
            "email"     => "required",
            "password"  => "required",
        ];

        $validator = Validator::make($request->all(), $rules);

        $creditionals = $request -> only(['email', 'password']);

        $token = Auth::guard('admin-api')->attempt($creditionals);
        $admin = Auth::guard('admin-api')->user();
        $admin -> api_token = $token;

        if(!$token)
            return $this->returnError('E002', 'UserName or password is Incorrect');

        //return token
        return $this->returnData('admin', $admin);

    }


    public function logout(Request $request){
        $token = $request->token;
        if($token){
            JWTAuth::setToken($token)->invalidate();
            return $this->returnSuccessMessage('User Logout Successfully');
        }else{
            return $this->returnError('', 'Something Incorrect');
        }
    }


    public function addEmployee(Request $request){
        $empl = Employee::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'active'    => 1,
            'phone'     => $request->phone,
            'image'     => $request->image,
        ]);
        return $this->returnData('Employee', $empl);
    }


    public function addClient(Request $request){
        $client = Client::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'active'    => 1,
            'address'   => $request->address,
            'image'     => $request->image,
        ]);
        return $this->returnData('Client', $client);
    }

    public function DeleteEmployee(Request $request){
        if($request->id){
            Employee::find($request->id)->delete();
            return $this->returnSuccessMessage('Employee Deleted Successfully');
        }else{
            return $this->returnError('E002', 'Something Wrong');
        }
    }

    public function DeleteClient(Request $request){
        if($request->id){
            Client::find($request->id)->delete();
            return $this->returnSuccessMessage('Client Deleted Successfully');
        }else{
            return $this->returnError('E002', 'Something Wrong');
        }
    }

    public function deActiveEmployee(Request $request){
        if($request->id){
            Employee::where('id', $request->id)->update(['active'=> 0]);
            return $this->returnSuccessMessage('Employee DeActivated Successfully');
        }else{
            return $this->returnError('E002', 'Something Wrong');
        }
    }

    public function deActiveClint(Request $request){
        if($request->id){
            Client::where('id', $request->id)->update(['active'=> 0]);
            return $this->returnSuccessMessage('Client DeActivated Successfully');
        }else{
            return $this->returnError('E002', 'Something Wrong');
        }
    }


    ############################### Control Category ########################
    public function editCategory(Request $request){
        if($request->id){
            if($request->name){
                Category::where('id', $request->id)->update([ 'name' => $request->name ]);
            }

            if($request->image){
                Category::where('id', $request->id)->update([ 'image' => $request->image ]);
            }

            return $this->returnSuccessMessage("Category Updated Successfully");
        }else{
            return $this->returnError('E002', 'Something Wrong');
        }
    }

    public function editProduct(Request $request){
        if($request->id){
            if($request->name){
                Product::where('id', $request->id)->update([ 'name' => $request->name ]);
            }

            if($request->price){
                Product::where('id', $request->id)->update([ 'price' => $request->price ]);
            }

            if($request->description){
                Product::where('id', $request->id)->update([ 'description' => $request->description ]);
            }

            return $this->returnSuccessMessage("Product Updated Successfully");
        }else{
            return $this->returnError('E002', 'Something Wrong');
        }
    }
}
