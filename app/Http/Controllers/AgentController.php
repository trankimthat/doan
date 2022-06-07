<?php

namespace App\Http\Controllers;

use App\Http\Requests\AgentLoginRequest;
use App\Http\Requests\AgentRequet;
use App\Http\Requests\UpdateTKNhanVienRequest;
use App\Models\agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('admin.pages.TKUser.index');
    }
    public function getData()
    {
        $dulieuUser = agent::all();
        return response()->json([
            'dulieuNhanVien' => $dulieuUser,
        ]);
    }
    public function doiTrangThai($id)
    {
        $user = agent::find($id);
        if($user) {
            $user->is_open = !$user->is_open;
            $user->save();
            return response()->json([
                'trangThai'         =>  true,
                'tinhTrangUser'      =>  $user->is_open,
            ]);
        } else {
            return response()->json([
                'trangThai'         =>  false,
            ]);
        }
    }
    public function destroy($id)
    {
        $user = agent::find($id);
        if($user) {
            $user->delete();
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
        $user = agent::find($id);
        if($user) {
            return response()->json([
                'status'  =>  true,
                'data'    =>  $user,
            ]);
        } else {
            return response()->json([
                'status'  =>  false,
            ]);
        }
    }
    public function update(UpdateTKNhanVienRequest $request)
    {
        $user = agent::find($request->id);
        $parts = explode(" ", $request->ho_va_ten);
        if(count($parts) > 1) {
            $lastname = array_pop($parts);
            $firstname = implode(" ", $parts);
        }
        else
        {
            $firstname = $request->ho_va_ten;
            $lastname = " ";
        }
        if(!$request->password){
            $user->ho_lot = $firstname;
            $user->ten = $lastname;
            $user->ho_va_ten = $request->ho_va_ten;
            $user->so_dien_thoai = $request->so_dien_thoai;
            $user->email = $request->email;
            $user->dia_chi = $request->dia_chi;
            $user->is_open = $request->is_open;
            $user->save();
        } else{
            $data           = $request->all();
            $data['ho_lot'] = $firstname;
            $data['ten']    = $lastname;
            $data['password']   = bcrypt($request->password);
            $user->update($data);
        }
        return response()->json(['status'=> true]);
    }

    public function register()
    {
        return view('admin.pages.TKUser.dangki');
    }

    public function registerAction(AgentRequet $request)
    {
        $parts = explode(" ", $request->ho_va_ten);
        if(count($parts) > 1) {
            $lastname = array_pop($parts);
            $firstname = implode(" ", $parts);
        }
        else
        {
            $firstname = $request->ho_va_ten;
            $lastname = " ";
        }


        $data = $request->all();
        // $data['hash']       = Str::uuid();
        $data['ho_lot']     = $firstname;
        $data['ten']        = $lastname;
        $data['password']   = bcrypt($request->password);
        Agent::create($data);
        return response()->json(['status' => true]);
    }
    public function login(){
        return view('user.login');
    }
    public function loginAction(AgentLoginRequest $request){
        $data  = $request->all();
        // dd($data);
        $check = Auth::guard('agent')->attempt($data);
        // dd($check);
        if($check) {
            // Đã login thành công!!!
            $agent = Auth::guard('agent')->user();
            if($agent->is_open == 1) {
                return response()->json(['status' => 2]);
                // dd(2);
            } else {
                return response()->json(['status' => 1]);
                // dd(1);
            }
         } else{
            //Login thất bại
            return response()->json(['status' => 0]);
        }
    }
}
