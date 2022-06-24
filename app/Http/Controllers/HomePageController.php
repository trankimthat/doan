<?php

namespace App\Http\Controllers;

use App\Models\Ban;
use App\Models\DanhMucSanPham;
use App\Models\SanPham;
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

         return view('home_page_new.pages.user.index', compact('allSanPham'));
        // return view('home_page_new.pages.user.index');
        }else{
            toastr()->error('Bạn cần đăng nhập');
            return view('user.login');
        }
    }
    // public function getData($id){
    //     $agent = Auth::guard('agent')->user();
    //     $danhmuc = DanhMucSanPham::find($id);
    //     if($agent){
    //         $sanPham = SanPham::join('danh_muc_san_phams', 'danh_muc_san_phams.id', 'san_phams.id_danh_muc')
    //                             ->where('id_danh_muc_cha',$danhmuc->id)
    //                             ->where('danh_muc_san_phams.id_danh_muc_cha','<>',0)
    //                             ->select('san_phams.*')
    //                             ->get();
    //         // dd($sanPham->toArray());
    //                             return response()->json(['data' => $sanPham]);
    //     }
    // }
    // public function search(Request $request)
    // {
    //     $agent = Auth::guard('agent')->user();
    //     $idBan = $request->id_ban;
    //     // array_push($idBan, $request->id_ban);
    //     if($agent){
    //      $sql = "SELECT *, (`gia_ban` - `gia_khuyen_mai`) / `gia_ban` * 100 AS `TYLE` FROM `san_phams` WHERE `is_open` = 1 and `ten_san_pham` like '%".$request->search_sp ."%' ORDER BY TYLE DESC";
    //      $allSanPham = DB::select($sql);
    //             return view('home_page_new.pages.user.index', compact('allSanPham', 'idBan'));

    //     // return view('home_page_new.pages.user.index');
    //     }else{
    //         toastr()->error('Bạn cần đăng nhập');
    //         return view('user.login');
    //     }
    // }

}
