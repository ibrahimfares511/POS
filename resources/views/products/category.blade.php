@php
$title = 'الأصناف';
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
              <div id="new_serial" value="{{$new_serial}}"></div>
              <h2> الأصناف </h2>
              <div class="title-buttons">
                @can('إضافة صنف')
                <button class="btn btn-success new-add"  data-toggle="modal" data-target="#add-category-modal">
                  <i class="far fa-plus-square"></i>
                  <span>أضافة صنف</span>
                </button>
                @endcan
              </div>
            </div>
            @can('بحث صنف')
            <div class="portlet mb-3">
              <form class='products-search'>
                <div class="row">
                  <div class="col-sm-8">
                    <div class="main-input input-group">
                      <input type="text"  class="form-control" placeholder='بحث عن صنف محدد' id='search-item'>
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
            </div>
            @endcan
            <div class="table-wrapper">
              <table class="fl-table view-table update-table">
                <thead>
                  <tr>
                    <th>رقم الصنف</th>
                    <th> اسم الصنف</th>
                    <th>عدد المنتجات</th>
                    <th>تفعيل</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($categories as $category)
                  <tr row_id='{{$category->id}}'>
                    <td> <span class='row-id'>{{$category->id}}</span> </td>
                    <td> <span data-input='category_name'>{{$category->name}}</span> </td>
                    <td> <span>{{$category->items}}</span> </td>
                    <td class='checkbox-td' onclick='event.stopPropagation()'>
                      <label class="checker">
                        @if($category->status == 1)
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
                    <td> <span data-input='row-id'></span> </td>
                    <td> <span data-input='category_name'></span> </td>
                    <td> <span></span> </td>
                    <td class='checkbox-td' onclick='event.stopPropagation()'>
                      <label class="checker">
                        <input class="checkbox" type="checkbox" checked/>
                        <div class="check-bg"></div>
                        <div class="checkmark">
                          <svg viewBox="0 0 100 100">
                            <path d="M20,55 L40,75 L77,27" fill="none" stroke="#FFF" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" />
                          </svg>
                        </div>
                      </label>
                    </td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </section>
      </main>
    </div>
    <!-- Add Category Modal -->
    <div class="modal modal-info add-category-modal fade" id="add-category-modal" data-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <button type="button" class='close-modal' data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
          <div class="modal-content-form">
            <nav>
              <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-link active" id="category-tab" data-toggle="tab" href="#add-category" role="tab" aria-controls="add-category" aria-selected="true">الصنف</a>
                @can('خصم صنف')
                <a class="nav-link" id="discount-tab" data-toggle="tab" href="#category-discount" role="tab" aria-controls="category-discount" aria-selected="false">الخصم</a>
                @endcan
              </div>
            </nav>
            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="add-category" role="tabpanel" aria-labelledby="category-tab">
                <div class="add-category-form">
                  <div class="row">
                      <div class="col-12">
                        <label>الكود</label>
                        <div class="main-input input-group mb-3">
                          <input type="number"  name="serial" id="serial" readonly class="form-control serial" data-value='row-id'>
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <label>اسم الصنف</label>
                        <div class="main-input input-group mb-3">
                          <input type="text" class="form-control" name="name_category" id="name_category" placeholder='اسم الصنف' data-value='category_name' required>
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-pen-alt"></i></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <button class="btn btn-block btn-success add-button" id='add_category'>
                          <i class="far fa-plus-square"></i>
                          <span>أضافة صنف</span>
                        </button>
                        <div class="buttons">
                          @can('تعديل صنف')
                          <button class="btn btn-primary update-button" id='update_category'>
                            <i class="far fa-edit"></i>
                            <span>تعديل صنف</span>
                          </button>
                          @endcan
                          @can('حذف صنف')
                          <button class="btn btn-danger remove-button" id='delete_category'>
                            <i class="far fa-trash-alt"></i>
                            <span>حذف صنف</span>
                          </button>
                          @endcan
                        </div>
                      </div>
                    </div>
                </div>
              </div>
              <div class="tab-pane fade" id="category-discount" role="tabpanel" aria-labelledby="discount-tab">
                <div class="add-discount-form">
                    <div class="row justify-content-center">
                      <div class="col-6">
                        <div class='checkbox-parent'>
                          <label class="checker">
                            <input class="checkbox" type="checkbox" checked/>
                            <div class="check-bg"></div>
                            <div class="checkmark">
                              <svg viewBox="0 0 100 100">
                                <path d="M20,55 L40,75 L77,27" fill="none" stroke="#FFF" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" />
                              </svg>
                            </div>
                          </label>
                          <span>سعر قطاعى</span>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class='checkbox-parent'>
                          <label class="checker">
                            <input class="checkbox" type="checkbox" checked/>
                            <div class="check-bg"></div>
                            <div class="checkmark">
                              <svg viewBox="0 0 100 100">
                                <path d="M20,55 L40,75 L77,27" fill="none" stroke="#FFF" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" />
                              </svg>
                            </div>
                          </label>
                          <span>سعر جملة</span>
                        </div>
                      </div>
                      <div class="col-md-10 my-4">
                        <label>الخصم</label>
                        <div class="main-input input-group">
                          <input type="text" class="form-control" placeholder='قيمة الخصم'>
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-percent"></i></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-10">
                        <button class="btn btn-block btn-success">
                          <i class="fas fa-check"></i>
                          <span>حفظ</span>
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
  </div>
@include('ajax.products.category')
@endsection
