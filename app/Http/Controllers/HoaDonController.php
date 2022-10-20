<?php

namespace App\Http\Controllers;

use App\Models\Ban;
use App\Models\ChiTietHoaDon;
use App\Models\HoaDon;
use App\Models\SanPham;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;


class HoaDonController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = new HoaDon();
    }

    public function index()
    {
        $check = Auth::guard('Admin')->user();
        if ($check) {
            return view('admin.pages.hoa_don.index');
        } else {
            toastr()->error('Bạn cần phải đăng nhập');
            return view('admin.login');
        }
    }

    public function api_HD()
    {
        return DataTables::of($this->model::query())
            ->editColumn('created_at', function ($object) {
                return $object->created_at->format('d/m/Y H:i:s');
            })
            ->editColumn('updated_at', function ($object) {
                return $object->updated_at->format('d/m/Y H:i:s');
            })
            ->addColumn('details', function ($object) {
                return route('hoa-don.details', $object);
            })
            ->make(true);
    }

    public function details($id)
    {
        // dd($id);
        return view('admin.pages.hoa_don.details', [
            'id' => $id
        ]);
        // return redirect('/admin/hoa-don/details/' . $id);
    }

    public function getData($id)
    {
        // dd($id);
        $data = $this->model::join('chi_tiet_hoa_dons', 'chi_tiet_hoa_dons.hoa_don_id', 'hoa_dons.id')
            ->join('bans', 'bans.id', 'hoa_dons.id_ban')
            //  ->join('san_phams', 'chi_tiet_hoa_dons.san_pham_id', 'san_phams.id')
            // ->where('xuat_hoa_don', 1)
            ->where('chi_tiet_hoa_dons.hoa_don_id', $id)
            ->select('hoa_dons.*', 'chi_tiet_hoa_dons.*', 'bans.ma_ban')
            ->get();
        // dd($data);
        return response()->json([
            'dulieu' => $data,
        ]);

        // return DataTables::of($data)
        //     ->editColumn('created_at', function ($object) {
        //         return $object->created_at->format('d/m/Y H:i:s');
        //     })
        //     ->editColumn('updated_at', function ($object) {
        //         return $object->updated_at->format('d/m/Y H:i:s');
        //     })
        //     ->make(true);
    }

    public function search_HD(Request $request)
    {
        return $this->model
            ->where('ma_hoa_don', 'like', '%' . $request->get('q') . '%')
            ->get([
                'id',
                'ma_hoa_don',
            ]);
        // return $this->model->select('id', 'ma_hoa_don')
        //     ->where('ma_hoa_don', 'like', '%' . $request->get('q') . '%')
        //     ->get();
    }

    public function banData()
    {
        $data = Ban::all();
        return response()->json([
            'dulieu' => $data,
        ]);
    }

    public function ban($id)
    {
        $ban = HoaDon::find($id);
        // dd($ban);
        if ($ban) {
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

    public function hoaDon($id)
    {
        $data = HoaDon::join('chi_tiet_hoa_dons', 'chi_tiet_hoa_dons.hoa_don_id', 'hoa_dons.id')
            ->where('chi_tiet_hoa_dons.hoa_don_id', $id)
            ->select('hoa_dons.*', 'chi_tiet_hoa_dons.id as id_chi_tiet', 'chi_tiet_hoa_dons.*')
            ->get();
        return response()->json([
            'status'  =>  true,
            'dataNe'    =>  $data,
        ]);
    }

    public function store($id)
    {
        $admin = Auth::guard('Admin')->user();
        if ($admin) {
            // $ban = Ban::find($id);
            $data = $this->model::where('id_ban', $id)
                ->where('xuat_hoa_don', 1)
                ->get();
            // if($ban){
            if (count($data) > 0) {
                foreach ($data as $value) {
                    $tmp  = $this->model::find($value->id);
                    $tmp->xuat_hoa_don = 0;
                    $tmp->save();
                    // dd($tmp);
                }
                return response()->json([
                    'status' => true,
                ]);
            } else {
                return response()->json([
                    'status' => false,
                ]);
            }
            // }else{
            //     toastr()->error('id bàn không đúng');
            // }
        } else {
            toastr()->error('bạn cần phải đăng nhập');
        }
    }

    public function page()
    {
        $check = Auth::guard('Admin')->user();
        if ($check) {
            return view('admin.pages.doanh_thu.index');
        } else {
            toastr()->error('Bạn cần đăng nhập');
            return view('admin.login');
        }
    }

    public function tongHD(Request $request)
    {
        $hoadon = $this->model::join('bans', 'bans.id', 'hoa_dons.id_ban')
            ->whereDate('ngay_hoa_don', $request->ngay_hoa_don)
            ->select('hoa_dons.*', 'bans.ma_ban')
            ->get();
        return response()->json([
            'ngay_hoa_don' => $hoadon,
        ]);
    }
}
