<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Unit_Request extends FormRequest
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
        'unit'=>'required|unique:units,name',
      ];
  }

  public function messages()
  {
    return
      [
        'unit.required' => __('ادخل اسم الوحدة'),
        'unit.unique'   => __('اسم الوحدة موجود بالفعل'),
      ];
  }
}
