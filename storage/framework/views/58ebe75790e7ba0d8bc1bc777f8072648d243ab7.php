<?php $__env->startSection('admin.main'); ?>

<div class="row">
  <div class="col-lg-12">
    <h4 class="page-header">
      <i class="fa fa-fw fa-users"></i> Users Files 
    </h4>
    <ol class="breadcrumb">
      <li class="active">
        <i class="fa fa-dashboard"></i> Dashboard

      </li>                

      <li class="active">
        <i class="fa fa-fw fa-files-o"></i> Files Setting
      </li>

      <li >
        <i class="fa fa-fw fa-users"></i> Files 
      </li>
    </ol>
  </div>
</div>
<!-- /.row -->


<div class="row">

  <?php if($errors->any() ): ?>
  <div class="col-md-12">
    <div style="padding:8px;margin-bottom:25px;"
    class="alert alert-danger text-left" role="alert">
    <ul style="list-style:none;" >
      <?php echo e(implode('',$errors->all('
      <li ><i class="fa fa-exclamation-circle"></i> :message</li>
      '))); ?>

  </ul>
</div>
</div>

<?php endif; ?>       

<?php if(Session::has('Message')): ?>
<div class="col-md-12">
  <div id="message-alert" class="alert alert-success alert-dismissible" role="alert"> 
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> 
      <span aria-hidden="true">×</span>
    </button> 
    <strong>Well!</strong> <?php echo e(Session::get('Message')); ?>

  </div>
</div>

<?php endif; ?>




<div class="col-md-12">
  <div class="panel panel-default">
    <div class="panel-heading">
      <i class="fa fa-fw fa-users"></i>  Users Uploaded Files  
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
          <th data-field="type"><i class="fa fa-filter"></i></th>
          <th data-search="true" data-field="name"><i class="fa fa-file-text-o"></i> Name</th>
          <th data-search="true" data-field="category"><i class="fa fa-library"></i> Category</th>
          <th data-search="false" data-field="size">
            <i class="fa fa-crosshairs"></i> Size
          </th>
          <th data-search="false" data-field="uploadAt"><i class="fa fa-clock-o"></i> Upload time</th>

          <th data-search="false" data-field="fileUploader">
            <i class="fa fa-user"></i> By 
          </th>
          <th data-search="false" data-field="fileLink"><i class="fa fa-link"></i> File Link</th>
          <th data-search="false" data-field="fileOptions"> Options</th>

        </tr>                

      </thead>
      <tbody style="text-align:left;">

        <?php foreach($data['files'] as $key=>$file): ?>

        <tr id="tr-<?php echo e($file->id); ?>" >
          <td style="display:none;" data-field="id">

            <?php echo e(((($data['files']->currentPage() - 1)* $data['files']->perPage()) + $key+1)); ?>


          </td>
          <td data-field="type">
            <?php if($file->fileExt === 'jpg' ): ?>
            <i class="fa fa-picture-o"></i> <?php echo e($file->fileExt); ?> 
            <?php elseif($file->fileExt === 'jpg'): ?>
            <i class="fa fa-picture-o"></i> <?php echo e($file->fileExt); ?>

            <?php elseif($file->fileExt === 'png'): ?>
            <i class="fa fa-picture-o"></i> <?php echo e($file->fileExt); ?>

            <?php elseif($file->fileExt === 'zip'): ?>
            <i class="fa fa-file-archive-o"></i> <?php echo e($file->fileExt); ?>

            <?php elseif($file->fileExt === 'mp3'): ?>
            <i class="fa fa-music"></i> <?php echo e($file->fileExt); ?>

            <?php elseif($file->fileExt === 'exe'): ?>
            <i class="fa fa-cog"></i> <?php echo e($file->fileExt); ?>

            <?php elseif($file->fileExt === 'mp4'): ?>
            <i class="fa fa-film"></i> <?php echo e($file->fileExt); ?>

            <?php else: ?>
            <i class="fa fa-file-text-o"></i> <?php echo e($file->fileExt); ?>

            <?php endif; ?>
          </td>
          <td data-field="name">
            <?php echo e(mb_substr($file->fileName,0,10,"utf-8")); ?>

          </td>
          <td data-field="name">
            <?php echo e(DB::table('categories')->where('id','=',$file->category)->value('name')); ?>


          </td>
          <td data-field="size">
            <?php echo e(\App\File::formatFileSize( $file->fileSize )); ?>

          </td>
          <td data-field="uploadAt">
            <?php echo e(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $file->created_at)->diffForHumans()); ?>

          </td>

          <td data-field="fileUploader">

           <i class="fa fa-external-link"></i>
           <?php echo e($file->username); ?>

         </a>
       </td>
       <td data-field="fileLink">
        <a target="_blank" style="text-decoration:underline;
        font-size:14px;" href="<?php echo e(asset('file/show/'.$file->id)); ?>">
        <i class="fa fa-external-link"></i>
        <?php echo e(mb_substr(html_entity_decode($file->fileName),0,10,"utf-8")); ?>

      </a>
    </td>
    <td data-search="false"  data-field="fileOptions">

      <a class="confirm" id="delete" 
      style="font-size:18px;"
      href="<?php echo e(asset('admin/files/Pcdelete/'.$file->id)); ?>"
      >
      <i class="fa fa-trash"></i>
    </a>


  </td>
</tr>

<?php endforeach; ?>
</tbody>

</table>
<?php echo e($data['files']->links()); ?> 


</div>

</div>

</div>


</div>




<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.index', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>