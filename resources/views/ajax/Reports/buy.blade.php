<script>
    let _token  = $('input[name="_token"]').val();
    let dateDIv = $(".date-time .date");
    let timeDIv = $(".date-time .time");

    
    $('#to-Excel').on('click', function() {
        var table2excel = new Table2Excel();
        table2excel.export(document.getElementById("table-buy") , 'مشتريات');
    });

    $('#to-Pdf').on('click', function() {
        var table2Pdf = document.getElementById("table-buy")
        html2pdf().from(table2Pdf).save();
    });

    $('#search').on('click',function (e) {
        console.log('hi')
        e.preventDefault();
        let text = $('#search-item').val();
        let type = $('#reports-search').val();
        let date_to = $('#date_to').val() || '0';
        let date_from = $('#date_from').val() || '0';
        let customer = $('#reports-customer').val() || '0';

        $.ajax({
        url: "{{route('salesreportbuy')}}",
        method: 'post',
        enctype: "multipart/form-data",
        data: {
            _token     : _token,
            text       : text,
            type       : type,
            customer   : customer,
            date_to    : date_to,
            date_from  : date_from,
            date      : dateDIv.text()
        },

        success: function (data) {
            let html = '';
            for(var count = 0 ; count < data.length ; count++)
            {
                html +=`<tr row_id='${data[count].id}'>
                      <td> <span class='row-id'>${data[count].id}</span></td>
                      <td> <span>${data[count].op_ar}</span> </td>
                      `;
                      if(data[count].customer[0]){
                          html +=`<td> <span>${data[count].customer[0].customer}</span> </td>`;
                        
                      }else{
                        
                          html +=`<td> <span> - </span> </td>`;
                      }
                html +=`
                      <td> <span>${data[count].subtotal}</span> </td>
                      <td> <span>${data[count].val_discount}</span> </td>
                      <td> <span>${data[count].total}</span> </td>`

                      if(data[count].op == 'aggel'){
                        html+=`<td> <span>${data[count].balanc}</span> </td>`
                      }else{
                        html+=`<td> <span>${data[count].total}</span> </td>`
                      }
                      if(type == "delete")
                    {
                        html+=`<td> <span>${data[count].user_delete[0].name}</span> </td>`

                    }else{
                        html+=`<td> <span>${data[count].user[0].name}</span> </td>`

                    }
                      html+=`<td> <span>${data[count].date}</span> </td>
                </tr>`;
            }
            $('tbody').html(html);

        }

        });
  });

  $(document).on('click', '#table-buy tbody tr', function() {
    let rowId = $(this).attr('row_id');
    $('.buy-report-modal').modal('show')
    $.ajax({
    url: "{{route('buyreportorder')}}",
    method: 'post',
    enctype: "multipart/form-data",
    data: {
        _token     : _token,
        rowId       : rowId,
    },
    success: function (data) {
        let html = '';
        for(var count = 0 ; count < data.details.length ; count++)
        {
            html +=`<tr row_id='${data.details[count].id}'>
                    <td> <span class='row-id'>${data.details[count].item_name}</span></td>
                    <td> <span class='row-id'>${data.details[count].unit}</span></td>
                    <td> <span>${data.details[count].quan}</span> </td>
                    <td> <span>${data.details[count].price}</span> </td>
                    <td> <span>${data.details[count].discount}</span> </td>
                    <td> <span>${data.details[count].total}</span> </td>
                    </tr>`
        }
        $('#table-buy-details tbody').html(html);
    },
    });
});
</script>