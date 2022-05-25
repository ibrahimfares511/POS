<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffRequest extends FormRequest
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
          'employee_name'     =>'required|unique:employees,employee',
          'salary_number'     =>'required',
          'type_work'         =>'required',
          'dayes_of_work'     =>'required',
          'hours_of_work'     =>'required',
          'inauguration_date' =>'required',
          'holidays_number'   =>'required',
        ];
    }
  
    public function messages()
    {
      return
        [
          'employee_name.required'       => __('ادخل اسم الموظف'),
          'employee_name.unique'         => __(' اسم الموظف موجود بالفعل'),
          'salary_number.required'       => __('ادخل مرتب الموظف'),
          'type_work.required'           => __('ادخل نوع العمل '),
          'dayes_of_work.required'       => __('ادخل عدد ايام العمل'),
          'hours_of_work.required'       => __('ادخل عدد ساعات العمل في اليوم الواحد'),
          'inauguration_date.required'   => __('اختار تاريخ التوظيف'),
          'holidays_number.required'     => __('ادخل عدد ايام الاجازة'),
        ];
    }
}
