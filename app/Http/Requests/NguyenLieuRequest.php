<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NguyenLieuRequest extends FormRequest
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
            'ten_nguyen_lieu'         =>   'required|max:100|unique:nguyen_lieus,ten_nguyen_lieu',
            'slug_nguyen_lieu'        =>   'required|unique:nguyen_lieus,slug_nguyen_lieu',
            'don_vi'                  =>    'required',
            'is_open'                 =>   'required|boolean',
        ];

    }
    public function messages()
    {
        return [
            'required'      =>  ':attribute không được để trống',
            'max'           =>  ':attribute quá dài',
            'boolean'       =>  ':attribute chỉ được chọn True/False',
            'unique'        =>  ':attribute đã tồn tại',
        ];
    }
    public function attributes()
    {
        return [
            'ten_nguyen_lieu'         =>   'Tên nguyên liệu',
            'slug_nguyen_lieu'        =>   'Slug nguyên liệu',
            'don_vi'                  =>   'đơn_vi',
            'is_open'                 =>   'Tình trạng',
        ];
    }
}
