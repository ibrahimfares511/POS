<script>
    let _token  = $('input[name="_token"]').val();
    let dateDIv = $(".date-time .date");
    let timeDIv = $(".date-time .time");
    /* live search Search Item by using Name*/
    $('#item_name').keyup(function ()
    {
        var html = '';
        let op = 'name';
        let nameList = $(this).parents('.main-input').next('.item_name_list');
        let salesop = $('input[name="salesopration"]:checked').val();
        var query = $(this).val();
        
        if(query != '')
        {

          $.ajax({
              url:"{{route('Search.Name.halk')}}",
              method:'post',
              data:{query:query, _token:_token,op:op},
              success:function(data)
              {
                
                for(var count = 0 ; count < data.length ; count ++)
                {
                  html += `<li name_id="${data[count].code}">${data[count].name} <span>${(salesop == "gomla") ? parseFloat(data[count].saleprice_p).toFixed(2) : parseFloat(data[count].price_p).toFixed(2)}</span></li>`
                }
                nameList.html(html);
              }
          });
        }else{
          nameList.html('');
        }
    });

    /* live search Search Item by using Name*/
    $('#item_code').on('input', function () {
      var html = '';
      let op = 'code';
      let saletype = $('#saletype').attr('sale');
      let salesop = $('input[name="salesopration"]:checked').val();
      var query = $(this).val();
      if(query != '')
      {
          $.ajax({
              url:"{{route('Search.Name.halk')}}",
              method:'post',
              data:{query:query, _token:_token,op:op},
              success:function(data)
              {
                $('#item_name').val(data.name)
                  $('#item_name').attr('countval',data.pieces)
                  if(salesop == "gomla"){
                      $('#item_price').val(parseFloat(data.saleprice_p).toFixed(2))
                      $('#item_name').attr('price',parseFloat(data.saleprice_p).toFixed(2))
                      $('#item_name').attr('pricelist',parseFloat(data.pricelist_p).toFixed(2))
                  }else{
                      $('#item_price').val(parseFloat(data.price_p).toFixed(2))
                      $('#item_name').attr('price',parseFloat(data.price_p).toFixed(2))
                      $('#item_name').attr('pricelist',parseFloat(data.pricelist_p).toFixed(2))
                  }
                if(saletype == "direct")
                {
                  let job = $('#product_unit').val()
                  let price     = $('#item_name').attr('price')
                  let pricelist = $('#item_name').attr('pricelist')
                  let quant = $('#item_name').attr('countval')
                  if(job == 'one'){
                      $('#item_price').val(price)
                  }else if(job == 'all'){
                      $('#item_price').val(quant * price)
                      $('#item_name').attr('pricelist',quant * pricelist)
                  }
                  $('#add-cart').click();
                  $('#item_code').val('')
                  $('#item_name').val('')
                  $('#discount_ratio').val('')
                }
              }
          });
      }else{
          $('#item_name').val('')
          $('#item_price').val('')
      }
    });

    $(document).on('click', '.item_name_list li', function() {
      let query = $(this).attr('name_id');
      $('#item_code').val(query);
      var html = '';
      let op = 'code';
      let saletype = $('#saletype').attr('sale');
      let salesop = $('input[name="salesopration"]:checked').val();

      if(query != '')
      {
          $.ajax({
              url:"{{route('Search.Name.halk')}}",
              method:'post',
              data:{query:query, _token:_token,op:op},
              success:function(data)
              {
                $('#item_name').val(data.name)
                $('#item_name').attr('countval',data.pieces)
                if(salesop == "gomla"){
                      $('#item_price').val(parseFloat(data.price_p).toFixed(2))
                      $('#item_name').attr('price',parseFloat(data.price_p).toFixed(2))
                      $('#item_name').attr('pricelist',parseFloat(data.pricelist_p).toFixed(2))
                  }else{
                      $('#item_price').val(parseFloat(data.saleprice_p).toFixed(2))
                      $('#item_name').attr('price',parseFloat(data.saleprice_p).toFixed(2))
                      $('#item_name').attr('pricelist',parseFloat(data.pricelist_p).toFixed(2))
                  }
                if(saletype == "direct")
                {
                  let job = $('#product_unit').val()
                  let price     = $('#item_name').attr('price')
                  let pricelist = $('#item_name').attr('pricelist')
                  let quant = $('#item_name').attr('countval')
                  if(job == 'one'){
                      $('#item_price').val(price)
                  }else if(job == 'all'){
                      $('#item_price').val(quant * price)
                      $('#item_name').attr('pricelist',quant * pricelist)
                  }
                  $('#add-cart').click();
                  $('#item_name').val('')
                  $('#item_code').val('')
                  $('#discount_ratio').val('')
                }
                $('.item_name_list').html('')
              }
          });
      }else{
          $('#item_name').val('')
          $('#item_price').val('')
      }
    });
    /*Change in Select unit */
    $('#product_unit').on('change', function() {
        let job = $(this).val();
        let price     = $('#item_name').attr('price')
        let pricelist = $('#item_name').attr('pricelist')
        let quant = $('#item_name').attr('countval')
        if(job == 'one'){
            $('#item_price').val(price)
        }else if(job == 'all'){
            $('#item_price').val(quant * price)
            $('#item_name').attr('pricelist',quant * pricelist)
        }
    });

    /* Add ORder in add-cart*/
    $('#add-cart').on('click',function (e) {
      e.preventDefault();
      let mybut      = $(this);
      let customer   = $('#customer').val()||'0';
      let opration   = $('#order-opration').val();
      let order      = $('#number-order').val();
      let item       = $('#item_code').val();
      let itemname   = $('#item_name').val();
      let unit       = $('#product_unit').val();
      let quan       = $('#item_quant').val();
      let price      = $('#item_price').val();
      let disc       = $('#discount_ratio').val();
      let pricelist  = $('#item_name').attr('pricelist');
      let pecies     = $('#item_name').attr('countval');
      $.ajax({
        url: "{{route('item_order.halk')}}",
        method: 'post',
        enctype: "multipart/form-data",
        data: {
          _token      :_token,
          customer    :customer,
          opration    :opration,
          order       :order,
          item        :item,
          itemname    :itemname,
          unit        :unit,
          quan        :quan,
          price       :price,
          disc        :disc,
          pricelist   :pricelist,
          pecies      :pecies,
          date        :dateDIv.text(),
          time        :timeDIv.text(),
        },
        success: function (data) {
          if(data.errorquan){
            cuteToast({
              type: "error",
              message: 'لا يوجد كمية كافية عدد القطع  ' + data.productquan,
              timer: 4000
            });
          }

          if(data.customer){
            cuteToast({
              type: "error",
              message: data.customer,
              timer: 4000
            });
          }

        },
      });
  });

