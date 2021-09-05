<html lang="en">
<head>
   <!-- Theme style -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CV. Agus Wahyu | Starter</title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/fontawesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/brands.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('template/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('template/dist/css/adminlte.min.css') }}">
  <script src="{{ asset('jquery-1.12.4.js') }}"></script>
 
  <script>
    $(document).ready(function(){

      $( "input[type='submit']" ).prop( "disabled", false );

      // Jquery Dependency
      $("input[data-type='currency']").on({
          keyup: function() {
            formatCurrency($(this));
          },
          blur: function() { 
            formatCurrency($(this), "blur");
          }
      });


      function formatNumber(n) {
        // format number 1000000 to 1,234,567
        return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".")
      }


      function formatCurrency(input, blur) {
        // appends $ to value, validates decimal side
        // and puts cursor back in right position.
        
        // get input value
        var input_val = input.val();
        
        // don't validate empty input
        if (input_val === "") { return; }
        
        // original length
        var original_len = input_val.length;

        // initial caret position 
        var caret_pos = input.prop("selectionStart");
          
        // check for decimal
        if (input_val.indexOf(",") >= 0) {

          // get position of first decimal
          // this prevents multiple decimals from
          // being entered
          var decimal_pos = input_val.indexOf(",");

          // split number by decimal point
          var left_side = input_val.substring(0, decimal_pos);
          var right_side = input_val.substring(decimal_pos);

          // add commas to left side of number
          left_side = formatNumber(left_side);

          // validate right side
          right_side = formatNumber(right_side);
          
          // On blur make sure 2 numbers after decimal
          if (blur === "blur") {
            right_side += "00";
          }
          
          // Limit decimal to only 2 digits
          right_side = right_side.substring(0, 2);

          // join number by .
          input_val = "Rp " + left_side + "," + right_side;

        } else {
          // no decimal entered
          // add commas to number
          // remove all non-digits
          input_val = formatNumber(input_val);
          input_val = "Rp " + input_val;
          
          // final formatting
          if (blur === "blur") {
            input_val += ",00";
          }
        }
        
        // send updated string to input
        input.val(input_val);

        // put caret back in the right position
        var updated_len = input_val.length;
        caret_pos = updated_len - original_len + caret_pos;
        input[0].setSelectionRange(caret_pos, caret_pos);
      }
    });
  </script>
</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">
<script>
$(document).ready(function(){
	var height_content = $(".content").height() + 190 ;
	$('body').attr({style: 'height: '+height_content+'px'});
});
</script>