<?php $__env->startSection('home'); ?>
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
     <?php foreach($data['categories'] as $key=>$category): ?>
     <!-- category  -->
     <div class="panel panel-default">
      <div class="panel-heading" ><?php echo e($category['name']); ?></div>

      <!-- Table -->
      <table id="table-pagination" data-toggle="table"
      data-classes="table table-bordered table-striped table-hover"
      data-search="true"
      data-search-align="right"
      >
      <thead>
        <tr >
          <th data-sortable="true" data-field="id">
            <i class="fa fa-list-ol"></i>
          </th>
          <th data-search="true" data-field="name"><i class="fa fa-file-text-o"></i> Name</th>
          <th class=" hidden-xs" data-field="type" data-searchable="false"><i class="fa fa-filter"></i></th>
          <th class=" hidden-xs" data-search="false" data-field="size" data-searchable="false">
            <i class="fa fa-crosshairs"></i> Size
          </th>
          <th class=" hidden-xs" data-search="false" data-field="uploadAt" data-searchable="false"><i class="fa fa-clock-o"></i> Upload time</th>
          <th class=" hidden-xs" title="File Status" data-search="false" data-field="owner">
           <i class="fa fa-user"></i> By
         </th>
         <th class=" hidden-xs" data-search="false" data-field="downloadCounter" data-searchable="false">
          <i class="fa fa-cloud-download"></i> 
        </th>
        <th class=" hidden-xs" title="File Status" data-search="false" data-field="status" data-searchable="false">
         <i class="fa fa-globe"></i> 
       </th>
       <th data-search="false" data-field="fileLink"><i class="fa fa-link" data-searchable="false"></i> File Link</th>
       <!--   <th data-search="false" data-field="fileOptions"><i class="fa fa-link"></i>  Options</th> -->

     </tr>                
     
   </thead>
   <tbody style="text-align:left;">
     
    <?php foreach($data['userFiles'] as $key=>$file): ?>
    <?php if($file->category != $category['id']): ?> <?php continue; ?>
    <?php endif; ?>
    <tr id="tr-<?php echo e($file->id); ?>" >
      <td style="display:none;" data-field="id">
        <?php echo e($file->id); ?>

        
      </td>
      <td data-field="name"  data-search="true">
        <?php echo e(mb_substr($file->fileName,0,10,"utf-8")); ?>

      </td>

      <td class=" hidden-xs" data-search="false" data-field="type">
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
      
      <td class=" hidden-xs" data-field="size">
        <?php echo e(( $file->fileSize )); ?>

      </td>
      <td class=" hidden-xs" data-field="uploadAt">
        <?php echo e($file->created_at->diffForHumans()); ?>

      </td>
      <td  data-field="owner"  data-search="true">
        <?php echo e(DB::table('users')->where('id', '=',$file->userID)->value('username')); ?>

      </td>                   
      <td class=" hidden-xs" data-field="downloadCounter">
        <?php echo e($file->fileDownloadCounter); ?>

      </td>
      <td class=" hidden-xs" data-field="status">
        <?php if($file->fileStatus == 1 ): ?>
        <i class="fa fa-check"></i> 
        <?php else: ?>
        <i class="fa fa-times"></i> 
        <?php endif; ?>
      </td>  
      <td data-field="fileLink">
        <a target="_blank" style="text-decoration:underline;
        font-size:14px;" href="<?php echo e(asset('file/show/'.$file->id)); ?>">
        <i class="fa fa-external-link"></i>
        <?php echo e(mb_substr(html_entity_decode($file->fileName),0,10,"utf-8")); ?>

      </a>
    </td>
    
  </tr>
  
  <?php endforeach; ?>
</tbody>

</table>
<?php echo e($data['userFiles']->links()); ?> 

</div>  <!-- end category  -->
<?php endforeach; ?>

</div>
</div>

<script src="<?php echo e(asset('assets/js/tables.min.js')); ?>"></script>

<script language="javascript">
$(document).ready(function(){
  

  
// for toggle category
$('.panel-heading').on('click', function (e) {
  e.preventDefault();
  var elem = $(this).parent().find('#table-pagination');
  console.log(elem);
  elem.toggle('slow');
});


});

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>