/* Add Discount Value */
$('#save-dis-value').on('click',function (e) {
    e.preventDefault();
    let mybut      = $(this);
    let order      = $('#number-order').val();
    let discount   = $('#val-dis-value').val();
    let distype    = 'Value';

    $.ajax({
      url: "{{route('order.discount.halk')}}",
      method: 'post',
      enctype: "multipart/form-data",
      data: {
        _token      :_token,
        order       :order,
        discount    :discount,
        distype     :distype,
      },
      success: function (data) {
        $('.discount-content').hide();
        $('#alldiscountval').html(data.discount);
        $('#totalcheck').html(data.total);
      },
    });
  });
  
  /* Add Discount Ratio */
$('#save-dis-ratio').on('click',function (e) {
    e.preventDefault();
    let mybut      = $(this);
    let order      = $('#number-order').val();
    let discount   = $('#val-dis-ratio').val();
    let distype    = 'Ratio';

    $.ajax({
      url: "{{route('order.discount.halk')}}",
      method: 'post',
      enctype: "multipart/form-data",
      data: {
        _token      :_token,
        order       :order,
        discount    :discount,
        distype     :distype,
      },
      success: function (data) {
        $('.discount-content').hide();
        $('#alldiscountval').html(data.discount);
        $('#totalcheck').html(data.total);
      },
    });
  });

    /* Delete ORder */


