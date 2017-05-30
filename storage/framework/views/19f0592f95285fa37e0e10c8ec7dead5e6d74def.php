<?php $__env->startSection('admin.main'); ?>

<div class="row">
  <div class="col-lg-12">
    <h4 class="page-header">
      <i class="fa fa-fw fa-users"></i> Show Users 
    </h4>
    <ol class="breadcrumb">
      <li class="active">
        <i class="fa fa-dashboard"></i> Dashboard
      </li>                
      
      <li class="active">
        <i class="fa fa-fw fa-files-o"></i> Files Setting
      </li>
      
      <li >
        <i class="fa fa-fw fa-users"></i> Categories 
      </li>
      
      
    </ol>
  </div>
</div>
<!-- /.row -->


<div class="row">

  
 <?php if(Session::has('Message')): ?>
 <div class="col-md-12">
  <div id="message-alert" class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span></button>
      <strong>Well!</strong> 
      <?php echo e(Session::get('Message')); ?>

      
    </div>
  </div>

  <?php endif; ?>
  
  <div class="col-md-12">
   
    <div class="panel panel-default">
      <div class="panel-heading">
       All Categories  
     </div>
     
     <div class="panel-body">

      <table id="table-pagination" data-toggle="table"

      data-classes="table table-bordered table-striped table-hover"
      data-search="true"
      data-search-align="left"

      >
      <thead>
        <tr >
          <th data-sortable="true" data-field="id">
            <i class="fa fa-list-ol"></i>
          </th>
          <th data-search="true" data-field="name"><i class="fa fa-user"></i> name</th>

          <th data-search="false" data-field="size">
            <i class="fa fa-hdd-o"></i> Description
          </th>
          <th data-search="false" data-field="CreateAt">
            <i class="fa fa-clock-o"></i> Create at
          </th>

          <th data-search="false" data-field="Last_Update">
            <i class="fa fa-lock"></i> Last Update
          </th>
          <th data-search="false" data-field="fileOptions"> Options</th>
          

        </tr>                
        
      </thead>
      <tbody style="text-align:left;">
       <?php if(is_array($data['categories']) || is_object($data['categories'])): ?>
       <?php foreach( $data['categories'] as $key=>$category ): ?>
       
       
       <tr id="tr-<?php echo e($category->id); ?>" >
        <td style="display:none;" data-field="id">
          <?php echo e(((($data['categories']->currentPage() - 1)* $data['categories']->perPage()) + $key+1)); ?>

        </td>

        <td data-field="name">
          <?php echo e($category->name); ?>

        </td>

        <td data-field="size">
          <?php echo e($category->description); ?>

        </td>

        <td data-field="SignupAt">
         <?php echo e(date("F j, Y",strtotime($category->created_at))); ?>

       </td>
       
       <td data-field="LastLogin">
         
        <?php if($category->created_at !== null ): ?>
        <?php echo e($last_update = $category->created_at); ?>

        <?php else: ?>
        <?php echo e($last_update = $category->update_at); ?>                         
        <?php endif; ?>
        
        <?php echo e(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $last_update)->diffForHumans()); ?>

    </td>

    <td data-search="false"  data-field="categoryOptions">
      <a class="confirm" id="delete" 
      style="font-size:18px;"
      href="<?php echo e(asset('admin/category/delete/'.$category->id)); ?>"
      >
      <?php if($category->id != 0): ?>
      <i class="fa fa-trash"></i>
      <?php endif; ?>
    </a>
    
    
  </td>
  
</tr>

<?php endforeach; ?>
<?php endif; ?>
</tbody>

</table>

</div>

</div>

</div>


<?php echo e(Form::open( array(
  'role' => 'form',
  'files'=> true

  ) )); ?>

  <div class="col-md-6">
   
    <div class="panel panel-default">
      <div class="panel-heading">
        <label for="maxFileSize">
          <i style="font-size:16px;" class="fa fa-crosshairs "></i> Add Category
        </label>
      </div>
      
      <div class="panel-body">
        <div class="form-group">
          <div class="input-group">
            <?php echo e(Form::text('name',
            'Name',array(
            'class'=>'form-control'
            ))); ?>

            <span class="input-group-addon"></span>

          </div>   
          <div class="form-group">
            <?php echo e(Form::textarea('description','Description',array(
            'class'=>'form-control'
            ))); ?>

          </div>
        </div>
      </div>
      
      <div class="form-group">
        <?php echo e(Form::button('<i class="fa fa-save"></i> Add', array(
        'type' => 'submit',
        'class' => 'btn btn-success  btn-block'
        ))); ?>

    </div>
  </div>
</div>




<?php echo e(Form::close()); ?>

</div>




<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.index', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>