<script>
    let _token = $('input[name="_token"]').val();
    let dateDIv = $(".date-time .date");
    let timeDIv = $(".date-time .time");

    $('#selectop').on('change', function() {
        let job = $(this).val();
        console.log(job)
        $.ajax({
        url: "{{route('change_op')}}",
        method: 'post',
        enctype: "multipart/form-data",
        data: {
            _token    : _token,
            job       : job,
        },
        success: function (data) {
            $('#foateer').html(data.foateer)
            $('#salesshow').html(parseFloat(data.sales).toFixed(2))
            $('#sales_agel').html(parseFloat(data.agel).toFixed(2))
            $('#sales_back').html(parseFloat(data.back).toFixed(2))
            $('#sales_backacc').html(parseFloat(data.backofcus).toFixed(2))

            $('#foateer_buy').html(data.foateer_buy)
            $('#buy').html(parseFloat(data.buy).toFixed(2))
            $('#buy_aggel').html(parseFloat(data.buy_aggel).toFixed(2))
            $('#buy_back').html(parseFloat(data.buy_back).toFixed(2))
            $('#buy_backacc').html(parseFloat(data.buy_backacc).toFixed(2))


            $('#Spending').html(parseFloat(data.Spending).toFixed(2))
            $('#supply').html(parseFloat(data.supply).toFixed(2))
            $('#exchange').html(parseFloat(data.exchange).toFixed(2))
            $('#total').html(parseFloat(data.total).toFixed(2))
        },
        });
    });
</script>