<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Product_Request extends FormRequest
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
        'name'          =>'required|unique:products,name',
        'unit_id'       =>'required',
        'category_id'   =>'required',
        'quan'          =>'required',
        'pieces'        =>'required',
        'total_pieces'  =>'required',
        'saleprice_p'   =>'required',
        'price_p'       =>'required',
        'pricelist_p'   =>'required',
        'min_quantity'  =>'required',
        'code'          =>'required|unique:products,code',
      ];
  }

  public function messages()
  {
    return
      [
        'name.required'          => __('ادخل اسم المنتج'),
        'name.unique'            => __('اسم المنتج موجود بالفعل'),
        'code.unique'            => __('كود المنتج موجود بالفعل'),
        'unit_id.required'       =>__('اختار الوحدة'),
        'category_id.required'   =>__('اختار الصنف'),
        'quan.required'          =>__('ادخل الكمية'),
        'pieces.required'        =>__('ادخل عدد القطع'),
        'total_pieces.required'  =>__('مجموع القطع'),
        'saleprice_p.required'   =>__('ادخل سعر الجمله'),
        'price_p.required'       =>__('ادخل سعر الجمله'),
        'pricelist_p.required'   =>__('ادخل سعر الشراء'),
        'min_quantity.required'  =>__('ادخل حد الطلب'),
      ];
  }
}
