<?php

namespace App\Http\Controllers\ReportsController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expenses;
use App\Models\Spending;

class ExpenseController extends Controller
{
    

    public function Expense_Report_view(){
        $expenses = Expenses::get();
        return view('Reports.Expense',compact('expenses')); 
    }

    public function Expense_Report(Request $request){
        $data = [];
        switch($request->type)
        {
            case '':{
                $data = Spending::with(['users','Expenses'])
                ->where(['date'=>$request->date])
                ->orderBy('id', 'desc')
                ->get();
            }break;
            case 'customer':{
                if($request->date_from == 0 || $request->date_to == 0){
                    $data = Spending::with(['users','Expenses'])
                    ->where('expense',$request->customer)
                    ->orderBy('id', 'desc')
                    ->get();
                }else{
                    $data = Spending::with(['users','Expenses'])
                        ->where('expense',$request->customer)
                        ->whereBetween('date', array($request->date_from, $request->date_to))
                        ->orderBy('id', 'desc')
                        ->get();
                }
            }break;
            case 'id':{
                $data = Spending::with(['users','Expenses'])
                ->where('id',$request->text)
                ->orderBy('id', 'desc')
                ->get();
            }break;
            case 'all':{
                if($request->date_from == 0 || $request->date_to == 0){
                    $data = Spending::with(['users','Expenses'])
                        ->orderBy('id', 'desc')
                        ->get();
                }else{
                    $data = Spending::with(['users','Expenses'])
                        ->whereBetween('date', array($request->date_from, $request->date_to))
                        ->orderBy('id', 'desc')
                        ->get();
                }
            }break;
        }
        return $data;
    }
}