$('#delete_order').on('click',function (e) {
    e.preventDefault();
    let mybut      = $(this);
    let order      = $('#number-order').val();

    $.ajax({
      url: "{{route('delete_order.halk')}}",
      method: 'post',
      enctype: "multipart/form-data",
      data: {
        _token      :_token,
        order       :order,
      },
      success: function (data) {
      },
    });
  });
//Search in Order
$('#search').on('click',function (e) {
    e.preventDefault();
    let order = $('#search-item').val();
    $('.check-body').html('');
    $('#alldiscountval').text(0);
    $('#totalcheck').text(0);
    $.ajax({
      url: "{{route('search_order.halk')}}",
      method: 'post',
      enctype: "multipart/form-data",
      data: {
        _token: _token,
        order  : order,
      },

      success: function (data) {
        let html = '';
        let countl = 0;
        for(var count = 0 ; count < data.orders[0].details.length ; count++)
        {
          html+=`<div class="check-item portlet added" ${data.orders[0].details[count].no_item}>
            <div class="item-name"> <bdi> ${data.orders[0].details[count].item_name} </bdi> </div>
            <div class="item-Quantity"> ${data.orders[0].details[count].quan} </div>
            <div class="item-unit"> ${data.orders[0].details[count].unit} </div>
            <div class="item-price"> <span>${data.orders[0].details[count].price}</span></div>
            <div class="item-total-price">
            <div class="item-total-price">
            <p class="new-price"> <span class="total">${data.orders[0].details[count].total}</span></p>
            `;
            if(data.orders[0].details[count].discount > 0)
            {
              html+=`<p class="old-price"> <span class="total">${parseInt(data.orders[0].details[count].total) + parseInt(data.orders[0].details[count].discount) }</span></p>`;
            }            
            html+=`</div>
            <p class="new-price"> <span class="total"></span></p>
            </div>
            <div class="trash-item" no="${data.orders[0].details[count].no_item}"><i class="far fa-trash-alt"></i></div>
          </div>`;
        }
        $('.check-body').html(html);
        $('#alldiscountval').text(data.orders[0].discount);
        $('#totalcheck').text(data.orders[0].total);
        $('#number-order').val(data.orders[0].id);
      }

    });
  });

