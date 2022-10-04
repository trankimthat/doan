<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateNguyenLieu;
use App\Models\NguyenLieu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NguyenLieuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $check = Auth::guard('Admin')->user();
        if($check){
        return view('admin.pages.nguyen_lieu.index');
        }else{
            toastr()->error('Bạn cần phải đăng nhập');
            return view('admin.login');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getData()
    {
        $data = NguyenLieu::where('is_open',1)->get();
        return response()->json([
            'dulieu' => $data,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        NguyenLieu::create($data);
        return response()->json([
            'trangThai'         =>  true,
        ]);
    }
    public function doiTrangThai($id)
    {
        $nguyenLieu = NguyenLieu::find($id);
        if($nguyenLieu) {
            $nguyenLieu->is_open = !$nguyenLieu->is_open;
            $nguyenLieu->save();
            return response()->json([
                'trangThai'         =>  true,
                'tinhTrangNL'      =>  $nguyenLieu->is_open,
            ]);
        } else {
            return response()->json([
                'trangThai'         =>  false,
            ]);
        }
    }
    public function destroy($id){
        $nguyenLieu = NguyenLieu::find($id);
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

    public function edit($id)

    {
        $nguyenLieu = NguyenLieu::find($id);
        if($nguyenLieu) {
            return response()->json([
                'status'  =>  true,
                'data'    =>  $nguyenLieu,
            ]);
        } else {
            return response()->json([
                'status'  =>  false,
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NguyenLieu  $nguyenLieu
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNguyenLieu $request)
    {
        $data     = $request->all();
        $nguyenLieu = NguyenLieu::find($request->id);
        $nguyenLieu->update($data);
        // dd($danh_muc->toArray());
        return response()->json(['status'=> true]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NguyenLieu  $nguyenLieu
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $data = NguyenLieu::where('ten_nguyen_lieu', 'like', '%' . $request->tenNguyenLieu .'%')
                                ->get();
        // dd($data);
        return response()->json(['dataProduct' => $data]);

    }

}
