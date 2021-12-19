<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Employee;

use App\Models\Token;
use Illuminate\Support\Str;
use DateTime;

class LoginController extends Controller
{
    

    public function loginSubmit(Request $request){
        // $this->validate(
        //     $request,
        //     [
        //         'pNumber'=>'required|regex:/^[0-9]*$/',
        //         'pass'=>'required|min:4',
        //     ],
        //     [
        //         'pNumber.required'=>'Please put your phone number',
        //         'pass.required'=>'Please put your password',
        //     ]
        // );
      
    
        $customer = Customer::where(['pNumber'=>$request->name,'pass'=>$request->password])->first();
        $employee = Employee::where(['pNumber'=>$request->name,'pass'=>$request->password])->first();
        
        
        $type ="";
        $id = "";

        if($customer!=""){
            $type = "customer"; 
            $id = $customer->id;
        }
        else if($employee != ""){
            $type = $employee->empType;
            $id = $employee->id;
        }
        
        
       if($type != ""){
            $api_token = Str::random(64);
            $token = new Token();
            $token->userid = $id;
            $token->type = $type;
            $token->token = $api_token;
            $token->created_at = new DateTime();
            $token->save();
            return $token;
       }
       else{
            return "No user";
       }

        
    }
    
}
