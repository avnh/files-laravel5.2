<?php $__env->startSection('user.setting'); ?>
  <div class="container">
    <div class="header-content">
      
      <div class="col-md-12">
       
        <div class="panel panel-default">
          
          <div class="panel-heading">
            <i style="font-size:18px;" class="fa fa-gear">
            </i> Your Account Settings          
          </div>
          
          <div class="panel-body text-left">
           <?php if(Session::has('Message')): ?>
                  <?php echo e(Session::get('Message')); ?>

            <?php endif; ?>
            
            <?php if($errors->any() ): ?>

                <div style="padding:8px;margin-bottom:25px;"
                 class="alert alert-danger text-left" role="alert">
                <ul style="list-style:none;" >
                    
                        <li ><i class="fa fa-exclamation-circle"></i><?php echo e(($errors->first())); ?></li>
                      
                   
                </ul>
                </div>

            <?php endif; ?>         
            
            <?php echo e(Form::open( array(
                'role' => 'form'

            ) )); ?>

           
           
          <div class="form-group">
               <?php echo e(Form::label( 'username','Username' )); ?>

               
               <?php echo e(Form::text('username',$data['userInfo']->username ,array(
               'class'=>'form-control',
               'placeholder'=>'Username'
               ))); ?>

           </div>
                
            <div class="form-group">
               <?php echo e(Form::label('email','Email')); ?>

                
               <?php echo e(Form::text('email',$data['userInfo']->email ,array(
                'class'=>'form-control',
                'placeholder'=>'Email'
                ))); ?>

            </div>            
                     
                      
        <div class="form-group">
                         <?php echo e(Form::label('password','Change Password')); ?>


           <?php echo e(Form::password( 'password',array(
               'id'         =>'password',
               'tabindex'   => '3',
               'class'      => 'form-control',
               'placeholder'=> 'Password'
           ) )); ?>


        </div>

        <div class="form-group">
           <?php echo e(Form::password( 'password_confirmation',array(
               'id'         =>'password_confirmation',
               'tabindex'   => '4',
               'class'      => 'form-control',
               'placeholder'=> 'Confirm Password'
           ) )); ?>


        </div>
 
            <br >
            <div class="form-group ">
                <?php echo e(Form::button('<i class="fa fa-check-circle"></i> Save', array(
                   'type' => 'submit',
                   'class' => 'btn btn-primary btn-block'
                   ))); ?>

            </div>
          
        </div>

        <?php echo e(Form::close()); ?>


         
          </div> <!-- /# END panel default -->
          
        </div> <!-- /# END col-md 12 --> 
        
      </div> <!-- /# Header Content --> 
</div>
<script language="javascript">
$("#message-alert").fadeTo(4000, 500).slideUp(500, function(){
    $("#message-alert").alert('close');
});    
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>