$('#getorder').on('change', function() {
    let order = $(this).val();
    $('.check-body').html('');
    $('#alldiscountval').text(0);
    $('#totalcheck').text(0);
    $.ajax({
      url: "{{route('search_order.halk')}}",
      method: 'post',
      enctype: "multipart/form-data",
      data: {
        _token: _token,
        order  : order,
      },

      success: function (data) {
        let html = '';
        let countl = 0;
        for(var count = 0 ; count < data.orders[0].details.length ; count++)
        {
          html+=`<div class="check-item portlet added" ${data.orders[0].details[count].no_item}>
            <div class="item-name"> <bdi> ${data.orders[0].details[count].item_name} </bdi> </div>
            <div class="item-Quantity"> ${data.orders[0].details[count].quan} </div>
            <div class="item-unit"> ${data.orders[0].details[count].unit} </div>
            <div class="item-price"> <span>${data.orders[0].details[count].price}</span></div>
            <div class="item-total-price">
            <div class="item-total-price">
            <p class="new-price"> <span class="total">${data.orders[0].details[count].total}</span></p>
            `;
            if(data.orders[0].details[count].discount > 0)
            {
              html+=`<p class="old-price"> <span class="total">${parseInt(data.orders[0].details[count].total) + parseInt(data.orders[0].details[count].discount) }</span></p>`;
            }            
            html+=`</div>
            <p class="new-price"> <span class="total"></span></p>
            </div>
            <div class="trash-item" no="${data.orders[0].details[count].no_item}"><i class="far fa-trash-alt"></i></div>
          </div>`;
        }
        $('.check-body').html(html);
        $('#alldiscountval').text(data.orders[0].discount);
        $('#totalcheck').text(data.orders[0].total);
        $('#number-order').val(data.orders[0].id);

      }

    });
  });

  function calcTotalCheckPrice() {
    let total = 0;
    let products = $(".check .check-body").children(".check-item");
    let totalDiv = $(".check .check-footer").find(".total-value span");

    products.each(function() {
      total += parseFloat(
        $(this)
          .find(".new-price .total")
          .text()
      );
    });
    totalDiv.text(total);
  }

  function createDeleteItemAnimation(button) {
    let itemParent = button.parents(".check-item");
    button.animate(
      {
        height: "100%",
        "font-size": "1.5em"
      },
      500,
      function() {
        itemParent.addClass("delete");
      }
    );

    itemParent.on("transitionend", function() {
      $(this).remove();
      calcTotalCheckPrice();
    });
  }
  // When Clicked On Trash Button Remove Parent Item
  $(document).on("click", ".trash-item", function(e) {
    e.preventDefault();

    let trashButton = $(this);
    let order      = $('#number-order').val();
    let element    = trashButton.attr('no');
    let customer   = $('#customer').val()||'0';
    let opration   = $('#order-opration').val();
    $.ajax({
        url: "{{route('del_element.halk')}}",
        method: 'post',
        enctype: "multipart/form-data",
        data: {
          _token : _token,
          order  : order,
          element : element,
          customer : customer,
          opration : opration,
        },
        success: function (data) {
          trashButton.parents(".check-item").addClass("warning-delete");
          createDeleteItemAnimation(trashButton);
          if(data.backmoney){
            cuteToast({
              type: "error",
              message: data.backmoney,
              timer: 6000
            });
          }
          if(data.customer){
            cuteToast({
              type: "error",
              message: data.customer,
              timer: 4000
            });
          }
        }
    });
  });

  $('#save-balance').on('click',function (e) {
    e.preventDefault();
    let balance    = $('#balance-price').val() || '0';
    let order      = $('#number-order').val();
    let customer   = $('#customer').val()||'0';

    $.ajax({
      url: "{{route('save_balance.halk')}}",
      method: 'post',
      enctype: "multipart/form-data",
      data: {
        _token : _token,
        order  : order,
        balance: balance,
        customer : customer
      },
      success: function (data) {
        $('.total-content').hide();
      }
    });
  });

  $('#btn-transfare-aggel').on('click',function (e) {
    e.preventDefault();
    let order      = $('#number-order').val();
    let customer   = $('#customer-transfare').val() || '0';
    $.ajax({
      url: "{{route('transfare_to_aggel.halk')}}",
      method: 'post',
      enctype: "multipart/form-data",
      data: {
        _token : _token,
        order  : order,
        customer : customer,
      },
      success: function (data) {
        if(data.status == 'true'){
            cuteToast({
              type: "success",
              message: 'تم التحويل بنجاح',
              timer: 2000
            });
          }
          if(data.customer){
            cuteToast({
              type: "error",
              message: data.customer,
              timer: 4000
            });
          }
      }
    });
  });
  $('#btn-transfare').on('click',function (e) {
    e.preventDefault();
    let order      = $('#number-order').val();
    $.ajax({
      url: "{{route('transfare_to_chash.halk')}}",
      method: 'post',
      enctype: "multipart/form-data",
      data: {
        _token : _token,
        order  : order,
      },
      success: function (data) {
        if(data.status == 'true'){
            cuteToast({
              type: "success",
              message: 'تم التحويل بنجاح',
              timer: 2000
            });
          }
      }
    });
  });

  $('#new_order').on('click',function (e) {
    e.preventDefault();
    location.reload()
   });

</script>      
