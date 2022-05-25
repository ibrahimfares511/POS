<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supply;
use App\Models\Spending;
use App\Models\Orders;
use App\Models\OrdersBuy;
use App\Models\Exchange;
use App\Traits\All_Functions;



class HomeController extends Controller
{
    use All_Functions;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = $this->FilterDay(); 
        return view('home',compact('data'));
    }
    public function change_op(Request $request){
        date_default_timezone_set('Africa/Cairo');
        $date = date('Y-m-d');
        $lastWeek  = date("Y-m-d", strtotime("-7 days"));
        $lastday   = date("Y-m-d", strtotime("-1 days"));
        $lastmonth = date("Y-m-d", strtotime("-30 days"));
        $lasyear   = date("Y-m-d", strtotime("-365 days"));
        switch($request->job){
            case 'Today':{
                return $this->FilterDay();                  
            }break;
            case 'Yesterday':{
                return $this->FilterPeriod($lastday,$lastday);  
            }break;
            case 'Last_Month':{  
                return $this->FilterPeriod($lastmonth,$date);  
            }break;
            case 'Last_Week':{
                return $this->FilterPeriod($lastWeek,$date);  
            }break;
            case 'Last_Year':{
                return $this->FilterPeriod($lasyear,$date);  
            }break;
            case 'All':{
                return $this->FilterAllDay();
            }break;
        }
    }
}
