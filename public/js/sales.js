 

const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000
          });

$("#makesale").click(function(e){

  e.preventDefault();

  var _url = $("#create").attr("action");

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });


  var _data = new FormData($('#create')[0]);

    $.ajax({

        url: _url,

        type:'POST',

        dataType:"json",

        data:_data,

        processData: false,
        
        contentType: false,

        success: function(data) {

            if($.isEmptyObject(data.error)){
              
              Toast.fire({
                type: 'success',
                title: 'Order Placed Successfully'
              }).then(
                function () {
                  window.location.reload();
                },
              );
              

            }else{
              
              printErrorMsg(data.error);

              $('#preview').modal('show');

            }

        }

    });

}); 


function printErrorMsg (msg) {
  $(".print-error-msg").find("ul").html('');
  $(".print-error-msg").css('display','block');
  $.each( msg, function( key, value ) {
    $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
  });

}