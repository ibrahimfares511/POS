<?php

namespace App\Http\Controllers\Purchases;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Customer;
use App\Models\OrdersBuy;
use App\Models\Setting;
use App\Models\Expired_Date;
use App\Models\DetailsOrder;
use App\Models\DetailsOrderBuy;
use App\Traits\All_Functions;
use Illuminate\Support\Facades\DB;

class PurchasesController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }
    use All_Functions;
    public function view_purchases()
    {
      date_default_timezone_set('Africa/Cairo');
      $date = date('Y-m-d');
      $customers  = Customer::where('typeid',2)->orWhere('typeid',3)
        ->where('status','1')
        ->select(['id','customer','custtype','debt','balance','discount'])
        ->get();
      $order = OrdersBuy::max('id');
      $order ++ ;
      $listorder = OrdersBuy::where(['date'=>$date,'del'=>'0'])->orderBy('id', 'desc')->select('id')->get();
      $salsetype = Setting::get()->first();
      return view('purchases.purchasing',compact('customers','order','listorder','salsetype'));
    }


    public function order_buy(Request $request){
      $pieces       = 0 ;
      $balance      = 0 ;
      $discount    = 0 ;
      $quan         = 0 ;
      $newprice     = '';
      $unit         = '';
      $op_ar        = '';
      $pricebuy     = 0 ;
      $priceq       = 0 ;
      $priceg       = 0 ;
      $user         = Auth::user()->id;
      $no_item      = $this->Increase_Sub_OrderBuy($request->order);  

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

      if($request->unit == 'one'){
        $unit = "قطعة";
        $pieces = $request->quan;
        $quan   = $pieces / $request->pecies;
        $pricebuy = $request->buy_price;
        $priceq   = $request->retailsale_price;
        $priceg   = $request->wholesale_price;
      }else{
        $unit = "كرتونة";
        $quan   = $request->quan;
        $pieces = $request->quan * $request->pecies;
        $pricebuy = $request->buy_price / $request->pecies;
        $priceq   = $request->retailsale_price /  $request->pecies;
        $priceg   = $request->wholesale_price  /  $request->pecies;
      }

      function checksale($item,$price,$saleprice,$pricelist,$pieces)
      {
        $pricelistnew = 0 ;
        $pricenew     = 0 ;
        $salepricenew = 0 ;
        $setting = Setting::first();
        $target = Products::limit(1)->where('code',$item)->select(['saleprice_p','price_p','pricelist_p','total_pieces'])->first();
        if($setting->buysale == 'two'){
          // $pricelistnew = ($pricelist*$pieces);
          // $pricelistnew = ($target->pricelist_p+$pricelist)/($pieces+$target->total_pieces);
          $pricelistnew = (($target->pricelist_p*$target->total_pieces)+($pricelist*$pieces))/($pieces+$target->total_pieces);
        }else{
          $pricelistnew = $pricelist ;
        }
        if($setting->salesale == 'two'){
          // $pricenew     = ($target->price_p+$price)/($pieces+$target->total_pieces);
          $pricenew     = (($target->price_p*$target->total_pieces)+($price*$pieces))/($pieces+$target->total_pieces);
          // $salepricenew = ($target->saleprice_p+$saleprice)/($pieces+$target->total_pieces);
          $salepricenew = (($target->saleprice_p*$target->total_pieces)+($saleprice*$pieces))/($pieces+$target->total_pieces);
        }else{
          $pricenew     = $price;
          $salepricenew = $saleprice;
        }
        return [
          'pricelist'   => round($pricelistnew,2),
          'price'       => round($pricenew,2),
          'saleprice'   => round($salepricenew,2),
        ];
      }

      $newprice = checksale($request->item,$priceg,$priceq,$pricebuy,$pieces);

      // return $newprice['pricelist'];
      function additem ($order,$date,$newprice,$time,$user,$quan,$disc,$customer,$opration,$op_ar,$item,$itemname,$no_item,$unit,$hunit,$hpecies){
        $pricel = 0;
        if($hunit == 'one'){
          $pricel = $newprice['pricelist'];
        }else{
          $pricel = $newprice['pricelist'] * $hpecies;
        }
        if(OrdersBuy::limit(1)->where(['id'=>$order])->count() > 0){
          $orders = OrdersBuy::limit(1)->where(['id'=>$order])
            ->select(['subtotal','discount','total'])
            ->first();
            $neworder = OrdersBuy::limit(1)->where(['id'=>$order])
              ->update([
                'date'     =>$date,
                'time'     =>$time,
                'user'     =>$user,
                'subtotal' =>$orders->subtotal + ((($pricel * $quan)-(($pricel * $quan * $disc)/100))),
                'total'    =>$orders->total + ((($pricel * $quan)-(($pricel * $quan * $disc)/100))),
              ]);
        }else{
          $neworder = OrdersBuy::create([
            'customer' =>$customer,
            'date'     =>$date,
            'time'     =>$time,
            'op'       =>$opration,
            'op_ar'    =>$op_ar,
            'user'     =>$user,
            'subtotal' =>(($pricel * $quan)-(($pricel * $quan * $disc)/100)),
            'total'    =>(($pricel * $quan)-(($pricel * $quan * $disc)/100)),
          ]);
        }
        $details = DetailsOrderBuy::create([
          'order_id'   =>$order,
          'item'       =>$item,
          'item_name'  =>$itemname,
          'no_item'    =>$no_item,
          'unit'       =>$unit,
          'quan'       =>$quan,
          'price'      =>$pricel,
          'total'      =>(($pricel * $quan)-(($pricel * $quan * $disc)/100)),
          'discount'   =>($pricel * $quan * $disc)/100,
          'user'       =>$user,
          'date'       =>$date,
          'time'       =>$time,
        ]);
      }
      function update_product($item,$quan,$pieces,$newprice,$expired){
        $pro_update = Products::with('Expired')->limit(1)->where('code',$item)->first();
        $pro_update->total_pieces += $pieces;
        $pro_update->quan += $quan;
        $pro_update->pricelist_p = $newprice['pricelist'];
        $pro_update->price_p     = $newprice['price'];
        $pro_update->saleprice_p = $newprice['saleprice'];
        $flag = 0;
        if($expired > 0){
          foreach($pro_update->expired as $ex){
            if($ex->date == $expired){
                $up = Expired_Date::limit(1)->where('id',$ex->id)->first();
                $up->quan += $pieces;
                $up->save();
                $flag = 1;
            }
          }
          if($flag == 0){
            $save = Expired_Date::create([
              'product' =>$pro_update->id,
              'date'    =>$expired,
              'quan'    =>$pieces,
            ]);
          }
        }
        $pro_update->save();
      }

      function update_productless($item,$quan,$pieces,$newprice,$expired){
        $pro_update = Products::limit(1)->where('code',$item)->first();
        $pro_update->total_pieces -= $pieces;
        $pro_update->quan -= $quan;
        $pro_update->pricelist_p = $newprice['pricelist'];
        $pro_update->price_p     = $newprice['price'];
        $pro_update->saleprice_p = $newprice['saleprice'];
        $flag = 0;
        if($expired > 0){
          foreach($pro_update->expired as $ex){
            if($ex->date == $expired){
                $up = Expired_Date::limit(1)->where('id',$ex->id)->first();
                $up->quan -= $pieces;
                $up->save();
                $flag = 1;
            }
          }
        }
        $pro_update->save();
      }

      switch($request->opration){
        case 'cash':{
          // Add new Order 
          $item = additem($request->order,$request->date,$newprice,$request->time,$user,$request->quan,$request->disc,$request->customer,$request->opration,$op_ar,$request->item,$request->itemname,$no_item,$unit,$request->unit,$request->pecies);
          /*Update Quantity Product*/
          $product = update_product($request->item,$quan,$pieces,$newprice,$request->expired);
          if($item && $product){
            return response()->json(['status'=>'true']);
          }
        }break;
  
        case 'aggel':{
          if($request->customer > 0)
          {
            $balance  = $request->buy_price * $request->quan;
            $discount = $balance * $request->disc / 100 ;
            $money    = 0;
            // Add new Order 
            $item = additem($request->order,$request->date,$newprice,$request->time,$user,$request->quan,$request->disc,$request->customer,$request->opration,$op_ar,$request->item,$request->itemname,$no_item,$unit,$request->unit,$request->pecies);
            /*Update Quantity Product*/
            $product = update_product($request->item,$quan,$pieces,$newprice,$request->expired);
            $upcustomer = Customer::limit(1)->where(['id'=>$request->customer])->first();
            $chck = $upcustomer->debt - $balance - $discount;
            if($chck > 0)
            {
              $upcustomer->balance = 0;
              $upcustomer->debt = $chck;
            }else{
              $upcustomer->balance += $chck * -1;
              $upcustomer->debt = 0;
            }
            $upcustomer->save();

            if($item && $product && $upcustomer){
              return response()->json(['status'=>'true']);
            }

          }else{
            return response()->json(['customer'=>'يجب تحديد العميل']);
          }
        }break;
        case 'back':{

          // Add new Order 
          $item = additem($request->order,$request->date,$newprice,$request->time,$user,$request->quan,$request->disc,$request->customer,$request->opration,$op_ar,$request->item,$request->itemname,$no_item,$unit,$request->unit,$request->pecies);
          /*Update Quantity Product*/
          $product = update_productless($request->item,$quan,$pieces,$newprice,$request->expired);
          if($item && $product){
            return response()->json(['status'=>'true']);
          }
        }break;
        case 'backofcus':{
          if($request->customer > 0)
          {
            $balance  = $request->buy_price * $request->quan;
            $discount = $balance * $request->disc / 100 ;
            $money    = 0;
            // Add new Order 
            $item = additem($request->order,$request->date,$newprice,$request->time,$user,$request->quan,$request->disc,$request->customer,$request->opration,$op_ar,$request->item,$request->itemname,$no_item,$unit,$request->unit,$request->pecies);
            /*Update Quantity Product*/
            $product = update_product($request->item,$quan,$pieces,$newprice);
            $upcustomer = Customer::limit(1)->where(['id'=>$request->customer])->first();

            $chck = $upcustomer->debt - $balance;
            if($chck > 0)
            {
              $upcustomer->debt = $chck;
              $upcustomer->balance = 0;
            }else{
              $upcustomer->debt = 0;
              $upcustomer->balance += $chck*-1;
            }
            $upcustomer->save();

            if($item && $product && $upcustomer){
              return response()->json(['status'=>'true']);
            }

          }else{
            return response()->json(['customer'=>'يجب تحديد العميل']);
          }
        }
      }
    }


      // Search Order in page Sales
  public function search_order(Request $request){
    $orders = OrdersBuy::limit(1)->with('Details')->where(['id'=>$request->order, 'del'=>'0'])->get();
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
      $update = OrdersBuy::limit(1)->where('id',$request->order)->update([
        'balanc' =>$request->balance,
      ]);
      $customerval = Customer::where(['id'=>$request->customer])->select(['debt'])->first();
      $upcustomer = Customer::where(['id'=>$request->customer])->update([
        'balance'=> $customerval->balance - $request->balance 
      ]);
      if($update){
        return response()->json(['status'=>'true']);
      }
    }else{
      return response()->json(['customer'=>'يجب تحديد العميل']);
    }

  }


    /* Crete Discount in Order  */
    public function order_discount(Request $request){
      $val_discount = 0;
      $total        = 0;
      $profits      = 0;
      $order = OrdersBuy::limit(1)->where('id',$request->order)
        ->select(['subtotal'])
        ->first();
      switch($request->distype){
        case 'Value':{
          $val_discount = $request->discount;
          $total   = $order->subtotal - $request->discount;
          $pro_update = OrdersBuy::limit(1)->where('id',$request->order)
            ->update([
              'discount'     => $request->discount,
              'dis_type'     => $request->distype,
              'val_discount' => $request->discount,
              'total'        => $order->subtotal - $request->discount,
            ]);
  
        }break;
        case 'Ratio':{
          $val_discount =($order->subtotal * $request->discount) / 100;
          $profits = $profits - $val_discount;
  
          $pro_update = OrdersBuy::limit(1)->where('id',$request->order)
            ->update([
              'discount'     => $request->discount,
              'dis_type'     => $request->distype,
              'val_discount' => $val_discount,
              'total'        => $order->subtotal - $val_discount,
            ]);
            $total = $order->subtotal - $val_discount;
  
        }break;
      }
      return ['discount' =>$val_discount , 'total'=>$total ];
    }


  /* Delete ORder */
  public function delete_order(Request $request){
    $user         = Auth::user()->id;
    $order = OrdersBuy::limit(1)->where('id',$request->order)
    ->update([
      'del' => 1,
      'user_del' =>$user,
    ]);
  }
  
  public function del_element(Request $request){

    function productinc($serial , $element)
    {
      $quan         = 0;
      $totalquan    = 0;
      $total_pieces = 0;
      $quan_pieces  = 0;
      $unit         = '';

      $details = DetailsOrderBuy::limit(1)
        ->where(['order_id'=>$serial ,'no_item'=>$element])
        ->select(['item','unit','quan'])->first();

      $product = Products::limit(1)->where('code',$details->item)
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
      $pro_update = Products::limit(1)->where('code',$details->item)
        ->update([
          'total_pieces' => $product->total_pieces - $total_pieces,
          'quan'         => $product->quan - $quan_pieces,
      ]);
    }
    function delitem($serial,$element)
    {
      $user         = Auth::user()->id;
      $newdiscount  = 0 ; 
      $valdisel     = 0 ;
      $newsubtotal  = 0 ;
      $newtotal     = 0 ;
      $backmoney    = 0 ;
      $ratio        = 0 ;
      // Get Order in Delete Element
      $order = OrdersBuy::limit(1)->where('id',$serial)->first();
      
      $details = DetailsOrderBuy::limit(1)
        ->where(['order_id'=>$serial ,'no_item'=>$element])
        ->first();
        
      if($order->dis_type != Null)
      {
        $ratio       = ($order->val_discount/$order->subtotal);
        $valdisel    = $ratio * $details->total;
        $newdiscount = $order->val_discount - $valdisel;
        $newsubtotal = $order->subtotal - $details->total;
        $newtotal    = $newsubtotal - $newdiscount;
        $backmoney   = $details->total - $valdisel;

        switch($order->dis_type){
          case 'Value':{
            $pro_update = OrdersBuy::limit(1)->where('id',$serial)
              ->update([
                'discount'     => $ratio * 100,
                'dis_type'     => "Ratio",
                'val_discount' => $newdiscount,
                'total'        => $newtotal,
                'subtotal'     => $newsubtotal,
              ]);
          }break;
          case 'Ratio':{
            $pro_update = OrdersBuy::limit(1)->where('id',$serial)
              ->update([
                'discount'     => $ratio * 100,
                'val_discount' => $newdiscount,
                'total'        => $newtotal,
                'subtotal'     => $newsubtotal,
              ]);
          }break;
        }
      }else{
        
        $newsubtotal = $order->subtotal - $details->total;
        $newtotal    = $newsubtotal;
        $backmoney   = $details->total;
        $pro_update = OrdersBuy::limit(1)->where('id',$serial)
        ->update([
          'total'        => $newtotal,
          'subtotal'     => $newsubtotal,
        ]);
      }
      $details = DetailsOrderBuy::limit(1)
        ->where(['order_id'=>$serial ,'no_item'=>$element])
        ->delete();
      // Check in last Order 
      if(DetailsOrderBuy::limit(1)->where(['order_id'=>$serial])->count() == 0)
      {
        $del = OrdersBuy::limit(1)->where('id',$order)->update([
          'del'      => 1,
          'user_del' => $user
        ]);
      }
      return $backmoney;
    }

    // return delitem($request->order , $request->element);
    switch($request->opration)
    {
     case 'backofcus':{
        if($request->customer > 0)
        {
          productinc($request->order, $request->element);
          $backmoney = delitem($request->order, $request->element);
          $customerval = Customer::where(['id'=>$request->customer])->select(['balance'])->first();
          $upcustomer = Customer::where(['id'=>$request->customer])->update([
            'balance'=> $customerval->balance - $backmoney 
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
          $customerval = Customer::where(['id'=>$request->customer])->select(['balance'])->first();
          $upcustomer = Customer::where(['id'=>$request->customer])->update([
            'balance'=> $customerval->balance - $backmoney 
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
}
