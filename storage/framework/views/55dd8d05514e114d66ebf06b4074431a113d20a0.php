<?php $__env->startSection('content'); ?>
<!-- jQuery -->
<script src="<?php echo e(asset('assets/js/fileinput.min.js')); ?>"></script>


<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome</div>

                <div class="panel-body">
                 Hello world!
             </div>
         </div>
     </div>
 </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>