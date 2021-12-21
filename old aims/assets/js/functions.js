


function suggetion() {

    $('#sug_input').keyup(function(e) {

        var formData = {
            'product_name' : $('input[name=title]').val()
        };

        if(formData['product_name'].length >= 1){
            console.log(" else statemennt "+formData['product_name'].length);

          // process the form
          $.ajax({
              type        : 'POST',
              url         : 'ajax.php',
              data        : formData,
              dataType    : 'json',
              encode      : true
          })
              .done(function(data) {
                  console.log("my  bbbbb"+data);
                  $('#result').html(data).fadeIn();
                  $('#result li').click(function() {

                    $('#sug_input').val($(this).text());
                    $('#result').fadeOut(500);

                  });

                  $("#sug_input").blur(function(){
                    $("#result").fadeOut(500);
                  });

              });

        } else {

          $("#result").hide();

        };

        e.preventDefault();
    });

}
 $('#sug-form').submit(function(e) {
     var formData = {
         'p_name' : $('input[name=title]').val()
     };
       // process the form
       $.ajax({
           type        : 'POST',
           url         : 'ajax.php',
           data        : formData,
           dataType    : 'json',
           encode      : true
       })
           .done(function(data) {
               //console.log(data);
               $('#product_info').html(data).show();
               total();
               $('.datePicker').datepicker('update', new Date());

           }).fail(function() {
               $('#product_info').html(data).show();
           });
     e.preventDefault();
 });
 $('#sug-form-sell').submit(function(e) {
    var formData = {
        'sell_p' : $('input[name=title]').val()
    };
      // process the form
      $.ajax({
          type        : 'POST',
          url         : 'ajax.php',
          data        : formData,
          dataType    : 'html',
          encode      : true
      })
          .done(function(data) {
              //console.log(data);
              $('#product_info').html(data).show();
              total();
              $('.datepicker').datepicker('update', new Date());

          }).fail(function() {
              $('#product_info').html(data).show();
          });
    e.preventDefault();
});

$('#sug-form-sell-m').submit(function(e) {
    var formData = {
        'sell_p_m' : $('input[name=title]').val()
    };
      // process the form
      $.ajax({
          type        : 'POST',
          url         : 'ajax.php',
          data        : formData,
          dataType    : 'html',
          encode      : true
      })
          .done(function(data) {
              //console.log(data);
              $('#product_finds').html(data).show();
              total();
              $('.datepicker').datepicker('update', new Date());

          }).fail(function() {
              $('#product_info').html(data).show();
          });
    e.preventDefault();
});
$('#sug-form-pur').submit(function(e) {
    var formData = {
        'pur_p' : $('input[name=title]').val()
    };
      // process the form
      $.ajax({
          type        : 'POST',
          url         : 'ajax.php',
          data        : formData,
          dataType    : 'html',
          encode      : true
      })
          .done(function(data) {
    console.log("From");

              //console.log(data);
              $('#product_info').html(data).show();
              total();
              $('.datepicker').datepicker('update', new Date());

          }).fail(function() {
    console.log("fail Purchase");

              $('#product_info').html(data).show();
          });
    e.preventDefault();
});



 $('#sug-form-move').submit(function(e) {
    var formData = {
        'move_p' : $('input[name=title]').val()
    };
    console.log(formData['move_p']+" dfsd fsd dfsd sdf sdf sdfsd ");
      // process the form
      $.ajax({
          type        : 'POST',
          url         : 'ajax.php',
          data        : formData,
          dataType    : 'html',
          encode      : true
      })
          .done(function(data) {
              console.log(data);
              $('#product_info').html(data).show();
            //   total();
              $('.datepicker').datepicker('update', new Date());

          }).fail(function() {
              $('#product_info').html(data).show();
          });
    e.preventDefault();
});





$('#sug-form-purchase').submit(function(e) {
    var formData = {
        'purchase_p' : $('input[name=title]').val()
    };
    console.log(formData['purchase_p']+" dfsd fsd dfsd sdf sdf sdfsd ");
      // process the form
      $.ajax({
          type        : 'POST',
          url         : 'ajax.php',
          data        : formData,
          dataType    : 'html',
          encode      : true
      })
          .done(function(data) {
              console.log(data);
              $('#product_info').html(data).show();
            //   total();
              $('.datepicker').datepicker('update', new Date());

          }).fail(function() {
              $('#product_info').html(data).show();
          });
    e.preventDefault();
});

