@extends('layouts.app')

@section('content')
  <div id="wrapper" class='toggled-2'>
    @include('includes.sidebar')
    <div id="page-content-wrapper">
      <main class="py-4">
        <section>
          <div class="container">
            <div class="page-title">
              <h2> الفروع </h2>
              <div class="title-buttons">
                <button class="btn btn-success"  data-toggle="modal" data-target="#add-branch-modal">
                  <i class="far fa-plus-square"></i>
                  <span>أضافة فرع</span>
                </button>
              </div>
            </div>
            <div class="portlet mb-3">
              <form class='products-search'>
                <div class="row">
                  <div class="col-sm-8">
                    <div class="main-input input-group">
                      <input type="text" class="form-control" placeholder='بحث عن فرع محدد' id='search-item'>
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-filter"></i></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <input type="submit" value="بحث" class="btn btn-block ">
                  </div>
                </div>
              </form>
            </div>
            <div class="table-wrapper">
              <table class="fl-table view-table update-table">
                <thead>
                  <tr>
                    <th>رقم الفرع</th>
                    <th> اسم الفرع</th>
                    <th>تفعيل</th>
                  </tr>
                </thead>
                <tbody>
                  <tr row_id='1'>
                    <td> <span class='row-id'>1</span> </td>
                    <td> <span data-input='branch_name'>الاسماعيلية</span> </td>
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
                  <tr row_id='2'>
                    <td> <span class='row-id'>2</span> </td>
                    <td> <span data-input='branch_name'>طنطا</span> </td>
                    <td class='checkbox-td' onclick='event.stopPropagation()'>
                      <label class="checker">
                        <input class="checkbox" type="checkbox"/>
                        <div class="check-bg"></div>
                        <div class="checkmark">
                          <svg viewBox="0 0 100 100">
                            <path d="M20,55 L40,75 L77,27" fill="none" stroke="#FFF" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" />
                          </svg>
                        </div>
                      </label>
                    </td>
                  </tr>
                </tbody>
                <tfoot class='d-none'>
                  <tr>
                    <td> <span class='row-id'></span> </td>
                    <td> <span data-input='branch_name'></span> </td>
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

    <!-- Add branch Modal -->
    <div class="modal modal-info add-branch-modal fade" id="add-branch-modal" data-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <button type="button" class='close-modal' data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
          <div class="modal-content-form">
            <nav>
              <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-link active" id="branch-tab" data-toggle="tab" href="#add-branch" role="tab" aria-controls="add-branch" aria-selected="true">الفرع</a>
              </div>
            </nav>
            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="add-branch" role="tabpanel" aria-labelledby="branch-tab">
                <div class="add-branch-form">
                  <form>
                    <div class="row">
                      <div class="col-12">
                        <label>اسم الفرع</label>
                        <div class="main-input input-group mb-3">
                          <input type="text" class="form-control" placeholder='اسم الفرع' data-value='branch_name' required>
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-pen-alt"></i></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <button class="btn btn-block btn-success add-button" id='add_branch'>
                          <i class="far fa-plus-square"></i>
                          <span>أضافة فرع</span>
                        </button>
                        <div class="buttons">
                          <button class="btn btn-primary update-button" id='update_branch'>
                            <i class="far fa-edit"></i>
                            <span>تعديل فرع</span>
                          </button>
                          <button class="btn btn-danger remove-button" id='delete_branch'>
                            <i class="far fa-trash-alt"></i>
                            <span>حذف فرع</span>
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
@endsection
