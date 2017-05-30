<!DOCTYPE html>
<html lang="">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo e($data['title']); ?></title>    
  <!-- Bootstrap Core CSS -->
  <link media="all" type="text/css" rel="stylesheet" href="<?php echo e(asset('admin/assets/css/bootstrap_2.min.css')); ?>">
  <!-- Font Awesome CSS -->
  <link media="all" type="text/css" rel="stylesheet" href="<?php echo e(asset('admin/assets/font-awesome/css/font-awesome.min.css')); ?>">
  <!-- Bootstrap Core CSS -->
  <link media="all" type="text/css" rel="stylesheet" href="<?php echo e(asset('admin/assets/css/sb-admin.css')); ?>">
  

</head>

<body>

  <div id="wrapper">

    <?php echo $__env->make('admin.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <div id="page-wrapper">

      <div class="container-fluid">
        
        <?php echo $__env->yieldContent('admin.main'); ?>

      </div>

    </div>
    <?php echo $__env->make('admin.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

  </div>

  
  <!-- jQuery -->
  <script src="<?php echo e(asset('admin/assets/js/jquery-1.11.3.min.js')); ?>"></script>
  <!-- Bootstrap Core JavaScript -->
  <script src="<?php echo e(asset('admin/assets/js/bootstrap.min.js')); ?>"></script>
  <script src="<?php echo e(asset('admin/assets/js/tables.min.js')); ?>"></script>
  <script src="<?php echo e(asset('admin/assets/js/jquery.confirm.js')); ?>"></script>

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
