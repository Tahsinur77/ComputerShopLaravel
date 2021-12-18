<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Models\Customer;
use App\Models\Employee;

class userType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $customer = Customer::where(['pNumber'=>$request->pNumber,'pass'=>$request->pass])->first();
        $employee = Employee::where(['pNumber'=>$request->pNumber,'pass'=>$request->pass])->first();
        
        
        $type ="";

        if($customer!=""){
            $type = "customer"; 
       
            $request->session()->put('id',$customer->id);  
            $request->session()->put('name',$customer->cName);
        }
        else if($employee != ""){
            $type = $employee->empType;
            $request->session()->put('id',$employee->id);  
            $request->session()->put('name',$employee->eName);
        }
        $request->session()->put('type',$type);
        return $next($request);
    }
}
