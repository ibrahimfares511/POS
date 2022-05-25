<script>
    let _token  = $('input[name="_token"]').val();
    let dateDIv = $(".date-time .date");
    let timeDIv = $(".date-time .time");
    /* =================== Save Data ####################### */
  $('#save_data').on('click',function (e) {
    e.preventDefault();
    let mybut  = $(this);
    let saletype = $('input[name="salesopration"]:checked').val();
    let buyopration = $('input[name="buyopration"]:checked').val();
    let buysale = $('input[name="buysale"]:checked').val();
    let salesale = $('input[name="salesale"]:checked').val();

    $.ajax({
      url: "{{route('save.setting')}}",
      method: 'post',
      enctype: "multipart/form-data",
      data: {
        _token          : _token,
        saletype        : saletype,
        buyopration     : buyopration,
        buysale     : buysale,
        salesale     : salesale,
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
</script>