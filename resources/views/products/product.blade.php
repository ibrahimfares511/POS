@php
$title = 'المنتجات';
@endphp
@extends('layouts.app')

@section('content')
  <div id="wrapper" class='toggled-2'>
    @include('includes.sidebar')
    <div id="page-content-wrapper">
      <main class="py-4">
        <section class="products">
          <div class="container">
            <div class="page-title">
              <div id="new_serial" value="{{$new_serial}}"></div>
              <h2> المنتجات </h2>
              <div class="title-buttons">
                @can('إضافة تسعيرة')
                <button class="btn btn-primary"  data-toggle="modal" data-target="#add-pricing-modal">
                  <i class="far fa-plus-square"></i>
                  <span>أضافة تسعيرة</span>
                </button>
                @endcan
                @can('تصدير منتجات')
                <button class="btn btn-secondary">
                  <i class="fas fa-file-export"></i>
                  <span>تصدير</span>
                </button>
                @endcan
                @can('استراد منتجات')
                <button class="btn btn-secondary">
                  <i class="fas fa-file-import"></i>
                  <span>استيراد</span>
                </button>
                @endcan
                @can('إضافة منتج')
                <button class="btn btn-success new-add"  data-toggle="modal" data-target="#add-product-modal">
                  <i class="far fa-plus-square"></i>
                  <span>أضافة منتج</span>
                </button>
                @endcan
              </div>
            </div>
            <div class="portlet mb-3">
              <form class='products-search'>
                @can('بحث منتجات')
                <div class="row">
                  <div class="col-md-8">
                    <div class="main-input input-group">
                      <select class="custom-select" id="product-search">
                        <option value="" disabled selected></option>
                        <option value="all" >الجميع</option>
                        <option value="id" >رقم المنتج</option>
                        <option value="name">اسم المنتج</option>
                        <option value="cat">الصنف</option>
                        <option value="quan">الكمية</option>
                        <option value="halk">الهالك</option>
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
                      
                      <input type="text" class="form-control" placeholder='بحث عن منتج محدد' id='search-item'>
                      
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-filter"></i></span>
                      </div>
                    </div>
                  </div>
                 
                  <div class="col-md-4">
                    <input type="submit" value="بحث" id="search" class="btn btn-block ">
                  </div>
                  
                </div>
                @endcan
              </form>
            </div>
            <div class="table-wrapper">
              <table class="fl-table view-table update-table">
                <thead>
                  <tr>
                    <th>الكود</th>
                    <th> اسم المنتج</th>
                    <th>الصنف</th>
                    <th>الوحده</th>
                    <th>الكميه</th>
                    <th class='col-row-span-th' data-before='وحده' data-after='قطعة'>عدد القطع</th>
                    <th class='col-row-span-th' data-before='الطقم' data-after='القطعة'>سعر الجمله</th>
                    <th class='col-row-span-th' data-before='الطقم' data-after='القطعة'>سعر القطاعى</th>
                    <th class='col-row-span-th' data-before='الطقم' data-after='القطعة'>سعر الشراء</th>
                    <th>تفعيل</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                  <tr row_id={{$product->id}}>
                    <td> <span data-input='barcode'>{{$product->code}}</span> </td>
                    <td> <span data-input='product_name'>{{$product->name}}</span> </td>
                    <td> <span data-select='product_category' val="{{$product->category_id}}">{{$product->category->name}}</span> </td>
                    <td> <span data-select='product_unit' val="{{$product->unit_id}}">{{$product->unit->name}}</span> </td>
                    <td> <span data-input='item_quant'>{{$product->quan}}</span> </td>
                    <td class='col-row-span'>
                      <div>
                        <span data-input='item_pieces'>{{$product->pieces}}</span>
                        <span data-input='item_unit_number'>{{$product->total_pieces}}</span>
                      </div>
                    </td>
                    <td class='col-row-span'>
                      <div>
                        <span data-input='wholesale_price_pieces'>{{$product->saleprice_p * $product->pieces}}</span>
                        <span data-input='wholesale_price_piece'>{{$product->saleprice_p}}</span>
                      </div>
                    </td>
                    <td class='col-row-span'>
                      <div>
                        <span data-input='retail_price_pieces'>{{$product->price_p * $product->pieces}}</span>
                        <span data-input='retail_price_piece'>{{$product->price_p}}</span>
                      </div>
                    </td>
                    <td class='col-row-span'>
                      <div>
                        <span data-input='buy_price_pieces'>{{$product->pricelist_p * $product->pieces}}</span>
                        <span data-input='buy_price_piece'>{{$product->pricelist_p}}</span>
                      </div>
                    </td>
                    <td class='checkbox-td' onclick='event.stopPropagation()'>
                      <label class="checker">
                        @if($product->status == 1)
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
                    <td style='display: none'>
                      <span data-input='minimum_product'>{{$product->min_quantity}}</span>
                    </td>
                  </tr>
                @endforeach
                </tbody>
                <tfoot class='d-none'>
                  <tr>
                    <td> <span data-input='barcode'></span> </td>
                    <td> <span data-input='product_name'></span> </td>
                    <td> <span data-select='product_category'></span> </td>
                    <td> <span data-select='product_unit'></span> </td>
                    <td> <span data-input='item_quant'></span> </td>
                    <td class='col-row-span'>
                      <div>
                        <span data-input='item_pieces'></span>
                        <span data-input='item_unit_number'></span>
                      </div>
                    </td>
                    <td class='col-row-span'>
                      <div>
                        <span data-input='wholesale_price_pieces'></span>
                        <span data-input='wholesale_price_piece'></span>
                      </div>
                    </td>
                    <td class='col-row-span'>
                      <div>
                        <span data-input='retail_price_pieces'></span>
                        <span data-input='retail_price_piece'></span>
                      </div>
                    </td>
                    <td class='col-row-span'>
                      <div>
                        <span data-input='buy_price_pieces'></span>
                        <span data-input='buy_price_piece'></span>
                      </div>
                    </td>
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
                    <td style='display: none'>
                      <span data-input='minimum_product'>3</span>
                    </td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </section>
      </main>
    </div>
    <!-- Add Product Modal -->
    <div class="modal modal-info add-product-modal fade" id="add-product-modal" data-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <button type="button" class='close-modal' data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
          <div class="modal-content-form">
            <nav>
              <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#add-product" role="tab" aria-controls="add-product" aria-selected="true">المنتج</a>
                @can('الخصم منتجات')
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#product-discount" role="tab" aria-controls="product-discount" aria-selected="false">الخصم</a>
                @endcan
                @can('الهالك منتجات')
                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#product-lost" role="tab" aria-controls="product-lost" aria-selected="false">الهالك</a>
                @endcan
              </div>
            </nav>
            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="add-product" role="tabpanel" aria-labelledby="home-tab">
                <div class="add-product-form">
                  <div class="row">
                      <div class="col-12">
                        <label>رقم المنتج</label>
                        <div class="main-input input-group mb-3">
                          <input type="number"  name="serial" id="serial" readonly class="form-control serial" data-value='row-id'>
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <label>الكود</label>
                        <div class="main-input input-group mb-3">
                          <input type="text" name="code" id="code" class="form-control" placeholder='الكود' data-value='barcode'>
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                          </div>
                        </div>
                      </div>

                      <div class="col-12">
                        <label>اسم المنتج</label>
                        <div class="main-input input-group mb-3">
                          <input type="text" name="name" id="name" class="form-control" placeholder='اسم المنتج' data-value='product_name' required>
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-pen-alt"></i></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-6">
                        <label>الوحده</label>
                        <div class="main-input input-group mb-3">
                          <select id="unit_id" name="unit" class="custom-select" data-value="product_unit">
                            <option value="" disabled selected></option>
                          @foreach($units as $unit)
                            <option value="{{$unit->id}}">{{$unit->name}}</option>
                            @endforeach
                          </select>
                          <div class='search-select'>
                            <div class='label-Select'>
                              <label>حدد الوحده</label>
                              <span class="select-value"></span>
                              <i class="fa fa-chevron-down arrow"></i>
                            </div>
                            <div class='input-options'>
                              <input autocomplete="off" type='text' class="search-input"  placeholder="بحث" />
                              <ul class='select-option' data-value="product_unit"></ul>
                            </div>
                          </div>
                          <div class="input-group-prepend">
                            <label class="input-group-text" for="product_unit"><i class="fas fa-weight-hanging"></i></label>
                          </div>
                        </div>
                      </div>
                      <div class="col-6">
                        <label>الاصناف</label>
                        <div class="main-input input-group mb-3">
                          <select id="category_id" name="category" class="custom-select" data-value="product_category">
                            <option value="" disabled selected></option>
                            @foreach($categories as $category)
                            <option value="{{$category->id}}"> {{$category->name}}</option>
                            @endforeach
                          </select>
                          <div class='search-select'>
                            <div class='label-Select'>
                              <label>حدد الصنف</label>
                              <span class="select-value"></span>
                              <i class="fa fa-chevron-down arrow"></i>
                            </div>
                            <div class='input-options'>
                              <input autocomplete="off" type='text' class="search-input"  placeholder="بحث" />
                              <ul class='select-option' data-value="product_category"></ul>
                            </div>
                          </div>
                          <div class="input-group-prepend">
                            <label class="input-group-text" for="product_unit"><i class="fab fa-elementor"></i></label>
                          </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <label>الكمية</label>
                        <div class="main-input input-group mb-3">
                          <input name="quantity" id="quan" type="number" min='1' class="form-control" placeholder='الكمية' data-value='item_quant' required>
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-cubes"></i></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <label>عدد القطع</label>
                        <div class="main-input input-group mb-3">
                          <input name="pieces" type="number" min='1' class="form-control" placeholder='عدد القطع' data-value='item_pieces' id='pieces'>
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-cube"></i></span>
                          </div>
                          <p class='input-message' >اجمالى عدد القطع : <input type="number" id="total_pieces" value='0' data-value='item_unit_number' disabled></p>
                        </div>
                      </div>
                      <div class="col-12">
                        <label>سعر الجملة</label>
                        <div class="main-input input-group mb-3">
                          <input id="saleprice_q" type="number" min='1' class="form-control" placeholder='سعر الجمله' data-value='wholesale_price_pieces' required>
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-money-bill"></i></span>
                          </div>
                          <p class='input-message' >سعر القطعه فى الجمله : <input type="number" id="saleprice_p" value='0' data-value='wholesale_price_piece' disabled></p>
                        </div>
                      </div>
                      <div class="col-12">
                        <label>سعر القطاعى</label>
                        <div class="main-input input-group mb-3">
                          <input id="price_q" type="number" min='1' class="form-control" placeholder='سعر القطاعى' data-value='retail_price_pieces' required>
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-money-bill-alt"></i></span>
                          </div>
                          <p class='input-message' >سعر القطعه فى القطاعى :  <input type="number" id="price_p" value='0' data-value='retail_price_piece' disabled></p>
                        </div>
                      </div>
                      <div class="col-12">
                        <label>سعر الشراء</label>
                        <div class="main-input input-group mb-3">
                          <input id="pricelist_q" type="number" min='1' class="form-control" placeholder='سعر الشراء' data-value='buy_price_pieces' required>
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-money-bill-alt"></i></span>
                          </div>
                          <p class='input-message' >سعر القطعه عند الشراء : <input type="number" id="pricelist_p" value='0' data-value='buy_price_piece' disabled></p>
                        </div>
                      </div>
                      <div class="col-12">
                        <label>حد الطلب</label>
                        <div class="main-input input-group mb-3">
                          <input type="number" id="min_quantity" min='1' class="form-control" placeholder='حد الطلب' data-value='minimum_product' required>
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-terminal"></i></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <label>انتهاء الصلاحية</label>
                        <div class="main-input input-group mb-3">
                          <input type="date" class="form-control" id="expired" data-value='inauguration_date' required>
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <button class="btn btn-block btn-success add-button" id='add_product'>
                          <i class="far fa-plus-square"></i>
                          <span>أضافة منتج</span>
                        </button>
                        <div class="buttons">
                          @can('تعديل منتج')
                          <button class="btn btn-primary update-button" id='update_product'>
                            <i class="far fa-edit"></i>
                            <span>تعديل المنتج</span>
                          </button>
                          @endcan
                          @can('حذف منتج')
                          <button class="btn btn-danger remove-button" id='delete_product'>
                            <i class="far fa-trash-alt"></i>
                            <span>حذف المنتج</span>
                          </button>
                          @endcan
                        </div>
                      </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="product-discount" role="tabpanel" aria-labelledby="profile-tab">
                <div class="add-discount-form">
                  <form>
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
                  </form>
                </div>
              </div>
              <div class="tab-pane fade" id="product-lost" role="tabpanel" aria-labelledby="contact-tab">
                <div class="add-lost-form">
                  <form>
                    <div class="row">
                      <div class="col-12">
                        <label>الكود</label>
                        <div class="main-input input-group mb-3">
                          <input type="text" class="form-control" placeholder='الكود' data-value='barcode' id="d_barcode" disabled>
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <label>اسم المنتج</label>
                        <div class="main-input input-group mb-3">
                          <input type="text" class="form-control" placeholder='اسم المنتج' data-value='product_name' id="d_product_name" required disabled>
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-pen-alt"></i></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <label>الكمية</label>
                        <div class="main-input input-group mb-3">
                          <input type="number" min='1' class="form-control" placeholder='الكمية' data-value='item_quant' id="d_item_quant" value='1' disabled>
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-cubes"></i></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <label>عدد القطع</label>
                        <div class="main-input input-group mb-3">
                          <input type="number" min='1' class="form-control" placeholder='عدد القطع' data-value='item_pieces' id="d_item_pieces">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-cube"></i></span>
                          </div>
                          <p class='input-message'> اجمالى عدد القطع الهالكة : <input type="number" value='0' data-value='item_pieces' id="d_items_pieces" disabled></p>
                        </div>
                      </div>
                      <div class="col-12">
                        <label>سعر الجملة للقطعة الواحده</label>
                        <div class="main-input input-group mb-3">
                          <input type="number" min='1' class="form-control" placeholder='سعر الجمله' data-value='wholesale_price_piece' id="d_wholesale_price_piece" required>
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-money-bill"></i></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <label>سعر القطاعى للقطعة الواحده</label>
                        <div class="main-input input-group mb-3">
                          <input type="number" min='1' class="form-control" placeholder='سعر القطاعى' data-value='retail_price_piece' id="d_retail_price_piece" required>
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-money-bill-alt"></i></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <label>سعر الشراء للقطعة الواحده</label>
                        <div class="main-input input-group mb-3">
                          <input type="number" min='1' class="form-control" placeholder='سعر الشراء'  data-value='buy_price_piece' id="d_buy_price_piece" required>
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-money-bill-alt"></i></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <button class="btn btn-block btn-success" id="save_damaged">
                          <i class="fas fa-check"></i>
                          <span>حفظ</span>
                        </button>
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
    <!-- Add Pricing Modal -->
    <div class="modal add-pricing-modal second-modal fade" id="add-pricing-modal" data-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <button type="button" class='close-modal' data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
          <div class="modal-content-form" style='overflow: unset'>
            <nav>
              <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-link active" id="increase-tab" data-toggle="tab" href="#increase" role="tab" aria-controls="increase" aria-selected="true">زيادة</a>
                <a class="nav-link" id="decrease-tab" data-toggle="tab" href="#decrease" role="tab" aria-controls="decrease" aria-selected="false">النقصان</a>
              </div>
            </nav>
            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="increase" role="tabpanel" aria-labelledby="increase-tab">
                <div class="increase-form">
                  <div class="row">
                    <div class="col-12">
                      <label>الاصناف</label>
                      <div class="main-input input-group mb-3">
                        <select class="custom-select quant">
                          <option value="" disabled selected></option>
                          <option value="all" >جميع الأصناف</option>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}"> {{$category->name}}</option>
                          @endforeach
                        </select>
                        <div class='search-select'>
                          <div class='label-Select'>
                            <label>حدد الصنف</label>
                            <span class="select-value"></span>
                            <i class="fa fa-chevron-down arrow"></i>
                          </div>
                          <div class='input-options'>
                            <input autocomplete="off" type='text' class="search-input"  placeholder="بحث" />
                            <ul class='select-option' data-value="product_category"></ul>
                          </div>
                        </div>
                        <div class="input-group-prepend">
                          <label class="input-group-text" for="product_unit"><i class="fab fa-elementor"></i></label>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <label>السعر</label>
                      <div class="main-input input-group mb-3">
                        <select class="custom-select price">
                          <option value="" disabled selected></option>
                          <option value="all">جميع الاسعار</option>
                          <option value="1">جملة</option>
                          <option value="2">قطاعى</option>
                          <option value="3">شراء</option>
                        </select>
                        <div class='search-select'>
                          <div class='label-Select'>
                            <label>حدد السعر</label>
                            <span class="select-value"></span>
                            <i class="fa fa-chevron-down arrow"></i>
                          </div>
                          <div class='input-options'>
                            <input autocomplete="off" type='text' class="search-input"  placeholder="بحث" />
                            <ul class='select-option'></ul>
                          </div>
                        </div>
                        <div class="input-group-prepend">
                          <label class="input-group-text" for="product_unit"><i class="fab fa-elementor"></i></label>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <label>قيمة الزيادة</label>
                      <div class="main-input input-group">
                        <input type="text" class="form-control deciinc-val" placeholder='قيمة الزيادة'>
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-percent"></i></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 mt-3">
                      <button class="btn btn-block btn-success dec-increase"  data-type='increase'>
                        <i class="fas fa-check"></i>
                        <span>حفظ</span>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="decrease" role="tabpanel" aria-labelledby="decrease-tab">
                <div class="decrease-form">
                  <div class="row">
                    <div class="col-12">
                      <label>الاصناف</label>
                      <div class="main-input input-group mb-3">
                        <select class="custom-select quant">
                          <option value="" disabled selected></option>
                          <option value="all" >جميع الأصناف</option>
                          @foreach($categories as $category)
                            <option value="{{$category->id}}"> {{$category->name}}</option>
                          @endforeach
                        </select>
                        <div class='search-select'>
                          <div class='label-Select'>
                            <label>حدد الصنف</label>
                            <span class="select-value"></span>
                            <i class="fa fa-chevron-down arrow"></i>
                          </div>
                          <div class='input-options'>
                            <input autocomplete="off" type='text' class="search-input"  placeholder="بحث" />
                            <ul class='select-option'></ul>
                          </div>
                        </div>
                        <div class="input-group-prepend">
                          <label class="input-group-text" for="product_unit"><i class="fab fa-elementor"></i></label>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <label>السعر</label>
                      <div class="main-input input-group mb-3">
                        <select class="custom-select price">
                          <option value="" disabled selected></option>
                          <option value="all">جميع الاسعار</option>
                          <option value="1" >جملة</option>
                          <option value="2" >قطاعى</option>
                          <option value="3" >شراء</option>
                        </select>
                        <div class='search-select'>
                          <div class='label-Select'>
                            <label>حدد السعر</label>
                            <span class="select-value"></span>
                            <i class="fa fa-chevron-down arrow"></i>
                          </div>
                          <div class='input-options'>
                            <input autocomplete="off" type='text' class="search-input"  placeholder="بحث" />
                            <ul class='select-option'></ul>
                          </div>
                        </div>
                        <div class="input-group-prepend">
                          <label class="input-group-text" for="product_unit"><i class="fab fa-elementor"></i></label>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <label>قيمة النقصان</label>
                      <div class="main-input input-group">
                        <input type="text" class="form-control deciinc-val" placeholder='قيمة النقصان'>
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-percent"></i></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 mt-3">
                      <button class="btn btn-block btn-success dec-increase" data-type='decrease'>
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
  @include('ajax.products.products')
@endsection

