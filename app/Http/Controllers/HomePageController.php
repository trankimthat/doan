<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomePageController extends Controller
{
    public function index(){

        $sql = "SELECT *, (`gia_ban` - `gia_khuyen_mai`) / `gia_ban` * 100 AS `TYLE` FROM `san_phams` ORDER BY TYLE DESC";

        $allSanPham = DB::select($sql);
        return view('home_page.master', compact('allSanPham'));
    }
}
