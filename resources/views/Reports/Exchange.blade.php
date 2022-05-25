@php
$title = 'تقارير الصرف';
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
              <h2>تقارير الصرف</h2>
              <div class="title-buttons">
                @can('excel الصرف')
                <button class="btn btn-success new-add" id='to-Excel'>
                    <i class="far fa-file-excel"></i>
                  <span>To Excel</span>
                </button>
                @endcan
                @can('pdf الصرف')
                <button class="btn btn-success new-add" id='to-Pdf'>
                  <i class="fas fa-file-pdf"></i>
                <span>To PDF</span>
              </button>
              @endcan
              @can('طباعة تقارير الصرف')
              <button class="btn btn-success new-add" id='to-Pdf'>
                <i class="fas fa-file-pdf"></i>
              <span>طباعة</span>
            </button>
            @endcan
              <div class="total"></div>
              <div class="profit"></div>
              <div class="orders"></div>
              </div>
            </div>
            <div class="portlet mb-3">
              <form class='expense-search'>
                <div class="row">
                  @can('بحث تقارير الصرف')
                  <div class="col-lg-9 col-md-12">
                    <div class="main-input search-container">
                      <div class="main-input input-group">
                        <select class="custom-select" id="reports-search">
                          <option value="" disabled selected></option>
                          <option value="all">الجميع</option>
                          <option value="id">رقم العملية</option>
                          <option value="customer">عميل</option>
                          <option value="delete">صرف ممسوح</option>
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

                      <input type="text" class="form-control search-name d-none" placeholder='رقم الفاتورة' id='search-item'>
                      <div class="input-group-prepend search-name d-none">
                        <span class="input-group-text"><i class="fas fa-filter"></i></span>
                      </div>

                      <div class="main-input input-group search-customer d-none">
                        <select class="custom-select" id="reports-customer">
                          <option value="" disabled selected></option>
                          @if(!empty($customers))
                            @foreach($customers as $customer)
                              <option value="{{ $customer->id }}">{{ $customer->customer }}</option>
                            @endforeach
                          @endif
                        </select>
                        <div class='search-select'>
                          <div class='label-Select'>
                            <label>حدد العميل</label>
                            <span class="select-value"></span>
                            <i class="fa fa-chevron-down arrow"></i>
                          </div>
                          <div class='input-options'>
                            <input autocomplete="off" type='text' class="search-input" id='branch-input' placeholder="بحث" />
                            <ul></ul>
                          </div>
                        </div>
                      </div>

                      <div class="main-input input-group search-date">
                        <div class="main-input input-group">
                          <input type="date" class="form-control" id='date_to'>
                          <div class="input-group-prepend">
                            <span class="input-group-text">الى</span>
                          </div>
                        </div>
                      </div>
                      <div class="main-input input-group search-date">
                        <div class="main-input input-group">
                          <input type="date" class="form-control" id='date_from'>
                          <div class="input-group-prepend">
                            <span class="input-group-text">من</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  @endcan
                  <div class="col-lg-3 col-md-12">
                    <input id="search" type="submit" value="بحث" class="btn btn-block">
                  </div>
                </div>
              </form>
            </div>
            <div class="table-wrapper">
              <table class="fl-table view-table update-table" id='table-exchange'>
                <thead>
                  <tr>
                    <th>#</th>
                    <th>العميل</th>
                    <th>المبلغ المدفوع</th>
                    <th>لة</th>
                    <th>الموظف</th>
                    <th>التاريخ</th>
                    <th>الملاحظات</th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
              </table>
            </div>
          </div>
        </section>
      </main>
    </div>
  </div>
  @include('ajax.Reports.Exchange')
@endsection
