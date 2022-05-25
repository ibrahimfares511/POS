@php
$title = 'المبيعات';
@endphp
@extends('layouts.app')

@section('content')
  <div id="wrapper" class='toggled-2'>
    @include('includes.sidebar')
    <div id="saletype" sale="{{ $salsetype->salestype }}"></div>
    <div id="page-content-wrapper">
      <main class="py-4">
        <section>
          <div class="container">
            <div class="row">
              <div class="col-12 mb-4">
                <div class="portlet">
                  <div class="row">
                    <div class="main-input input-group mb-3 col-md-4">
                      <input type="number" value="{{ $order }}" class="form-control" id='number-order' disabled>
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span>
                      </div>
                    </div>
                    <div class="main-input input-group mb-3 col-md-4">
                      <select class="custom-select" name="unit" id="order-opration">
                        <option value="" disabled  ></option>
                        <option selected value="cash">نقدي</option>
                        <option value="aggel">اجل</option>
                        <option value="tsaer">تسعير</option>
                        <option value="back">مرتجع</option>
                        <option value="backofcus">مرتجع من حساب</option>
                      </select>
                      <div class='search-select'>
                        <div class='label-Select'>
                          <span class="select-value"></span>
                          <i class="fa fa-chevron-down arrow"></i>
                        </div>
                        <div class='input-options'>
                          <ul></ul>
                        </div>
                      </div>
                      <div class="input-group-prepend">
                        <label class="input-group-text" for="product_unit"><i class="fas fa-money-bill-wave"></i></</label>
                      </div>
                    </div>
                    <div class="main-input input-group mb-3 col-md-4">
                      <select class="custom-select"  id="customer">
                        <option value="" disabled  selected></option>
                        @foreach ($customers as $customer)
                        <option custtype="{{ $customer->custtype }}" debt="{{ $customer->debt }}" balance="{{ $customer->balance }}" discount="{{ $customer->discount }}"  value="{{$customer->id}}">{{ $customer->customer }}</option>
                        @endforeach
                      </select>
                      <div class='search-select'>
                        <div class='label-Select'>
                          <label>العميل</label>
                          <span class="select-value"></span>
                          <i class="fa fa-chevron-down arrow"></i>
                        </div>
                        <div class='input-options'>
                          <input autocomplete="off" type='text' class="search-input" id='branch-input' placeholder="بحث" />
                          <ul></ul>
                        </div>
                      </div>
                      <div class="input-group-prepend">
                        <label class="input-group-text" for="product_unit"><i class="fas fa-user-tie"></i></label>
                      </div>
                    </div>
                  </div>
                  <div class="row my-3 d-flex align-items-center">
                    <div class="col-sm-4">
                      <div class="portlet price-box">
                        <div class="box-title"> نوع السعر </div>
                        <div class="box-radio">
                          <input type="radio" class='d-none radio-Button' value="ataay" id='ataay' name='salesopration' checked>
                          <label class="entry" for="ataay">
                            <div class="circle"></div>
                            <div class="entry-label">قطاعى</div>
                          </label>

                          <input type="radio" class='d-none radio-Button' value="gomla" id='gomla' name='salesopration'>
                          <label class="entry" for="gomla">
                            <div class="circle"></div>
                            <div class="entry-label">جملة</div>
                          </label>
                          <div class="highlight"></div>
                        </div>
                      </div>
                    </div>
                    @can('بحث فاتورة مبيعات')
                    <div class="col-sm-8">
                      <div class="main-input input-group mb-3">
                        <select class="custom-select"  id="getorder">
                          <option value="" disabled  selected></option>
                          @foreach ($listorder as $or)
                          <option value="{{$or->id}}">{{ $or->id }}</option>
                          @endforeach
                        </select>
                        <div class='search-select'>
                          <div class='label-Select'>
                            <label>بحث عن فاتورة</label>
                            <span class="select-value"></span>
                            <i class="fa fa-chevron-down arrow"></i>
                          </div>
                          <div class='input-options input-order-search'>
                            <input autocomplete="off" type='text' class="search-input" id='search-item' placeholder="بحث" />
                            <input type="submit" id="search" value="بـحـث" class="btn">
                            <ul></ul>
                          </div>
                        </div>
                        <div class="input-group-prepend">
                          <label class="input-group-text" for="product_unit"><i class="fas fa-filter"></i></label>
                        </div>
                      </div>
                    </div>
                    @endcan
                  </div>
                  <div class="title-buttons">
                    <button id="new_order" class="btn btn-success">
                      <i class="far fa-plus-square"></i>
                      <span>جديدة</span>
                    </button>
                    @can('حذف فاتورة مبيعات')
                    <button id="delete_order" class="btn btn-danger">
                      <i class="fas fa-trash"></i>
                      <span>حذف</span>
                    </button>
                    @endcan
                    <button class="btn btn-info">
                      <i class="fas fa-print"></i>
                      <span>طباعة</span>
                    </button>
                    <button class="btn btn-warning" id='btn-transfare' disabled>
                      <i class="fas fa-exchange-alt"></i>
                      <span>تحويل الى نقدى</span>
                    </button>
                    <button class="btn btn-warning" id='btn-transfare-aggel' disabled>
                      <i class="fas fa-exchange-alt"></i>
                      <span>تحويل الى اجل </span>
                    </button>
                    <div class="main-input input-group mb-3 col-md-4">
                      <select class="custom-select"  id="customer-transfare">
                        <option value="" disabled  selected></option>
                        @foreach ($customers as $customer)
                        <option custtype="{{ $customer->custtype }}" debt="{{ $customer->debt }}" balance="{{ $customer->balance }}" discount="{{ $customer->discount }}"  value="{{$customer->id}}">{{ $customer->customer }}</option>
                        @endforeach
                      </select>
                      <div class='search-select'>
                        <div class='label-Select'>
                          <label>العميل</label>
                          <span class="select-value"></span>
                          <i class="fa fa-chevron-down arrow"></i>
                        </div>
                        <div class='input-options'>
                          <input autocomplete="off" type='text' class="search-input" id='branch-input' placeholder="بحث" />
                          <ul></ul>
                        </div>
                      </div>
                      <div class="input-group-prepend">
                        <label class="input-group-text" for="product_unit"><i class="fas fa-user-tie"></i></label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4">
                @csrf
                <div class="portlet sale-form">
                  <div class="portlet-title">
                    <h4>طلب منتج للبيع</h4>
                  </div>
                  <div class="product-form">
                    <div class="main-input input-group">
                      <input type="text" id="item_code" class="form-control" placeholder='الكود'>
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                      </div>
                    </div>
                    <div class="main-input input-group">
                      <input type="text" countval="" pricelist="" class="form-control" placeholder='اسم المنتج' id='item_name'>
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-pen-alt"></i></span>
                      </div>
                    </div>
                    <ul class="item_name_list"></ul>
                    <div class="main-input input-group">
                      <select class="custom-select" name="unit" id="product_unit">
                        <option value="" disabled ></option>
                        <option selected value="one">قطعة</option>
                        <option value="all">كرتونة</option>
                      </select>
                      <div class='search-select'>
                        <div class='label-Select'>
                          <label> حدد الوحدة</label>
                          <span class="select-value"></span>
                          <i class="fa fa-chevron-down arrow"></i>
                        </div>
                        <div class='input-options'>
                          <!-- <input autocomplete="off" type='text' class="search-input" id='branch-input' placeholder="بحث" /> -->
                          <ul></ul>
                        </div>
                      </div>
                      <div class="input-group-prepend">
                        <label class="input-group-text" for="product_unit"><i class="fas fa-weight-hanging"></i></label>
                      </div>
                    </div>
                    <div class="counter-widget input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"  id="basic-addon1"><i class="fas fa-balance-scale-right"></i></span>
                      </div>
                      <span class="plus-minus-btn plus"><i class="fas fa-plus"></i></span>
                      <input type="number" value="1" min="1" class='form-control' id='item_quant'  placeholder='الكميه'/>
                      <span class="plus-minus-btn minus"><i class="fas fa-minus"></i></span>
                    </div>
                    @can('سعر المنتج مبيعات')
                    <div class="main-input input-group">
                      <input type="number" class="form-control"  id='item_price' placeholder='سعر المنتج' >
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span>
                      </div>
                    </div>
                    @else
                    <div class="main-input input-group">
                      <input type="number" class="form-control" id='item_price' placeholder='سعر المنتج'  disabled>
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span>
                      </div>
                    </div>
                    @endcan
                    @can('الخصم علي المنتج')
                    <div class="main-input input-group">
                      <input type="number" class="form-control" id='discount_ratio' placeholder='الخصم %'>
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-percent"></i></span>
                      </div>
                    </div>
                    @else
                    <div class="main-input input-group">
                      <input type="number" class="form-control" id='discount_ratio' placeholder='الخصم %' disabled>
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-percent"></i></span>
                      </div>
                    </div>
                    @endcan
                    @if($salsetype->saleopration == "direct")
                    <button type="button" class="btn btn-success btn-block d-none" id='add-cart'>
                      <i class="fas fa-cart-plus in-place"></i>
                      <span> أضافة للفاتوره </span>
                    </button>
                    @else
                    <button type="button" class="btn btn-success btn-block" id='add-cart'>
                      <i class="fas fa-cart-plus in-place"></i>
                      <span> أضافة للفاتوره </span>
                    </button>
                    @endif
                  </div>
                </div>
              </div>
              <div class="col-lg-8">
                <div class="portlet check">
                  <div class='check-header'>
                    <div class='item-name'> اسم المنتج </div>
                    <div class='item-Quantity'> الكمية </div>
                    <div class='item-unit'> الوحده </div>
                    <div class='item-price'> سعر الوحده </div>
                    <div class='item-total-price'> السعر الكلى </div>
                  </div>
                  <div class="check-body">
                  </div>
                  <div class="check-footer px-2">
                    <div class='discount-check'>
                      <p>خصم على الفاتوره</p>
                      <p><span id="alldiscountval">0.00</span> ج.م</p>
                    </div>
                    @can('خصم علي فاتورة مبيعات')
                    <div class="discount-content">
                      <ul class="nav nav-pills mb-1 p-0 discount-pills" id="pills-tab" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link active" id="ratio-tab" data-toggle="pill" href="#pills-ratio" role="tab" aria-controls="pills-ratio" aria-selected="true"><i class="fas fa-percent"></i></a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="value-tab" data-toggle="pill" href="#pills-value" role="tab" aria-controls="pills-value" aria-selected="false"><i class="fas fa-pound-sign"></i></a>
                        </li>
                      </ul>
                      <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-ratio" role="tabpanel" aria-labelledby="ratio-tab">
                          <input type="number" placeholder='%'  class="form-control input-discount" id='val-dis-ratio'>
                          <button type="button" class="btn btn-success btn-block mt-2" id='save-dis-ratio'> حفظ </button>
                        </div>
                        <div class="tab-pane fade" id="pills-value" role="tabpanel" aria-labelledby="value-tab">
                          <input type="number" placeholder='&pound;' class="form-control" id="val-dis-value">
                          <button type="button" class="btn btn-success btn-block mt-2" id='save-dis-value'> حفظ </button>
                        </div>
                      </div>
                    </div>
                    @endcan
                    <div class="total-check">
                      <p>الاجمالى</p>
                      <p class='total-value'><span id="totalcheck">0</span> ج.م</p>
                    </div>
                    <div class="total-content">
                      <div>
                        <input type="number" class="form-control mb-2" placeholder="المبلغ المدفوع" id='balance-price'>
                        <input type="submit" id="save-balance" value="حفظ" class="btn btn-success px-4">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </main>
    </div>
  </div>
@include('ajax.sales.sales')
@endsection
