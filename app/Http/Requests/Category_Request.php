<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Category_Request extends FormRequest
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
    return
      [
        'category'=>'required|unique:categories,name',
      ];
  }

  public function messages()
  {
    return
      [
        'category.required' => __('ادخل اسم الصنف'),
        'category.unique'   => __('اسم الصنف موجود بالفعل'),
      ];
  }
}
