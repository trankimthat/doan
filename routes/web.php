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
    return view('admin.master');
});
Route::group(['prefix' => '/admin'], function() {
    Route::group(['prefix' => '/danh-muc-san-pham'], function() {
        Route::get('/index', [\App\Http\Controllers\DanhMucSanPhamController::class, 'index']);
        Route::post('/index', [\App\Http\Controllers\DanhMucSanPhamController::class, 'store']);
        Route::get('/data', [\App\Http\Controllers\DanhMucSanPhamController::class, 'getData']);

        Route::get('/doi-trang-thai/{id}', [\App\Http\Controllers\DanhMucSanPhamController::class, 'doiTrangThai']);

        Route::get('/delete/{id}', [\App\Http\Controllers\DanhMucSanPhamController::class, 'destroy']);
        Route::get('/edit/{id}', [\App\Http\Controllers\DanhMucSanPhamController::class, 'edit']);
        Route::post('/update', [\App\Http\Controllers\DanhMucSanPhamController::class, 'update']);
    });
     Route::group(['prefix' => '/san-pham'], function() {
        Route::get('/index', [\App\Http\Controllers\SanPhamController::class, 'index']);
        Route::post('/tao-san-pham', [\App\Http\Controllers\SanPhamController::class, 'HamTaoSanPhamDayNe']);

        Route::get('/danh-sach-san-pham', [\App\Http\Controllers\SanPhamController::class, 'TraChoMotDoanJsonDanhSachSanPham']);
        Route::get('/doi-trang-thai/{id}', [\App\Http\Controllers\SanPhamController::class, 'DoiTrangThaiSanPham']);

        Route::get('/xoa-san-pham/{id}', [\App\Http\Controllers\SanPhamController::class, 'XoaSanPham']);

        Route::get('/edit/{id}', [\App\Http\Controllers\SanPhamController::class, 'editSanPham']);
        Route::post('/update', [\App\Http\Controllers\SanPhamController::class, 'updateSanPham']);
        Route::post('/search', [\App\Http\Controllers\SanPhamController::class, 'search']);
    });
    Route::group(['prefix' => '/ban'], function() {
        Route::get('/index', [\App\Http\Controllers\BanController::class, 'index']);
        Route::post('/index', [\App\Http\Controllers\BanController::class, 'store']);
        Route::get('/data', [\App\Http\Controllers\BanController::class, 'getData']);

        Route::get('/doi-trang-thai/{id}', [\App\Http\Controllers\BanController::class, 'doiTrangThai']);

        Route::get('/delete/{id}', [\App\Http\Controllers\BanController::class, 'destroy']);
        Route::get('/edit/{id}', [\App\Http\Controllers\BanController::class, 'edit']);
        Route::post('/update', [\App\Http\Controllers\BanController::class, 'update']);
    });
    Route::group(['prefix' => '/user'], function() {
        Route::get('/index', [\App\Http\Controllers\AgentController::class, 'index']);
        Route::get('/dulieu', [\App\Http\Controllers\AgentController::class, 'getData']);
        Route::get('/dangki', [\App\Http\Controllers\AgentController::class, 'register']);
        Route::post('/register', [\App\Http\Controllers\AgentController::class, 'registerAction']);
        Route::get('/doi-trang-thai/{id}', [\App\Http\Controllers\AgentController::class, 'doiTrangThai']);
        Route::get('/delete/{id}', [\App\Http\Controllers\AgentController::class, 'destroy']);
        Route::get('/edit/{id}', [\App\Http\Controllers\AgentController::class, 'edit']);
        Route::post('/update', [\App\Http\Controllers\AgentController::class, 'update']);
    });
    Route::group(['prefix' => '/kho'], function() {
        Route::get('/index', [\App\Http\Controllers\KhoController::class, 'index']);
        // Route::get('/loadData', [\App\Http\Controllers\KhoHangController::class, 'loadData']);
        // Route::get('/add/{id}', [\App\Http\Controllers\KhoHangController::class, 'store']);

        // Route::get('/remove/{id}', [\App\Http\Controllers\KhoHangController::class, 'destroy']);
        // Route::post('/update', [\App\Http\Controllers\KhoHangController::class, 'update']);

        // Route::get('/create', [\App\Http\Controllers\KhoHangController::class, 'create']);
        Route::get('/data', [\App\Http\Controllers\KhoController::class, 'data']);
    });
});
Route::group(['prefix' => '/user'], function() {
        Route::get('/login', [\App\Http\Controllers\AgentController::class, 'login']);
        Route::post('/login', [\App\Http\Controllers\AgentController::class, 'loginAction']);
});
