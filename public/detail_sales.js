$(document).ready(function () {
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#formJadwal").submit(function(event) {
        $('#btnSimpan').html('...Menyimpan');
        $('#btnSimpan').prop('disabled', true);
        $('#btnClose').prop('disabled', true);
        event.preventDefault();
        let dataFormJadwal = new FormData($(this)[0]);
    
        $.ajax({
            type: "POST",
            url: "/processJadwal",
            data: dataFormJadwal,
            dataType: "JSON",
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {

                if (response.status > 200) {
                    $('#formJadwal').before(`<div class="alert alert-warning alert-dismissible fade show m-3" role="alert">
                        ${response.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`);
                } else {
                    $('#formJadwal').before(`<div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                        ${response.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`);

                    setTimeout(() => { location.reload() }, 1500);
                }
                
                $('.btn-close').on('click', function(){
                    $(this).closest('div').remove();
                });
            },
            error: function (error) {
                $('#formJadwal').before(`<div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                    Terjadi kesalahan saat memproses data!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>`);

                $('.btn-close').on('click', function(){
                    $(this).closest('div').remove();
                });
            }
        });
    });
    
});

const showPreviewPenjadwalan = (id_penjadwalan) => {
    if(id_penjadwalan != 0) {
        $.ajax({
            type: 'GET',
            url: '/gtPenjadwalan',
            data: {
                id: id_penjadwalan
            },
            dataType: 'JSON',
            async: false,
            cache: false,
            success: function (response) {

                if(response.length != 0){
                    $('#exampleModal').modal('show');
                }

                $('#idTanggal').val(response.tanggal);

                var tanggal = response.tanggal;
                var mydate = new Date(tanggal);
                var month = ["Januari", "Februari", "Maret", "April", "Mei", "Juni",
                "Juli", "Agustus", "September", "Oktober", "November", "Desember"][mydate.getMonth()];
                var date = mydate.getDate();
                var str = date + ' ' + month + ' ' + mydate.getFullYear();
                $("#inputTanggal").val(str);

                $('#inputSales').val(response.client);
                $('#inputDeskripsi').val(response.description);
            },
        });
    }
}