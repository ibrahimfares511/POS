<?php

namespace App\Http\Controllers\ReportsController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Customer;
use App\Models\OrdersBuy;

class BuyController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:صفحة التقارير|تقارير المشتريات', ['only' => ['viewreport']]);
        $this->middleware('auth');
    }
    public function viewreport(){
        $customers  = Customer::where('typeid',1)->orWhere('typeid',2)
            ->where('status','1')
            ->select(['id','customer','custtype','debt','balance','discount'])
            ->get();
        return view('Reports.buy',compact('customers'));
    }
    public function buy_report(Request $request){
        $data = [];
        switch($request->type)
        {
            case '':{
                $data = OrdersBuy::with(['Customer','User'])
                ->where('date',$request->date)
                ->where('del','0')
                ->orderBy('id', 'desc')
                ->get();
            }break;
            case 'customer':{
                if($request->date_from == 0 || $request->date_to == 0){
                    $data = OrdersBuy::with(['Customer','User'])
                    ->where('customer',$request->customer)
                    ->where('del','0')
                    ->orderBy('id', 'desc')
                    ->get();
                }else{
                    $data = OrdersBuy::with(['Customer','User'])
                        ->where('customer',$request->customer)
                        ->where('del','0')
                        ->whereBetween('date', array($request->date_from, $request->date_to))
                        ->orderBy('id', 'desc')
                        ->get();
                }
            }break;
            case 'id':{
                $data = OrdersBuy::with(['Customer','User'])
                ->where('id',$request->text)
                ->where('del','0')
                ->orderBy('id', 'desc')
                ->get();
            }break;
            case 'delete':{
                if($request->date_from == 0 || $request->date_to == 0){
                    $data = OrdersBuy::with(['Customer','UserDelete'])
                    ->where('del','1')
                    ->orderBy('id', 'desc')
                    ->get();
                }else{
                    $data = OrdersBuy::with(['Customer','UserDelete'])
                        ->whereBetween('date', array($request->date_from, $request->date_to))
                        ->where('del','1')
                        ->orderBy('id', 'desc')
                        ->get();
                }
            }break;
            case 'all':{
                if($request->date_from == 0 || $request->date_to == 0){
                    $data = OrdersBuy::with(['Customer','User'])
                        ->where('del','0')
                        ->orderBy('id', 'desc')
                        ->get();
                }else{
                    $data = OrdersBuy::with(['Customer','User'])
                        ->where('del','0')
                        ->whereBetween('date', array($request->date_from, $request->date_to))
                        ->orderBy('id', 'desc')
                        ->get();
                }
            }break;
            default:{
                if($request->date_from == 0 || $request->date_to == 0){
                    $data = OrdersBuy::with(['Customer','User'])
                        ->where('op',$request->type)
                        ->where('del','0')
                        ->orderBy('id', 'desc')
                        ->get();
                }else{
                    $data = OrdersBuy::with(['Customer','User'])
                        ->where('op',$request->type)
                        ->where('del','0')
                        ->whereBetween('date', array($request->date_from, $request->date_to))
                        ->orderBy('id', 'desc')
                        ->get();
                }
            }
        }
        return $data;
    }

    public function buy_report_order(Request $request){

        $data = OrdersBuy::limit(1)
        ->with(['Details','Customer','User'])
        ->where('id',$request->rowId)
        ->first();
        if($data){
            return $data;
        }
    }
}
