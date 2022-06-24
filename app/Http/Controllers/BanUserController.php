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
    public function ban($id)
    {
        $ban = Ban::find($id);
        if($ban) {
            return response()->json([
                'status'  =>  true,
                // 'data'    =>  $ban,
            ]);
        } else {
            return response()->json([
                'status'  =>  false,
            ]);
        }
    }
    public function doiTrangThai($id)
    {
        $ban = Ban::find($id);
        if($ban) {
            $ban->is_open = !$ban->is_open;
            $ban->save();
            return response()->json([
                'trangThai'         =>  true,
                'tinhTrangBan'      =>  $ban->is_open,
            ]);
        } else {
            return response()->json([
                'trangThai'         =>  false,
            ]);
        }
    }
}
