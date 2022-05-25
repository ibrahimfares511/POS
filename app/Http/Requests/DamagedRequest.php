<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DamagedRequest extends FormRequest
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

        'd_item_quant'               =>'required',
        'd_item_pieces'              =>'required',
        'd_items_pieces'             =>'required',
        'd_wholesale_price_piece'    =>'required',
        'd_retail_price_piece'       =>'required',
        'd_buy_price_piece'          =>'required',
      ];
  }

  public function messages()
  {
    return
      [
        'd_item_quant.required'              =>__('ادخل الكمية'),
        'd_item_pieces.required'             =>__('ادخل عدد القطع'),
        'd_items_pieces.required'            =>__('مجموع القطع'),
        'd_wholesale_price_piece.required'   =>__('ادخل سعر الجمله'),
        'd_retail_price_piece.required'      =>__('ادخل سعر القطاعي'),
        'd_buy_price_piece.required'         =>__('ادخل سعر الشراء'),
      ];
  }
}
