<script>
    let _token = $('input[name="_token"]').val();
      /* =================== Add New Category ####################### */
  $('#add_customer').on('click',function (e) {
    e.preventDefault();
    let mybut  = $(this);
    let customer_name    = $('#customer_name').val();
    let phone_number     = $('#phone_number').val();
    let id_number        = $('#id_number').val();
    let typecustomer     = $('#typecustomer').val();
    let typeName         = $('#typecustomer option:selected').text();
    let funds            = $('#funds').val() || 0;
    let debt             = $('#debt').val() || 0;
    let discount         = $('#discount').val() || 0;

    $.ajax({
      url: "{{route('save.customer')}}",
      method: 'post',
      enctype: "multipart/form-data",
      data: {
        _token          : _token,
        customer_name   : customer_name,  
        phone_number    : phone_number,  
        id_number       : id_number,
        typecustomer    : typecustomer, 
        funds           : funds,
        debt            : debt,
        discount        : discount, 
        typeName        : typeName,
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
  $('#update_customer').on('click',function (e) {
    e.preventDefault();
   
    let mybut            = $(this);
    let id               = mybut.parents('.modal').attr('row_id');
    let customer_name    = $('#customer_name').val();
    let phone_number     = $('#phone_number').val();
    let id_number        = $('#id_number').val();
    let typecustomer     = $('#typecustomer').val();
    let typeName         = $('#typecustomer option:selected').text();
    let funds            = $('#funds').val() || 0;
    let debt             = $('#debt').val() || 0;
    let discount         = $('#discount').val() || 0;

    $.ajax({
      url: "{{route('update.customer')}}",
      method: 'post',
      enctype: "multipart/form-data",
      data: {
        _token          : _token,
        customer_name   : customer_name,  
        phone_number    : phone_number,  
        id_number       : id_number,
        typecustomer    : typecustomer, 
        funds           : funds,
        debt            : debt,
        discount        : discount, 
        typeName        : typeName,
        id              : id
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

  
  /* ================== Active Customer #################### */
  $(document).on('change', '.checkbox-td input', function() {
    let serial = $(this).parents('tr').attr('row_id');
    let active = '';
    if ($(this).is(':checked')) {
      active = 1;
    } else {
      active = 0;
    }
    $.ajax({
      url: "{{route('active.customer')}}",
      method: 'post',
      enctype: "multipart/form-data",
      data: {
        _token: _token,
        serial: serial,
        active  : active
      },
      success: function (data) {
      }
    });
  });

  /* ================== Search Customer ####################### */
  $('#search').on('click',function (e) {
    e.preventDefault();
    let text = $('#search-item').val();
    $.ajax({
      url: "{{route('search.customer')}}",
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
            <td> <span data-input='customer_name'>${data[count].customer}</span> </td>
            <td> <span data-input='phone_number'>${data[count].custphone}</span> </td>
            <td> <span data-input='id_number'>${data[count].custid}</span> </td>
            <td> <span val="${data[count].typeid}" data-select="customer_type">${data[count].custtype}</span> </td>
            <td> <span data-input='funds'>${data[count].balance}</span> </td>
            <td> <span data-input='debt'>${data[count].debt}</span> </td>
            <td> <span data-input='customer_discount'>${data[count].discount}</span> </td>
            <td class='checkbox-td' onclick='event.stopPropagation()'>
              <label class="checker">`;

                if(data[count].status == 1){
                  html +=`<input class="checkbox" type="checkbox" checked/>`
                }
                else{
                  html +=`<input class="checkbox" type="checkbox"/>`
                }
                html +=`
                <div class="check-bg"></div>
                <div class="checkmark">
                  <svg viewBox="0 0 100 100">
                    <path d="M20,55 L40,75 L77,27" fill="none" stroke="#FFF" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                </div>
              </label>
            </td>
          </tr>`
        }
        $('tbody').html(html);

      }

    });
  });

  /* ================== Delete Customer ####################### */
  $('.remove-button').on('click',function (e) {
    e.preventDefault();
    let mybut   = $(this);
    let serial  = mybut.parents('.modal').attr('row_id');
    let myModal = $(this).parents(".modal");
    let myRow = $(`tr[row_id='${serial}']`);
    cuteAlert({
      type: "question",
      title: "حذف العميل",
      message: "هل متأكد انك تريد حذف العميل ؟",
      confirmText: "موافق",
      cancelText: "إلغاء"
    }).then(e => {
      if (e == "confirm") {
        $.ajax({
          url: "{{route('delete.customer')}}",
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
</script>