<?php

namespace App\Http\Controllers;

use App\Models\Ban;
use App\Models\ChiTietHoaDon;
use App\Models\HoaDon;
use App\Models\SanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DonHangController extends Controller
{
    public function store($id)
    {
            $agent = Auth::guard('agent')->user();
            if($agent) {
                $ban = Ban::find($id);
                $giohang = ChiTietHoaDon::where('is_cart', 1)
                                        ->where('agent_id', $id)
                                        ->where('id_ban', $id )
                                        ->get();
                if(empty($giohang) || count($giohang) > 0) {
                    $hoadon = HoaDon::create([
                        'ma_hoa_don'   => Str::uuid(),
                        'tong_tien'     => 0,
                        'tien_giam_gia' => 0,
                        'thuc_tra'      => 0,
                        'id_ban'        => $ban->id,
                        'agent_id'      => $agent->id,
                        'loai_thanh_toan'   => 1,
                    ]);
                    $thuc_tra = 0; $tong_tien = 0;
                    foreach($giohang as $key => $value) {
                        $sanPham = SanPham::find($value->san_pham_id);
                        if($sanPham){
                            $giaBan = $sanPham->gia_khuyen_mai ? $sanPham->gia_khuyen_mai : $sanPham->gia_ban;
                            $thuc_tra += $value->so_luong * $giaBan;
                            $tong_tien += $value->so_luong * $sanPham->gia_ban;


                            $value->don_gia  = $giaBan;
                            $value->is_cart  = 0;
                            // $value->id_ban  = $ban->id_ban;
                            $value->hoa_don_id  = $hoadon->id;
                            $value->save();
                        } else {
                            $value->delete();
                        }
                    }
                    $hoadon->thuc_tra = $thuc_tra;
                    $hoadon->tong_tien = $tong_tien;
                    $hoadon->tien_giam_gia = $tong_tien - $thuc_tra;
                    $hoadon->save();

                    return response()->json(['status' => true]);
                } else {
                    return response()->json(['status' => 2]);
                }

            }
    }
}
