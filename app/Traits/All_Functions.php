<?php
namespace App\Traits;
use App\Models\Supply;
use App\Models\Spending;
use App\Models\Orders;
use App\Models\OrdersBuy;
use App\Models\Exchange;
Trait All_Functions
{
    /* create Serial in item order */
    function Increase_Sub_Order($serial)
    {
        $new_sub_num_order = 0;
        if(\App\Models\DetailsOrder::where('order_id',$serial)->limit(1)->count() > 0)
        {
          $new_sub_num_order = \App\Models\DetailsOrder::where('order_id',$serial)->max('no_item');
          $new_sub_num_order ++;
        }else{
          $new_sub_num_order ++;
        }
        return $new_sub_num_order ;
    }
    function Increase_Sub_OrderBuy($serial)
    {
        $new_sub_num_order = 0;
        if(\App\Models\DetailsOrderBuy::where('order_id',$serial)->limit(1)->count() > 0)
        {
          $new_sub_num_order = \App\Models\DetailsOrderBuy::where('order_id',$serial)->max('no_item');
          $new_sub_num_order ++;
        }else{
          $new_sub_num_order ++;
        }
        return $new_sub_num_order ;
    }

    function FilterDay(){
      date_default_timezone_set('Africa/Cairo');
      $date = date('Y-m-d');
      $supply    = 0;
      $buy       = 0;
      $buy_aggel = 0;
      $buy_back  = 0;
      $buy_backacc = 0;
      $exchange  = 0;
      $msrofat   = 0;
      $Spending  = 0;
      $total     = 0;
      $foateer   = 0;
      $sales     = 0;
      $agel      = 0;
      $back      = 0;
      $backofcus      = 0;
      $balanc_aggel = 0;

      $allsup = Supply::where(['date'=>$date])->select(['val'])->get();
      foreach($allsup as $sup){
          $supply   = $supply + $sup->val ;
      } 
      $allexchange = Exchange::where(['date'=>$date])->select(['val'])->get();
      foreach($allexchange as $ex){
          $exchange   = $exchange + $ex->val ;
      } 
      $allexpense = Spending::where(['date'=>$date])->select(['value'])->get();
      foreach($allexpense as $ex){
          $Spending   = $Spending + $ex->value ;
      }

      // ############ Sales ########################
      $allsales = Orders::where(['date'=>$date , 'op'=>'cash'])->select(['total','balanc'])->get();
      foreach($allsales as $sa){
          $sales += ($sa->total - $sa->balanc);
      }

      $allback = Orders::where(['date'=>$date , 'op'=>'back'])->select(['total'])->get();
      foreach($allback as $ba){
          $back += $ba->total;
      }

      $allbackofcus = Orders::where(['date'=>$date , 'op'=>'backofcus'])->select(['total'])->get();
      foreach($allbackofcus as $ba){
          $backofcus += $ba->total;
      }

      $allagel = Orders::where(['date'=>$date , 'op'=>'aggel'])->select(['total','balanc','val_discount'])->get();
      foreach($allagel as $ag){
          $agel += ($ag->total - $ag->balanc);
          $sales += $ag->balanc;
      }

      $foateer = Orders::where(['date'=>$date])->count();
      // ########### End Sales ############# 

      // ############### Buy ###################
      $allbuy = OrdersBuy::where(['date'=>$date , 'op'=>'cash'])->select(['total','balanc'])->get();
      foreach($allbuy as $by){
          $buy += ($by->total - $by->balanc);
      }
      $buyagel = OrdersBuy::where(['date'=>$date , 'op'=>'aggel'])->select(['total','balanc','val_discount'])->get();
      foreach($buyagel as $ag){
          $buy_aggel += ($ag->total - $ag->balanc);
          $buy       += $ag->balanc;
      }

      $buyback = OrdersBuy::where(['date'=>$date , 'op'=>'back'])->select(['total'])->get();
      foreach($buyback as $ba){
          $buy_back += $ba->total;
      }

      $buybackofcus = OrdersBuy::where(['date'=>$date , 'op'=>'backofcus'])->select(['total'])->get();
      foreach($buybackofcus as $ba){
          $buy_backacc += $ba->total;
      }
      $foateer_buy = OrdersBuy::where(['date'=>$date])->count();

      $total = $sales + $buy_back +  $supply - $Spending - $exchange - $backofcus - $buy;
      // ############ END BUY ############
      return 
        [
          'foateer_buy'=>$foateer_buy,
          'buy'=>$buy,
          'buy_aggel'=>$buy_aggel,
          'buy_back'=>$buy_back,
          'buy_backacc'=>$buy_backacc,
          'backofcus'=>$backofcus,
          'back'=>$back,
          'sales'=>$sales,
          'supply'=>$supply,
          'exchange'=>$exchange,
          'Spending'=>$Spending,
          'total'=>$total,
          'foateer'=>$foateer,
          'agel'=>$agel
        ];
    }
    function FilterAllDay(){
      date_default_timezone_set('Africa/Cairo');
      $date = date('Y-m-d');
      $supply    = 0;
      $buy       = 0;
      $buy_aggel = 0;
      $buy_back  = 0;
      $buy_backacc = 0;
      $exchange  = 0;
      $msrofat   = 0;
      $Spending  = 0;
      $total     = 0;
      $foateer   = 0;
      $sales     = 0;
      $agel      = 0;
      $back      = 0;
      $backofcus      = 0;
      $balanc_aggel = 0;

      $allsup = Supply::select(['val'])->get();
      foreach($allsup as $sup){
          $supply   = $supply + $sup->val ;
      } 
      $allexchange = Exchange::select(['val'])->get();
      foreach($allexchange as $ex){
          $exchange   = $exchange + $ex->val ;
      } 
      $allexpense = Spending::select(['value'])->get();
      foreach($allexpense as $ex){
          $Spending   = $Spending + $ex->value ;
      }

      // ############ Sales ########################
      $allsales = Orders::where(['op'=>'cash'])->select(['total','balanc'])->get();
      foreach($allsales as $sa){
          $sales += ($sa->total - $sa->balanc);
      }

      $allback = Orders::where(['op'=>'back'])->select(['total'])->get();
      foreach($allback as $ba){
          $back += $ba->total;
      }

      $allbackofcus = Orders::where(['op'=>'backofcus'])->select(['total'])->get();
      foreach($allbackofcus as $ba){
          $backofcus += $ba->total;
      }

      $allagel = Orders::where(['op'=>'aggel'])->select(['total','balanc','val_discount'])->get();
      foreach($allagel as $ag){
          $agel += ($ag->total - $ag->balanc);
          $sales += $ag->balanc;
      }

      $foateer = Orders::count();
      // ########### End Sales ############# 

      // ############### Buy ###################
      $allbuy = OrdersBuy::where(['op'=>'cash'])->select(['total','balanc'])->get();
      foreach($allbuy as $by){
          $buy += ($by->total - $by->balanc);
      }
      $buyagel = OrdersBuy::where(['op'=>'aggel'])->select(['total','balanc','val_discount'])->get();
      foreach($buyagel as $ag){
          $buy_aggel += ($ag->total - $ag->balanc);
          $buy       += $ag->balanc;
      }

      $buyback = OrdersBuy::where(['op'=>'back'])->select(['total'])->get();
      foreach($buyback as $ba){
          $buy_back += $ba->total;
      }

      $buybackofcus = OrdersBuy::where(['op'=>'backofcus'])->select(['total'])->get();
      foreach($buybackofcus as $ba){
          $buy_backacc += $ba->total;
      }
      $foateer_buy = OrdersBuy::count();

      $total = $sales + $buy_back +  $supply - $Spending - $exchange - $backofcus - $buy;
      // ############ END BUY ############
      return 
        [
          'foateer_buy'=>$foateer_buy,
          'buy'=>$buy,
          'buy_aggel'=>$buy_aggel,
          'buy_back'=>$buy_back,
          'buy_backacc'=>$buy_backacc,
          'backofcus'=>$backofcus,
          'back'=>$back,
          'sales'=>$sales,
          'supply'=>$supply,
          'exchange'=>$exchange,
          'Spending'=>$Spending,
          'total'=>$total,
          'foateer'=>$foateer,
          'agel'=>$agel
        ];
    }
    function FilterPeriod($from , $to){
      date_default_timezone_set('Africa/Cairo');
      $date = date('Y-m-d');
      $supply    = 0;
      $buy       = 0;
      $buy_aggel = 0;
      $buy_back  = 0;
      $buy_backacc = 0;
      $exchange  = 0;
      $msrofat   = 0;
      $Spending  = 0;
      $total     = 0;
      $foateer   = 0;
      $sales     = 0;
      $agel      = 0;
      $back      = 0;
      $backofcus      = 0;
      $balanc_aggel = 0;
      
      $allsup = Supply::whereBetween('date', array($from, $to))->select(['val'])->get();
      foreach($allsup as $sup){
          $supply   = $supply + $sup->val ;
      } 
      $allexchange = Exchange::whereBetween('date', array($from, $to))->select(['val'])->get();
      foreach($allexchange as $ex){
          $exchange   = $exchange + $ex->val ;
      } 
      $allexpense = Spending::whereBetween('date', array($from, $to))->select(['value'])->get();
      foreach($allexpense as $ex){
          $Spending   = $Spending + $ex->value ;
      }

      // ############ Sales ########################
      $allsales = Orders::whereBetween('date', array($from, $to))->where(['op'=>'cash'])->select(['total','balanc'])->get();
      foreach($allsales as $sa){
          $sales += ($sa->total - $sa->balanc);
      }

      $allback = Orders::whereBetween('date', array($from, $to))->where(['op'=>'back'])->select(['total'])->get();
      foreach($allback as $ba){
          $back += $ba->total;
      }

      $allbackofcus = Orders::whereBetween('date', array($from, $to))->where(['op'=>'backofcus'])->select(['total'])->get();
      foreach($allbackofcus as $ba){
          $backofcus += $ba->total;
      }

      $allagel = Orders::whereBetween('date', array($from, $to))->where(['op'=>'aggel'])->select(['total','balanc','val_discount'])->get();
      foreach($allagel as $ag){
          $agel += ($ag->total - $ag->balanc);
          $sales += $ag->balanc;
      }

      $foateer = Orders::whereBetween('date', array($from, $to))->count();
      // ########### End Sales ############# 

      // ############### Buy ###################
      $allbuy = OrdersBuy::whereBetween('date', array($from, $to))->where(['op'=>'cash'])->select(['total','balanc'])->get();
      foreach($allbuy as $by){
          $buy += ($by->total - $by->balanc);
      }
      $buyagel = OrdersBuy::whereBetween('date', array($from, $to))->where(['op'=>'aggel'])->select(['total','balanc','val_discount'])->get();
      foreach($buyagel as $ag){
          $buy_aggel += ($ag->total - $ag->balanc);
          $buy       += $ag->balanc;
      }

      $buyback = OrdersBuy::whereBetween('date', array($from, $to))->where(['op'=>'back'])->select(['total'])->get();
      foreach($buyback as $ba){
          $buy_back += $ba->total;
      }

      $buybackofcus = OrdersBuy::whereBetween('date', array($from, $to))->where(['op'=>'backofcus'])->select(['total'])->get();
      foreach($buybackofcus as $ba){
          $buy_backacc += $ba->total;
      }
      $foateer_buy = OrdersBuy::whereBetween('date', array($from, $to))->count();

      $total = $sales + $buy_back +  $supply - $Spending - $exchange - $backofcus - $buy;
      // ############ END BUY ############
      return 
        [
          'foateer_buy'=>$foateer_buy,
          'buy'=>$buy,
          'buy_aggel'=>$buy_aggel,
          'buy_back'=>$buy_back,
          'buy_backacc'=>$buy_backacc,
          'backofcus'=>$backofcus,
          'back'=>$back,
          'sales'=>$sales,
          'supply'=>$supply,
          'exchange'=>$exchange,
          'Spending'=>$Spending,
          'total'=>$total,
          'foateer'=>$foateer,
          'agel'=>$agel
        ];
    }
}