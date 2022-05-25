<?php

namespace App\Http\Controllers\Sales;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use App\Models\OrdersHalk;
use App\Models\DetailsOrderHalk;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\damaged;
use App\Traits\All_Functions;
use Illuminate\Support\Facades\DB;



class HalkController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }
  use All_Functions;
  public function view_sales(Request $request)
  {
    date_default_timezone_set('Africa/Cairo');
    $date = date('Y-m-d');
    $customers  = Customer::where('typeid',1)->orWhere('typeid',3)
      ->where('status','1')
      ->select(['id','customer','custtype','debt','balance','discount'])
      ->get();
    $order = OrdersHalk::max('id');
    $order ++ ;
    $listorder = OrdersHalk::where(['date'=>$date,'del'=>'0'])->orderBy('id', 'desc')->select('id')->get();
    $salsetype = Setting::get()->first();
    return view('sales.halk',compact('customers','order','listorder','salsetype'));
  }
  /* Search Item by using NAme */
  public function Search_Name(Request $request){
    $data = [];
    switch($request->op){
      case 'name':{
        $data = damaged::where('name', 'LIKE', '%' . $request['query'] . "%")
          ->get();
        return response()->json($data);
        }break;
      case 'code':{
        $data = damaged::limit(1)
          ->where('code',$request['query'])
          ->first();
        return response()->json($data);
      }break;
    }

  }
  /* Add Item In Order */
  public function item_order(Request $request){

    $user         = Auth::user()->id;
    $unit         = '';
    $quan         = 0;
    $no_item      = $this->Increase_Sub_Order($request->order);
    $order_id     = 0;
    $total_pieces = 0;
    $quan_pieces  = 0;
    $op_ar        = 0;
    $productquan  = 0;
    /* Opeartion arabic */
    switch($request->opration)
    {
      case 'cash':{
        $op_ar        = "نقدي";
      }break;
      case 'aggel':{
        $op_ar        = "أجل";
      }break;
      case 'tsaer':{
        $op_ar        = "تسعير";
      }break;
      case 'back':{
        $op_ar        = "مرتجع";
     }break;
     case 'backofcus':{
        $op_ar        = "مرتجع من حساب";
      }break;
    }

    if($request->unit == "one")
    {
      $unit = "قطعة";
      $quan = $request->quan;
      $quan_pieces = $quan / $request->pecies;
      $total_pieces = $quan;
    }elseif($request->unit == "all"){
      $unit = "كرتونة";
      $quan = $request->quan;
      $quan_pieces = $quan;
      $total_pieces = $quan * $request->pecies;
    }
        
    function additem ($order,$date,$time,$user,$price,$quan,$disc,$pricelist,$customer,$opration,$op_ar,$item,$itemname,$no_item,$unit){
      if(OrdersHalk::limit(1)->where(['id'=>$order])->count() > 0){
        $orders = OrdersHalk::limit(1)->where(['id'=>$order])
          ->select(['subtotal','discount','profits','total'])
          ->first();
  
          $neworder = OrdersHalk::limit(1)->where(['id'=>$order])
            ->update([
              'date'     =>$date,
              'time'     =>$time,
              'user'     =>$user,
              'subtotal' =>$orders->subtotal + ((($price * $quan)-(($price * $quan * $disc)/100))),
              'total'    =>$orders->total + ((($price * $quan)-(($price * $quan * $disc)/100))),
              'profits'  =>$orders->profits + ((($price * $quan)-(($price * $quan * $disc)/100)) - ($pricelist * $quan)),
            ]);
      }else{
        $neworder = OrdersHalk::create([
          'customer' =>$customer,
          'date'     =>$date,
          'time'     =>$time,
          'op'       =>$opration,
          'op_ar'    =>$op_ar,
          'user'     =>$user,
          'subtotal' =>(($price * $quan)-(($price * $quan * $disc)/100)),
          'total'    =>(($price * $quan)-(($price * $quan * $disc)/100)),
          'profits'  =>(($price * $quan)-(($price * $quan * $disc)/100)) - ($pricelist * $quan),
        ]);
      }
      $details = DetailsOrderHalk::create([
        'order_id'   =>$order,
        'item'       =>$item,
        'item_name'  =>$itemname,
        'no_item'    =>$no_item,
        'unit'       =>$unit,
        'quan'       =>$quan,
        'price'      =>$price,
        'total'      =>(($price * $quan)-(($price * $quan * $disc)/100)),
        'discount'   =>($price * $quan * $disc)/100,
        'profits'    =>(($price * $quan)-(($price * $quan * $disc)/100)) - ($pricelist * $quan),
        'user'       =>$user,
        'date'       =>$date,
        'time'       =>$time,
      ]);
    }


    switch($request->opration){
      case 'cash':{
        $product = damaged::limit(1)->where('code',$request->item)
        ->select(['total_pieces','quan'])
        ->first();
        if($product->total_pieces >= $total_pieces)
        {
          additem($request->order,$request->date,$request->time,$user,$request->price,$quan,$request->disc,$request->pricelist,$request->customer,$request->opration,$op_ar,$request->item,$request->itemname,$no_item,$unit);
          /*Update Quantity Product*/
          $pro_update = damaged::limit(1)->where('code',$request->item)
            ->update([
              'total_pieces' => $product->total_pieces - $total_pieces,
              'quan'         => $product->quan - $quan_pieces,
          ]);
        }else{
          $productquan = $product->total_pieces;
          return response()->json([
            'errorquan'   =>'error',
            'productquan'=>$productquan
          ]);
        }

      }break;

      case 'aggel':{
        $customerback = 0;
        if($request->unit == "one")
        {
          $customerback =  $total_pieces * $request->price ;
        }else{
          $customerback = $quan_pieces * $request->price ;
        }
        if($request->customer > 0)
        {
          $product = damaged::limit(1)->where('code',$request->item)
          ->select(['total_pieces','quan'])
          ->first();

        if($product->total_pieces >= $total_pieces)
        {
          additem($request->order,$request->date,$request->time,$user,$request->price,$quan,$request->disc,$request->pricelist,$request->customer,$request->opration,$op_ar,$request->item,$request->itemname,$no_item,$unit);
          /*Update Quantity Product*/

          $pro_update = damaged::limit(1)->where('code',$request->item)
            ->update([
              'total_pieces' => $product->total_pieces - $total_pieces,
              'quan'         => $product->quan - $quan_pieces,
          ]);
          /* Update Customer money */
          $customerval = Customer::where(['id'=>$request->customer])->select(['debt'])->first();
          $upcustomer = Customer::where(['id'=>$request->customer])->update([
            'debt'=> $customerval->debt + $customerback 
          ]);
          return response()->json(['status'=>'true']);
        }else{
          $productquan = $product->total_pieces;
          return response()->json([
            'errorquan'   =>'error',
            'productquan'=>$productquan,
        ]);
        }

        }else{
          return response()->json(['customer'=>'يجب تحديد العميل']);
        }
      }break;
      case 'tsaer':{
        additem($request->order,$request->date,$request->time,$user,$request->price,$quan,$request->disc,$request->pricelist,$request->customer,$request->opration,$op_ar,$request->item,$request->itemname,$no_item,$unit);
      }break;
      case 'back':{
        additem($request->order,$request->date,$request->time,$user,$request->price,$quan,$request->disc,$request->pricelist,$request->customer,$request->opration,$op_ar,$request->item,$request->itemname,$no_item,$unit);
        /*Update Quantity Product*/
        $product = damaged::limit(1)->where('code',$request->item)
          ->select(['total_pieces','quan'])
          ->first();
        $pro_update = damaged::limit(1)->where('code',$request->item)
          ->update([
            'total_pieces' => $product->total_pieces + $total_pieces,
            'quan'         => $product->quan + $quan_pieces,
        ]);
      }break;
      case 'backofcus':{
        $customerback = 0;
        if($request->unit == "one")
        {
          $customerback =  $total_pieces * $request->price ;
        }else{
          $customerback = $quan_pieces * $request->price ;
        }
        if($request->customer > 0)
        {
          additem($request->order,$request->date,$request->time,$user,$request->price,$quan,$request->disc,$request->pricelist,$request->customer,$request->opration,$request->op_ar,$request->item,$request->itemname,$no_item,$unit);
          /*Update Quantity Product*/
          $product = damaged::limit(1)->where('code',$request->item)
            ->select(['total_pieces','quan'])
            ->first();
          $pro_update = damaged::limit(1)->where('code',$request->item)
            ->update([
              'total_pieces' => $product->total_pieces + $total_pieces,
              'quan'         => $product->quan + $quan_pieces,
          ]);
          /* Update Customer money */
          $customerval = Customer::where(['id'=>$request->customer])->select(['debt'])->first();
          $upcustomer = Customer::where(['id'=>$request->customer])->update([
            'debt'=> $customerval->debt - $customerback 
          ]);
          return response()->json(['status'=>'true']);
        }else{
          return response()->json(['customer'=>'يجب تحديد العميل']);
        }
      }
    }
  }

  /* Crete Discount in Order  */
  public function order_discount(Request $request){
    $val_discount = 0;
    $total        = 0;
    $profits      = 0;
    $order = OrdersHalk::limit(1)->where('id',$request->order)
      ->select(['subtotal'])
      ->first();
    $details = DetailsOrderHalk::where('order_id',$request->order)
      ->select('profits')
      ->get();
    foreach($details as $detail){
      $profits = $profits + $detail->profits;
    }
    switch($request->distype){
      case 'Value':{
        $val_discount = $request->discount;
        $total   = $order->subtotal - $request->discount;
        $profits = $profits - $val_discount;
        $pro_update = OrdersHalk::limit(1)->where('id',$request->order)
          ->update([
            'discount'     => $request->discount,
            'dis_type'     => $request->distype,
            'val_discount' => $request->discount,
            'total'        => $order->subtotal - $request->discount,
            'profits'      => $profits,
          ]);

      }break;
      case 'Ratio':{
        $val_discount =($order->subtotal * $request->discount) / 100;
        $profits = $profits - $val_discount;

        $pro_update = OrdersHalk::limit(1)->where('id',$request->order)
          ->update([
            'discount'     => $request->discount,
            'dis_type'     => $request->distype,
            'val_discount' => $val_discount,
            'total'        => $order->subtotal - $val_discount,
            'profits'      => $profits,
          ]);
          $total = $order->subtotal - $val_discount;

      }break;
    }
    return ['discount' =>$val_discount , 'total'=>$total ];
  }

  /* Delete ORder */
  public function delete_order(Request $request){
    $user         = Auth::user()->id;
    $order = OrdersHalk::limit(1)->where('id',$request->order)
    ->update([
      'del' => 1,
      'user_del' =>$user,
    ]);
  }

  // Search Order in page Sales
  public function search_order(Request $request){
    $orders = OrdersHalk::limit(1)->with('Details')->where(['id'=>$request->order, 'del'=>'0'])->get();
    $customer = Customer::limit(1)->where('id',$orders[0]->customer)->first();
    if($orders){
      return response()->json([
        'orders'=>$orders,
        'customer' =>$customer,
      ]);
    }
  }

  public function save_balance(Request $request){
    if($request->customer > 0)
    {
      $update = OrdersHalk::limit(1)->where('id',$request->order)->update([
        'balanc' =>$request->balance,
      ]);
      $customerval = Customer::where(['id'=>$request->customer])->select(['debt'])->first();
      $upcustomer = Customer::where(['id'=>$request->customer])->update([
        'debt'=> $customerval->debt - $request->balance 
      ]);
      if($update){
        return response()->json(['status'=>'true']);
      }
    }else{
      return response()->json(['customer'=>'يجب تحديد العميل']);
    }

  }

  public function del_element(Request $request){

    function productinc($serial , $element)
    {

      $quan         = 0;
      $totalquan    = 0;
      $total_pieces = 0;
      $quan_pieces  = 0;
      $unit         = '';

      $details = DetailsOrderHalk::limit(1)
        ->where(['order_id'=>$serial ,'no_item'=>$element])
        ->select(['item','unit','quan'])->first();

      $product = damaged::limit(1)->where('code',$details->item)
        ->select(['total_pieces','quan','pieces'])
        ->first();
      if($details->unit == "قطعة")
      {
        $unit = "one";
      }elseif($details->unit =="كرتونة"){
        $unit = "all";
      }
      if($unit == "one")
      {
        $quan = $details->quan;
        $quan_pieces = $quan / $product->pieces;
        $total_pieces = $quan;
      }elseif($unit == "all"){
        $quan = $details->quan;
        $quan_pieces = $quan;
        $total_pieces = $quan * $product->pieces;
      }
      $pro_update = damaged::limit(1)->where('code',$details->item)
        ->update([
          'total_pieces' => $product->total_pieces + $total_pieces,
          'quan'         => $product->quan + $quan_pieces,
      ]);
    }
    function delitem($serial,$element)
    {
      $user         = Auth::user()->id;
      $newdiscount  = 0 ; 
      $valdisel     = 0 ;
      $newprofits   = 0 ;
      $newsubtotal  = 0 ;
      $newtotal     = 0 ;
      $backmoney    = 0 ;
      $ratio        = 0 ;
      // Get Order in Delete Element
      $order = OrdersHalk::limit(1)->where('id',$serial)->first();
      $details = DetailsOrderHalk::limit(1)
        ->where(['order_id'=>$serial ,'no_item'=>$element])
        ->first();


      if($order->dis_type != Null)
      {
        $ratio       = ($order->val_discount/$order->subtotal);
        $valdisel    = $ratio * $details->total;
        $newdiscount = $order->val_discount - $valdisel;
        $newprofits  = $order->profits - $valdisel;
        $newsubtotal = $order->subtotal - $details->total;
        $newtotal    = $newsubtotal - $newdiscount;
        $backmoney   = $details->total - $valdisel;

        switch($order->dis_type){
          case 'Value':{
            $pro_update = OrdersHalk::limit(1)->where('id',$serial)
              ->update([
                'discount'     => $ratio * 100,
                'dis_type'     => "Ratio",
                'val_discount' => $newdiscount,
                'total'        => $newtotal,
                'profits'      => $newprofits,
                'subtotal'     => $newsubtotal,
              ]);
          }break;
          case 'Ratio':{
            $pro_update = OrdersHalk::limit(1)->where('id',$serial)
              ->update([
                'discount'     => $ratio * 100,
                'val_discount' => $newdiscount,
                'total'        => $newtotal,
                'profits'      => $newprofits,
                'subtotal'     => $newsubtotal,
              ]);
          }break;
        }
      }else{
        $newprofits  = $order->profits - $details->profits;
        $newsubtotal = $order->subtotal - $details->total;
        $newtotal    = $newsubtotal;
        $backmoney   = $details->total;

        $pro_update = OrdersHalk::limit(1)->where('id',$order)
        ->update([
          'total'        => $newtotal,
          'profits'      => $newprofits,
          'subtotal'     => $newsubtotal,
        ]);
      }
      $details = DetailsOrderHalk::limit(1)
        ->where(['order_id'=>$serial ,'no_item'=>$element])
        ->delete();
      // Check in last Order 
      if(DetailsOrderHalk::limit(1)->where(['order_id'=>$serial])->count() == 0)
      {
        $del = OrdersHalk::limit(1)->where('id',$order)->update([
          'del'      => 1,
          'user_del' => $user
        ]);
      }
      return $backmoney;
    }
    switch($request->opration)
    {
     case 'backofcus':{
        if($request->customer > 0)
        {
          productinc($request->order, $request->element);
          $backmoney = delitem($request->order, $request->element);
          $customerval = Customer::where(['id'=>$request->customer])->select(['debt'])->first();
          $upcustomer = Customer::where(['id'=>$request->customer])->update([
            'debt'=> $customerval->debt - $backmoney 
          ]);
          return response()->json(['backmoney'=>$backmoney]);
        }else{
          return response()->json(['customer'=>'يجب تحديد العميل']);
        }
      }break;
      case 'aggel':{
        if($request->customer > 0)
        {
          productinc($request->order, $request->element);
          $backmoney = delitem($request->order, $request->element);
          $customerval = Customer::where(['id'=>$request->customer])->select(['debt'])->first();
          $upcustomer = Customer::where(['id'=>$request->customer])->update([
            'debt'=> $customerval->debt - $backmoney 
          ]);
          return response()->json(['backmoney'=>$backmoney]);
        }else{
          return response()->json(['customer'=>'يجب تحديد العميل']);
        }
      }break;
      default:{
        productinc($request->order, $request->element);
        $backmoney = delitem($request->order, $request->element);
        return response()->json(['backmoney'=>$backmoney]);
      }
    }
  }
  
  public function transfare_to_chash(Request $request)
  {
    $update_product = '';
    $orderupdate = OrdersHalk::limit(1)->where('id',$request->order)
      ->update([
        'op'    => 'cash',
        'op_ar' =>'نقدي'
      ]);
    if($orderupdate){
      if(DetailsOrderHalk::limit(1)->where(['order_id'=>$request->order])->count() > 0)
      {
        $update = DetailsOrderHalk::where(['order_id'=>$request->order])->get();
        if($update){
          foreach($update as $item)
          {
            $pro_update = damaged::limit(1)->where('code',$item->item)->first();

            if($item->unit == "قطعة"){

              $total_pieces = $pro_update->total_pieces -  $item->quan;
              $total_quan   = $pro_update->quan - ($item->quan / $pro_update->pieces);

              $update_product = damaged::limit(1)->where('code',$item->item)
              ->update([
                'total_pieces' => $total_pieces,
                'quan'         => $total_quan,
              ]);

            }else{
              $total_pieces = $pro_update->total_pieces -  ($item->quan * $pro_update->pieces);
              $total_quan   = $pro_update->quan - $item->quan;

              $update_product = damaged::limit(1)->where('code',$item->item)
              ->update([
                'total_pieces' => $total_pieces,
                'quan'         => $total_quan,
              ]);
            }
          }
        }

      } 
    }
    if($update_product){
      return response()->json(['status'=>'true']);
    }
  }


  public function transfare_to_aggel(Request $request)
  {
    if($request->customer > '0'){

      $update_product = '';
      $total = 0;
      $orderupdate = OrdersHalk::limit(1)->where('id',$request->order)
        ->update([
          'op'    => 'aggel',
          'op_ar' =>'أجل',
          'customer' =>$request->customer, 
        ]);
      if($orderupdate){
        if(DetailsOrderHalk::limit(1)->where(['order_id'=>$request->order])->count() > 0)
        {
          $update = DetailsOrderHalk::where(['order_id'=>$request->order])->get();
          if($update){
            foreach($update as $item)
            {
              $pro_update = damaged::limit(1)->where('code',$item->item)->first();

              if($item->unit == "قطعة"){
  
                $total_pieces = $pro_update->total_pieces -  $item->quan;
                $total_quan   = $pro_update->quan - ($item->quan / $pro_update->pieces);
  
                $update_product = damaged::limit(1)->where('code',$item->item)
                ->update([
                  'total_pieces' => $total_pieces,
                  'quan'         => $total_quan,
                ]);
  
              }else{
                $total_pieces = $pro_update->total_pieces -  ($item->quan * $pro_update->pieces);
                $total_quan   = $pro_update->quan - $item->quan;
  
                $update_product = damaged::limit(1)->where('code',$item->item)
                ->update([
                  'total_pieces' => $total_pieces,
                  'quan'         => $total_quan,
                ]);
              }
            }
          }
  
        } 
      }
      if($update_product){
        $order = OrdersHalk::limit(1)->where('id',$request->order)->first();
        if($order->customer > 0)
        {
          $update_customer = Customer::limit(1)->where(['id'=>$order->customer])->first();
          $update_customer->debt -= $order->total;
          $update_customer->save();
        }
        $update_customer = Customer::limit(1)->where(['id'=>$request->customer])->first();
        $update_customer->debt += $order->total;
        $update_customer->save();
        if($update_customer){
          return response()->json(['status'=>'true']);
        }
      }
    }else{
      return response()->json(['customer'=>'برجاء تحديد العميل']);
    }

  }
}
