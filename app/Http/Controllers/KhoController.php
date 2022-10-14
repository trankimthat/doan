<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteChiTietNhapKhoRequest;
use App\Http\Requests\KhoRequest;
use App\Models\DanhMucSanPham;
use App\Models\Kho;
use App\Models\NguyenLieu;
use App\Models\SanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class KhoController extends Controller
{
    public function index()
    {
        $check = Auth::guard('Admin')->user();
        if($check){
        return view('admin.pages.kho.index');
        }else{
            toastr()->error('Bạn cần phải đăng nhập');
            return view('admin.login');
        }
    }


    public function create()
    {
        // Bước 1: Lấy toàn bộ dữ liệu đang là kho đang nhập => type = 0
        $data = Kho::where('type', 0)->whereNull('thanh_tien')->get(); // trả về 1 array

        foreach($data as $key => $value) {
            // Cập nhật số lượng của sản phẩm
            $nguyenLieu = NguyenLieu::find($value->id_nguyen_lieu);
            if($nguyenLieu) {
                if($value->so_luong > 0 && $value->don_gia > 0) {
                    $value->thanh_tien      = $value->so_luong * $value->don_gia;
                    $value->type            = 1;
                    $value->ten_nguyen_lieu    = $nguyenLieu->ten_nguyen_lieu;
                    $value->save();
                    $nguyenLieu->so_luong = $nguyenLieu->so_luong + $value->so_luong;
                    $nguyenLieu->save();
                    return response()->json(['status' => true]);
                } else {
                    $value->delete();
                    // return response()->json(['status' => false]);
                }
            } else {
                $value->delete();
            }
        }
    }

    public function getData()
    {
        $data = Kho::join('nguyen_lieus','khos.id_nguyen_lieu', 'nguyen_lieus.id')
                              ->select('khos.*', 'nguyen_lieus.ten_nguyen_lieu','nguyen_lieus.don_vi')
                              ->where('khos.type',0)
                              ->get();

        return response()->json([
            'nhapKho' => $data,
        ]);

    }


    public function store(Request $request)
    {
        $nguyenLieu = NguyenLieu::find($request->id_nguyen_lieu);
        if($nguyenLieu) {
            $khoHang = Kho::where('id_nguyen_lieu', $request->id_nguyen_lieu)->where('type', 0)->first();
            if($khoHang) {
                $khoHang->so_luong++;
                $khoHang->save();
            } else {
                Kho::create([
                    'id_nguyen_lieu'       => $nguyenLieu->id,
                    'ten_nguyen_lieu'      => $nguyenLieu->ten_nguyen_lieu,
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


    //Xuất Kho
    // public function dataXuat(){
    //     $data = NguyenLieu::all();
    //     return response()->json([
    //         'dataXuat'=>$data,
    //     ]);
    // }
}
