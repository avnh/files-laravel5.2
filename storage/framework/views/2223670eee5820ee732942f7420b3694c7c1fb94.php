<?php $__env->startSection('user.file'); ?>
<!-- Start Page Content -->     
<div class="header-content">
<div  class="col-md-12 ">

<div id="showfile" class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                
                 <i style="font-size:18px;" class="fa fa-cloud-download"></i> 
                 Download File 
            </div>
            <div class="panel-body">
            
            <ul class="list-group col-md-6 text-left">
                <li class="list-group-item">
                    <span>
                     <i style="font-size:18px;" class="fa fa-file-o"></i> File Name |    
                    </span>
                    <?php echo e(mb_substr($data['fileName'],0,20,"utf-8")); ?>

                </li>
                
                <li class="list-group-item">   
                    <span>
                       <i style="font-size:18px;" class="fa fa-filter"></i> File Extension | 
                    </span>
                    <?php echo e($data['fileExt']); ?>

                </li>
                
                <li class="list-group-item">
                    <span>
                    <i style="font-size:18px;" class="fa fa-crosshairs"></i> File Size |
                    </span>
                    <?php echo e($data['fileSize']); ?>

                </li>
                <br>

              <?php if($data['isLocked'] == 0 ): ?>
                <?php echo e(Form::open( array(
                    'role' => 'form',
                    'id' => 'downloadLocked',
                    'url' =>  asset('file/downloadLocked/'.$data["fileId"]) 
                ) )); ?>

                 <label for="password"><i class="fa fa-lock"></i> File Password</label>
                <?php if( Session::has('message') ?
                 $border= 'border-color:#a02a1b;': $border =''): ?><?php endif; ?>
                <?php echo e(Form::password( 'password',array(
                   'id'         =>'password',
                   'tabindex'   => '1',
                   'class'      => 'form-control',
                   'style'      => $border,
                   'placeholder'=> 'Password'
               ) )); ?>

               
                <?php else: ?>
                <?php echo e(Form::open( array(
                    'role' => 'form',
                    'id' => 'download',
                    'url' => asset('file/download/'.$data["fileId"])
                ))); ?>


                <?php endif; ?>
                
               <?php echo e(Form::button('<i class="fa fa-cloud-download"></i> Download Now',
                   array(
                       'type' => 'submit',
                       'class' => 'btn btn-primary',
                       'id' => 'as'
                   ))); ?>

                
                 <?php echo e(Form::close()); ?>

              </ul>
         <ul class="list-group col-md-6 col-right text-left">
               
                <li class="list-group-item">
                    <span>
                     <i class="fa fa-globe"> </i>  Username
                     
                    </span>  
                    <input style="margin-bottom:0px;" class="form-control" style="width:100%;" type="text" value="<?php echo e($data['ownername']); ?>" readonly>
                    

                </li>
                
                <li class="list-group-item">
                    <span>
                     <i class="fa fa-cloud-download"></i> </i>  Email
                     
                    </span>  
                    <input style="margin-bottom:0px;" class="form-control" style="width:100%;"
                     type="text" value="<?php echo e($data['owneremail']); ?>" readonly>

                </li>
                         
            

                </div>
                    
              </ul>
            
            </div>
        </div>

    </div>

</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>