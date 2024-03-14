$(document).ready(function () {

    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $('#formLogin').submit(function(event) {
        $('#btnLogin').prop('disabled', true);
        $('#btnLogin').html('...Login');
        event.preventDefault();
        formData = new FormData($(this)[0]);
        $.ajax({
            url: "/processLogin",
            type: "post",
            data: formData,
            async: false,
            cache: false,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function (response) {
                // Swal.fire({
                //     icon: 'success',
                //     title: response.message,
                //     timer: 2000,
                //     showCancelButton: false,
                //     showConfirmButton: false,
                //     allowOutsideClick: false,
                //     onAfterClose: () => window.location = response.redirect
                // });
                alert(response.message);
                setTimeout(function(){ location.reload(); }, 3000);
            },
            error: function (error) {
                alert(error.message);
            }
      });
      return false;
    });

});