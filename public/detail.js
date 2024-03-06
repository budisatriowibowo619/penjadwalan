$(document).ready(function () {
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#formJadwal").submit(function(event) {
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

$(document).on("click", ".button-tanggal", function () {
    var tanggal = $(this).data('tanggal');
    $(".modal-body #idTanggal").val( tanggal );
    // $('#exampleModalLabel').html('Tambah data tanggal '+tanggal);
    var mydate = new Date(tanggal);
    var month = ["Januari", "Februari", "Maret", "April", "Mei", "Juni",
    "Juli", "Agustus", "September", "Oktober", "November", "Desember"][mydate.getMonth()];
    var date = mydate.getDate();
    var str = date + ' ' + month + ' ' + mydate.getFullYear();
    $("#inputTanggal").val(str);
});

const hapusJadwal = (id) => {
    Swal.fire({
        title: 'Apakah anda yakin ?',
        text: 'Anda akan menghapus jadwal ini',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya'
    }).then((result) => {
        if(result.isConfirmed) {
            $.ajax({
                type: 'GET',
                url: '/deleteJadwal',
                data: {
                    id: id
                },
                dataType: 'JSON',
                async: false,
                cache: false,
                success: function (response) {
                    Swal.fire({
                        title : response.message,
                        icon: 'success',
                        timer: 3000,
                        showConfirmButton: false
                    });
                    setTimeout(() => { location.reload() }, 1500);
                },
                error: function (error) {
                    Swal.fire({
                        title: 'Terjadi kesalahan saat mengambil data!',
                        text: error.responseText, 
                        icon: 'error',
                        showConfirmButton: false
                    });
                }
            });
        }
    })
}