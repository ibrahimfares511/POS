<script>
    let _token = $('input[name="_token"]').val();
    let dateDIv = $(".date-time .date");
    let timeDIv = $(".date-time .time");
      /* =================== Add New Category ####################### */
  $('#add_employee').on('click',function (e) {
    e.preventDefault();
    let mybut  = $(this);
    let employee_name        = $('#employee_name').val();
    let salary_number        = $('#salary_number').val();
    let hours_of_work        = $('#hours_of_work').val();
    let dayes_of_work        = $('#dayes_of_work').val();
    let type_work            = $('#type_work option:selected').val();
    let inauguration_date    = $('#inauguration_date').val();
    let holidays_number      = $('#holidays_number').val();

    $.ajax({
      url: "{{route('save.staff')}}",
      method: 'post',
      enctype: "multipart/form-data",
      data: {
        _token             : _token,
        employee_name      : employee_name,  
        salary_number      : salary_number,  
        type_work          : type_work,
        dayes_of_work      : dayes_of_work, 
        hours_of_work      : hours_of_work,
        inauguration_date  : inauguration_date,
        holidays_number    : holidays_number, 
      },
      success: function (data) {
        if(data.status == 'true')
        {
          mybut
            .parents(".modal")
            .modal("hide");
          cuteToast({
            type: "success",
            message: "تم الاضافة بنجاح",
            timer: 2000
          });
        }
      },
      error: function (reject) {
        var response  = $.parseJSON(reject.responseText);
        $.each(response.errors , function (key, val)
        {
          $(`#${key}`).addClass('error');
          cuteToast({
            type: "error",
            message: val,
            timer: 4000
          });
        });
      }
    });

  });

  /* =================== Add New Category ####################### */
  $('#update_employee').on('click',function (e) {
    e.preventDefault();
   
    let mybut                = $(this);
    let serial               = mybut.parents('.modal').attr('row_id');
    let employee_name        = $('#employee_name').val();
    let salary_number        = $('#salary_number').val();
    let hours_of_work        = $('#hours_of_work').val();
    let dayes_of_work        = $('#dayes_of_work').val();
    let type_work            = $('#type_work option:selected').val();
    let inauguration_date    = $('#inauguration_date').val();
    let holidays_number      = $('#holidays_number').val();

    $.ajax({
      url: "{{route('update.staff')}}",
      method: 'post',
      enctype: "multipart/form-data",
      data: {
        _token             : _token,
        employee_name      : employee_name,  
        salary_number      : salary_number,  
        type_work          : type_work,
        dayes_of_work      : dayes_of_work, 
        hours_of_work      : hours_of_work,
        inauguration_date  : inauguration_date,
        holidays_number    : holidays_number, 
        serial             : serial
      },
      success: function (data) {
        if(data.status == 'true')
        {
          mybut
            .parents(".modal")
            .modal("hide");
          cuteToast({
            type: "success",
            message: "تم التعديل بنجاح",
            timer: 2000
          });
        }
      },
    });
  });

  /* ================== Search staff ####################### */
  $('#search').on('click',function (e) {
    e.preventDefault();
    let text = $('#search-item').val();
    $.ajax({
      url: "{{route('search.staff')}}",
      method: 'post',
      enctype: "multipart/form-data",
      data: {
        _token: _token,
        text  : text,
      },
      success: function (data) {
        let html = '';
        for(var count = 0 ; count < data.length ; count++)
        {
          html +=`
           <tr row_id='${data[count].id}'>
                <td> <span data-input='employee_name'>${data[count].employee}</span> </td>
                <td> <span data-input='salary_number'>${data[count].salary}</span> </td>
                <td> <span val="${data[count].job}" data-select='type_work'>${data[count].jobs.job}</span> </td>
                <td> <span data-input='dayes_of_work'>${data[count].day}</span> </td>
                <td> <span data-input='hours_of_work'>${data[count].hours}</span> </td>
                <td> <span data-input='inauguration_date'>${data[count].date_hiring}</span> </td>
                <td> <span data-input='holidays_number'>${data[count].vacation}</span> </td>
            </tr>`
        }
        $('tbody').html(html);

      }

    });
  });

  /* ================== Delete staff ####################### */
  $('.remove-button').on('click',function (e) {
    e.preventDefault();
    let mybut   = $(this);
    let serial  = mybut.parents('.modal').attr('row_id');
    let myModal = $(this).parents(".modal");
    let myRow = $(`tr[row_id='${serial}']`);
    cuteAlert({
      type: "question",
      title: "حذف الموظف",
      message: "هل متأكد انك تريد حذف الموظف ؟",
      confirmText: "موافق",
      cancelText: "إلغاء"
    }).then(e => {
      if (e == "confirm") {
        $.ajax({
          url: "{{route('delete.staff')}}",
          method: 'post',
          enctype: "multipart/form-data",
          data: {
            _token: _token,
            serial: serial,
          },
          success: function (data) {
            myRow.remove();
            myModal.modal("hide");
            cuteToast({
              type: "success",
              message: "تم الحذف بنجاح",
              timer: 2000
            });
          }
        });

      } else {
      }
    });
  });

  /* =================== Add add_discount_payment ####################### */
  $('#add_discount_payment').on('click',function (e) {
    e.preventDefault();
    let mybut  = $(this);
    let employee    = mybut.parents('.modal').attr('row_id');
    let val         = $('#val').val();
    let op          = $('#op').val();
    let op_name     = $('#op option:selected').text();
    let text        = $('#text').val();
    let date        = $('.date-time .date').text()
    $.ajax({
      url: "{{route('staff.payment')}}",
      method: 'post',
      enctype: "multipart/form-data",
      data: {
        _token    : _token,
        employee  : employee,  
        val       : val,  
        op        : op,
        op_name   : op_name,
        text      : text, 
        date      : date
      },
      success: function (data) {
        if(data.status == 'true')
        {
          mybut.parents(".modal").modal("hide");
          cuteToast({
            type: "success",
            message: "تم الاضافة بنجاح",
            timer: 2000
          });
        }
      },
    });

  });
  /* ======================= Change Select ===============================*/
  $('#staff-select').on('change', function() {
    let job = $(this).val();

    $.ajax({
      url: "{{route('change.select')}}",
      method: 'post',
      enctype: "multipart/form-data",
      data: {
        _token    : _token,
        job       : job,
        dateDIv   : dateDIv.text()
      },
      success: function (data) {
        let html = '';
        for(var count = 0 ; count < data.length ; count++)
        {
          html += `<tr row_id='${data[count].id}'>
                      <td><input type="checkbox" name='staff'></td>
                      <td>${data[count].id}</td>
                      <td>${data[count].employee}</td>`
          if(data[count].atendance.length > 0)
          {
            html +=   `<td class='attend'>${data[count].atendance[0].presence}</td>
                      <td class='leave'>${data[count].atendance[0].leave || ''}</td>
                      <td class='hours'>${data[count].hours}</td>
                      <td class='today'>${data[count].atendance[0].date}</td>
                    </tr>`
          }else{
            html +=   `<td class='attend'></td>
                      <td class='leave'></td>
                      <td class='hours'>${data[count].hours}</td>
                      <td class='today'></td>
                    </tr>`
          }

        }
        $('#payment_emp').html(html)
      },
    });
  });



  /* ======================= Attend Employee =========================== */
 $(".attend-employee-button").on('click', function() {
  let employeeCode = $(this)
      .parents(".modal")
      .find("#employee-select option:selected");

    let employeeArray = [];
    let operation     ="presence"
    let employeeObject = new Object;

    employeeObject.id = employeeCode.data("code");
    employeeObject.time = timeDIv.text();
    employeeObject.date = dateDIv.text();

    employeeArray.push(employeeObject)

    $.ajax({
      url: "{{route('absence.employee')}}",
      method: 'post',
      enctype: "multipart/form-data",
      data: {
        _token          : _token,
        employeeArray   : employeeArray,
        operation       : operation

      },
      success: function (data) {

      }
    });

 });

 /* ======================= Attend Staff =========================== */
 $(".attend-staff-button").on('click', function() {
  let staffTable = $(".staff-table tbody").find("tr.active");

    let employeeArray = [];
    let operation     ="presence"

    staffTable.each(function() {
      let employeeObject = new Object;

      employeeObject.id = $(this).attr('row_id');
      employeeObject.time = timeDIv.text();
      employeeObject.date = dateDIv.text();

      employeeArray.push(employeeObject);
    });

    $.ajax({
      url: "{{route('absence.employee')}}",
      method: 'post',
      enctype: "multipart/form-data",
      data: {
        _token          : _token,
        employeeArray   : employeeArray,
        operation       : operation
      },
      success: function (data) {

      },
    });
 });

 /* ====================== Leave Staff & employee =================== */
 $(".leave-button").on('click', function() {
  let employeeRow = $(this)
      .parents(".tab-pane")
      .find(".fl-table tr.active");

      let employeeArray = []
      let operation     ="leave"


  employeeRow.each(function() {
    let employeeObject = new Object;

    employeeObject.id = $(this).attr('row_id');
    employeeObject.time = timeDIv.text();
    employeeObject.date = dateDIv.text();

    employeeArray.push(employeeObject);
  });
  $.ajax({
      url: "{{route('absence.employee')}}",
      method: 'post',
      enctype: "multipart/form-data",
      data: {
        _token          : _token,
        employeeArray   : employeeArray,
        operation       : operation

      },
      success: function (data) {

      },
    });
  })
</script>