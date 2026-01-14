<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
  
  function createAdmin(){

     $admin=User::create([
       'name'=>'admin123',
       'email'=>'admin123@gmail.com',
       'password'=>'123',
       'role'=>'admin'
     ]);
       return ["message"=>"create admin","admin"=>$admin];
  }

  function dashboard(){
    //return view('admin_dashboard');
  }

  function logout(){
    Auth::logout();
    return "logout";
  }
}
