<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category_Request;
use App\Http\Requests\DamagedRequest;
use App\Http\Requests\Product_Request;
use App\Http\Requests\Unit_Request;
use App\Models\Category;
use App\Models\damaged;
use App\Models\Products;
use App\Models\Expired_Date;
use App\Models\Units;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }
  /*##########################################################################################
  ####################################### products ############################################
  ############################################################################################*/
  /*====================== Start View Product page ======================================*/
  public function view_products(Request $request)
  {
      $units        = Units::where('status',1)->get();
      $categories   = Category::where('status',1)->get();
      $products     = Products::with(['category','unit'])->paginate(10);
      $new_serial   = Products::max('id');
      $new_serial++;
      return view('products.product',compact('units','categories','products','new_serial'));
  }

  /*====================== Start Save Product  ======================================*/
  public function save_product(Product_Request $request)
  {
    if(empty($request->code))
    {
      $request->code = $request->serial;
    }
    $save = Products::create([
        'name' =>$request->name,
        'code'=>$request->code,
        'unit_id'=>$request->unit_id,
        'category_id'=>$request->category_id,
        'quan'=>$request->quan,
        'pieces'=>$request->pieces,
        'total_pieces'=>$request->total_pieces,
        'saleprice_p'=>$request->saleprice_p,
        'price_p'=>$request->price_p,
        'pricelist_p'=>$request->pricelist_p,
        'min_quantity'=>$request->min_quantity,
    ]);
    $cat = Category::limit(1)->where('id',$request->category_id)->select(['items'])->first();
    $up  = Category::limit(1)->where('id',$request->category_id)->update(['items'=>$cat->items + 1]);
    if($request->expired >0){
        $expired_date = Expired_Date::create([
          'product' =>$save->id,
          'date'    =>$request->expired,
          'quan'    =>$request->total_pieces
        ]);
    }
    if($save){
      return response()->json(['status'=>'true']);
    }
  }


  /*====================== Start Update Product  ======================================*/
  public function update_product(Request $request)
  {
    $check = $save = Products::where('id',$request->serial)->limit(1)->first();
    $cat = Category::limit(1)->where('id',$check->category_id)->select(['items'])->first();
    $up  = Category::limit(1)->where('id',$check->category_id)->update(['items'=>$cat->items - 1]);
    $save = Products::where('id',$request->serial)->limit(1)->update([
      'name' =>$request->name,
      'code'=>$request->code,
      'unit_id'=>$request->unit_id,
      'category_id'=>$request->category_id,
      'quan'=>$request->quan,
      'pieces'=>$request->pieces,
      'total_pieces'=>$request->total_pieces,
      'saleprice_p'=>$request->saleprice_p,
      'price_p'=>$request->price_p,
      'pricelist_p'=>$request->pricelist_p,
      'min_quantity'=>$request->min_quantity,
    ]);
    $cat = Category::limit(1)->where('id',$request->category_id)->select(['items'])->first();
    $up  = Category::limit(1)->where('id',$request->category_id)->update(['items'=>$cat->items + 1]);
    if($save){
      return response()->json(['status'=>'true']);
    }
  }

  /*====================== Start Active Product  ======================================*/
  public function active_product(Request  $request)
  {
    $data = Products::where('id',$request->serial)->limit(1)->update([
      'status' => $request->active
    ]);
  }


  /*====================== Start Change sale Product  ======================================*/
  public function changesale_product(Request $request){
    $type = 0;
    
    if($request->type == 'increase'){
      $type = 1;
    }elseif($request->type == 'decrease'){
      $type = -1;
    }
    if($request->cate == 'all')
    {
      $products = Products::get()->all();

    }else{
      $products = Products::where('category_id',$request->cate)->get();
    }
    switch($request->priceType){
      case 'all':{
        foreach($products as $product){
          $ratio = ($product->saleprice_p * $request->inputVal)/100;
          $ratio = $ratio * $type;
          $data = Products::where('id',$product->id)
          ->update([
            'saleprice_p'=>$product->saleprice_p + $ratio,
            'price_p'=>$product->price_p + ((($product->price_p * $request->inputVal)/100)*$type),
            'pricelist_p'=>$product->pricelist_p + ((($product->pricelist_p * $request->inputVal)/100)*$type),
          ]);
        }
      }break;
      case '1':{
        foreach($products as $product){
          $ratio = ($product->saleprice_p * $request->inputVal)/100;
          $ratio = $ratio * $type;
          $data = Products::where('id',$product->id)
          ->update([
            'saleprice_p'=>$product->saleprice_p + $ratio,
          ]);
        }
      }break;
      case '2':{
        foreach($products as $product){
          $ratio = ($product->saleprice_p * $request->inputVal)/100;
          $ratio = $ratio * $type;
          $data = Products::where('id',$product->id)
          ->update([
            'price_p'=>$product->price_p + ((($product->price_p * $request->inputVal)/100)*$type),
          ]);
        }
      }break;
      case '3':{
        foreach($products as $product){
          $ratio = ($product->saleprice_p * $request->inputVal)/100;
          $ratio = $ratio * $type;
          $data = Products::where('id',$product->id)
          ->update([
            'pricelist_p'=>$product->pricelist_p + ((($product->pricelist_p * $request->inputVal)/100)*$type),
          ]);
        }
      }break;
    }
    if($data){
      return response()->json(['status'=>'true']);
    }
  }


  /*====================== Start Halk Product  ============================================*/
  public function damaged_product(DamagedRequest $request)
  {
      $product = Products::limit(1)->where('code',$request->d_barcode)
          ->select(['category_id','unit_id','quan','total_pieces','pieces'])->first();
      if($product->total_pieces >= $request->d_item_pieces)
      {
        if(damaged::limit(1)->where('code',$request->d_barcode)->get()->count() > 0)
        {
          $data = damaged::limit(1)->where('code',$request->d_barcode)->first();
          $rec = damaged::limit(1)->where('code',$request->d_barcode)
            ->update([
              'quan'        =>$data->quan + ($request->d_items_pieces / $product->pieces),
              'pieces'      =>$product->pieces,
              'total_pieces'=>$data->total_pieces + $request->d_item_pieces,
              'saleprice_p' =>$request->d_wholesale_price_piece,
              'price_p'     =>$request->d_retail_price_piece,
              'pricelist_p' =>$request->d_buy_price_piece,
              'status'      =>1,
              'category_id' =>$product->category_id,
              'unit_id'     =>$product->unit_id,
            ]);
        }else{
          $rec  = damaged::create([
            'name'        =>$request->d_product_name,
            'code'        =>$request->d_barcode,
            'quan'        =>$request->d_items_pieces / $product->pieces,
            'pieces'      =>$product->pieces,
            'total_pieces'=>$request->d_item_pieces,
            'saleprice_p' =>$request->d_wholesale_price_piece,
            'price_p'     =>$request->d_retail_price_piece,
            'pricelist_p' =>$request->d_buy_price_piece,
            'status'      =>1,
            'category_id' =>$product->category_id,
            'unit_id'     =>$product->unit_id,
          ]);
        }
        if($rec){
          $save = Products::where('code',$request->d_barcode)->limit(1)->update([
            'quan'=>$product->quan -($request->d_items_pieces / $product->pieces),
            'total_pieces'=>$product->total_pieces - ($request->d_item_quant * $request->d_item_pieces),
          ]);
          return response()->json(['status'=>'true']);
        }
      }else{
        return response()->json(['status'=>'false']);
      }


  }


  /*====================== Start search product  ===========================================*/
  public function search_product(Request $request){
    $data = [];
    switch($request->type){
      case 'id':{
        $data = Products::limit(1)->with('category')->where('code',$request->search)->get();
      }break;
      case 'name':{
        $data = Products::with('category')->where('name', 'LIKE', '%' . $request->search . "%")->get();
      }break;
      case 'cat':{
        $cat = Category::where('name', 'LIKE', '%' . $request->search . "%")
            ->select(['id'])->get();
        foreach($cat as $c){
          $new = Products::with('category')->where('category_id',$c->id)->get();
          foreach($new as $n){
            if(!empty($new)){
              array_push($data ,$n);
            }
          }
        }
      }break;
      case 'halk':{
        $data = damaged::with('category')->where('name', 'LIKE', '%' . $request->search . "%")->get();
      }break;
      case 'quan':{
        $data = Products::with('category')->where('quan',$request->search)->get();
      }break;
      case 'all':{
        $data = Products::with('category')->get();

      }break;
    }
    if($data)
    {
      return response()->json($data);
    }
  }


  /*##########################################################################################
  ################################### Category ###############################################
  ############################################################################################*/
  /*====================== Start view Category  ===========================================*/
  public function view_Category(Request $request)
  {
    $categories = Category::paginate(10);
    $count = 0;
    $new_serial = Category::max('id');
    $new_serial++;
    return view('products.category',compact('categories','new_serial'));
  }


  /*====================== Start Save Category  ===========================================*/
  public function save_category(Category_Request $request)
  {
    $save = Category::create([
      'name' => $request->category,
    ]);
    if($save){
      return response()->json(['status'=>'true']);
    }
  }


  /*====================== Start Update Category  ===========================================*/
  public function update_category(Category_Request $request)
  {
    $save = Category::where('id',$request->serial)->limit(1)->update([
      'name' => $request->category,
    ]);
    if($save){
      return response()->json(['status'=>'true']);
    }
  }


  /*====================== Start Delete Category  ===========================================*/
  public function delete_category(Request $request)
  {
    $save = Category::where('id',$request->serial)->limit(1)->delete();
    $new_serial = Category::max('id');
    $new_serial ++;
    if($save){
      return response()->json(['status'=>'true','serial'=>$new_serial]);
    }
  }


  /*====================== Start Search Category  ===========================================*/
  public function search_category(Request $request)
  {
    $data = Category::where('name', 'LIKE', '%' . $request->text . "%")->get();
    if($data)
    {
      return response()->json($data);
    }
  }


  /*====================== Start Active Category  ===========================================*/
  public function active_category(Request  $request)
  {
    $data = Category::where('id',$request->serial)->limit(1)->update([
      'status' => $request->active
    ]);
  }


  /*##########################################################################################
  ################################### Units ##################################################
  ############################################################################################*/
  /*====================== Start View Unit  ===========================================*/
  public function view_unit(Request $request)
  {
      $units     = Units::paginate(10);
      $new_serial = Units::max('id');
      $new_serial++;
      return view('products.units',compact('units','new_serial'));
  }


  /*====================== Start Save Unit  ===========================================*/
  public function save_unit(Unit_Request $request)
  {
      $save = Units::create([
        'name' => $request->unit,
      ]);
      if($save){
        return response()->json(['status'=>'true']);
      }
  }

  /*====================== Start Update Unit  ===========================================*/
  public function update_unit(Unit_Request $request)
  {
    $save = Units::where('id',$request->serial)->limit(1)->update([
      'name' => $request->unit,
    ]);
    if($save){
      return response()->json(['status'=>'true']);
    }
  }


  /*====================== Start Delete Unit  ===========================================*/
  public function delete_unit(Request $request)
  {
    $save = Units::where('id',$request->serial)->limit(1)->delete();
    $new_serial = Units::max('id');
    $new_serial ++;
    if($save){
      return response()->json(['status'=>'true','serial'=>$new_serial]);
    }
  }


  /*====================== Start Search Unit  ===========================================*/
  public function search_unit(Request $request)
  {
      $data = Units::where('name', 'LIKE', '%' . $request->text . "%")->get();
      if($data)
      {
        return response()->json($data);
      }
  }

  /*====================== Start Active Unit  ===========================================*/
  public function active_unit(Request  $request)
  {
    $data = Units::where('id',$request->serial)->limit(1)->update([
      'status' => $request->active
    ]);
  }

}
