<?php $__env->startSection('user.dashboard'); ?>

<div class="container">
    

    <!-- Begin files listing -->
    <div class="header-content">
      
      <div class="col-md-12">
       
        <div class="panel panel-default">
          
          <div class="panel-heading main">
            <i style="font-size:18px;" class="fa fa-dropbox">
            </i> Your Uploaded Files         
          </div>
          
          <div class="panel-body">
            <?php foreach($data['categories'] as $key=>$category): ?>
            <!-- category  -->
            <div class="panel panel-default">
                <div class="panel-heading" ><?php echo e($category['name']); ?></div>

                <!-- Table -->
            <table id="table-pagination" data-toggle="table"
               data-classes="table table-bordered table-striped table-hover"
            >
              <thead>
                <tr >
                    <th data-sortable="true" data-field="id">
                    <i class="fa fa-list-ol"></i>
                    </th>
                    <th class=" hidden-xs" data-field="type"><i class="fa fa-filter"></i></th>
                    <th data-search="true" data-field="name"><i class="fa fa-file-text-o"></i> Name</th>
                    <th class=" hidden-xs" data-search="false" data-field="size">
                        <i class="fa fa-crosshairs"></i> Size
                    </th>
                    <th class=" hidden-xs" data-search="false" data-field="uploadAt"><i class="fa fa-clock-o"></i> Upload time</th>
                    
                    <th class=" hidden-xs" data-search="false" data-field="downloadCounter">
                      <i class="fa fa-cloud-download"></i> 
                    </th>
                    <th data-search="false" data-field="fileLink"><i class="fa fa-link"></i> File Link</th>
                    <th data-search="false" data-field="fileOptions"><i class="fa fa-link"></i>  Options</th>

                </tr>                
             
                </thead>
                <tbody style="text-align:left;">
                   
                    <?php foreach($data['userFiles'] as $key=>$file): ?>
                        <?php if($file->category != $category['id']): ?> <?php continue; ?>
                        <?php endif; ?>
                    <tr id="tr-<?php echo e($file->id); ?>" >
                        <td style="display:none;" data-field="id">

<?php echo e(((($data['userFiles']->currentPage() - 1)* $data['userFiles']->perPage()) + $key+1)); ?>

                       
                        </td>
                        <td class=" hidden-xs" data-field="type">
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
                        <td class=" hidden-xs" data-field="size">
                          <?php echo e(( $file->fileSize )); ?>

                        </td>
                        <td lass=" hidden-xs" data-field="uploadAt">
                          <?php echo e($file->created_at->diffForHumans()); ?>

                        </td>
                                        
                        <td lass=" hidden-xs" data-field="downloadCounter">
                            <?php echo e($file->fileDownloadCounter); ?>

                        </td>
                        <td data-field="fileLink">
                            <a target="_blank" style="text-decoration:underline;
                            font-size:14px;" href="<?php echo e(asset('file/show/'.$file->id)); ?>">
                             <i class="fa fa-external-link"></i>
                              <?php echo e(mb_substr(html_entity_decode($file->fileName),0,10,"utf-8")); ?>

                            </a>
                        </td>
                        <td data-field="fileOptions">
                            <a style="font-size:18px; margin:0 10px;"
                                id="delete-<?php echo e($file->id); ?>" data-id="<?php echo e($file->id); ?>"
                                role="button" class="delete_confirm"
                             >
                              <i class="fa fa-trash"></i>
                            </a>
                            
                            <a  style="font-size:18px;"
                                id="lock-<?php echo e($file->id); ?>" data-id="<?php echo e($file->id); ?>"
                                role="button" class="lock_confirm">
                                
                                <?php if( count(\App\LockFile::where('fileId','=',$file->id)->get()) ): ?>
                                    <i class="fa fa-lock"></i>
                                <?php else: ?>
                                    <i class="fa fa-unlock"></i>
                                <?php endif; ?>
                            </a>
                        </td>
                    </tr>
                    
                    <?php endforeach; ?>
                </tbody>
              
            </table>
                <?php echo e($data['userFiles']->links()); ?> 

                </div>  <!-- end category  -->
            <?php endforeach; ?>

          </div>  <!-- end panel body -->
          
        </div> <!-- /# END panel default -->
        
      </div> <!-- /# END col-md 12 --> 
       
    </div> <!-- /# END HEADER CONTETNT -->

