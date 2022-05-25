@extends('layouts.app')

@section('content')
  <div id="wrapper" class='toggled-2'>
    @include('includes.sidebar')
    <div id="page-content-wrapper">
      <main class="py-4">
        <section>
          <div class="container">
            <div class="page-title">
              <h2> الاعمال </h2>
              <div class="title-buttons">
                <button class="btn btn-success"  data-toggle="modal" data-target="#add-job-modal">
                  <i class="far fa-plus-square"></i>
                  <span>أضافة عمل</span>
                </button>
              </div>
            </div>
            <div class="portlet mb-3">
              <form class='products-search'>
                <div class="row">
                  <div class="col-sm-8">
                    <div class="main-input input-group">
                      <input type="text" class="form-control" placeholder='بحث عن عمل محدد' id='search-item'>
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
                    <th>رقم العمل</th>
                    <th>اسم العمل</th>
                  </tr>
                </thead>
                <tbody>
                  <tr row_id='1'>
                    <td> <span class='row-id'>1</span> </td>
                    <td> <span data-input='job_name'>عامل</span> </td>
                  </tr>
                  <tr row_id='2'>
                    <td> <span class='row-id'>2</span> </td>
                    <td> <span data-input='job_name'>مدير</span> </td>
                  </tr>
                  <tr row_id='3'>
                    <td> <span class='row-id'>3</span> </td>
                    <td> <span data-input='job_name'>كاشير</span> </td>
                  </tr>
                </tbody>
                <tfoot class='d-none'>
                  <tr>
                    <td> <span class='row-id'></span> </td>
                    <td> <span data-input='job_name'></span> </td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </section>
      </main>
    </div>

    <!-- Add job Modal -->
    <div class="modal modal-info add-job-modal fade" id="add-job-modal" data-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <button type="button" class='close-modal' data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
          <div class="modal-content-form">
            <nav>
              <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-link active" id="job-tab" data-toggle="tab" href="#add-job" role="tab" aria-controls="add-job" aria-selected="true">العمل</a>
              </div>
            </nav>
            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="add-job" role="tabpanel" aria-labelledby="job-tab">
                <div class="add-job-form">
                  <form>
                    <div class="row">
                      <div class="col-12">
                        <label>اسم العمل</label>
                        <div class="main-input input-group mb-3">
                          <input type="text" class="form-control" placeholder='اسم العمل' data-value='job_name' required>
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-pen-alt"></i></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <button class="btn btn-block btn-success add-button" id='add_job'>
                          <i class="far fa-plus-square"></i>
                          <span>أضافة عمل</span>
                        </button>
                        <div class="buttons">
                          <button class="btn btn-primary update-button" id='update_job'>
                            <i class="far fa-edit"></i>
                            <span>تعديل عمل</span>
                          </button>
                          <button class="btn btn-danger remove-button" id='delete_job'>
                            <i class="far fa-trash-alt"></i>
                            <span>حذف عمل</span>
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
