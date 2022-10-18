<?php

namespace App\Http\Controllers;

use App\Http\Requests\KiemTraDuLieuTaoSanPham;
use App\Http\Requests\UpdateSanPhamRequest;
use App\Models\DanhMucSanPham;
use App\Models\SanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SanPhamController extends Controller
{
    public function index()
    {
        $check = Auth::guard('Admin')->user();
        if($check){
        $list_danh_muc = DanhMucSanPham::where('is_open', 1)
                                        // ->where('id_danh_muc_cha', '<>', 0)
                                        ->get();
        return view('admin.pages.san_pham.index', compact('list_danh_muc'));
        }else{
            toastr()->error('Bạn cần phải đăng nhập');
            return view('admin.login');
        }
    }

    public function HamTaoSanPhamDayNe(KiemTraDuLieuTaoSanPham $bienNhanDuLieu)
    {
        $check = Auth::guard('Admin')->user();
        if($check){
        $data = $bienNhanDuLieu->all();
        SanPham::create($data);

        return response()->json(['thongBao' => 1235]);
        }
    }

    public function getData()
    {
        $data = SanPham::join('danh_muc_san_phams', 'san_phams.id_danh_muc', 'danh_muc_san_phams.id')
                        ->select('san_phams.*', 'danh_muc_san_phams.ten_danh_muc')
                        ->get();

        return response()->json([
            'dulieuneban' => $data
        ]);
    }

    public function DoiTrangThaiSanPham($id)
    {
        $san_pham = SanPham::find($id);
        if($san_pham) {
            $tinh_trang_moi = $san_pham->is_open == true ? false : true;
            $san_pham->is_open = $tinh_trang_moi;
            $san_pham->save();

            return response()->json(['status' => true]);
        }
    }

    public function XoaSanPham($id)
    {
        $san_pham = SanPham::find($id);
        if($san_pham) {
            $san_pham->delete();

            return response()->json(['status' => true]);
        }
    }

    public function editSanPham($id)
    {
        $san_pham = SanPham::find($id);;
        if($san_pham) {
            return response()->json([
                'status'  =>  true,
                'data'    =>  $san_pham,
            ]);
        } else {
            return response()->json([
                'status'  =>  false,
            ]);
        }
    }

    public function updateSanPham(UpdateSanPhamRequest $request)
    {
        $data     = $request->all();
        $san_pham = SanPham::find($data['id']);
        $san_pham->update($data);

        return response()->json([
            'status' => true,
        ]);
    }
    public function search(Request $request)
    {
        // $data = SanPham::where('ten_san_pham', 'like', '%' . $request->tenSanPham .'%')->get();
        $data = SanPham::join('danh_muc_san_phams','danh_muc_san_phams.id','san_phams.id_danh_muc')
                        ->where('danh_muc_san_phams'.$request->id)
                        ->where('ten_san_pham', 'like', '%' . $request->tenSanPham .'%')
                        ->select('san_phams.*','danh_muc_san_phams.*')
                        ->get();

        return response()->json([
            'dataProduct' => $data,
        ]);

    }
}
