<?php

namespace App\Http\Controllers\Exchange_Supply;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exchange;
use App\Models\Customer;
use App\Http\Requests\ExchangeRequest;
use App\User;
use Illuminate\Support\Facades\Auth;

class ExchangeController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }
    public function view_exchange()
    {
      date_default_timezone_set('Africa/Cairo');
      $date       = date('Y-m-d');
      $customers  = Customer::where('typeid',2)->orWhere('typeid',3)->get();
      $new_serial = Exchange::max('id');
      $new_serial++;
      $supply = Exchange::with(['Customers','Users'])->where(['date'=>$date,'del'=>0])->get();
      return view('exchange_supply.exchange',compact('customers','new_serial','supply'));
    }

      /*##################################################################################################*/
            /*######################## Exchange Page   ####################################*/
  /*##################################################################################################*/
  public function save_exchange(ExchangeRequest $request){
    $user = Auth::user()->id;
    $data = Exchange::create([
        'customer'=>$request->customer,
        'forhim'  =>$request->supply_name,
        'val'     =>$request->paid_amount,
        'note'    =>$request->note,
        'date'    =>$request->date,
        'time'    =>$request->time,
        'user'    =>$user
    ]);
    $new_serial = $data->id;
    $new_serial ++;
    if($data){
      $customer = Customer::where('id',$request->customer)->update(['balance'=>$request->supply_name]);
      return response()->json(['status'=>'true','serial'=>$new_serial]);
    }
  }

  public function search_exchange(Request $request){
    $data = [];
    switch($request->type){
      case 'id':{
        $data = Exchange::limit(1)->with(['Customers','Users'])->where(['id'=>$request->search,'del'=>0])->get();
      }break;
      case 'price':{
        $data = Exchange::with(['Customers','Users'])->where(['val'=>$request->search,'del'=>0])->get();
      }break;
      case 'name':{
        $cat = Customer::where('customer', 'LIKE', '%' . $request->search . "%")
            ->select(['id'])->get();
        foreach($cat as $c){
          $new = Exchange::with(['Customers','Users'])->where(['customer'=>$c->id,'del'=>0])->get();
          foreach($new as $n){
            if(!empty($new)){
              array_push($data ,$n);
            }
          }
        }
      }break;
      case 'date':{
        $data = Exchange::with(['Customers','Users'])->whereBetween(['date'=>[$request->from, $request->to],'customer'=>$c->id])->get();
      }break;
      case 'all':{
        $data = Exchange::with(['Customers','Users'])->get();
      }break;
    }
    if($data)
    {
      return response()->json($data);
    }
  }

  public function delete_exchange(Request $request){
    $user = Auth::user()->id;
    $up_exchange = Exchange::where(['id'=>$request->op])->update([
        'del' => 1,
        'del_user' => $user,
    ]);
    $up_customer = Customer::limit(1)->where('id',$request->customer)->select(['balance','id'])->first();
    $update      = Customer::limit(1)->where('id',$request->customer)->update([
      'balance' => $up_customer->balance + $request->mony,
    ]);
    if($update){
      return response()->json(['status'=>'true']);
    }
  }
}
