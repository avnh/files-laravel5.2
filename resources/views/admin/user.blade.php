@extends('admin.index')

@section('admin.main')

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
        <i class="fa fa-fw fa-users"></i> Users Settings 
      </li>
      
      
    </ol>
  </div>
</div>
<!-- /.row -->


<div class="row">

  
 @if(Session::has('Message'))
 <div class="col-md-12">
  <div id="message-alert" class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span></button>
      <strong>Well!</strong> 
      {{ Session::get('Message') }}
      
    </div>
  </div>

  @endif
  
  
  <div class="col-md-12">
   
    <div class="panel panel-default">
      <div class="panel-heading">
        
       All Users  
       
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
            <i class="fa fa-hdd-o"></i> Used
          </th>
          
          <th data-search="false" data-field="SignupAt">
            <i class="fa fa-clock-o"></i> Register time
          </th>

          <th data-search="false" data-field="Last_Login">
            <i class="fa fa-lock"></i> Last Login
          </th>
          
          <th data-search="false" data-field="userLink">
            <i class="fa fa-link"></i> User Profile
          </th>
          
          <th data-search="false" data-field="userOptions"> Op</th>

        </tr>                
        
      </thead>
      <tbody style="text-align:left;">
       @if (is_array($data['users']) || is_object($data['users']))
       @foreach( $data['users'] as $key=>$user )
       
       
       @continue ($user->level === 'admin')
       
       
       
       <tr id="tr-{{ $key+1 }}" >
        <td style="display:none;" data-field="id">
          {{ ((($data['users']->currentPage() - 1)* $data['users']->perPage()) + $key+1) }}
        </td>

        <td data-field="name">
          {{ $user->username }}
        </td>

        <td data-field="size">
          {{ \App\File::formatFileSize(DB::table('files')->where('userID','=',$user->id)->sum('fileSize')) }} of {{ \App\File::formatFileSize(\App\UploadSetting::find(1)->userDiskSpace) }}
        </td>
        
        <td data-field="SignupAt">
         {{ date("F j, Y",strtotime($user->created_at)) }}
       </td>
       
       <td data-field="LastLogin">
         
        @if($user->last_login !== null )
        {{  $last_login = $user->created_at }}
        @else
        {{  $last_login = $user->last_login }}                         
        @endif
        
        {{ 
        \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $last_login)->diffForHumans()
      }}
    </td>
    
    <td data-field="userLink">
      <a target="_blank" style="text-decoration:underline;
      font-size:14px;" href="{{ url('user/'.$user->username) }}">
      <i class="fa fa-external-link"></i> Show Profile
    </a>
  </td>
  <td data-field="userOptions">
    <a class="confirm" style="font-size:18px;"
    href="{{ url('admin/user/delete/'.$user->id) }}"
    
    >
    <i class="fa fa-trash"></i>
  </a>

</td>
</tr>

@endforeach
@endif
</tbody>

</table>
<!-- {{ $data['users']->links()  }}  -->

</div>

</div>

</div>






</div>




@endsection

