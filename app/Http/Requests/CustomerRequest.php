<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
          'customer_name'=>'required|unique:customers,customer',
          'phone_number' =>'required|unique:customers,custphone',
          'id_number'    =>'unique:customers,custid',
          'typecustomer' =>'required',
        ];
    }
  
    public function messages()
    {
      return
        [
          'customer_name.required'   => __('ادخل اسم العميل'),
          'phone_number.unique'      => __('رقم العميل موجود بالفعل'),
          'phone_number.required'    => __('ادخل رقم الهاتق'),
          'id_number.unique'         => __('الرقم القومي موجود بالفعل'),
          'typecustomer.required'    => __('اختار نوع العميل'),
        ];
    }
}
