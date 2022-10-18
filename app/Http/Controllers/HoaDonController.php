<?php

namespace App\Http\Controllers;

use App\Models\agent;
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
                        ->join('agents','agents.id','hoa_dons.agent_id')
                        //  ->join('san_phams', 'chi_tiet_hoa_dons.san_pham_id', 'san_phams.id')
                        ->where('xuat_hoa_don', 1)
                        ->where('bans.id', $id)
                        ->select('hoa_dons.*','chi_tiet_hoa_dons.*','bans.ma_ban','agents.ho_va_ten')
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


/// PHẦN HÓA ĐƠN THEO NGÀY


   //Hóa đơn từng ngày của quán Cafe
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
                    ->join('agents','agents.id','hoa_dons.agent_id')
                     ->whereDate('ngay_hoa_don',$request->ngay_hoa_don)
                     ->select('hoa_dons.*','bans.ma_ban','agents.ho_va_ten')
                     ->orderBy('hoa_dons.id', 'desc')
                     ->get();
     return response()->json([
        'ngay_hoa_don' => $hoadon,
       ]);
   }
   public function HoaDon($id){
        // $HoaDon = HoaDon::find($id);
        // dd($HoaDon);
        // if($HoaDon) {
            $data = HoaDon::join('chi_tiet_hoa_dons','chi_tiet_hoa_dons.hoa_don_id','hoa_dons.id')
                            ->where('chi_tiet_hoa_dons.hoa_don_id',$id)
                            ->select('hoa_dons.*','chi_tiet_hoa_dons.id as id_chi_tiet','chi_tiet_hoa_dons.*')
                            ->get();
            return response()->json([
                'status'  =>  true,
                'dataNe'    =>  $data,
            ]);
        // } else {
        //     return response()->json([
        //         'status'  =>  false,
        //     ]);
        // }
    }
    public function search(Request $request)
    {
        $data = agent::join('hoa_dons','hoa_dons.agent_id','agents.id')
                    ->join('bans','bans.id','hoa_dons.id_ban')
                    ->where('ho_va_ten', 'like', '%' . $request->tenNhanVien .'%')
                    ->whereDate('hoa_dons.ngay_hoa_don',$request->ngay_hoa_don)
                    ->select('agents.ho_va_ten','bans.ma_ban','hoa_dons.ngay_hoa_don','hoa_dons.id')
                    ->orderBy('hoa_dons.id', 'desc')
                    ->get();
        // dd($data);
        return response()->json(['dataProduct' => $data]);

    }
    public function updateqty(Request $request)
    {
        // $request = $request->all();
        // $request->id, $request->so_luong, $request->don_gia
        $khoHang = ChiTietHoaDon::where('id', $request->id)->first();
        // $sanPham = SanPham::where('id', $request->id)->first();
        $total = 0;
        $thuc_tra = 0;
        if($khoHang) {
            // $sanPham = SanPham::find($khoHang->san_pham_id);
            // if($sanPham)
            // {
                $khoHang->so_luong = $request->so_luong;
            // }
            if($khoHang->so_luong > 0){
                $khoHang->save();
                $hoaDon = HoaDon::find($khoHang->hoa_don_id);
                 if($hoaDon){
                    $chiTiet = ChiTietHoaDon::join('san_phams', 'chi_tiet_hoa_dons.san_pham_id', 'san_phams.id')->where('hoa_don_id', $khoHang->hoa_don_id)->where('is_cart', 0)->select('san_phams.gia_ban', 'chi_tiet_hoa_dons.*')->get();
                    foreach ($chiTiet as $value) {
                        $sanPham = SanPham::find($value->san_pham_id);
                        if($sanPham){
                            $giaBan = $sanPham->gia_khuyen_mai ? $sanPham->gia_khuyen_mai : $sanPham->gia_ban;
                            $total += $value->gia_ban * $value->so_luong;
                        // dd($giaBan);
                            $thuc_tra += $value->so_luong * $giaBan;
                        }

                    }
                        // $giaBan = $sanPham->gia_khuyen_mai ? $sanPham->gia_khuyen_mai : $sanPham->gia_ban;
                        $hoaDon->tong_tien = $total;
                        $hoaDon->thuc_tra = $thuc_tra;
                        $hoaDon->tien_giam_gia = $hoaDon->tong_tien - $hoaDon->thuc_tra;
                        $hoaDon->save();
                    // $hoaDon->thuc_tra = $khoHang->so_luong * $khoHang->don_gia;
                    // $hoaDon->save();
                 }

                    return response()->json(['status' => true,
                    'kho_hang' => $khoHang
                    ]);
            }else{
                return response()->json(['status' => false]);
            }
            ///
            // }

        } else {
            return response()->json(['status' => false]);
        }
    }
    public function ngayHoaDon($id){
        $HoaDon = HoaDon::find($id);
        if($HoaDon) {
            return response()->json([
                'status'  =>  true,
                'data'    =>  $HoaDon,
            ]);
        } else {
            return response()->json([
                'status'  =>  false,
            ]);
        }
    }
    public function destroy($id){
        $hoaDon = ChiTietHoaDon::find($id);
        // $total = 0;
        // $thuc_tra = 0;
        if($hoaDon) {
                $hoaDon->delete();
                // $hoaDon = HoaDon::find($hoaDon->hoa_don_id);
                //     if($hoaDon){
                //         $chiTiet = ChiTietHoaDon::join('san_phams', 'chi_tiet_hoa_dons.san_pham_id', 'san_phams.id')
                //                                 ->where('hoa_don_id', $hoaDon->hoa_don_id)
                //                                 ->where('is_cart', 0)
                //                                 ->select('san_phams.gia_ban', 'chi_tiet_hoa_dons.*')
                //                                 ->get();
                //         foreach ($chiTiet as $value) {
                //             $sanPham = SanPham::find($value->san_pham_id);
                //             if($sanPham){
                //                 $giaBan = $sanPham->gia_khuyen_mai ? $sanPham->gia_khuyen_mai : $sanPham->gia_ban;
                //                 $total += $value->gia_ban * $value->so_luong;
                //             // dd($giaBan);
                //                 $thuc_tra += $value->so_luong * $giaBan;
                //             }

                //         }
                //             // $giaBan = $sanPham->gia_khuyen_mai ? $sanPham->gia_khuyen_mai : $sanPham->gia_ban;
                //             $hoaDon->tong_tien = $total;
                //             $hoaDon->thuc_tra = $thuc_tra;
                //             $hoaDon->tien_giam_gia = $hoaDon->tong_tien - $hoaDon->thuc_tra;
                //             $hoaDon->save();
                return response()->json([
                    'status'  =>  true,
                    'kho_hang' => $hoaDon,
                ]);
            } else {
                return response()->json([
                    'status'  =>  false,
                ]);
            }
        }
    // }
    public function StoreDoanhThu($id)
    {
        $data = HoaDon::where('id',$id)
                        ->where('xuat_hoa_don',0)
                        ->get();
        if(count($data)>0){
            return response()->json([
                'status'    => true,
                'kho_hang'  => $data,
            ]);
        }else{
            return response()->json([
                'status'    => false,
            ]);
        }
    }
}
