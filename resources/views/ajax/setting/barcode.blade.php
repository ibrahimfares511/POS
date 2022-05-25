<script>
    let _token  = $('input[name="_token"]').val();
    $('#search').on('click',function (e) {
        e.preventDefault();
        let text     = $('#search-item').val();
        let type     = $('#reports-search').val();
        let customer = $('#reports-customer').val() || '0';
        console.log(type)
        $.ajax({
        url: "{{route('search.get.barcode')}}",
        method: 'post',
        enctype: "multipart/form-data",
        data: {
            _token     : _token,
            text       : text,
            type       : type,
            customer   : customer,
        },

        success: function (data) {
            let html = '';
            for(var count = 0 ; count < data.length ; count++)
            {
                html+=`<div class="col-sm-6">                  
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">${data[count].code}</h5>
                      <p class="card-text">${data[count].name} | ${data[count].price_p}</p>
                    </div>
                  </div>
                </div>`;
            }
            $('.barcode-product').html(html);

        }

        });
  });
</script>