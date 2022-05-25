<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SpendingRequest extends FormRequest
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
          'expense_name' =>'required',
          'expense_money'=>'required',
          'expense_date' =>'required',
        ];
    }
  
    public function messages()
    {
      return
        [
          'expense_name.required'  => __('اختار نوع المصروف'),
          'expense_money.required' => __('ادخل قيمة المصروف '),
          'expense_date.required'  => __('ادخل تاريخ المصروف '),
        ];
    }
}
