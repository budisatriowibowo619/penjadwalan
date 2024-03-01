$(document).ready(function () {
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });
});

$(document).on("click", ".button-tanggal", function () {
    var tanggal = $(this).data('tanggal');
    $(".modal-body #idTanggal").val( tanggal );
    $('#exampleModalLabel').html('Tambah data tanggal '+tanggal);
});

// $("#formJadwal").submit(function(event) {
//     event.preventDefault();
//     dataFormJadwal = new FormData($(this)[0]);
//     $.ajax({
//         type: "POST",
//         url: "/processJadwal",
//         data: dataFormJadwal,
//         dataType: "JSON",
//         async: false,
//         cache: false,
//         contentType: false,
//         processData: false,
//         success: function (response) {
//             alert('data berhasil ditambahkan');
//             // location.reload();
//         },
//         error: function (error) {
//             alert('error');
//         }
//     });
// });