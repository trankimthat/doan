<?php

namespace App\Http\Controllers;

use App\Models\Ban;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class HomePageController extends Controller
{
    public function index(){
        $agent = Auth::guard('agent')->user();
        if($agent){
         $sql = "SELECT *, (`gia_ban` - `gia_khuyen_mai`) / `gia_ban` * 100 AS `TYLE` FROM `san_phams` WHERE `is_open` = 1 ORDER BY TYLE DESC";

        $allSanPham = DB::select($sql);
        // while(strpos($id, 'post')) {
        //     $viTri = strpos($id, 'post');
        //     $id = Str::substr($id, $viTri + 4);
        // }

        // $Ban = Ban::find($id);

        // $allBan = Ban::where('id', $Ban->id)->get();

        //  dd($allBan);
        return view('home_page_new.pages.user.index', compact('allSanPham'));
        }else{
            toastr()->error('Bạn cần đăng nhập');
            return view('user.login');
        }


    }

}
