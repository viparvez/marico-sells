/**
 * Marico
 * @constructor
 * @param {string} title - functions
 */

function show(url, action = 'new') {
  if (action == 'new') {
    $('#preview').modal('show');
  } else {
    $("#preview").find("#showcontent").html('');
  }
  
  $("#spinner").show();
   
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      $("#spinner").hide();
      $("#preview").find("#showcontent").html(this.responseText);
    }
  };
  xhttp.open("GET", url, true);
  xhttp.send();

}


/*
Code that will act upon submission of edit #editForm
Will post the data to the action URL
*/

function update() {

  const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });

  var _url = $("#update").attr("action");

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  var _data = $("#update").serialize();

    $.ajax({

        url: _url,

        type:'POST',

        dataType:"json",

        data:_data,

        success: function(data) {

            if($.isEmptyObject(data.error)){
              $('#preview').modal('hide');
              Toast.fire({
                type: 'success',
                title: 'Data Updated Successfully!'
              }).then(
                function () {
                  window.location.reload();
                },
              );

            }else{
              
              printUpdateError(data.error);

            }

        }

    });

}
/*
Function to print error messages on update/delete
*/

function printUpdateError(msg) {
  $("#error_messages").find("ul").html('');
  $("#error_messages").css('display','block');
  $.each( msg, function( key, value ) {
    $("#error_messages").find("ul").append('<li>'+value+'</li>');
  });
}


/*
Function for new data insertion\
*/

$(document).ready(function() {

      const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });

      $("#submit").click(function(e){

        e.preventDefault();

        var _url = $("#create").attr("action");

        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        //var _data = $("#create").serialize();

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
                    $('#myModal').modal('hide');
                    Toast.fire({
                      type: 'success',
                      title: 'Data Updated Successfully!'
                    }).then(
                      function () {
                        window.location.reload();
                      },
                    );

                  }else{
                    
                    printErrorMsg(data.error);

                  }

              }

          });

      }); 


      $(document).ajaxStart(function () {
          $("#loading").show();
          $("#submit").hide();
      }).ajaxStop(function () {
          $("#loading").hide();
          $("#submit").show();
      });


      function printErrorMsg (msg) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display','block');
        $.each( msg, function( key, value ) {
          $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
        });

      }

  });