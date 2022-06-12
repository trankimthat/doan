<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCartRequest;
use App\Models\ChiTietHoaDon;
use App\Models\SanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChiTietHoaDonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home_page_new.pages.Oder.index');
    }

    public function addToCart(AddCartRequest $request)
    {
        // Phải kiểm tra xem là đã login hay chưa?
        $agent = Auth::guard('agent')->user();
        if($agent) {
            $sanPham = SanPham::find($request->san_pham_id);

            $chiTietDonHang = ChiTietHoaDon::where('san_pham_id', $request->san_pham_id)
                                            ->where('is_cart', 1)
                                            ->where('agent_id', $agent->id)
                                            ->first();
            // dd($chiTietDonHang, $sanPham);

            if($chiTietDonHang) {
                $chiTietDonHang->so_luong += $request->so_luong;
                $chiTietDonHang->save();
            } else {
                ChiTietHoaDon::create([
                    'san_pham_id'       => $sanPham->id,
                    'ten_san_pham'      => $sanPham->ten_san_pham,
                    'don_gia'           => $sanPham->gia_khuyen_mai ? $sanPham->gia_khuyen_mai : $sanPham->gia_ban,
                    'so_luong'          => $request->so_luong,
                    'is_cart'           => 1,
                    'agent_id'          => $agent->id,
                ]);
            }
            return response()->json(['status' => true]);
        } else {
            return response()->json(['status' => false]);
        }
    }
    // public function addToCartUpdate(AddToCartRequest $request){
    //     $agent = Auth::guard('agent')->user();

    //     if($agent) {
    //         $sanPham = SanPham::find($request->san_pham_id);

    //         $chiTietDonHang = ChiTietDonHang::where('san_pham_id', $request->san_pham_id)
    //                                         ->where('is_cart', 1)
    //                                         ->where('agent_id', $agent->id)
    //                                         ->first();

    //         if($chiTietDonHang) {
    //             $chiTietDonHang->so_luong = $request->so_luong;
    //             $chiTietDonHang->save();
    //         } else {
    //             ChiTietDonHang::create([
    //                 'san_pham_id'       => $sanPham->id,
    //                 'ten_san_pham'      => $sanPham->ten_san_pham,
    //                 'don_gia'           => $sanPham->gia_khuyen_mai ? $sanPham->gia_khuyen_mai : $sanPham->gia_ban,
    //                 'so_luong'          => $request->so_luong,
    //                 'is_cart'           => 1,
    //                 'agent_id'          => $agent->id,
    //             ]);
    //         }
    //         return response()->json(['status' => true]);
    //     } else {
    //         return response()->json(['status' => false]);
    //     }
    // }
     public function dataCart(){
        $agent = Auth::guard('agent')->user();
        if($agent){
            $data = ChiTietHoaDon::join('san_phams', 'chi_tiet_hoa_dons.san_pham_id', 'san_phams.id')
                                   ->where('agent_id', $agent->id)
                                   ->where('is_cart', 1)
                                   ->select('chi_tiet_hoa_dons.*', 'san_phams.anh_dai_dien')
                                   ->get();
            return response()->json(['data' => $data]);
        }
    }

    // public function removeCart(Request $request){
    //     $agent = Auth::guard('agent')->user();
    //     $id_sanPham = $request->id;
    //     if($agent){
    //         $chiTietDonHang = ChiTietDonHang::where('is_cart', 1)
    //                                         ->where('agent_id', $agent->id)
    //                                         ->where('san_pham_id', $request->san_pham_id)
    //                                         ->first();
    //         $chiTietDonHang->delete();
    //     }
    // }
}
