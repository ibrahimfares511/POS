<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Products;
use App\Models\DetailsOrderBuy;
use App\Models\Category;
use Picqer;

class SettingController extends Controller
{
      public function __construct()
    {
      $this->middleware('auth');
    }
    public function view_add_job()
    {
      return view('setting.add_job');
    }

    /* ------------------------ Barcode Page ------------------------ */
    public function view_barcode()
    {
      $Products = Products::select(['name','code','price_p'])->get()->all();
      $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
      $categories = Category::select(['id','name'])->get()->all();

      foreach($Products as $update){
        $barcode =  $generator->getBarcode($update->code, $generator::TYPE_CODE_128);
        $update->code = $barcode;
      }
      return view('setting.barcode',compact('Products','categories'));
    }
    public function search_get_barcode(Request $request){
      $Products = [];
      $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
      switch($request->type)
      {
        case '':{
          $Products = Products::select(['name','code','price_p'])->get()->all();
        }break;
        case 'all':{
          $Products = Products::select(['name','code','price_p'])->get()->all();
        }break;
        case 'id':{
          $Products = Products::limit(1)->where('code',$request->text)->select(['name','code','price_p'])->get();
        }break;
        case 'customer':{
          $Products = Products::where('category_id',$request->customer)->select(['name','code','price_p'])->get();
        }break;
        case 'pruduct':{
          $Products = Products::where('name','LIKE','%' . $request->text . '%')->select(['name','code','price_p'])->get();
        }break;
        case 'buy':{
          $count = 0;
          $buy = DetailsOrderBuy::select('item')->where('order_id',$request->text)->get();
          foreach($buy as $element){
            $Products[$count] = Products::limit(1)->where('code',$element->item)->select(['name','code','price_p'])->first();
            if($Products[$count] != null){
              $count++;
            }
          }
        }break;
      }
      if($Products){
        foreach($Products as $update){
          $barcode =  $generator->getBarcode($update->code, $generator::TYPE_CODE_128);
          $update->code = $barcode;
        }
        return $Products;
      }
    }
    /* -------------------- End Barcode Page --------------------- */
    public function view_setting()
    {
      $setting = Setting::get()->first();
      return view('setting.setting',compact(['setting']));
    }
  
    public function view_add_branch()
    {
      return view('setting.branch');
    }

    public function view_add_contact()
    {
      return view('contact.contact');
    }

    /* Save Setting in Pos */
    public function save_setting(Request $request){
        $check = Setting::get()->first();
        if($check){
          $data = Setting::where('id',$check->id)->update([
            'salestype'   =>$request->saletype,
            'buyopration' =>$request->buyopration,
            'buysale'     =>$request->buysale,
            'salesale'     =>$request->salesale,
          ]);
        }else{
          $data = Setting::create([
            'salestype'   =>$request->saletype,
            'buyopration' =>$request->buyopration,
            'buysale'     =>$request->buysale,
            'salesale'     =>$request->salesale,
          ]);
        }
        if($data){
          return response()->json(['status'=>'true']);
        }
    }
}
