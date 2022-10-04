<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index(){
        return view('admin.login');
    }
    public function loginAdmin(AdminRequest $request)
    {
        $data  = $request->all();
        // dd($data);
        $check = Auth::guard('Admin')->attempt($data);
        // dd($check);
        if($check) {
                return response()->json(['status' => 1]);

                // dd(2);
         } else{
            //Login thất bại
            return response()->json(['status' => 0]);
        }
    }
    public function logout(){
        Auth::guard("Admin")->logout();
        return redirect("/");
    }
}
