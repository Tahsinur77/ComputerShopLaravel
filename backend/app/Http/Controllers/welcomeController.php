<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class welcomeController extends Controller
{
    //
   

    


    public function logout(Request $req){
        $req->session()->flush();
        return redirect()->route('welcome');
    }



}
