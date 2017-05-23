<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('/public/themes/uploads/favicon.png') }}">
    <title>{{ $data['title'] }}</title>    
    <!-- Bootstrap Core CSS -->
    <link media="all" type="text/css" rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap_2.min.css') }}">
    <!-- Font Awesome CSS -->
    <link media="all" type="text/css" rel="stylesheet" href="{{ asset('admin/assets/font-awesome/css/font-awesome.min.css') }}">
    <!-- Bootstrap Core CSS -->
    <link media="all" type="text/css" rel="stylesheet" href="{{ asset('admin/assets/css/sb-admin.css') }}">
   

</head>

<body>

<div id="wrapper">

@include('admin.header')

  <div id="page-wrapper">

      <div class="container-fluid">
      
@yield('admin.main')

      </div>

  </div>
@include('admin.footer')

</div>

   
    <!-- jQuery -->
    <script src="{{ asset('admin/assets/js/jquery-1.11.3.min.js') }}"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('admin/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/tables.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jquery.confirm.js') }}"></script>

 <script type="text/javascript">
     $(".confirm").confirm();

$(".alert").fadeTo(4000, 500).slideUp(500, function(){
    $(".alert").alert('close');
});  
     
     $('#adsPage > option:last').hide();
     $('#adsPosition > option:last').hide();
    /* Load adsCode into textarea <selec> */
$("#adsPage").change(function() {
    $("#adsPosition").val('Position')
                                $("#adsContent").val(null)

});
     
 
</script>
</body>
</html>
