<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTKNhanVienRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ho_va_ten'         =>  'required|max:50|unique:agents,ho_va_ten,'.$this->id,
            'so_dien_thoai'     =>  'required|max:50|unique:agents,so_dien_thoai,'.$this->id,
            'email'             =>  'required|max:50|unique:agents,email,'.$this->id,
            // 'password'          =>  'required|nullable',
            'dia_chi'           =>  'required|max:50|unique:agents,dia_chi,'.$this->id,
            'is_open'           =>  'required|boolean',
            'id'                =>  'required|exists:agents,id',
        ];
    }
    public function messages()
    {
        return [
            'required'      =>  ':attribute không được để trống',
            'max'           =>  ':attribute quá dài',
            'min'           =>  ':attribute quá ngắn',
            'exists'        =>  ':attribute không tồn tại',
            'boolean'       =>  ':attribute chỉ được chọn True/False',
            'unique'        =>  ':attribute đã tồn tại',
        ];
    }

    public function attributes()
    {
        return [
            'id'                =>  'Tài khoản nhân viên',
            'ho_va_ten'         =>  'Họ và tên',
            'so_dien_thoai'     =>  'Số điện thoại',
            'email'             =>  'Email',
            // 'password'          =>  'password',
            'dia_chi'           =>  'dia_chi',
            'is_open'           =>  'Tình trạng',
        ];
    }
}
