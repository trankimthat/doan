<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCartRequest;
use App\Models\Ban;
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
        // dd($request->all);
        // Phải kiểm tra xem là đã login hay chưa?
        $agent = Auth::guard('agent')->user();
        if ($agent) {
            $sanPham = SanPham::find($request->san_pham_id);
            $ban = Ban::find($request->id_ban);
            // $ban = Ban::all();
            $chiTietDonHang = ChiTietHoaDon::where('san_pham_id', $request->san_pham_id)
                ->where('is_cart', 1)
                ->where('id_ban', $ban->id)
                ->where('agent_id', $agent->id)
                ->first();

            if ($chiTietDonHang) {
                $chiTietDonHang->so_luong += $request->so_luong;
                $chiTietDonHang->save();
            } else {
                ChiTietHoaDon::create([
                    'san_pham_id'       => $sanPham->id,
                    'ten_san_pham'      => $sanPham->ten_san_pham,
                    'don_gia'           => $sanPham->gia_khuyen_mai ? $sanPham->gia_khuyen_mai : $sanPham->gia_ban,
                    'so_luong'          => $request->so_luong,
                    'id_ban'            => $ban->id,
                    'is_cart'           => 1,
                    'agent_id'          => $agent->id,
                ]);
            }
            return response()->json(['status' => true]);
        } else {
            return response()->json(['status' => false]);
        }
    }

    public function updateqty(Request $request)
    {

        $mon = ChiTietHoaDon::where('id', $request->id)->where('is_cart', 1)->whereNull('hoa_don_id')->first();
        if ($mon) {
            $mon->so_luong = $request->so_luong;
            if ($mon->so_luong > 0) {
                $mon->save();
                return response()->json(['status' => true]);
            } else {
                return response()->json(['status' => false]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }
    public function dataCart($id)
    {

        $agent = Auth::guard('agent')->user();
        if ($agent) {
            $data = ChiTietHoaDon::join('san_phams', 'chi_tiet_hoa_dons.san_pham_id', 'san_phams.id')
                ->where('agent_id', $agent->id)
                ->where('id_ban', $id)
                ->where('is_cart', 1)
                ->select('chi_tiet_hoa_dons.*', 'san_phams.anh_dai_dien', 'san_phams.gia_ban')
                ->get();

            return response()->json(['data' => $data]);
        }
    }

    public function removeCart($id)
    {
        $agent = Auth::guard('agent')->user();
        $chiTietDonHang = ChiTietHoaDon::where('is_cart', 1)
            ->where('agent_id', $agent->id)
            ->where('id',  $id)
            ->whereNull("hoa_don_id")
            ->first();
        if ($chiTietDonHang) {
            $chiTietDonHang->delete();
            return response()->json(['status' => true]);
        } else {
            return response()->json(['status' => false]);
        }
    }
}
