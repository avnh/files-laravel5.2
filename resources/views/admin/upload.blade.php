@extends('admin.index')

@section('admin.main')

<div class="row">
  <div class="col-lg-12">
    <h4 class="page-header">
      <i class="fa fa-cloud-upload"></i> Upload Settings
    </h4>
    <ol class="breadcrumb">
      <li class="active">
        <i class="fa fa-dashboard"></i> Dashboard
      </li>                
      <li >
        <i class="fa fa-cloud-upload"></i> Upload Settings
      </li>
    </ol>
  </div>
</div>
<!-- /.row -->

<div class="row">

  @if($errors->any() )
  <div class="col-md-12">
    <div style="padding:8px;margin-bottom:25px;"
    class="alert alert-danger text-left" role="alert">
    <ul style="list-style:none;" >
      {{ implode('',$errors->all('
      <li ><i class="fa fa-exclamation-circle"></i> :message</li>
      '))
    }}
  </ul>
</div>
</div>

@endif    

@if(Session::has('Message'))
<div class="col-md-12">
  <div id="message-alert" class="alert alert-success alert-dismissible" role="alert"> 
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> 
      <span aria-hidden="true">×</span>
    </button> 
    <strong>Well!</strong> {{ Session::get('Message') }}
  </div>
</div>

@endif

{{ Form::open( array(
  'role' => 'form',
  'files'=> true

  ) ) }}
  <div class="col-md-6">
   
    <div class="panel panel-default">
      <div class="panel-heading">
        <label for="maxFileSize">
          <i style="font-size:16px;" class="fa fa-crosshairs "></i> Upload max filesize
        </label>
      </div>
      
      <div class="panel-body">
        <div class="form-group">
          <div class="input-group">
            {{ Form::text('maxFileSize',
            mb_substr($data['maxFileSize'],0,6,"utf-8"),array(
            'class'=>'form-control'
            )) }}
            <span class="input-group-addon">MB</span>
          </div>   
        </div>
      </div>
      
    </div>

  </div>
  <div class="col-md-6">

    <div class="panel panel-default">
      <div class="panel-heading">
        
        <label for="userDiskSpace">
          <i style="font-size:16px;" class="fa fa-hdd-o"></i> User Disk Space
        </label>
        
      </div>
      
      <div class="panel-body">
        <div class="form-group">
          <div class="input-group">

            {{ Form::text('userDiskSpace',
            $data['userDiskSpace'],array(
            'class'=>'form-control'
            )) }}
            <span class="input-group-addon">MB</span>

          </div>
        </div>
      </div>
      
    </div>


  </div>
  
  <div class="col-md-12">

    <div class="panel panel-default">
      <div class="panel-heading">
        
        <label for="AllowedFilesType">
          <i style="font-size:16px;" class="fa fa-filter"></i> Allowed Files Types
        </label>
      </div>
      
      <div class="panel-body">
        <div class="form-group">
          {{ Form::textarea('AllowedFilesType',$data['allowedFilesExt'],array(
          'class'=>'form-control'
          )) }}
        </div>
      </div>
      
    </div>
  </div>
  
  


  
  
  <div class="clearfix"></div>
  <div class="col-md-6">

    <div class="form-group">
      {{ Form::button('<i class="fa fa-save"></i> Save', array(
      'type' => 'submit',
      'class' => 'btn btn-success  btn-block'
      ))
    }}
  </div>
  <br >

</div>




{{ Form::close() }}

</div>


@endsection
