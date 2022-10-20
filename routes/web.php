<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login');
});
Route::get('/home-page/{id}', [\App\Http\Controllers\HomePageController::class, 'index']);
Route::get('/home-page/data/{id}', [\App\Http\Controllers\HomePageController::class, 'getData']);


Route::group(['prefix' => '/admin'], function () {
    // Route::post('/getData/{id}', [\App\Http\Controllers\DanhMucSanPhamController::class, 'getData1']);
    Route::get('/index', [\App\Http\Controllers\AdminController::class, 'index']);
    Route::post('/login', [\App\Http\Controllers\AdminController::class, 'loginAdmin']);
    Route::get('/logout', [\App\Http\Controllers\AdminController::class, 'logout']);
    Route::group(['prefix' => '/danh-muc-san-pham'], function () {
        Route::get('/index', [\App\Http\Controllers\DanhMucSanPhamController::class, 'index']);
        Route::post('/index', [\App\Http\Controllers\DanhMucSanPhamController::class, 'store']);
        Route::get('/data', [\App\Http\Controllers\DanhMucSanPhamController::class, 'getData']);

        Route::get('/doi-trang-thai/{id}', [\App\Http\Controllers\DanhMucSanPhamController::class, 'doiTrangThai']);

        Route::get('/delete/{id}', [\App\Http\Controllers\DanhMucSanPhamController::class, 'destroy']);
        Route::get('/edit/{id}', [\App\Http\Controllers\DanhMucSanPhamController::class, 'edit']);
        Route::post('/update', [\App\Http\Controllers\DanhMucSanPhamController::class, 'update']);
        // Route::post('/search', [\App\Http\Controllers\DanhMucSanPhamController::class, 'search']);
    });
    Route::group(['prefix' => '/san-pham'], function () {
        Route::get('/index', [\App\Http\Controllers\SanPhamController::class, 'index']);
        Route::post('/tao-san-pham', [\App\Http\Controllers\SanPhamController::class, 'HamTaoSanPhamDayNe']);

        Route::get('/danh-sach-san-pham', [\App\Http\Controllers\SanPhamController::class, 'getData']);
        Route::get('/doi-trang-thai/{id}', [\App\Http\Controllers\SanPhamController::class, 'DoiTrangThaiSanPham']);

        Route::get('/xoa-san-pham/{id}', [\App\Http\Controllers\SanPhamController::class, 'XoaSanPham']);

        Route::get('/edit/{id}', [\App\Http\Controllers\SanPhamController::class, 'editSanPham']);
        Route::post('/update', [\App\Http\Controllers\SanPhamController::class, 'updateSanPham']);
        // Route::post('/search', [\App\Http\Controllers\SanPhamController::class, 'search']);

    });
    Route::group(['prefix' => '/ban'], function () {
        Route::get('/index', [\App\Http\Controllers\BanController::class, 'index']);
        Route::post('/index', [\App\Http\Controllers\BanController::class, 'store']);
        Route::get('/data', [\App\Http\Controllers\BanController::class, 'getData']);

        Route::get('/doi-trang-thai/{id}', [\App\Http\Controllers\BanController::class, 'doiTrangThai']);

        Route::get('/delete/{id}', [\App\Http\Controllers\BanController::class, 'destroy']);
        Route::get('/edit/{id}', [\App\Http\Controllers\BanController::class, 'edit']);
        Route::post('/update', [\App\Http\Controllers\BanController::class, 'update']);
    });
    Route::group(['prefix' => '/user'], function () {
        Route::get('/index', [\App\Http\Controllers\AgentController::class, 'index']);
        Route::get('/dulieu', [\App\Http\Controllers\AgentController::class, 'getData']);
        Route::get('/dangki', [\App\Http\Controllers\AgentController::class, 'register']);
        Route::post('/register', [\App\Http\Controllers\AgentController::class, 'registerAction']);
        Route::get('/doi-trang-thai/{id}', [\App\Http\Controllers\AgentController::class, 'doiTrangThai']);
        Route::get('/delete/{id}', [\App\Http\Controllers\AgentController::class, 'destroy']);
        Route::get('/edit/{id}', [\App\Http\Controllers\AgentController::class, 'edit']);
        Route::post('/update', [\App\Http\Controllers\AgentController::class, 'update']);
    });
    Route::group(['prefix' => '/kho'], function () {
        Route::get('/index', [\App\Http\Controllers\KhoController::class, 'index']);
        Route::get('/data', [\App\Http\Controllers\KhoController::class, 'getData']);
        Route::post('/create', [\App\Http\Controllers\KhoController::class, 'store']);

        Route::get('/remove/{id}', [\App\Http\Controllers\KhoController::class, 'destroy']);
        Route::post('/updateqty', [\App\Http\Controllers\KhoController::class, 'updateqty']);
        Route::post('/updateprice', [\App\Http\Controllers\KhoController::class, 'updateprice']);
        Route::get('/createnhapkho', [\App\Http\Controllers\KhoController::class, 'create']);

        //xuất khogetData
    });

    Route::group(['prefix' => '/xuat-kho'], function () {
        Route::get('/index', [\App\Http\Controllers\XuatKhoController::class, 'index']);
        Route::get('/data', [\App\Http\Controllers\XuatKhoController::class, 'dataXuat']);
        Route::post('/create', [\App\Http\Controllers\XuatKhoController::class, 'store']);
        Route::get('/data/table-xuat', [\App\Http\Controllers\XuatKhoController::class, 'getData']);
    });

    // Route::get('hoa-don/index', [\App\Http\Controllers\HoaDonController::class, 'index'])->name('index');
    // Route::get('hoa-don/api', [\App\Http\Controllers\HoaDonController::class, 'api'])->name('hoa-don.api');
    Route::group(['prefix' => '/hoa-don'], function () {
        Route::get('/index', [\App\Http\Controllers\HoaDonController::class, 'index']);
        Route::get('/api_HD', [\App\Http\Controllers\HoaDonController::class, 'api_HD'])->name('hoa-don.api_HD');
        Route::get('/api/search_HD', [\App\Http\Controllers\HoaDonController::class, 'search_HD'])->name('hoa-don.api.search_HD');
        Route::get('/details/{id}', [\App\Http\Controllers\HoaDonController::class, 'details'])->name('hoa-don.details');
        Route::get('/details/{id?}', [\App\Http\Controllers\HoaDonController::class, 'getData'])->name('hoa-don.getData');
        Route::get('/page-ban', [\App\Http\Controllers\HoaDonController::class, 'banData']);
        Route::get('/doanh-thu/{id}', [\App\Http\Controllers\HoaDonController::class, 'hoaDon']);

        Route::get('/ban/{id}', [\App\Http\Controllers\HoaDonController::class, 'ban']);
        Route::post('/in-bill/{id}', [\App\Http\Controllers\HoaDonController::class, 'store']);
    });
    Route::group(['prefix' => '/doanh-thu'], function () {
        Route::get('/index', [\App\Http\Controllers\HoaDonController::class, 'page']);
        Route::post('/data', [\App\Http\Controllers\HoaDonController::class, 'TongHD']);
    });
    Route::group(['prefix' => '/nguyen-lieu'], function () {
        Route::get('/index', [\App\Http\Controllers\NguyenLieuController::class, 'index']);
        Route::post('/index', [\App\Http\Controllers\NguyenLieuController::class, 'store']);
        Route::get('/data', [\App\Http\Controllers\NguyenLieuController::class, 'getData']);
        Route::get('/doi-trang-thai/{id}', [\App\Http\Controllers\NguyenLieuController::class, 'doiTrangThai']);
        Route::get('/delete/{id}', [\App\Http\Controllers\NguyenLieuController::class, 'destroy']);
        Route::get('/edit/{id}', [\App\Http\Controllers\NguyenLieuController::class, 'edit']);
        Route::post('/update', [\App\Http\Controllers\NguyenLieuController::class, 'update']);

        Route::post('/search', [\App\Http\Controllers\NguyenLieuController::class, 'search']);
    });
});

