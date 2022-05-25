<script>
  let _token = $('input[name="_token"]').val();
  /* ================== Add New Product ####################### */
  $('#add_product').on('click',function (e) {
    e.preventDefault();
    let mybut         = $(this);
    let serial        = $('#serial').val();
    let name          = $('#name').val();
    let code          = $('#code').val();
    let unit_id       = $('#unit_id').val();
    let category_id   = $('#category_id').val();
    let quan          = $('#quan').val();
    let pieces        = $('#pieces').val();
    let total_pieces  = $('#total_pieces').val();
    let saleprice_p   = $('#saleprice_p').val();
    let price_p       = $('#price_p').val();
    let pricelist_p   = $('#pricelist_p').val();
    let min_quantity  = $('#min_quantity').val();
    let expired       = $('#expired').val() || '0';

    if (code === '') {
      code = serial
    }
    $.ajax({
      url: "{{route('save.product')}}",
      method: 'post',
      enctype: "multipart/form-data",
      data: {
        _token: _token,
        serial:serial,
        name  :name,
        code:code,
        unit_id:unit_id,
        category_id:category_id,
        quan:quan,
        pieces:pieces,
        total_pieces :total_pieces,
        saleprice_p:saleprice_p,
        price_p:price_p,
        pricelist_p:pricelist_p,
        min_quantity:min_quantity,
        expired:expired,
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
          $('#name_uint').val('');
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
  /* ================== Update Product ####################### */
  $('#update_product').on('click',function (e) {
    e.preventDefault();
    let mybut  = $(this);
    let serial        = $('#serial').val();
    let name          = $('#name').val();
    let code          = $('#code').val();
    let unit_id          = $('#unit_id').val();
    let category_id      = $('#category_id').val();
    let quan          = $('#quan').val();
    let pieces        = $('#pieces').val();
    let total_pieces  = $('#total_pieces').val();
    let saleprice_p   = $('#saleprice_p').val();
    let price_p       = $('#price_p').val();
    let pricelist_p   = $('#pricelist_p').val();
    let min_quantity  = $('#min_quantity').val();
    $.ajax({
      url: "{{route('update.product')}}",
      method: 'post',
      enctype: "multipart/form-data",
      data: {
        _token: _token,
        serial :serial,
        name  :name,
        code:code,
        unit_id:unit_id,
        category_id:category_id,
        quan:quan,
        pieces:pieces,
        total_pieces :total_pieces,
        saleprice_p:saleprice_p,
        price_p:price_p,
        pricelist_p:pricelist_p,
        min_quantity:min_quantity,
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
          $('#name_uint').val('');
        }
      }
    });
  });
  /* ================== Active Product #################### */
  $(document).on('change', '.checkbox-td input', function() {
    let serial = $(this).parents('tr').attr('row_id');
    let active = '';
    if ($(this).is(':checked')) {
      active = 1;
    } else {
      active = 0;
    }
    $.ajax({
      url: "{{route('active.product')}}",
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
  /* ================== Damaged Products ############## */
  $('#save_damaged').on('click', function(e) {
    e.preventDefault();
    let mybut         = $(this);
    let d_product_name = $("#d_product_name").val();
    let d_barcode = $("#d_barcode").val();
    let d_item_quant = $('#d_item_quant').val();
    let d_item_pieces = $('#d_item_pieces').val();
    let d_items_pieces = $('#d_items_pieces').val();
    let d_wholesale_price_piece = $('#d_wholesale_price_piece').val();
    let d_retail_price_piece = $('#d_retail_price_piece').val();
    let d_buy_price_piece = $('#d_buy_price_piece').val();
    $.ajax({
      url: "{{route('damaged.product')}}",
      method: 'post',
      enctype: "multipart/form-data",
      data: {
        _token  : _token,
        d_product_name : d_product_name,
        d_barcode : d_barcode,
        d_item_quant : d_item_quant,
        d_item_pieces : d_item_pieces,
        d_items_pieces : d_items_pieces,
        d_wholesale_price_piece : d_wholesale_price_piece,
        d_retail_price_piece : d_retail_price_piece,
        d_buy_price_piece : d_buy_price_piece,
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
  /* =========================== Search Producrs ================== */
  $(document).on('click', '#search', function (e) {
    e.preventDefault();
    let type   = $('#product-search').val();
    let search = $('#search-item').val();
    console.log(type , search)
    $.ajax({
      url: "{{route('search.product')}}",
      method: 'post',
      enctype: "multipart/form-data",
      data: {
        _token: _token,
        search: search,
        type  : type
      },
      success: function (data) {
        let html = '';
        for(var count = 0 ; count < data.length ; count++)
        {
          html += `
          <tr row_id=${data[count].id}>
                    <td> <span data-input='barcode'>${data[count].code}</span> </td>
                    <td> <span data-input='product_name'>${data[count].name}</span> </td>
                    <td> <span data-select='product_category' val="${data[count].category_id}">${data[count].category.name}</span> </td>
                    <td> <span data-select='product_unit' val="${data[count].unit_id}">${data[count].name}</span> </td>
                    <td> <span data-input='item_quant'>${data[count].quan}</span> </td>
                    <td class='col-row-span'>
                      <div>
                        <span data-input='item_pieces'>${data[count].pieces}</span>
                        <span data-input='item_unit_number'>${data[count].total_pieces}</span>
                      </div>
                    </td>
                    <td class='col-row-span'>
                      <div>
                        <span data-input='wholesale_price_pieces'>${data[count].saleprice_p * data[count].pieces}</span>
                        <span data-input='wholesale_price_piece'>${data[count].saleprice_p}</span>
                      </div>
                    </td>
                    <td class='col-row-span'>
                      <div>
                        <span data-input='retail_price_pieces'>${data[count].price_p * data[count].pieces}</span>
                        <span data-input='retail_price_piece'>${data[count].price_p}</span>
                      </div>
                    </td>
                    <td class='col-row-span'>
                      <div>
                        <span data-input='buy_price_pieces'>${data[count].pricelist_p * data[count].pieces}</span>
                        <span data-input='buy_price_piece'>${data[count].pricelist_p}</span>
                      </div>
                    </td>
                    <td class='checkbox-td' onclick='event.stopPropagation()'>
                      <label class="checker">`;
                        if(data[count].status == 1)
                        {
                      html += `<input class="checkbox" type="checkbox" checked/>`
                        }else{
                         html += `<input class="checkbox" type="checkbox"/>`

                        }
                        html += `<div class="check-bg"></div>
                        <div class="checkmark">
                          <svg viewBox="0 0 100 100">
                            <path d="M20,55 L40,75 L77,27" fill="none" stroke="#FFF" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" />
                          </svg>
                        </div>
                      </label>
                    </td>
                    <td style='display: none'>
                      <span data-input='minimum_product'>${data[count].min_quantity}</span>
                    </td>
                  </tr>`
        }$('tbody').html(html);
      }
    });

  });
    // ===== Start Decrase And Increas =====
  $('.dec-increase').on('click', function() {
    let type = $(this).data('type')
    let modal = $(this).parents('.modal')

    modal.attr('type', type);

    let inputVal = $(this).parents('.row').find('.deciinc-val').val()
    let cate = $(this).parents('.row').find('.quant').val()
    let priceType = $(this).parents('.row').find('.price').val()
    let mybut  = $(this);
    $.ajax({
      url: "{{route('changesale.product')}}",
      method: 'post',
      enctype: "multipart/form-data",
      data: {
        _token  : _token,
        inputVal : inputVal,
        cate : cate,
        priceType : priceType,
        type      : type
      },
    success: function (data) {
      if(data.status == 'true')
      {
        mybut
          .parents(".modal")
          .modal("hide");
        cuteToast({
          type: "success",
          message: "تم تعديل الاسعار بنجاح",
          timer: 2000
        });
        $('#name_uint').val('');
      }
    }
    });
  });

</script>
