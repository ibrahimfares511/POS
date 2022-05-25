@php
$title = 'الوحدات';
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
              <h2> الوحدات </h2>
              <div class="title-buttons">
                @can('إضافة وحدة')
                <button class="btn btn-success new-add"  data-toggle="modal" data-target="#add-unit-modal">
                  <i class="far fa-plus-square"></i>
                  <span>أضافة وحدة</span>
                </button>
                @endcan
              </div>
            </div>
            <div class="portlet mb-3">
              <form class='products-search'>
                @can('بحث وحدة')
                <div class="row">
                  <div class="col-sm-8">
                    <div class="main-input input-group">
                      <input type="text" class="form-control" id="search_value" placeholder='بحث عن وحدة محدد' id='search-item'>
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-filter"></i></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <input type="submit" id="search"  value="بحث" class="btn btn-block ">
                  </div>
                </div>
                @endcan
              </form>
            </div>
            <div class="table-wrapper">
              <table class="fl-table view-table update-table">
                <thead>
                  <tr>
                    <th>رقم الوحدة</th>
                    <th>اسم الوحدة</th>
                    <th>تفعيل</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($units as $unit)
                  <tr row_id='{{$unit->id}}'>
                    <td> <span data-input='row-id'>{{$unit->id}}</span> </td>
                    <td> <span data-input='unit_name'>{{$unit->name}}</span> </td>
                    <td class='checkbox-td' onclick='event.stopPropagation()'>
                      <label class="checker">
                        @if($unit->status == 1)
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
                    <td> <span data-input='unit_name'></span> </td>
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
            {{$units->links()}}
          </div>
        </section>
      </main>
    </div>


    <!-- Add Unit Modal -->
    <div class="modal modal-info add-unit-modal fade" id="add-unit-modal" data-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <button type="button" class='close-modal' data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
          <div class="modal-content-form">
            <nav>
              <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-link active" id="unit-tab" data-toggle="tab" href="#add-unit" role="tab" aria-controls="add-unit" aria-selected="true">الوحدة</a>
              </div>
            </nav>
            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="add-unit" role="tabpanel" aria-labelledby="unit-tab">
                <div class="add-unit-form">
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
                        <label>اسم الوحدة</label>
                        <div class="main-input input-group mb-3">
                          <input type="text" class="form-control" id="unit" name="unit" placeholder='اسم الوحدة' data-value='unit_name' required>
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-pen-alt"></i></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <button class="btn btn-block btn-success add-button" id='save_unit'>
                          <i class="far fa-plus-square"></i>
                          <span>أضافة وحدة</span>
                        </button>
                        <div class="buttons">
                          @can('تعديل وحدة')
                          <button class="btn btn-primary update-button" id='update_unit'>
                            <i class="far fa-edit"></i>
                            <span>تعديل وحدة</span>
                          </button>
                          @endcan
                          @can('مسح وحدة')
                          <button class="btn btn-danger remove-button" id='delete_unit'>
                            <i class="far fa-trash-alt"></i>
                            <span>حذف وحدة</span>
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
  @include('ajax.products.units')
  @endsection
