<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteChiTietNhapKhoRequest;
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
        $hash = Str::uuid();
        foreach($data as $key => $value) {
            // Cập nhật số lượng của sản phẩm
            $sanPham = SanPham::find($value->id_san_pham);
            if($sanPham) {
                if($value->so_luong > 0 && $value->don_gia > 0) {
                    $value->thanh_tien      = $value->so_luong * $value->don_gia;
                    $value->type            = 1;
                    $value->hash            = $hash;
                    $value->ten_san_pham    = $sanPham->ten_san_pham;
                    $value->save();

                    $sanPham->so_luong = $sanPham->so_luong + $value->so_luong;
                    $sanPham->save();
                } else {
                    $value->delete();
                }
            } else {
                $value->delete();
            }
        }
    }

    public function loadData()
    {
        $data = Kho::where('type', 0)->get();

        return response()->json(['nhapKho' => $data]);
    }

    public function store($id)
    {
        $sanPham = SanPham::find($id);
        if($sanPham) {
            $khoHang = Kho::where('id_san_pham', $id)->where('type', 0)->first();
            if($khoHang) {
                $khoHang->so_luong++;
                $khoHang->save();
            } else {
                Kho::create([
                    'id_san_pham'       => $sanPham->id,
                    'ten_san_pham'      => $sanPham->ten_san_pham,
                    'so_luong'          => 1,
                ]);
            }
            return response()->json(['status' => true]);
        } else {
            return response()->json(['status' => false]);
        }
    }

    public function show(Kho $khoHang)
    {
        //
    }


    public function edit(Kho $khoHang)
    {
        //
    }

    public function update(Request $request)
    {
        // $request->id, $request->so_luong, $request->don_gia
        $khoHang = Kho::where('id', $request->id)->where('type', 0)->first();

        if($khoHang) {
            $khoHang->so_luong = $request->so_luong;
            $khoHang->don_gia  = $request->don_gia;
            $khoHang->save();

            return response()->json(['status' => true]);
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
