<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
class CustomersController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }

    public function view_customers()
    {
      $customers  = Customer::paginate(10);
      return view('customers.customers',compact('customers'));
    }
    /* =============================== Save Customers ========================= */
    public function save_customer(CustomerRequest $request){
      $data = Customer::create([
          'customer'  =>$request->customer_name,
          'custphone' =>$request->phone_number,
          'custid'    =>$request->id_number,
          'custtype'  =>$request->typeName,
          'typeid'    =>$request->typecustomer,
          'debt'      =>$request->debt,
          'balance'   =>$request->funds,
          'discount'  =>$request->discount,
      ]);
      if($data){
        return response()->json([
          'status' => 'true'
        ]);
      }
    }

    public function update_customer(Request $request)
    {
      $data = Customer::limit(1)
        ->where('id',$request->id)
        ->update([
        'customer'  =>$request->customer_name,
        'custphone' =>$request->phone_number,
        'custid'    =>$request->id_number,
        'custtype'  =>$request->typeName,
        'typeid'    =>$request->typecustomer,
        'debt'      =>$request->debt,
        'balance'   =>$request->funds,
        'discount'  =>$request->discount,
    ]);
    if($data)
    {
      return response()->json([
        'status' => 'true'
      ]);
    } 
  }

  /*====================== Start Active Category  ===========================================*/
  public function active_customer(Request $request){
    $data = Customer::where('id',$request->serial)->limit(1)->update([
      'status' => $request->active
    ]);
  }

  /*====================== Start Search Customer  ===========================================*/
  public function search_customer(Request $request)
  {
    $data = Customer::where('customer', 'LIKE', '%' . $request->text . "%")->get();
    if($data)
    {
      return response()->json($data);
    }
  }

  public function delete_customer(Request $request){
    $data = Customer::limit(1)->where(['id'=>$request->serial])
      ->delete();
    if($data)
    {
      return response()->json($data);
    }
  }
}
