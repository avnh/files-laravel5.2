@extends('layouts.app')

@section('user.upload')
<div class="container">
    
 <div class="header-content">
      
      <div class="col-md-12">
       
        <div class="panel panel-default">
          
          <div class="panel-heading">
            <i style="font-size:18px;" class="fa fa-cloud-upload">
            </i> Upload New Files 
            <span style="font-size:11px;">
            (Max Files:{{ \App\UploadSetting::find(1)->maxUploadsFiles }})
            | Max File Size :({{ \App\File::formatFileSize(\App\UploadSetting::find(1)->maxFileSize) }}) 

            </span>   
          </div>
          
          <div class="panel-body">
		            <div id="message-alert" class="alert alert-success alert-dismissible" role="alert">

                </div>
		
                <label for="sel1">Select file to upload:</label>
                <input type="file" name="file" id="file">
                <!-- drop down category -->
                <label for="sel1">Select category:</label>
                      <select class="form-control" name="category" id="category">
                        @foreach($data['categories'] as $key=>$category)
                        <option value="{{ $category->id }}">{{$category->name}}</option>
                        @endforeach
                      </select>
              <!-- end drop down category -->

                                    
                {{ csrf_field() }}

            {{ Form::button('<i class="fa fa-upload"></i> Upload', array(
                   'type' => 'submit',
                   'id' => 'upload',
                   ))
                }}

        <br><small>File Extensions :[{{ \App\UploadSetting::find(1)->allowedFilesExt }}] </small>
          </div>
          
          
        </div> <!-- /# END panel default -->
        
      </div> <!-- /# END col-md 12 --> 
       
    </div> <!-- /# END HEADER CONTETNT -->

</div> 
<script language="javascript">
 $(document).ready(function() {
    
  $('#upload').click (function() {
    console.log('click');
    var file_data = $('#file').prop('files')[0];   
    var form_data = new FormData();
    var _token = $("input[name=_token]").val();             
    var category = $('#category').val();             
    form_data.append('file', file_data);
    form_data.append('_token', _token);
    form_data.append('category', category);
    console.log(_token);                             
    $.ajax({
                url: "#", // point to server-side PHP script 
                dataType: 'text',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'post',
                success: function(response){
                    if(response=='"success"') {
                        $('#message-alert').html("Upload success!");
                    } else {
                      
                        $('#message-alert').html(response);
                    }
                }
     });
  });
});
    
</script>
   
@endsection
