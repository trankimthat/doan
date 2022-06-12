<?php

namespace App\Http\Controllers;

use App\Models\Ban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BanUserController extends Controller
{
    public function index(){
         $agent = Auth::guard('agent')->user();
         if($agent){
            return view('user.ban.index');
         }else{
            toastr()->error('Bạn cần đăng nhập');
             return view('user.login');
         }

    }
    public function getData()
    {

        $data = Ban::all();
        return response()->json([
            'dulieu' => $data,
        ]);
    }
}
