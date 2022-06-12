<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddCartRequest extends FormRequest
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
            'san_pham_id'       =>  'required|exists:san_phams,id',
            'so_luong'          =>  'required|numeric|min:1',
        ];
    }
    public function messages()
    {
        return [
            'required'     => ':attribute không được để trống',
            'exists'       => ':attribute không tồn tại' ,
            'numeric'      => ':attribute phải dạng số',
            'min'          => ':attribute lớn hơn 1 ' ,
        ];

    }
    public function attributes()
    {
        return [
            'san_pham_id'       =>  'sản phẩm',
            'so_luong'          =>  'số lượng',
        ];
    }
}
