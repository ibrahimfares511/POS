<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExchangeRequest extends FormRequest
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
          'customer'    =>'required',
          'paid_amount' =>'required'
        ];
    }
  
    public function messages()
    {
      return
        [
          'customer.required' => __('ادخل اسم العميل'),
          'paid_amount.required'   => __('ادخل القيمة'),
        ];
    }
}
