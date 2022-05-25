@php
$title = 'الموردين';
@endphp
@extends('layouts.app')

@section('content')
  <div id="wrapper" class='toggled-2'>
    @include('includes.sidebar')
    <div id="page-content-wrapper">
      <main class="py-4">
        <section>
          <div class="container">
            @can('حذف صرف') 
              <div id="delper" value="del">
            @else
              <div id="delper" value="notdel">
            @endcan
            <div class="page-title">
              <div id="new_serial" value="{{$new_serial}}"></div>
              <h2> التوريد </h2>
              @Can('إذن توريد')
              <div class="title-buttons">
                <button class="btn btn-success new-add"  data-toggle="modal" data-target="#add-supply-modal">
                  <i class="far fa-plus-square"></i>
                  <span>اذن توريد</span>
                </button>
              </div>
              @endcan
            </div>
            <div class="portlet mb-3">
              @can('البحث توريد')
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
              <table class="fl-table view-table">
                <thead>
                  <tr>
                    <th>رقم العملية</th>
                    <th>اسم العميل</th>
                    <th>المبلغ المدفوع</th>
                    <th>عليه</th>
                    <th>التاريخ</th>
                    <th>الملاحظات</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($supply as $sub)
                  <tr row_id='{{ $sub->id }}'>
                    <td> <span class='row-id'>{{ $sub->id }}</span> </td>
                    <td> <span data-select='supply_name'>{{ $sub->customers->customer }}</span> </td>
                    <td> <span data-input='supply_money'>{{ $sub->val }}</span> </td>
                    <td> <span data-input='supply_forHim'>{{ $sub->forhim }}</span> </td>
                    <td> <span data-input='supply_note'>{{ $sub->date }}</span> </td>
                    <td> <span data-input='supply_note'>{{ $sub->note }}</span> </td>
                    @can('حذف توريد')
                    <td class='remove-row' mony="{{ $sub->val }}" op="{{ $sub->id }}" customer="{{ $sub->customers->id }}"> <button class='btn btn-block btn-danger rounded-0'><i class="far fa-trash-alt"></i></button> </td>
                    @endcan
                  </tr>
                  @endforeach
                </tbody>
                <tfoot class='d-none'>
                  <tr>
                    <td> <span class='row-id'></span> </td>
                    <td> <span data-select='supply_name'></span> </td>
                    <td> <span data-input='supply_money'></span> </td>
                    <td> <span data-input='supply_forHim'></span> </td>
                    <td> <span data-input='supply_note'></span> </td>
                    <td class='remove-row'> <button class='btn btn-block btn-danger rounded-0'><i class="far fa-trash-alt"></i></button> </td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </section>
      </main>
    </div>
    <!-- Add supply Modal -->
    <div class="modal add-supply-modal fade" id="add-supply-modal" data-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <button type="button" class='close-modal' data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
          <div class="modal-content-form">
            <nav>
              <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-link active" id="supply-tab" data-toggle="tab" href="#add-supply" role="tab" aria-controls="add-supply" aria-selected="true">التوريد</a>
              </div>
            </nav>
            <div class="tab-content py-3" id="myTabContent">
              <div class="tab-pane fade show active" id="add-supply" role="tabpanel" aria-labelledby="supply-tab">
                <div class="add-supply-form">
                  <form>
                    <div class="row">
                      <div class="col-12">
                        <label>رقم العملية</label>
                        <div class="main-input input-group mb-3">
                          <input type="text" class="form-control" placeholder='رقم العملية' data-value='barcode' id="d_barcode">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <label>اسم العميل</label>
                        <div class="main-input input-group mb-3">
                          <select class="custom-select select-changed" id="customer" data-value='supply_name'>
                            <option value="" disabled selected></option>
                            @foreach($customers as $customer)
                              <option value="{{ $customer->id }}" customer="{{ $customer->customer }}" data-price='{{ $customer->debt }}' >{{ $customer->customer }}</option>
                            @endforeach
                          </select>
                          <div class='search-select'>
                            <div class='label-Select'>
                              <label>حدد العميل</label>
                              <span class="select-value"></span>
                              <i class="fa fa-chevron-down arrow"></i>
                            </div>
                            <div class='input-options'>
                              <input autocomplete="off" type='text' class="search-input"  placeholder="بحث" />
                              <ul class='select-option' data-value="supply_name"></ul>
                            </div>
                          </div>
                          <div class="input-group-prepend">
                            <label class="input-group-text" for="product_unit"><i class="fab fa-elementor"></i></label>
                          </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <label>عليه</label>
                        <div class="main-input input-group mb-3">
                          <input type="number" class="form-control" placeholder='عليه' id="supply_forHim" data-value='supply_forHim' disabled >
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-clock"></i></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <label>المبلغ المدفوع</label>
                        <div class="main-input input-group mb-3">
                          <input type="number" class="form-control" id='paid_amount' placeholder='المبلغ المدفوع' data-value='supply_money'>
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-calendar-day"></i></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <label>ملاحظات</label>
                        <div class="main-input input-group mb-3">
                          <input type='text' class="form-control" placeholder='ملاحظات' id="note" data-value='supply_note'>
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-clock"></i></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <button class="btn btn-block btn-success add-button" id='add_supply'>
                          <i class="fas fa-check"></i>
                          <span>حفظ</span>
                        </button>
                        <div class="buttons">
                          <button class="btn btn-primary" id='update_supply'>
                            <i class="far fa-edit"></i>
                            <span>تعديل توريد</span>
                          </button>
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
  @include('ajax.exchange_supply.Supply')
@endsection