// $('#download_all_remaning').click(function(e) {
//     var formData = {
//         'download_all_remaning' : "t"
//     };
//     console.log(formData['download_all_remaning']+" dfsd fsd dfsd sdf sdf sdfsd ");
//       // process the form
//       $.ajax({
//           type        : 'POST',
//           url         : 'ajax.php',
//           data        : formData,
//           dataType    : 'html',
//           encode      : true
//       })
//         //   .done(function(data) {
//         //       console.log(data);
//         //     //   $('#product_info').html(data).show();
//         //     // //   total();
//         //     //   $('.datepicker').datepicker('update', new Date());

//         //   }).fail(function() {
//         //       console.log(data);
//         //     //   $('#product_info').html(data).show();
//         //   });
//     e.preventDefault();
// });
$('#sug-form-sample').submit(function(e) {
    var formData = {
        'sample_p' : $('input[name=title]').val()
    };
    console.log(formData['sample_p']+" dfsd fsd dfsd sdf sdf sdfsd ");
      // process the form
      $.ajax({
          type        : 'POST',
          url         : 'ajax.php',
          data        : formData,
          dataType    : 'html',
          encode      : true
      })
          .done(function(data) {
              console.log(data);
              $('#product_info').html(data).show();
            //   total();
              $('.datepicker').datepicker('update', new Date());

          }).fail(function() {
              $('#product_info').html(data).show();
          });
    e.preventDefault();
});

$('#sug-form-detail').submit(function(e) {
    var formData = {
        'found_p' : $('input[name=title]').val()
    };
    console.log(formData['found_p']+" dfsd fsd dfsd sdf sdf sdfsd ");
      // process the form
      $.ajax({
          type        : 'POST',
          url         : 'ajax.php',
          data        : formData,
          dataType    : 'html',
          encode      : true
      })
          .done(function(data) {
              console.log(data);
              $('#product_finds').html(data).show();
            //   total();
              $('.datepicker').datepicker('update', new Date());

          }).fail(function() {
              $('#product_finds').html(data).show();
          });
    e.preventDefault();
});


// function sell_but_not_enough()
// {
//     // window.location.href = "http://localhost/aims/move_to_shop.php";
//     console.log(" after redirect ");
//     var formData = {
//         'purchase_p' : $('input[name=frfr]').val()
//     };
    
//     $.ajax({
//         type        : 'POST',
//         url         : 'ajax.php',
//         data        : formData,
//         dataType    : 'html',
//         encode      : true
//     })
//         .done(function(data) {
//             $('#product_info').html(data).show();
//           //   total();
//             $('.datepicker').datepicker('update', new Date());

//         }).fail(function() {
//             $('#product_info').html(data).show();
//         });
    
    
// }



 function total(){
   $('#product_info input').change(function(e)  {
           var price = +$('input[name=price]').val() || 0;
           var qty   = +$('input[name=quantity]').val() || 0;
           var total = qty * price ;
               $('input[name=total]').val(total.toFixed(2));
   });
 }

  $(document).ready(function() {
      
    $( "#pr" ).click(function(e) {
    
        // var formData = {
        //     'move_p' : $("ss").val()
        // };
        console.log(" dfsd fsd dfsd sdf sdf sdfsd ");
          // process the form
        //   $.ajax({
        //       type        : 'POST',
        //       url         : 'ajax.php',
        //       data        : formData,
        //       dataType    : 'html',
        //       encode      : true
        //   })
        //       .done(function(data) {
        //           console.log(data);
        //           $('#product_info').html(data).show();
        //         //   total();
        //           $('.datepicker').datepicker('update', new Date());
    
        //       }).fail(function() {
        //           $('#product_info').html(data).show();
        //       });
    
    
    
      });
    //tooltip
    $('[data-toggle="tooltip"]').tooltip();

    $('.submenu-toggle').click(function () {
       $(this).parent().children('ul.submenu').toggle(200);
    });
    //suggetion for finding product names
    suggetion();
    // Callculate total ammont
    total();
   
$.fn.datepicker.defaults.format = "dd-mm-yyyy";
    $('.datepicker')
        .datepicker({
            // format: 'dd/mm/yyyy',
            todayHighlight: true,
            autoclose: true,
              changeMonth: true,
        changeYear: true,
        orientation: "bottom"
        });
  });
