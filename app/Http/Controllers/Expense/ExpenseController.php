<?php

namespace App\Http\Controllers\Expense;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expenses;
use App\Models\Spending;
use App\Http\Requests\ExpensesRequest;
use App\Http\Requests\SpendingRequest;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function __Construct()
    {
      $this->middleware('auth');
    }
    public function view_expense()
    {
      date_default_timezone_set('Africa/Cairo');
      $date = date('Y-m-d');
      $new_serial   = Spending::max('id');
      $new_serial++;
      $expense = Expenses::get()->all();
      $Spending = Spending::with('Expenses')->where('date',$date)->paginate(10);
      
      return view('Expense.expense',compact('new_serial','expense','Spending'));
    }


    public function save_expense(ExpensesRequest $request){
      $data = Expenses::create([
        'name'=>$request->new_expense
      ]);
      if($data){
        return response()->json(['status'=>'true']);
      }
    }

    public function delte_expense(Request $request){
      $check = Expenses::where('name',$request->expens)->select('id')->first();
      if(Spending::where('expense',$check->id)->count() > 0)
      {
        return response()->json(['status'=>'false']);
      }else{
        $data = Expenses::where('id',$check->id)->delete();
        if($data){
          return response()->json(['status'=>'true']);
        }
      }
    }

    public function save_new_expense(SpendingRequest $request){
      $user = Auth::user()->id;
      $id = 0;
      if(is_numeric($request->expense_name))
      {
        $id = $request->expense_name;
      }else{
        $check = Expenses::where('name',$request->expense_name)->select('id')->first();
        $id= $check->id;
      }
      $data = Spending::create([
        'expense'=>$id,
        'value'  =>$request->expense_money,
        'note'   =>$request->expense_note,
        'date'   =>$request->expense_date,
        'user'   =>$user
      ]);
      if($data){
        return response()->json(['status'=>'true']);
      }
    }

    public function update_new_expense(SpendingRequest $request){
      $user = Auth::user()->id;
      $id = 0;
      if(is_numeric($request->expense_name))
      {
        $id = $request->expense_name;
      }else{
        $check = Expenses::where('name',$request->expense_name)->select('id')->first();
        $id= $check->id;
      }
      $data = Spending::where('id', $request->serial)->update([
        'expense'=>$id,
        'value'  =>$request->expense_money,
        'note'   =>$request->expense_note,
        'date'   =>$request->expense_date,
        'user'   =>$user
      ]);
      if($data){
        return response()->json(['status'=>'true']);
      }
    }

    public function delete_sprending(Request $request){
      $data = Spending::where('id', $request->serial)->delete();
      if($data){
        return response()->json(['status'=>'true']);
      }
    }

    public function search_spending(Request $request){
      $data = [];
      switch($request->type){
        case 'id':{
          $data = Spending::limit(1)->with('Expenses')->where('id',$request->search)->get();
        }break;
        case 'price':{
          $data = Spending::with('Expenses')->where('value', $request->search)->get();
        }break;
        case 'name':{
          $cat = Expenses::where('name', 'LIKE', '%' . $request->search . "%")
              ->select(['id'])->get();
          foreach($cat as $c){
            $new = Spending::with('Expenses')->where('expense',$c->id)->get();
            foreach($new as $n){
              if(!empty($new)){
                array_push($data ,$n);
              }
            }
          }
        }break;
        case 'date':{
          $data = Spending::with('Expenses')->whereBetween('date',[$request->from, $request->to])->get();
        }break;
        case 'all':{
          $data = Spending::with('Expenses')->get();
        }break;
      }
      if($data)
      {
        return response()->json($data);
      }
    }
}
