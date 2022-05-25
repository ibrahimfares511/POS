<script>
    let _token  = $('input[name="_token"]').val();
    let dateDIv = $(".date-time .date");
    let timeDIv = $(".date-time .time");

    
    $('#to-Excel').on('click', function() {
        var table2excel = new Table2Excel();
        table2excel.export(document.getElementById("table-exchange") , 'الصرف');
    });

    $('#to-Pdf').on('click', function() {
        var table2Pdf = document.getElementById("table-exchange")
        html2pdf().from(table2Pdf).save();
    });

    $('#search').on('click',function (e) {
        e.preventDefault();
        let text = $('#search-item').val();
        let type = $('#reports-search').val();
        let date_to = $('#date_to').val() || '0';
        let date_from = $('#date_from').val() || '0';
        let customer = $('#reports-customer').val() || '0';

        $.ajax({
        url: "{{route('Expense_Report')}}",
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
                      <td> <span>${data[count].users.name}</span> </td>
                      <td> <span>${data[count].expenses.name}</span> </td>
                      <td> <span>${data[count].value}</span> </td>
                      <td> <span>${data[count].date}</span> </td>`
                      if(data[count].note == null){
                        html+=`<td> <span> - </span> </td>`

                      }else{
                        html+=`<td> <span>${data[count].note}</span> </td>`
                      }
                      html+=`</tr>`
                
            }
            $('tbody').html(html);

        }

        });
  });
</script>