<?php

namespace App\Http\Controllers;

use App\Http\Requests\BanRequest;
use App\Models\Ban;
use App\Models\SanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pages.ban.index');
    }

    public function store(BanRequest $request)
    {
        Ban::create([
            'ma_ban'            =>  $request->ma_ban,
            'is_open'           =>  $request->is_open,
        ]);

        return response()->json([
            'trangThai'         =>  true,
        ]);
    }
    public function getData()
    {
        $data = Ban::all();
        return response()->json([
            'dulieu' => $data,
        ]);
    }
    public function doiTrangThai($id)
    {
        $ban = Ban::find($id);
        if($ban) {
            $ban->is_open = !$ban->is_open;
            $ban->save();
            return response()->json([
                'trangThai'         =>  true,
                'tinhTrangBan'      =>  $ban->is_open,
            ]);
        } else {
            return response()->json([
                'trangThai'         =>  false,
            ]);
        }
    }
    public function destroy($id)
    {
        $ban = Ban::find($id);
        if($ban) {
            $ban->delete();
            return response()->json([
                'status'  =>  true,
            ]);
        } else {
            return response()->json([
                'status'  =>  false,
            ]);
        }
    }
}
