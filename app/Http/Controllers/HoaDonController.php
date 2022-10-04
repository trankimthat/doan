<?php

namespace App\Http\Controllers;

use App\Models\Ban;
use App\Models\ChiTietHoaDon;
use App\Models\HoaDon;
use App\Models\SanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class HoaDonController extends Controller
{
    public function index(){
        $check = Auth::guard('Admin')->user();
        if($check){
            return view('admin.pages.hoa_don.index');
        }else{
            toastr()->error('Bạn cần phải đăng nhập');
            return view('admin.login');
        }
    }
    public function banData()
    {
        $data = Ban::all();
        return response()->json([
            'dulieu' => $data,
        ]);
    }
    public function getData($id)
    {


        $data = HoaDon::join('chi_tiet_hoa_dons','chi_tiet_hoa_dons.hoa_don_id', 'hoa_dons.id')
                        ->join('bans' , 'bans.id' , 'hoa_dons.id_ban')
                        //  ->join('san_phams', 'chi_tiet_hoa_dons.san_pham_id', 'san_phams.id')
                            ->where('xuat_hoa_don', 1)
                            ->where('bans.id', $id)
                            ->select('hoa_dons.*','chi_tiet_hoa_dons.*','bans.ma_ban')
                            ->get();

        return response()->json([
            'dulieu' => $data,
        ]);


    }
    public function ban($id){
        $ban = Ban::find($id);
        if($ban) {
            return response()->json([
                'status'  =>  true,
                'data'    =>  $ban,
            ]);
        } else {
            return response()->json([
                'status'  =>  false,
            ]);
        }
    }

   public function store($id){
    $admin = Auth::guard('Admin')->user();
    if($admin){
        // $ban = Ban::find($id);
        $data = HoaDon::where('id_ban',$id)
                        ->where('xuat_hoa_don',1)
                        ->get();
        // if($ban){
            if(count($data)>0){
                foreach ($data as $value) {
                    $tmp  = HoaDon::find($value->id);
                    $tmp->xuat_hoa_don = 0;
                    $tmp->save();
                    // dd($tmp);
                }
                return response()->json([
                    'status'=>true,
                ]);
            }else{
                return response()->json([
                    'status'=>false,
                ]);
            }
        // }else{
        //     toastr()->error('id bàn không đúng');
        // }
    }else{
        toastr()->error('bạn cần phải đăng nhập');
    }
   }
   public function page(){
    $check = Auth::guard('Admin')->user();
    if($check){
        return view('admin.pages.doanh_thu.index');
    }else{
        toastr()->error('Bạn cần đăng nhập');
        return view('admin.login');
    }
   }
   public function tongHD(Request $request){
    $hoadon = HoaDon::join('bans','bans.id','hoa_dons.id_ban')
                     ->whereDate('ngay_hoa_don',$request->ngay_hoa_don)
                     ->select('hoa_dons.*','bans.ma_ban')
                     ->get();
     return response()->json([
        'ngay_hoa_don' => $hoadon,
       ]);
   }
}
