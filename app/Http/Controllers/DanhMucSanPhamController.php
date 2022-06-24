<?php

namespace App\Http\Controllers;

use App\Models\DanhMucSanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CreateDanhMucSanPhamRequest;
use App\Http\Requests\UpdateDanhMucSanPhamRequest;
use App\Models\SanPham;

class DanhMucSanPhamController extends Controller
{

    public function index()

    {
        $list_danh_muc = DanhMucSanPham::where('is_open', 1)->get();
        $danh_muc_cha = DanhMucSanPham::where('is_open', 1)->where('id_danh_muc_cha', 0)->orWhereNull('id_danh_muc_cha')->get();
        return view('admin.pages.danh_muc_san_pham.index', compact('list_danh_muc', 'danh_muc_cha'));
    }

    public function getData()
    {
        $danh_muc_cha = DanhMucSanPham::where('id_danh_muc_cha', 0)->get();

        $sql = 'SELECT a.*, b.ten_danh_muc as `ten_danh_muc_cha`
                FROM `danh_muc_san_phams` a LEFT JOIN `danh_muc_san_phams` b
                on a.id_danh_muc_cha = b.id';
        $data = DB::select($sql);

        return response()->json([
            'list'          => $data,
            'danh_muc_cha'  => $danh_muc_cha,
        ]);
        // $array = [ "id" => [1,2,3], "ten" => "tien","hoang","cs001"];
        // dd($array);
    }

    public function store(CreateDanhMucSanPhamRequest $request)
    {
        DanhMucSanPham::create([
            'ten_danh_muc'      =>  $request->ten_danh_muc,
            'slug_danh_muc'     =>  $request->slug_danh_muc,
            'hinh_anh'          =>  $request->hinh_anh,
            'id_danh_muc_cha'   =>  empty($request->id_danh_muc_cha) ? 0 : $request->id_danh_muc_cha,
            'is_open'           =>  $request->is_open,
        ]);

        return response()->json([
            'trangThai'         =>  true,
        ]);
    }
    public function doiTrangThai($id)
    {
        $danh_muc = DanhMucSanPham::find($id);
        if($danh_muc) {
            $danh_muc->is_open = !$danh_muc->is_open;
            $danh_muc->save();
            return response()->json([
                'trangThai'         =>  true,
                'tinhTrangDanhMuc'  =>  $danh_muc->is_open,
            ]);
        } else {
            return response()->json([
                'trangThai'         =>  false,
            ]);
        }
    }
    public function destroy($id)
    {
        $danh_muc = DanhMucSanPham::find($id);
        if($danh_muc) {
            $danh_muc->delete();
            return response()->json([
                'status'  =>  true,
            ]);
        } else {
            return response()->json([
                'status'  =>  false,
            ]);
        }
    }
    public function edit($id)
    {
        $danh_muc = DanhMucSanPham::find($id);
        if($danh_muc) {
            return response()->json([
                'status'  =>  true,
                'data'    =>  $danh_muc,
            ]);
        } else {
            return response()->json([
                'status'  =>  false,
            ]);
        }
    }
    public function update(UpdateDanhMucSanPhamRequest $request)
    {
        $data     = $request->all();
        $danh_muc = DanhMucSanPham::find($request->id);
        $danh_muc->update($data);
        // dd($danh_muc->toArray());
        return response()->json(['status'=> true]);
    }
    public function search(Request $request)
    {
        $data = DanhMucSanPham::where('ten_danh_muc', 'like', '%' . $request->tenDanhMuc .'%')
                                ->where('id_danh_muc_cha', 0)
                                ->get();
        // dd($data);
        return response()->json(['dataProduct' => $data]);

    }

}
