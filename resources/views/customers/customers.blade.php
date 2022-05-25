@php
$title = 'العملاء';
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
                <h2> العملاء </h2>
                @can('إضافة عميل')
                <div class="title-buttons">
                  <button class="btn btn-success"  data-toggle="modal" data-target="#add-customer-modal">
                    <i class="far fa-plus-square"></i>
                    <span>أضافة عميل</span>
                  </button>
                </div>
                @endcan
              </div>
              <div class="portlet mb-3">
                @can('بحث عن عميل')
                <form class='products-search'>
                  <div class="row">
                    <div class="col-sm-8">
                      <div class="main-input input-group">
                        <input type="text" class="form-control" placeholder='بحث عن عميل محدد' id='search-item'>
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
                      <th>اسم العميل</th>
                      <th>رقم الهاتف</th>
                      <th>الرقم القومى</th>
                      <th>نوع العميل</th>
                      <th>الرصيد</th>
                      <th>المديونيه</th>
                      <th>الخصم</th>
                      <th>التفعيل</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($customers as $customer)
                    <tr row_id='{{ $customer->id }}'>
                      <td> <span data-input='customer_name'>{{ $customer->customer }}</span> </td>
                      <td> <span data-input='phone_number'>{{ $customer->custphone }}</span> </td>
                      <td> <span data-input='id_number'>{{ $customer->custid }}</span> </td>
                      <td> <span val="{{ $customer->typeid }}" data-select="customer_type">{{ $customer->custtype }}</span> </td>
                      <td> <span data-input='funds'>{{ $customer->balance }}</span> </td>
                      <td> <span data-input='debt'>{{ $customer->debt }}</span> </td>
                      <td> <span data-input='customer_discount'>{{ $customer->discount }}</span> </td>
                      <td class='checkbox-td' onclick='event.stopPropagation()'>
                        <label class="checker">
                          @if($customer->status == 1)
                            <input class="checkbox" type="checkbox" checked/>
                          @else
                            <input class="checkbox" type="checkbox"/>
                          @endif
                          <div class="check-bg"></div>
                          <div class="checkmark">
                            <svg viewBox="0 0 100 100">
                              <path d="M20,55 L40,75 L77,27" fill="none" stroke="#FFF" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                          </div>
                        </label>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                  <tfoot class='d-none'>
                    <tr>
                      <td> <span data-input='customer_name'></span> </td>
                      <td> <span data-input='phone_number'></span> </td>
                      <td> <span data-input='id_number'></span> </td>
                      <td> <span data-select="customer_type"></span> </td>
                      <td> <span data-input='funds'></span> </td>
                      <td> <span data-input='debt'></span> </td>
                      <td> <span data-input='customer_discount'></span> </td>
                      <td class='checkbox-td' onclick='event.stopPropagation()'>
                    </tr>
                  </tfoot>
                </table>
              </div>
              {{$customers->links()}}
            </div>
          </section>
      </main>
    </div>
    <!-- Add Customer Modal -->
    <div class="modal modal-info add-customer-modal fade" id="add-customer-modal" data-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <button type="button" class='close-modal' data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
          <div class="modal-content-form">
            <nav>
              <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-link active" id="customer-tab" data-toggle="tab" href="#add-customer" role="tab" aria-controls="add-category" aria-selected="true">العميل</a>
              </div>
            </nav>
            <div class="tab-content py-3" id="myTabContent">
              <div class="tab-pane fade show active" id="add-customer" role="tabpanel" aria-labelledby="customer-tab">
                <div class="add-customer-form">
                  <div class="row">
                    <div class="col-12">
                      <label>اسم العميل</label>
                      <div class="main-input input-group mb-3">
                        <input type="text" class="form-control" placeholder='اسم العميل' data-value='customer_name' id="customer_name">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-pen-alt"></i></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <label>رقم الهاتف</label>
                      <div class="main-input input-group mb-3">
                        <input type="number" class="form-control" placeholder='رقم الهاتف' data-value='phone_number' id="phone_number" required>
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <label>الرقم القومى</label>
                      <div class="main-input input-group mb-3">
                        <input type="number" class="form-control" placeholder='الرقم القومى' id="id_number" data-value='id_number' required>
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <label>نوع العميل</label>
                      <div class="main-input input-group mb-3">
                        <select class="custom-select" id="typecustomer">
                          <option value="" disabled selected></option>
                          <option value="1">عميل</option>
                          <option value="2">مورد</option>
                          <option value="3">عميل مورد</option>
                        </select>
                        <div class='search-select'>
                          <div class='label-Select'>
                            <label>حدد النوع</label>
                            <span class="select-value"></span>
                            <i class="fa fa-chevron-down arrow"></i>
                          </div>
                          <div class='input-options'>
                            <ul class='select-option' data-value="customer_type"></ul>
                          </div>
                        </div>
                        <div class="input-group-prepend">
                          <label class="input-group-text" for="product_unit"><i class="fab fa-elementor"></i></label>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <label>الرصيد</label>
                      <div class="main-input input-group mb-3">
                        <input type="number" class="form-control" value="0" placeholder='الرصيد' data-value='funds' id="funds" required>
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-wallet"></i></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <label>المديونية</label>
                      <div class="main-input input-group mb-3">
                        <input type="number" class="form-control" value="0" placeholder='المديونية' data-value='debt' id="debt" required>
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-hand-holding-usd"></i></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <label>الخصم</label>
                      <div class="main-input input-group mb-3">
                        <input type="number" class="form-control" value="0" placeholder='الخصم' data-value='customer_discount' id="discount" required>
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-percent"></i></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-block btn-success add-button" id='add_customer'>
                        <i class="far fa-plus-square"></i>
                        <span>أضافة عميل</span>
                      </button>
                      <div class="buttons">
                        @can('تعديل عميل')
                        <button class="btn btn-primary update-button" id='update_customer'>
                          <i class="far fa-edit"></i>
                          <span>تعديل عميل</span>
                        </button>
                        @endcan
                        @can('حذف عميل')
                        <button class="btn btn-danger remove-button" id='delete_customer'>
                          <i class="far fa-trash-alt"></i>
                          <span>حذف عميل</span>
                        </button>
                        @endcan
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@include('ajax.Customers.customer')
@endsection

