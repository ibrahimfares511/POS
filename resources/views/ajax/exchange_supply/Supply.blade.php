<script>
  let _token = $('input[name="_token"]').val();
  let date = $(".date-time .date");
  let time = $(".date-time .time");
  /* =================== Add New Expenses ####################### */
  $('#add_supply').on('click',function (e) {
        e.preventDefault();
        let mybut  = $(this);
        let customer    = $('#customer').val()
        let supply_name = $('#supply_forHim').val()
        let paid_amount = $('#paid_amount').val()
        let note        = $('#note').val()

      $.ajax({
        url: "{{route('save.supply')}}",
        method: 'post',
        enctype: "multipart/form-data",
        data: {
          _token         : _token,
           customer      : customer,
           supply_name   : supply_name,
           paid_amount   : paid_amount,
           note          : note,
           date          : date.text(),
           time          : time.text()
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
            $('#new_serial').attr('value',data.serial);
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

    $('#search').on('click',function (e) {
      e.preventDefault();
      let search   = $('#search-item').val();
      let type     = $('#expense-search').val();
      let to       = $('#date_to').val();
      let from     = $('#date_from').val();
      let checkdel = $('#delper').attr('value')

      $.ajax({
        url: "{{route('search.supply')}}",
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
                    <td> <span data-select='supply_name'>${data[count].customers.customer}</span> </td>
                    <td> <span data-input='supply_money'>${data[count].val}</span> </td>
                    <td> <span data-input='supply_forHim'>${data[count].forhim}</span> </td>
                    <td> <span data-input='supply_note'>${data[count].date}</span> </td>
                    <td> <span data-input='supply_note'>${data[count].note}</span> </td>`

                    if(checkdel == 'del')
                    {
                      html+=`<td class='remove-row' mony="${data[count].val}" op="${data[count].id}" customer="${data[count].customers.id}"> <button class='btn btn-block btn-danger rounded-0'><i class="far fa-trash-alt"></i></button> </td>`
                    }

                  html+=`</tr>`
          }
          $('tbody').html(html);
  
        }
  
      });
    });

    $('.remove-row').on('click',function (e) {
        e.preventDefault();
        let mybut    = $(this);
        let op       = mybut.attr('op');
        let customer = mybut.attr('customer');
        let mony     = mybut.attr('mony');
        cuteAlert({
        type: "question",
        title: "حذف الموظف",
        message: "هل متأكد انك تريد حذف الصرف ؟",
        confirmText: "موافق",
        cancelText: "إلغاء"
      }).then(e => {
        if (e == "confirm") {
          $.ajax({
            url: "{{route('delete.supply')}}",
            method: 'post',
            enctype: "multipart/form-data",
            data: {
              _token   : _token,
              op       : op,
              customer : customer,
              mony     : mony,
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
</script>