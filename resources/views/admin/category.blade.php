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
       @if (is_array($data['categories']) || is_object($data['categories']))
       @foreach( $data['categories'] as $key=>$category )
       
       
       <tr id="tr-{{ $category->id }}" >
        <td style="display:none;" data-field="id">
          {{ ((($data['categories']->currentPage() - 1)* $data['categories']->perPage()) + $key+1) }}
        </td>

        <td data-field="name">
          {{ $category->name }}
        </td>

        <td data-field="size">
          {{ $category->description }}
        </td>

        <td data-field="SignupAt">
         {{ date("F j, Y",strtotime($category->created_at)) }}
       </td>
       
       <td data-field="LastLogin">
         
        @if($category->created_at !== null )
        {{  $last_update = $category->created_at }}
        @else
        {{  $last_update = $category->update_at }}                         
        @endif
        
        {{ 
        \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $last_update)->diffForHumans()
      }}
    </td>

    <td data-search="false"  data-field="categoryOptions">
      <a class="confirm" id="delete" 
      style="font-size:18px;"
      href="{{ asset('admin/category/delete/'.$category->id) }}"
      >
      @if($category->id != 0)
      <i class="fa fa-trash"></i>
      @endif
    </a>
    
    
  </td>
  
</tr>

@endforeach
@endif
</tbody>

</table>

</div>

</div>

</div>


{{ Form::open( array(
  'role' => 'form',
  'files'=> true

  ) ) }}
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
            {{ Form::text('name',
            'Name',array(
            'class'=>'form-control'
            )) }}
            <span class="input-group-addon"></span>

          </div>   
          <div class="form-group">
            {{ Form::textarea('description','Description',array(
            'class'=>'form-control'
            )) }}
          </div>
        </div>
      </div>
      
      <div class="form-group">
        {{ Form::button('<i class="fa fa-save"></i> Add', array(
        'type' => 'submit',
        'class' => 'btn btn-success  btn-block'
        ))
      }}
    </div>
  </div>
</div>




{{ Form::close() }}
</div>




@endsection

