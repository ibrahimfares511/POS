<?php

namespace App\Http\Controllers\ReportsController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Exchange;
use App\Models\Supply;

class ExchangeController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }
    public function viewreport(){
        $customers  = Customer::where('typeid',1)->orWhere('typeid',2)
        ->where('status','1')
        ->select(['id','customer','custtype','debt','balance','discount'])
        ->get();
        return view('Reports.Exchange',compact('customers'));
    }
    public function viewreportsupply(){
      $customers  = Customer::where('typeid',1)->orWhere('typeid',3)
      ->where('status','1')
      ->select(['id','customer','custtype','debt','balance','discount'])
      ->get();
      return view('Reports.Supllay',compact('customers'));
  }

    public function exchange_report(Request $request){
      $data = [];
      switch($request->type)
      {
          case '':{
              $data = Exchange::with(['Customers','Users'])
              ->where(['date'=>$request->date,'del'=>'0'])
              ->orderBy('id', 'desc')
              ->get();
          }break;
          case 'delete':{
            if($request->date_from == 0 || $request->date_to == 0){
                $data = Exchange::with(['Customers','UserDelete'])
                ->where('del','1')
                ->orderBy('id', 'desc')
                ->get();
            }else{
                $data = Exchange::with(['Customers','UserDelete'])
                    ->whereBetween('date', array($request->date_from, $request->date_to))
                    ->where('del','1')
                    ->orderBy('id', 'desc')
                    ->get();
            }
        }break;
          case 'customer':{
              if($request->date_from == 0 || $request->date_to == 0){
                  $data = Exchange::with(['Customers','Users'])
                  ->where('customer',$request->customer)
                  ->orderBy('id', 'desc')
                  ->get();
              }else{
                  $data = Exchange::with(['Customers','Users'])
                      ->where('customer',$request->customer)
                      ->whereBetween('date', array($request->date_from, $request->date_to))
                      ->orderBy('id', 'desc')
                      ->get();
              }
          }break;
          case 'id':{
              $data = Exchange::with(['Customers','Users'])
              ->where('id',$request->text)
              ->orderBy('id', 'desc')
              ->get();
          }break;
          case 'all':{
              if($request->date_from == 0 || $request->date_to == 0){
                  $data = Exchange::with(['Customers','Users'])
                      ->orderBy('id', 'desc')
                      ->get();
              }else{
                  $data = Exchange::with(['Customers','Users'])
                      ->whereBetween('date', array($request->date_from, $request->date_to))
                      ->orderBy('id', 'desc')
                      ->get();
              }
          }break;
      }
      return $data;
  }

  public function Supply_report(Request $request){
    $data = [];
    switch($request->type)
    {
        case '':{
            $data = Supply::with(['Customers','Users'])
            ->where(['date'=>$request->date,'del'=>'0'])
            ->orderBy('id', 'desc')
            ->get();
        }break;
        case 'delete':{
            if($request->date_from == 0 || $request->date_to == 0){
                $data = Supply::with(['Customers','UserDelete'])
                ->where('del','1')
                ->orderBy('id', 'desc')
                ->get();
            }else{
                $data = Supply::with(['Customers','UserDelete'])
                    ->whereBetween('date', array($request->date_from, $request->date_to))
                    ->where('del','1')
                    ->orderBy('id', 'desc')
                    ->get();
            }
        }break;
        case 'customer':{
            if($request->date_from == 0 || $request->date_to == 0){
                $data = Supply::with(['Customers','Users'])
                ->where('customer',$request->customer)
                ->orderBy('id', 'desc')
                ->get();
            }else{
                $data = Supply::with(['Customers','Users'])
                    ->where('customer',$request->customer)
                    ->whereBetween('date', array($request->date_from, $request->date_to))
                    ->orderBy('id', 'desc')
                    ->get();
            }
        }break;
        case 'id':{
            $data = Supply::with(['Customers','Users'])
            ->where('id',$request->text)
            ->orderBy('id', 'desc')
            ->get();
        }break;
        case 'all':{
            if($request->date_from == 0 || $request->date_to == 0){
                $data = Supply::with(['Customers','Users'])
                    ->orderBy('id', 'desc')
                    ->get();
            }else{
                $data = Supply::with(['Customers','Users'])
                    ->whereBetween('date', array($request->date_from, $request->date_to))
                    ->orderBy('id', 'desc')
                    ->get();
            }
        }break;
    }
    return $data;
}

}
