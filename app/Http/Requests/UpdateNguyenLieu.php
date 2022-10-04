<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNguyenLieu extends FormRequest
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
            'ten_nguyen_lieu'      =>  'required|max:50|unique:nguyen_lieus,ten_nguyen_lieu,'.$this->id,
            'slug_nguyen_lieu'     =>  'required|max:50|unique:nguyen_lieus,slug_nguyen_lieu,'.$this->id,
            'is_open'           =>  'required|boolean',
            'id'                =>  'required|exists:nguyen_lieus,id',
        ];
    }
    public function messages()
    {
        return [
            'required'      =>  ':attribute không được để trống',
            'max'           =>  ':attribute quá dài',
            'exists'        =>  ':attribute không tồn tại',
            'boolean'       =>  ':attribute chỉ được chọn True/False',
            'unique'        =>  ':attribute đã tồn tại',
        ];
    }
    public function attributes()
    {
        return [
            'id'                =>  'Danh mục nguyên liệu',
            'ten_nguyen_lieu'      =>  'Tên nguyên liệu',
            'slug_nguyen_lieu'     =>  'Slug nguyên liệu',
            'is_open'           =>  'Tình trạng',
        ];
    }
}
