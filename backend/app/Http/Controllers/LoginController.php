<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Employee;

class LoginController extends Controller
{
    

    public function loginSubmit(Request $request){
        $this->validate(
            $request,
            [
                'pNumber'=>'required|regex:/^[0-9]*$/',
                'pass'=>'required|min:4',
            ],
            [
                'pNumber.required'=>'Please put your phone number',
                'pass.required'=>'Please put your password',
            ]
        );
      

        if($request->session()->has('type')){
            $type = $request->session()->get('type');
        }
        
       return $type;

        
    }
    
}
