<?php

namespace App\Http\Controllers\Exchange_Supply;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Supply;
use App\Http\Requests\SupplyRequest;
use Illuminate\Support\Facades\Auth;
class SupplyController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }
  public function view_supply()
  {
    date_default_timezone_set('Africa/Cairo');
    $date = date('Y-m-d');
    $customers = Customer::where('typeid',1)->orWhere('typeid',3)->get();
    $new_serial    = Supply::max('id');
    $new_serial++;
    $supply = Supply::with(['Customers','Users'])->where(['date'=>$date,'del'=>0])->get();
    return view('exchange_supply.supply',compact('customers','new_serial','supply'));
  }

  /*##################################################################################################*/
            /*########################  Supply Page   ####################################*/
  /*##################################################################################################*/
  public function save_supply(SupplyRequest $request){
    $user = Auth::user()->id;
    $data = Supply::create([
        'customer'=>$request->customer,
        'forhim'=>$request->supply_name,
        'val'=>$request->paid_amount,
        'note'=>$request->note,
        'date'=>$request->date,
        'user'=>$user,
        'time'=>$request->time
    ]);
    $new_serial = $data->id;
    $new_serial ++;
    if($data){
      $customer = Customer::where('id',$request->customer)->update(['debt'=>$request->supply_name]);
      return response()->json(['status'=>'true','serial'=>$new_serial]);
    }
  }

  public function search_supply(Request $request){
    $data = [];
    switch($request->type){
      case 'id':{
        $data = Supply::limit(1)->with('Customers')->where('id',$request->search)->get();
      }break;
      case 'price':{
        $data = Supply::with('Customers')->where('val', $request->search)->get();
      }break;
      case 'name':{
        $cat = Customer::where('customer', 'LIKE', '%' . $request->search . "%")
            ->select(['id'])->get();
        foreach($cat as $c){
          $new = Supply::with('Customers')->where('customer',$c->id)->get();
          foreach($new as $n){
            if(!empty($new)){
              array_push($data ,$n);
            }
          }
        }
      }break;
      case 'date':{
        $data = Supply::with('Customers')->whereBetween('date',[$request->from, $request->to])->get();
      }break;
      case 'all':{
        $data = Supply::with('Customers')->get();
      }break;
    }
    if($data)
    {
      return response()->json($data);
    }
  }
  public function delete_supply(Request $request){
    $user = Auth::user()->id;
    if(Supply::where(['id'=>$request->op,'del_user'=>1])->count()>0)
    {

    }else{
    $up_exchange = Supply::where(['id'=>$request->op])->update([
        'del' => 1,
        'del_user' => $user,
    ]);
    $up_customer = Customer::limit(1)->where('id',$request->customer)->select(['debt','id'])->first();
    $update      = Customer::limit(1)->where('id',$request->customer)->update([
      'debt' => $up_customer->debt + $request->mony,
    ]);
    if($update){
      return response()->json(['status'=>'true']);
    }
    }

  }

}
