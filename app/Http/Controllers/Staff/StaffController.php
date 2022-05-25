<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jobs;
use App\Models\Employees;
use App\Http\Requests\StaffRequest;
use App\Models\Transactions;
use App\Models\Atendance;

class StaffController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }
  public function view_staff()
  {
    date_default_timezone_set('Africa/Cairo');
    $date = date('Y-m-d');

    $employees = Employees::with(['Jobs'])->paginate(10);
    $employees_list = Employees::select(['id','employee'])->get();
    $Atendance = Employees::with(['Atendance'=>function($q)use($date) {
      $q->where('date',$date);
    }])->paginate(10);
    $jobs = jobs::get()->all();
    return view('employee.staff',compact('Atendance','jobs','employees','employees_list'));
  }

  public function save_staff(StaffRequest $request){
    $data = Employees::create([
      'employee'    => $request->employee_name,
      'salary'      => $request->salary_number,
      'job'         => $request->type_work,
      'day'         => $request->dayes_of_work,
      'hours'       => $request->hours_of_work,
      'date_hiring' => $request->inauguration_date,
      'vacation'    => $request->holidays_number,
    ]);
    if($data){
      return response()->json(['status'=>'true']);
    }
  }
  
  public function update_staff(Request $request){
    $data = Employees::limit(1)
      ->where('id',$request->serial)
      ->update([
        'employee'    => $request->employee_name,
        'salary'      => $request->salary_number,
        'job'         => $request->type_work,
        'day'         => $request->dayes_of_work,
        'hours'       => $request->hours_of_work,
        'date_hiring' => $request->inauguration_date,
        'vacation'    => $request->holidays_number,
      ]);
    if($data){
      return response()->json(['status'=>'true']);
    }
  }


  public function delete_staff(Request $request){
    $data = Employees::limit(1)->where(['id'=>$request->serial])
      ->delete();
    if($data)
    {
      return response()->json($data);
    }
  }


  public function search_staff(Request $request)
  {
    $data = Employees::with('Jobs')->where('employee', 'LIKE', '%' . $request->text . "%")->get();
    if($data)
    {
      return response()->json($data);
    }
  }

  public function staff_payment(Request $request){
    $data = Transactions::create([
      'employee' =>$request->employee,
      'op'       =>$request->op,
      'op_name'  =>$request->op_name,
      'val'      =>$request->val,
      'note'     =>$request->text,
      'date'     =>$request->date,
    ]);
    if($data)
    {
      return response()->json(['status'=>'true']);
    }
  }

  public function change_select(Request $request)
  {
    $employees = Employees::with(['Atendance'=>function($q)use($request) {
          $q->where('date',$request->dateDIv);
    }])
        ->where(['job'=>$request->job])
        ->get();
      return $employees;
  }

  public function absence_employee(Request $request){
    if($request->operation == "leave")
    {
      foreach($request->employeeArray as $emp){
        $data = Atendance::where(['employee'=>$emp['id'],'date'=>$emp['date']])
          ->update([
            'leave' =>$emp['time'],
          ]);
      }
    }else{
      foreach($request->employeeArray as $emp){
        $data = Atendance::create([
          'employee' =>$emp['id'],
          'presence' =>$emp['time'],
          'date'     =>$emp['date'],
        ]);
      }
    }

    if($data)
    {
      return response()->json(['status'=>'true']);
    }
  }
}
