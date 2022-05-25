@php
$title = 'المصروفات';
@endphp
@extends('layouts.app')

@section('content')
  <div id="wrapper" class='toggled-2'>
    @include('includes.sidebar')
    <div id="page-content-wrapper">
      <main class="py-4">
        <section class='expense'>
          <div class="container">
            <div class="page-title">
              <div id="new_serial" value="{{$new_serial}}"></div>
              <h2> المصروفات </h2>
              @can('إضافة مصروف')
              <div class="title-buttons">
                <button class="btn btn-success new-add"  data-toggle="modal" data-target="#add-expense-modal">
                  <i class="far fa-plus-square"></i>
                  <span>أضافة مصروف</span>
                </button>
              </div>
              @endcan
            </div>
            <div class="portlet mb-3">
              @can('بحث عن مصروف')
              <form class='expense-search'>
                <div class="row">
                  <div class="col-lg-9 col-md-12">
                    <div class="main-input search-container">
                      <div class="main-input input-group">
                        <select class="custom-select" id="expense-search">
                          <option value="" disabled selected></option>
                          <option value="all" data-type='search-name'>الجميع</option>
                          <option value="id" data-type='search-name'>رقم العملية</option>
                          <option value="name" data-type='search-name'>الاسم</option>
                          <option value="price" data-type='search-name'>المبلغ</option>
                          <option value="date" data-type='search-date'>التاريخ</option>
                        </select>
                        <div class='search-select'>
                          <div class='label-Select'>
                            <label>حدد نوع البحث</label>
                            <span class="select-value"></span>
                            <i class="fa fa-chevron-down arrow"></i>
                          </div>
                          <div class='input-options'>
                            <ul></ul>
                          </div>
                        </div>
                      </div>

                      <input type="text" class="form-control search-name" placeholder='بحث عن مصروف محدد' id='search-item'>
                      <div class="input-group-prepend search-name">
                        <span class="input-group-text"><i class="fas fa-filter"></i></span>
                      </div>

                      <div class="main-input input-group search-date d-none">
                        <div class="main-input input-group">
                          <input type="date" class="form-control" id='date_to'>
                          <div class="input-group-prepend">
                            <span class="input-group-text">الى</span>
                          </div>
                        </div>
                      </div>
                      <div class="main-input input-group search-date d-none">
                        <div class="main-input input-group">
                          <input type="date" class="form-control" id='date_from'>
                          <div class="input-group-prepend">
                            <span class="input-group-text">من</span>
                          </div>
                        </div>
                      </div>


                    </div>
                  </div>
                  <div class="col-lg-3 col-md-12">
                    <input id="search" type="submit" value="بحث" class="btn btn-block">
                  </div>
                </div>
              </form>
              @endcan
            </div>
            <div class="table-wrapper">
              <table class="fl-table view-table update-table">
                <thead>
                  <tr>
                    <th>رقم العملية</th>
                    <th>اسم المصروف</th>
                    <th>المبلغ</th>
                    <th>التاريخ</th>
                    <th>الملاحظات</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($Spending as $spin)
                    <tr row_id='{{ $spin->id }}'>
                      <td> <span class='row-id'>{{ $spin->id }}</span> </td>
                      <td> <span  val="{{ $spin->expenses->id }}" data-select='expense_name'>{{ $spin->expenses->name }}</span> </td>
                      <td> <span data-input='expense_money'>{{ $spin->value }}</span> </td>
                      <td> <span data-input='expense_date' class='date-today'>{{ $spin->date }}</span> </td>
                      <td> <span data-input='expense_note'>{{ $spin->note }}</span> </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
              {{ $Spending->links() }}
            </div>
          </div>
        </section>
      </main>
    </div>
    <!-- Add expense Modal -->
    <div class="modal modal-info add-today-modal add-expense-modal fade" id="add-expense-modal" data-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <button type="button" class='close-modal' data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
          <div class="modal-content-form">
            <nav>
              <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-link active" id="expense-tab" data-toggle="tab" href="#add-expense" role="tab" aria-controls="add-expense" aria-selected="true">المصروف</a>
              </div>
            </nav>
            <div class="tab-content py-3" id="myTabContent">
              <div class="tab-pane fade show active" id="add-expense" role="tabpanel" aria-labelledby="expense-tab">
                <div class="add-expense-form">
                  <form>
                    <div class="row">
                      <div class="col-12">
                        <label>رقم العملية</label>
                        <div class="main-input input-group mb-3">
                          <input type="number"  name="serial" id="serial" readonly class="form-control serial" data-value='row-id'>
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <label>اسم المصروف</label>
                        <div class="main-input input-group mb-3">
                          @can('إضافة مصروف جديد')
                          <button class='btn btn-primary rounded-0' id='add-new-expense'><i class="fas fa-plus"></i></button>
                          @endcan
                          <input type="text" id="new_expense" class="form-control" placeholder='اسم المصروف'>
                          
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-pen-alt"></i></span>
                          </div>
                          
                        </div>
                      </div>
                      <div class="col-12">
                        <label>الاسم</label>
                        <div class="main-input input-group mb-3" id='expense-select'>
                          <select class="custom-select" data-value="expense_name" id="expense_name">
                            <option value="" disabled selected></option>
                            @foreach($expense as $exp)
                            <option value="{{ $exp->id }}">{{ $exp->name }}</option>
                            @endforeach
                          </select>
                          <div class='search-select'>
                            <div class='label-Select'>
                              <label>حدد المصروف</label>
                              <span class="select-value"></span>
                              <i class="fa fa-chevron-down arrow"></i>
                            </div>
                            <div class='input-options'>
                              <ul class='select-option expense-list' data-value="expense_name"></ul>
                            </div>
                          </div>
                          <div class="input-group-prepend">
                            <label class="input-group-text" for="product_unit"><i class="fab fa-elementor"></i></label>
                          </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <label>المبلغ</label>
                        <div class="main-input input-group mb-3">
                          <input type="number" class="form-control" placeholder='المبلغ' id="expense_money" data-value='expense_money'>
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-calendar-day"></i></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <label>ملاحظات</label>
                        <div class="main-input input-group mb-3">
                          <input type="text" class="form-control" placeholder='ملاحظات' id="expense_note" data-value='expense_note' >
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-clock"></i></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <label>التاريخ</label>
                        <div class="main-input input-group mb-3">
                          <input type="date" class="form-control" id="expense_date" data-value='expense_date' >
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-12">
                        @can('إضافة مصروف')
                        <button class="btn btn-block btn-success add-button" id='add_expense'>
                          <i class="far fa-plus-square"></i>
                          <span>أضافة مصروف</span>
                        </button>
                        @endcan
                        <div class="buttons">
                          @can('تعديل مصروف')
                          <button class="btn btn-primary update-button" id='update_expense'>
                            <i class="far fa-edit"></i>
                            <span>تعديل مصروف</span>
                          </button>
                          @endcan
                          @can('حذف مصروف')
                          <button class="btn btn-danger remove-button" id='delete_expense'>
                            <i class="far fa-trash-alt"></i>
                            <span>حذف مصروف</span>
                          </button>
                          @endcan
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @include('ajax.Expenses.expenses')
@endsection
