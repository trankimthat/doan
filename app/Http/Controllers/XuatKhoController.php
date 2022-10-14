<?php

namespace App\Http\Controllers;

use App\Models\ChiTietHoaDon;
use App\Models\HoaDon;
use App\Models\NguyenLieu;
use App\Models\XuatKho;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class XuatKhoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin = Auth::guard('Admin')->user();
        if($admin){
        return view('admin.pages.xuat_kho.indexXuatKho');
        }else{
            toastr()->error('Bạn cần phải đăng nhập');
            return view('admin.login');
        }
    }

    public function dataXuat(){
        $data = NguyenLieu::where('is_open',1)->get();
        return response()->json([
            'data'=> $data,
        ]);
    }


    public function store(Request $request)
    {
        $nguyenLieu = NguyenLieu::find($request->id_nguyen_lieu);
        if($nguyenLieu) {
            $xuatKho = XuatKho::where('id_nguyen_lieu', $request->id_nguyen_lieu)->where('type', 0)->first();
            if($xuatKho) {
                // dd($xuatKho->so_luong);
                if($xuatKho->so_luong < $nguyenLieu->so_luong){
                    $xuatKho->so_luong++;
                    $xuatKho->save();
                    return response()->json(['hihi' => true]);
                }else{
                    // dd($xuatKho->so_luong);
                    return response()->json(['hihi' => false]);
                }
            } else {
                XuatKho::create([
                    'id_nguyen_lieu'       => $nguyenLieu->id,
                    'ten_nguyen_lieu'      => $nguyenLieu->ten_nguyen_lieu,
                    'so_luong'             => 1,
                ]);

            }
            return response()->json(['hihi' => true]);
        } else {
            return response()->json(['hihi' => false]);
        }
    }

    public function getData(){
        $data = XuatKho::join('nguyen_lieus','xuat_khos.id_nguyen_lieu', 'nguyen_lieus.id')
                            ->where('xuat_khos.type',0)
                            ->select('xuat_khos.*', 'nguyen_lieus.ten_nguyen_lieu','nguyen_lieus.don_vi')
                            ->get();

        return response()->json([
            'xuatKho' => $data,
        ]);
    }


    public function updateqty(Request $request)
    {
        $khoHang = XuatKho::where('id', $request->id)->where('type', 0)->first();
        if($khoHang) {
            $nguyenLieu = NguyenLieu::find($khoHang->id_nguyen_lieu);

        if($nguyenLieu) {
            if ($request->so_luong > $nguyenLieu->so_luong) {
                return response()->json(['status' => false]);
            } else {
                $khoHang->so_luong = $request->so_luong;
                if($khoHang->so_luong > 0 ){
                    $khoHang->save();
                    return response()->json(['status' => true]);
                }else{
                    return response()->json(['status' => false]);
                }

            }

        } else {
            return response()->json(['status' => false]);
        }
    }else{
        return response()->json(['status' => false]);
    }
    }


    public function destroy($id)
    {
        $nguyenLieu = XuatKho::find($id);
        if($nguyenLieu) {
            $nguyenLieu->delete();
            return response()->json([
                'status'  =>  true,
            ]);
        } else {
            return response()->json([
                'status'  =>  false,
            ]);
        }
    }
    public function create()
    {
        // Bước 1: Lấy toàn bộ dữ liệu đang là kho đang nhập => type = 0
        $data = XuatKho::where('type', 0)->get(); // trả về 1 array

        foreach($data as $key => $value) {
            // Cập nhật số lượng của sản phẩm
            $nguyenLieu = NguyenLieu::find($value->id_nguyen_lieu);
            if($nguyenLieu) {
                if($value->so_luong > 0 ) {
                    $value->type            = 1;
                    $value->ten_nguyen_lieu    = $nguyenLieu->ten_nguyen_lieu;
                    $value->save();
                    $nguyenLieu->so_luong = $nguyenLieu->so_luong - $value->so_luong;
                    $nguyenLieu->save();
                    return response()->json(['status' => true]);
                } else {
                    $value->delete();
                }
            } else {
                $value->delete();
            }
        }
    }
}