<div class="header-content">
      
      <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i style="font-size:18px;" class="fa fa-bar-chart"></i> Your Files Statistics
            </div>
            <div class="panel-body">
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i style="font-size:45px" class="fa fa-cloud-upload fa-stack-2x"></i>
                        </div>
                        <div class="col-xs-9 ">
                            <div class="huge"><?php echo e($data['totalFiles']); ?></div>
                            <div>Total Uploaded Files</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i style="font-size:45px;" class="fa fa-hdd-o fa-stack-2x"></i>
                        </div>
                        <div class="col-xs-9">
                            <div class="huge"><?php echo e($data['totalFilesSize']); ?></div>
                            <div>Total Files Size</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                        <i style="font-size:45px;" class="fa fa-hdd-o fa-stack-2x"></i>
                        </div>
                        <div class="col-xs-9">
                            <div class="huge"><?php echo e($data['totalFreeDiskSpace']); ?></div>
                            <div>Your Free Disk Space</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                        <i style="font-size:45px" class="fa fa-cloud-download fa-stack-2x"></i>
                        </div>
                        <div class="col-xs-9">
                            <div class="huge"><?php echo e($data['totalDownloadedFiles']); ?></div>
                            <div>Total Download Files</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
           
            </div>
            </div>
            </div>
       
        </div> <!-- end statisc -->

   
</div>


<script language="javascript">
$(document).ready(function(){

    // Callback Function To Get Delete ID
    function createCallback( i ){
        return function(){
            window.id = $(this).data("id");
            window.tr = i;
        }
    }
    
    function e_createCallback( e ){
        return function(){
            window.eid = $(this).data("id");
            window.etr = e;

        }
    }

    // Delete OK/Cancel Question
    $(".delete_confirm").click(function() {
        console.log('del clocked');
        var id = $(this).data("id");
        var btn = window.confirm("Are you sure you want to delete this file ?");
            if(btn){
              $.ajax({
                  
                        url: "<?php echo e(asset('/file/delete')); ?>",
                        type: 'post',
                        dataType: "JSON",
                        data: {
                            "id": id,
                            "_token": "<?php echo e(csrf_token()); ?>"
                        },
                        success: function (response) {
                            if (response == 'ok') {
                                
                                $('#tr-' + id).hide('slow').remove();
                            } else {

                                console.log("deleted failed");
                            }
                        }
                });

                console.log("It failed");
            }
        
    });

    
    // Lock Question
    $(".lock_confirm").click(function() {
        var eid = $(this).data("id");

        var btn = window.prompt("Please Insert Password (Leave empty to unlock):");
            if(btn != null ){
              $.ajax({
                        url: "<?php echo e(asset('/file/lock')); ?>",
                        type: 'post',
                        dataType: "JSON",
                        data: {
                            "eid": eid,
                            "password":btn,
                            "_token": "<?php echo e(csrf_token()); ?>"
                        },
                        success: function (response) {
                            var str = response;
                            console.log(typeof str);
                            if (str.indexOf("ock-ok")) {
                                if($('#lock-' + eid + ' i').hasClass('fa fa-unlock') && btn.val != ''){
                                    $('#lock-' + eid + ' i')
                                        .removeClass('fa fa-unlock').addClass('fa fa-lock')
                                        
                                }else if($('#lock-' + eid + ' i').hasClass('fa fa-lock') && btn.val != ''){
                                    $('#lock-' + eid + ' i')
                                        .removeClass('fa fa-lock').addClass('fa fa-unlock')
                                        
                                    
                                }else if($('#lock-' + eid + ' i').hasClass('fa fa-lock') && btn.val == ''){
                                    $('#lock-' + eid + ' i')
                                        .removeClass('fa fa-lock').addClass('fa fa-unlock')
                                        
                                    
                                }    
                                console.log("locked");
                            } else {
                                console.log("locked failed!");

                            }
                            
                        }
                
                    });
                console.log("It failed");
            }
        
    });

    
  // Delete File Loop To get Clicked Item ID
  for(var i = 1; i <= <?php echo e($data['totalFiles']); ?>; i++) {
      $('#delete-' + i).click( createCallback( i ) );  
  }

  // Lock File Loop To get Clicked Item ID
  for(var e = 1; e <= <?php echo e($data['totalFiles']); ?>; e++) {
      $('#lock-' + e).click( e_createCallback( e ) );  
  }
        
});
// for toggle category
$('.panel-heading').on('click', function (e) {
        e.preventDefault();
        var elem = $(this).parent().find('#table-pagination');
        console.log(elem);
        elem.toggle('slow');
    });

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>