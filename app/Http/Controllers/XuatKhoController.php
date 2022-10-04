<?php

namespace App\Http\Controllers;

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


    public function create()
    {

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
            $khoHang = XuatKho::where('id_nguyen_lieu', $request->id_nguyen_lieu)->where('type', 0)->first();
            if($khoHang) {
                $khoHang->so_luong++;
                $khoHang->save();
            } else {
                XuatKho::create([
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

    public function getData(){
        $data = XuatKho::join('nguyen_lieus','xuat_khos.id_nguyen_lieu', 'nguyen_lieus.id')
                              ->select('xuat_khos.*', 'nguyen_lieus.ten_nguyen_lieu','nguyen_lieus.don_vi')
                              ->where('xuat_khos.type',0)
                              ->get();

        return response()->json([
            'xuatKho' => $data,
        ]);
    }
    public function edit(XuatKho $xuatKho)
    {

    }


    public function update(Request $request, XuatKho $xuatKho)
    {

    }


    public function destroy(XuatKho $xuatKho)
    {

    }
}
