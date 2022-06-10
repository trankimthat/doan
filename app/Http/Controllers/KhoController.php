<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteChiTietNhapKhoRequest;
use App\Http\Requests\KhoRequest;
use App\Models\DanhMucSanPham;
use App\Models\Kho;
use App\Models\SanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KhoController extends Controller
{
    public function index()
    {
        return view('admin.pages.kho.index');
    }


    public function create()
    {
        // Bước 1: Lấy toàn bộ dữ liệu đang là kho đang nhập => type = 0
        $data = Kho::where('type', 0)->get(); // trả về 1 array
        foreach($data as $key => $value) {
            // Cập nhật số lượng của sản phẩm
            $danhMuc = DanhMucSanPham::find($value->id_danh_muc);
            if($danhMuc) {
                if($value->so_luong > 0 && $value->don_gia > 0) {
                    $value->thanh_tien      = $value->so_luong * $value->don_gia;
                    $value->type            = 1;
                    $value->ten_danh_muc   = $danhMuc->ten_danh_muc;
                    $value->save();
                    $danhMuc->so_luong = $danhMuc->so_luong + $value->so_luong;
                    $danhMuc->save();
                    return response()->json(['status' => true]);
                } else {
                    $value->delete();
                    return response()->json(['status' => false]);
                }
            } else {
                $value->delete();

            }
        }
    }

    public function getData()
    {
        $data = Kho::join('danh_muc_san_phams','khos.id_danh_muc', 'danh_muc_san_phams.id')
                
                              ->select('khos.*', 'danh_muc_san_phams.ten_danh_muc')
                              ->get();
        return response()->json([
            'nhapKho' => $data,
        ]);

    }


    public function store(Request $request)
    {
        $danhMuc = DanhMucSanPham::find($request->id_danh_muc);
        if($danhMuc) {
            $khoHang = Kho::where('id_danh_muc', $request->id_danh_muc)->where('type', 0)->first();
            if($khoHang) {
                $khoHang->so_luong++;
                $khoHang->save();
            } else {
                Kho::create([
                    'id_danh_muc'       => $danhMuc->id,
                    'ten_danh_muc'      => $danhMuc->ten_danh_muc,
                    'so_luong'          => 1,
                ]);
            }
            return response()->json(['status' => true]);
        } else {
            return response()->json(['status' => false]);
        }
    }

    public function updateqty(Request $request)
    {
        // $request = $request->all();
        // $request->id, $request->so_luong, $request->don_gia
        $khoHang = Kho::where('id', $request->id)->where('type', 0)->first();

        if($khoHang) {
            $khoHang->so_luong = $request->so_luong;
            if($khoHang->so_luong > 0){
                $khoHang->save();
                return response()->json(['status' => true]);
            }else{
                return response()->json(['status' => false]);
            }

        } else {
            return response()->json(['status' => false]);
        }
    }
    public function updateprice(Request $request)
    {
        // $request->id, $request->so_luong, $request->don_gia
        $khoHang = Kho::where('id', $request->id)->where('type', 0)->first();

        if($khoHang) {
            $khoHang->don_gia = $request->don_gia;
            if($khoHang->don_gia > 0){
                $khoHang->save();
                return response()->json(['status' => true]);
            }else{
                return response()->json(['status' => false]);

            }

        } else {
            return response()->json(['status' => false]);
        }
    }

    public function destroy($id)
    {
        $khoHang = Kho::where('id', $id)->where('type', 0)->first();

        if($khoHang) {
            $khoHang->delete();
            return response()->json(['status' => true]);
        } else {
            return response()->json(['status' => false]);
        }
    }
}
