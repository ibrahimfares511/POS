@php
$title = 'باركود';
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
                <h2> باركود </h2>
                <div class="title-buttons">
                </div>
              </div>
              <div class="portlet mb-3">
                <div class="row">
                  <div class="col-lg-9 col-md-12">
                    <div class="main-input search-container">
                      <div class="main-input input-group">
                        <select class="custom-select" id="reports-search">
                          <option value="" disabled selected></option>
                          <option  value="all">الجميع</option>
                          <option  value="id">الباركود</option>
                          <option  value="buy">فاتورة</option>
                          <option  value="customer">صنف معين</option>
                          <option  value="product">اسم منتج</option>
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
  
                      <input type="text" class="form-control search-name d-none" placeholder='الباركود' id='search-item'>
                      <div class="input-group-prepend search-name d-none">
                        <span class="input-group-text"><i class="fas fa-filter"></i></span>
                      </div>
  
                      <div class="main-input input-group search-customer d-none">
                        <select class="custom-select" id="reports-customer">
                          <option value="" disabled selected></option>
                          @if(!empty($categories))
                            @foreach($categories as $category)
                              <option value="{{ $category->id }}">{{ $category->name }}</option>
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
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-12">
                    <button id="search" class="btn btn-primary btn-block">بحث</button>
                  </div>
                </div>
              </div>

              <div class="row barcode-product">
                @foreach($Products as $product) 
                <div class="col-sm-6">                  
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">{!! $product->code !!}</h5>
                      <p class="card-text">{{ $product->name }} | {{ $product->price_p}}</p>
                    </div>
                  </div>
                </div>
                @endforeach
              </div>
            </div>
          </section>
      </main>
    </div>
  </div>
  @include('ajax.setting.barcode')
@endsection