Route::get('/user', [\App\Http\Controllers\AgentController::class, 'login']);
Route::post('/login', [\App\Http\Controllers\AgentController::class, 'loginAction']);
Route::get('/logout', [\App\Http\Controllers\AgentController::class, 'logout']);

Route::group(['prefix' => '/user'], function () {
    // Route::get('/oder/index', [\App\Http\Controllers\DonHangController::class, 'index']);
    Route::get('/ban/index', [\App\Http\Controllers\BanUserController::class, 'index']);
    Route::get('/data', [\App\Http\Controllers\BanUserController::class, 'getData']);
    Route::get('/ban/doi-trang-thai/{id}', [\App\Http\Controllers\BanUserController::class, 'doiTrangThai']);
    Route::get('/ban/{id}', [\App\Http\Controllers\BanUserController::class, 'ban']);
    Route::post('/add-to-cart', [\App\Http\Controllers\ChiTietHoaDonController::class, 'addToCart']);
    Route::get('/cart/{id}', [\App\Http\Controllers\ChiTietHoaDonController::class, 'index']);
    Route::get('/cart/data/{id}', [\App\Http\Controllers\ChiTietHoaDonController::class, 'dataCart']);
    Route::post('/updateqty', [\App\Http\Controllers\ChiTietHoaDonController::class, 'updateqty']);
    Route::get('/remove-cart/{id}', [\App\Http\Controllers\ChiTietHoaDonController::class, 'removeCart']);
    Route::get('/create-bill/{id}', [\App\Http\Controllers\DonHangController::class, 'store']);
});
