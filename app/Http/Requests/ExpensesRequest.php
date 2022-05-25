<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpensesRequest extends FormRequest
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
          'new_expense'=>'required|unique:expenses,name',
        ];
    }
  
    public function messages()
    {
      return
        [
          'new_expense.required' => __('ادخل اسم المصروف الجديد'),
          'new_expense.unique'   => __('اسم المصروف موجود بالفعل'),
        ];
    }
}
