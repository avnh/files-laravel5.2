@extends('layouts.app')

@section('user.file')
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
                    {{ mb_substr($data['fileName'],0,20,"utf-8") }}
                </li>
                
                <li class="list-group-item">   
                    <span>
                       <i style="font-size:18px;" class="fa fa-filter"></i> File Extension | 
                    </span>
                    {{ $data['fileExt'] }}
                </li>
                
                <li class="list-group-item">
                    <span>
                    <i style="font-size:18px;" class="fa fa-crosshairs"></i> File Size |
                    </span>
                    {{ $data['fileSize'] }}
                </li>
                <br>

              @if ($data['isLocked'])
                {{ Form::open( array(
                    'role' => 'form',
                    'id' => 'downloadLocked',
                    'url' =>  Request::path().'file/downloadLocked' 
                ) ) }}
                 <label for="password"><i class="fa fa-lock"></i> File Password</label>
                @if( Session::has('message') ?
                 $border= 'border-color:#a02a1b;': $border ='')@endif
                {{ Form::password( 'password',array(
                   'id'         =>'password',
                   'tabindex'   => '1',
                   'class'      => 'form-control',
                   'style'      => $border,
                   'placeholder'=> 'Password'
               ) ) }}
               
                @else
                {{ Form::open( array(
                    'role' => 'form',
                    'id' => 'download',
                    'url' => $data['fileDownloadPath']
                )) }}

                @endif
                
               {{ Form::button('<i class="fa fa-cloud-download"></i> Download Now',
                   array(
                       'type' => 'submit',
                       'class' => 'btn btn-primary',
                       'id' => 'as'
                   ))
                }}
                
                 {{ Form::close() }}
              </ul>
         <ul class="list-group col-md-6 col-right text-left">
               
                <li class="list-group-item">
                    <span>
                     <i class="fa fa-globe"> </i>  Username
                     
                    </span>  
                    <input style="margin-bottom:0px;" class="form-control" style="width:100%;" type="text" value="{{ $data['ownername'] }}" readonly>
                    

                </li>
                
                <li class="list-group-item">
                    <span>
                     <i class="fa fa-cloud-download"></i> </i>  Email
                     
                    </span>  
                    <input style="margin-bottom:0px;" class="form-control" style="width:100%;"
                     type="text" value="{{ $data['owneremail'] }}" readonly>

                </li>
                         
            

                </div>
                    
              </ul>
            
            </div>
        </div>

    </div>

</div>
</div>
@endsection