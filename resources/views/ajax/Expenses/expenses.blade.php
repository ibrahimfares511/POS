<script>
    let _token = $('input[name="_token"]').val();
    /* =================== Add New Expenses ####################### */
    $('#add-new-expense').on('click',function (e) {
        e.preventDefault();
        let mybut  = $(this);
        let new_expense = $('#new_expense').val();

        let expenseSelect = $("#expense-select").find("select");
        let expenseList = $("#expense-select").find(".select-option");

        let expenseOption = $(
        `<option value='${new_expense
            .trim()
            .split(" ")
            .join("-")}'>${new_expense}</option>`
        );

        let expenseItem = $(
        `<li class="search-item" data-value='${new_expense
            .trim()
            .split(" ")
            .join("-")}'>${new_expense} <span></span></li>`
        );


      $.ajax({
        url: "{{route('save.expense')}}",
        method: 'post',
        enctype: "multipart/form-data",
        data: {
          _token: _token,
          new_expense  : new_expense
        },
        success: function (data) {
          if(data.status == 'true')
          {
            expenseSelect.append(expenseOption);
            expenseList.append(expenseItem);
            expenseItem.click();
            $('#new_expense').val('')
            $('#new_expense').removeClass('error')
            cuteToast({
              type: "success",
              message: "تم الاضافة بنجاح",
              timer: 2000
            });
            serial++
            $('#new_serial').attr('value',serial);
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
    /* -================== Remove Expens Name #####################*/
    $(document).on('click', 'ul.expense-list li span', function(e) {
        e.stopPropagation();
        let expensItem = $(this).parents('li');
        let select = $(this).parents('.search-select');
        cuteAlert({
            type: "question",
            title: "حذف المصروف",
            message: "هل متأكد انك تريد حذف المصروف؟",
            confirmText: "موافق",
            cancelText: "إلغاء"
        }).then(e => {
            if (e == "confirm") {
            $.ajax({
                url: "{{route('delte.expense')}}",
                method: 'post',
                enctype: "multipart/form-data",
                data: {
                _token: _token,
                expens: expensItem.text(),
                },
                success: function (data) {
                    if (data.status == 'false') {
                        cuteToast({
                            type: "error",
                            message: "هذا المصروف تم عليه معاملات من قبل",
                            timer: 2500
                        });
                    } else if (data.status == 'true'){
                        expensItem.remove();
                        select.removeClass('choosed')
                        cuteToast({
                            type: "success",
                            message: "تم الحذف بنجاح",
                            timer: 2000
                        });
                    }
                },
            });
            } else {}
        });
    });
    /* =================== Add New Expenses ####################### */
    $('#add_expense').on('click',function (e) {
        e.preventDefault();
        let mybut  = $(this);
        let expense_name     = $('#expense_name').val()
        let expense_money    = $('#expense_money').val()
        let expense_note     = $('#expense_note').val()
        let expense_date     = $('#expense_date').val()
        let serial           = $('#new_serial').attr('value')
      $.ajax({
        url: "{{route('save.new.expense')}}",
        method: 'post',
        enctype: "multipart/form-data",
        data: {
            _token          : _token,
            expense_name    : expense_name,
            expense_money   : expense_money,
            expense_note    : expense_note,
            expense_date    : expense_date,
            serial          : serial
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
            serial++
            $('#new_serial').attr('value',serial);
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
    /* =================== Update New Expenses ####################### */
    $('#update_expense').on('click',function (e) {
        e.preventDefault();
        let mybut  = $(this);
        let expense_name     = $('#expense_name').val()
        let expense_money    = $('#expense_money').val()
        let expense_note     = $('#expense_note').val()
        let expense_date     = $('#expense_date').val()
        let serial           = $('#serial').val()
      $.ajax({
        url: "{{route('update.new.expense')}}",
        method: 'post',
        enctype: "multipart/form-data",
        data: {
            _token          : _token,
            expense_name    : expense_name,
            expense_money   : expense_money,
            expense_note    : expense_note,
            expense_date    : expense_date,
            serial          : serial,
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
            serial++
            $('#new_serial').attr('value',serial);
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
    /* ================== Delete Category ####################### */
    $('.remove-button').on('click',function (e) {
      e.preventDefault();
      let myModal = $(this).parents(".modal");
      let serial = $('#serial').val();
      let myRow = $(`tr[row_id='${serial}']`);
      cuteAlert({
        type: "question",
        title: "حذف المصروف",
        message: "هل متأكد انك تريد حذف المصروف؟",
        confirmText: "موافق",
        cancelText: "إلغاء"
      }).then(e => {
        if (e == "confirm") {
          $.ajax({
            url: "{{route('delete.sprending')}}",
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
              $('#new_serial').attr('value',data.serial);
              $('#name_uint').val('');
  
            }
          });
  
        } else {
        }
      });
    });
    /* ================== Search Unit ####################### */
    $('#search').on('click',function (e) {
      e.preventDefault();
      let search = $('#search-item').val();
      let type   = $('#expense-search').val();
      let to     = $('#date_to').val();
      let from     = $('#date_from').val();
      $.ajax({
        url: "{{route('search.sprending')}}",
        method: 'post',
        enctype: "multipart/form-data",
        data: {
          _token : _token,
          search : search,
          type   : type,
          from   : from,
          to     : to
        },
        success: function (data) {
          let html = '';
          for(var count = 0 ; count < data.length ; count++)
          {
              html += `
                <tr row_id='${data[count].id}'>
                    <td> <span class='row-id'>${data[count].id}</span> </td>
                    <td> <span  val="${data[count].expenses.id}" data-select='expense_name'>${data[count].expenses.name}</span> </td>
                    <td> <span data-input='expense_money'>${data[count].value}</span> </td>
                    <td> <span data-input='expense_date' class='date-today'>${data[count].date}</span> </td>
                    <td> <span data-input='expense_note'>${data[count].note}</span> </td>
                </tr>`
          }
          $('tbody').html(html);
  
        }
  
      });
    });

</script>