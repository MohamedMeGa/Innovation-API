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
use Illuminate\Support\Facades\Hash;
use Auth;
use JWTAuth;


class EmployeeController extends Controller
{
    use generalTrait;

    public function login(Request $request){
        $rules = [
            "email"     => "required",
            "password"  => "required",
        ];

        $validator = Validator::make($request->all(), $rules);
        $active_status = Employee::select('active')->where('email', '=',$request->email)->get();
        foreach($active_status as $status){
            $active = $status->active;
        }

        if($active  == 1){
            $creditionals = $request -> only(['email', 'password']);

            $token = Auth::guard('employee-api')->attempt($creditionals);
            $employee = Auth::guard('employee-api')->user();
            $employee -> api_token = $token;

            if(!$token)
                return $this->returnError('E002', 'UserName or password is Incorrect');

            //return token
            return $this->returnData('employee', $employee);
        }else{
            return $this->returnError('E001', 'Account Not Active');
        }
    }


    public function logout(Request $request){
        $token = $request->token;
        if($token){
            JWTAuth::setToken($token)->invalidate();
            return $this->returnSuccessMessage('Employee Logout Successfully');
        }else{
            return $this->returnError('', 'Something Incorrect');
        }
    }
}
