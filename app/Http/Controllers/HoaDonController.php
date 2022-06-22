<?php

namespace App\Http\Controllers;

use App\Models\Ban;
use App\Models\ChiTietHoaDon;
use App\Models\HoaDon;
use App\Models\SanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class HoaDonController extends Controller
{
    public function index(){
        return view('admin.pages.hoa_don.index');
    }
    public function banData()
    {
        $data = Ban::all();
        return response()->json([
            'dulieu' => $data,
        ]);
    }
    public function getData($id)
    {


        $data = HoaDon::join('chi_tiet_hoa_dons','chi_tiet_hoa_dons.hoa_don_id', 'hoa_dons.id')
                        ->join('bans' , 'bans.id' , 'hoa_dons.id_ban')
                        //  ->join('san_phams', 'chi_tiet_hoa_dons.san_pham_id', 'san_phams.id')
                            ->where('xuat_hoa_don', 1)
                            ->where('bans.id', $id)
                            ->select('hoa_dons.*','chi_tiet_hoa_dons.*')
                            ->get();

        return response()->json([
            'dulieu' => $data,
        ]);


    }
    public function ban($id){
        $ban = Ban::find($id);
        if($ban) {
            return response()->json([
                'status'  =>  true,
                'data'    =>  $ban,
            ]);
        } else {
            return response()->json([
                'status'  =>  false,
            ]);
        }
    }

   public function store($id){
        $data = HoaDon::join('chi_tiet_hoa_dons','chi_tiet_hoa_dons.hoa_don_id', 'hoa_dons.id')
                        ->join('bans' , 'bans.id' , 'hoa_dons.id_ban')
                        //  ->join('san_phams', 'chi_tiet_hoa_dons.san_pham_id', 'san_phams.id')
                        ->where('xuat_hoa_don', 1)
                        ->where('bans.id', $id)
                        ->select('hoa_dons.*')
                        ->get();

        if(count($data)){
            foreach ($data as $value) {
                $tmp  = HoaDon::find($value->id);
                $tmp->xuat_hoa_don = 0;
                $tmp->save();
            }
            return response()->json([
                'status'=>true,
            ]);
        }else{
            return response()->json([
                'status'=>false,
            ]);
        }
   }
}
