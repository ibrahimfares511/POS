@php
$title = 'الموظفين';
@endphp
@extends('layouts.app')

@section('content')
  <div id="wrapper" class='toggled-2'>
    @include('includes.sidebar')
    <div id="page-content-wrapper">
      <main class="py-4">
        <section>
          <div class="container">
            <div class="page-title">
              <h2> الموظفين </h2>
              <div class="title-buttons">
                @can('الحضور والانصراف')
                <button class="btn btn-primary"  data-toggle="modal" data-target="#attending-leaving-modal">
                  <i class="far fa-plus-square"></i>
                  <span>الحضور والانصراف</span>
                </button>
                @endcan
                @can('إضافة موظف')
                <button class="btn btn-success"  data-toggle="modal" data-target="#add-employee-modal">
                  <i class="far fa-plus-square"></i>
                  <span>أضافة موظف</span>
                </button>
                @endcan
              </div>
            </div>
            <div class="portlet mb-3">
              @can('بحث عن موظق')
              <form class='products-search'>
                <div class="row">
                  <div class="col-sm-8">
                    <div class="main-input input-group">
                      <input type="text" class="form-control" placeholder='بحث عن موظف محدد' id='search-item'>
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-filter"></i></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <input type="submit" value="بحث" id="search" class="btn btn-block ">
                  </div>
                </div>
              </form>
              @endcan
            </div>
            <div class="table-wrapper">
              <table class="fl-table view-table update-table">
                <thead>
                  <tr>
                    <th>اسم الموظف</th>
                    <th>المرتب</th>
                    <th>نوع العمل</th>
                    <th>أيام العمل</th>
                    <th>عدد ساعات العمل</th>
                    <th>تاريخ التعين</th>
                    <th>عدد أيام الاجازه</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($employees as $employee)
                    <tr row_id='{{ $employee->id }}'>
                      <td> <span data-input='employee_name'>{{ $employee->employee }}</span> </td>
                      <td> <span data-input='salary_number'>{{ $employee->salary }}</span> </td>
                      <td> <span val="{{ $employee->job }}" data-select='type_work'>{{ $employee->Jobs->job }}</span> </td>
                      <td> <span data-input='dayes_of_work'>{{ $employee->day }}</span> </td>
                      <td> <span data-input='hours_of_work'>{{ $employee->hours }}</span> </td>
                      <td> <span data-input='inauguration_date'>{{ $employee->date_hiring }}</span> </td>
                      <td> <span data-input='holidays_number'>{{ $employee->vacation }}</span> </td>
                    </tr>
                  @endforeach
                </tbody>
                <tfoot class='d-none'>
                  <tr>
                    <td> <span class='row-id'></span> </td>
                    <td> <span data-input='employee_name'></span> </td>
                    <td> <span data-input='salary_number'></span> </td>
                    <td> <span data-select='type_work'></span> </td>
                    <td> <span data-input='dayes_of_work'></span> </td>
                    <td> <span data-input='hours_of_work'></span> </td>
                    <td> <span data-input='inauguration_date'></span> </td>
                    <td> <span data-input='holidays_number'></span> </td>
                  </tr>
                </tfoot>
              </table>
            </div>
            {{$employees->links()}}
          </div>
        </section>
      </main>
    </div>
    <!-- Add Employee Modal -->
    <div class="modal modal-info add-today-modal add-employee-modal fade" id="add-employee-modal" data-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <button type="button" class='close-modal' data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
          <div class="modal-content-form">
            <nav>
              <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-link active" id="employee-tab" data-toggle="tab" href="#add-employee" role="tab" aria-controls="add-employee" aria-selected="true">الموظف</a>
                @can('السلف والخصم')
                <a class="nav-link" id="discount-tab" data-toggle="tab" href="#category-discount" role="tab" aria-controls="category-discount" aria-selected="false">السلفه والخصم</a>
                @endcan
              </div>
            </nav>
            <div class="tab-content py-3" id="myTabContent">
              <div class="tab-pane fade show active" id="add-employee" role="tabpanel" aria-labelledby="employee-tab">
                <div class="add-employee-form">
                  <div class="row">
                    <div class="col-12">
                      <label>اسم الموظف</label>
                      <div class="main-input input-group mb-3">
                        <input type="text" class="form-control" placeholder='اسم الموظف' id="employee_name" data-value='employee_name'>
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-pen-alt"></i></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <label>المرتب</label>
                      <div class="main-input input-group mb-3">
                        <input type="number" class="form-control" placeholder='المرتب' id="salary_number" data-value='salary_number' required>
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-credit-card"></i></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <label>نوع العمل</label>
                      <div class="main-input input-group mb-3">
                        <select class="custom-select" id="type_work" data-value="type_work">
                          <option value="" disabled selected></option>
                          @foreach($jobs as $job)
                          <option value="{{ $job->id }}" >{{ $job->job }}</option>
                          @endforeach
                        </select>
                        <div class='search-select'>
                          <div class='label-Select'>
                            <label>حدد نوع العمل</label>
                            <span class="select-value"></span>
                            <i class="fa fa-chevron-down arrow"></i>
                          </div>
                          <div class='input-options'>
                            <ul class='select-option' data-value="type_work"></ul>
                          </div>
                        </div>
                        <div class="input-group-prepend">
                          <label class="input-group-text" for="product_unit"><i class="fab fa-elementor"></i></label>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <label>عدد أيام العمل</label>
                      <div class="main-input input-group mb-3">
                        <input type="number" class="form-control" placeholder='عدد أيام العمل' data-value='dayes_of_work' id="dayes_of_work" required>
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-calendar-day"></i></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <label>عدد ساعات العمل</label>
                      <div class="main-input input-group mb-3">
                        <input type="number" class="form-control" placeholder='عدد ساعات العمل' id="hours_of_work" data-value='hours_of_work' required>
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-clock"></i></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <label>تاريخ التعين</label>
                      <div class="main-input input-group mb-3">
                        <input type="date" class="form-control" id="inauguration_date" data-value='inauguration_date' required>
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <label>عدد أيام الأجازة</label>
                      <div class="main-input input-group mb-3">
                        <input type="number" class="form-control" placeholder='عدد أيام الأجازة' data-value='holidays_number' id="holidays_number" required>
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-calendar-times"></i></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-block btn-success add-button" id='add_employee'>
                        <i class="far fa-plus-square"></i>
                        <span>أضافة موظف</span>
                      </button>
                      <div class="buttons">
                        @can('تعديل موظف')
                        <button class="btn btn-primary update-button" id='update_employee'>
                          <i class="far fa-edit"></i>
                          <span>تعديل موظف</span>
                        </button>
                        @endcan
                        @can('حذف موظف')
                        <button class="btn btn-danger remove-button" id='delete_employee'>
                          <i class="far fa-trash-alt"></i>
                          <span>حذف موظف</span>
                        </button>
                        @endcan
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="category-discount" role="tabpanel" aria-labelledby="discount-tab">
                <div class="discount-onAccount-form">
                  <div class="row">
                    <div class="col-12">
                      <label>نوع العملية</label>
                      <div class="main-input input-group mb-3">
                        <select class="custom-select" id="op">
                          <option value="" disabled selected></option>
                          <option value="1" >مكافأة</option>
                          <option value="2" >سلفه</option>
                          <option value="3">خصم</option>
                        </select>
                        <div class='search-select'>
                          <div class='label-Select'>
                            <label>حدد العملية</label>
                            <span class="select-value"></span>
                            <i class="fa fa-chevron-down arrow"></i>
                          </div>
                          <div class='input-options'>
                            <ul class='select-option' data-value="type_work"></ul>
                          </div>
                        </div>
                        <div class="input-group-prepend">
                          <label class="input-group-text" for="product_unit"><i class="fab fa-elementor"></i></label>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <label>اسم الموظف</label>
                      <div class="main-input input-group mb-3">
                        <input type="text" class="form-control" placeholder='اسم الموظف' id="employee" data-value='employee_name' disabled>
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-pen-alt"></i></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <label>القيمة</label>
                      <div class="main-input input-group mb-3">
                        <input type="number" class="form-control" id="val" placeholder='القيمة'>
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-money-bill-alt"></i></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <label>الملاحظات</label>
                      <div class="main-input input-group mb-3">
                        <textarea id="text" class="form-control" placeholder='الملاحظات'></textarea>
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-sticky-note"></i></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-block btn-success" id='add_discount_payment'>
                        <i class="far fa-plus-square"></i>
                        <span>أضافة</span>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal modal-update attending-leaving-modal fade" id="attending-leaving-modal" data-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <button type="button" class='close-modal' data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
          <div class="modal-content-form">
            <nav>
              <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-link active" id="employee-tab" data-toggle="tab" href="#employee" role="tab" aria-controls="employee" aria-selected="true">حضور وانصراف موظف</a>
                <a class="nav-link" id="staff-tab" data-toggle="tab" href="#staff" role="tab" aria-controls="staff" aria-selected="false">حضور وانصراف فئة</a>
              </div>
            </nav>
            <div class="tab-content" id="myTabContent" style='min-height: calc(100% - 44px)'>
              <div class="tab-pane fade show active" id="employee" role="tabpanel" aria-labelledby="employee-tab">
                <div class="portlet-content-form">
                  <div class="col-md-6">
                    <label>أسم الموظف</label>
                    <div class="main-input input-group mb-3">
                      <select class="custom-select" id='employee-select'>
                        <option value="" disabled selected></option>
                        @foreach($employees_list as $emp)
                        <option value="{{ $emp->id }}" data-code='{{ $emp->id }}' >{{ $emp->employee }}</option>
                        @endforeach
                      </select>
                      <div class='search-select'>
                        <div class='label-Select'>
                          <label>حدد الموظف</label>
                          <span class="select-value"></span>
                          <i class="fa fa-chevron-down arrow"></i>
                        </div>
                        <div class='input-options'>
                          <input autocomplete="off" type='text' class="search-input"  placeholder="بحث" />
                          <ul class='select-option'></ul>
                        </div>
                      </div>
                      <div class="input-group-prepend">
                        <label class="input-group-text"><i class="fab fa-elementor"></i></label>
                      </div>
                    </div>
                  </div>
                  <div class="portlet-content-form-buttons">
                    <button class="btn btn-success attend-button attend-employee-button" disabled>
                      <span>حضور</span>
                    </button>
                    <button class="btn btn-danger leave-button" disabled>
                      <span>انصراف</span>
                    </button>
                  </div>
                </div>

                <div class="table-wrapper">
                  <table class="fl-table employee-table">
                    <thead>
                      <tr>
                        <th><input type="checkbox" name="employee" class="check-all"></th>
                        <th>الكود</th>
                        <th>اسم الموظف</th>
                        <th>الحضور</th>
                        <th>الانصراف</th>
                        <th>عدد ساعات العمل</th>
                        <th>التاريخ</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($Atendance as $at)
                        @php
                          $len = sizeof($at->atendance);
                        @endphp
                        @if($len > 0 )
                        <tr row_id='{{ $at->id }}'>
                          <td><input type="checkbox" name='staff'></td>
                          <td>{{ $at->id }}</td>
                          <td>{{ $at->employee }}</td>
                          <td class='attend'>{{ $at->atendance[0]->presence}}</td>
                          <td class='leave'>{{ $at->atendance[0]->leave}}</td>
                          <td class='hours'>{{ $at->hours}}</td>
                          <td class='today'>{{ $at->atendance[0]->date}}</td>
                          @endif
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                {{$Atendance->links()}}
              </div>
              <div class="tab-pane fade" id="staff" role="tabpanel" aria-labelledby="staff-tab">
                <div class="portlet-content-form">
                  <div class="col-md-6">
                    <label>الفئة</label>
                    <div class="main-input input-group mb-3">
                      <select class="custom-select" id='staff-select'>
                        <option value="" disabled selected></option>
                        @foreach($jobs as $job)
                        <option value="{{ $job->id }}" >{{ $job->job }}</option>
                        @endforeach
                      </select>
                      <div class='search-select'>
                        <div class='label-Select'>
                          <label>حدد الفئة</label>
                          <span class="select-value"></span>
                          <i class="fa fa-chevron-down arrow"></i>
                        </div>
                        <div class='input-options'>
                          <input autocomplete="off" type='text' class="search-input"  placeholder="بحث" />
                          <ul class='select-option'></ul>
                        </div>
                      </div>
                      <div class="input-group-prepend">
                        <label class="input-group-text"><i class="fab fa-elementor"></i></label>
                      </div>
                    </div>
                  </div>
                  <div class="portlet-content-form-buttons">
                    <button class="btn btn-success attend-button attend-staff-button " disabled>
                      <span>حضور</span>
                    </button>
                    <button class="btn btn-danger leave-button " disabled>
                      <span>انصراف</span>
                    </button>
                  </div>
                </div>
                <div class="table-wrapper">
                  <table class="fl-table staff-table">
                    <thead>
                      <tr>
                        <th><input type="checkbox" name="staff" class="check-all"></th>
                        <th>الكود</th>
                        <th>اسم الموظف</th>
                        <th>الحضور</th>
                        <th>الانصراف</th>
                        <th>عدد ساعات العمل</th>
                        <th>التاريخ</th>
                      </tr>
                    </thead>
                    <tbody id="payment_emp">
                      @foreach($Atendance as $at)
                        @php
                          $len = sizeof($at->atendance);
                        @endphp
                        @if($len > 0 )
                        <tr row_id='{{ $at->id }}'>
                          <td><input type="checkbox" name='staff'></td>
                          <td>{{ $at->id }}</td>
                          <td>{{ $at->employee }}</td>
                          <td class='attend'>{{ $at->atendance[0]->presence}}</td>
                          <td class='leave'>{{ $at->atendance[0]->leave}}</td>
                          <td class='hours'>{{ $at->hours}}</td>
                          <td class='today'>{{ $at->atendance[0]->date}}</td>
                          @endif
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                {{$Atendance->links()}}
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
@include('ajax.Staff.staff')
@endsection
