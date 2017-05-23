@extends('layouts.app')

@section('home')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
                     @foreach($data['categories'] as $key=>$category)
            <!-- category  -->
            <div class="panel panel-default">
                <div class="panel-heading" >{{ $category['name'] }}</div>

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
                    <th class=" hidden-xs" data-field="type"><i class="fa fa-filter"></i></th>
                    <th data-search="true" data-field="name"><i class="fa fa-file-text-o"></i> Name</th>
                    <th class=" hidden-xs" data-search="false" data-field="size">
                        <i class="fa fa-crosshairs"></i> Size
                    </th>
                    <th class=" hidden-xs" data-search="false" data-field="uploadAt"><i class="fa fa-clock-o"></i> Upload time</th>
                    <th class=" hidden-xs" title="File Status" data-search="false" data-field="status">
                        <i class="fa fa-globe"></i> Owner
                    </th>
                    <th class=" hidden-xs" data-search="false" data-field="downloadCounter">
                      <i class="fa fa-cloud-download"></i> 
                    </th>
                    <th data-search="false" data-field="fileLink"><i class="fa fa-link"></i> File Link</th>
                  <!--   <th data-search="false" data-field="fileOptions"><i class="fa fa-link"></i>  Options</th> -->

                </tr>                
             
                </thead>
                <tbody style="text-align:left;">
                   
                    @foreach($data['userFiles'] as $key=>$file)
                        @if ($file->category != $category['id']) @continue
                        @endif
                    <tr id="tr-{{ $key+1 }}" >
                        <td style="display:none;" data-field="id">

{{ ((($data['userFiles']->currentPage() - 1)* $data['userFiles']->perPage()) + $key+1) }}
                       
                        </td>
                        <td class=" hidden-xs" data-field="type">
                          @if ($file->fileExt === 'jpg' )
                            <i class="fa fa-picture-o"></i> {{ $file->fileExt }} 
                          @elseif ($file->fileExt === 'jpg')
                            <i class="fa fa-picture-o"></i> {{ $file->fileExt }}
                          @elseif ($file->fileExt === 'png')
                            <i class="fa fa-picture-o"></i> {{ $file->fileExt }}
                          @elseif ($file->fileExt === 'zip')
                            <i class="fa fa-file-archive-o"></i> {{ $file->fileExt }}
                          @elseif ($file->fileExt === 'mp3')
                            <i class="fa fa-music"></i> {{ $file->fileExt }}
                          @elseif ($file->fileExt === 'exe')
                            <i class="fa fa-cog"></i> {{ $file->fileExt }}
                          @elseif ($file->fileExt === 'mp4')
                            <i class="fa fa-film"></i> {{ $file->fileExt }}
                          @else
                            <i class="fa fa-file-text-o"></i> {{ $file->fileExt }}
                          @endif
                        </td>
                        <td data-field="name">
                          {{ mb_substr($file->fileName,0,10,"utf-8") }}
                        </td>
                        <td class=" hidden-xs" data-field="size">
                          {{ ( $file->fileSize ) }}
                        </td>
                        <td class=" hidden-xs" data-field="uploadAt">
                          {{ $file->created_at->diffForHumans() }}
                        </td>
                        <td  data-field="fileOptions">
                          {{ DB::table('users')->where('id', '=',$file->userID)->value('username') }}
                        </td>                   
                        <td class=" hidden-xs" data-field="downloadCounter">
                            {{ $file->fileDownloadCounter }}
                        </td>
                        <td data-field="fileLink">
                            <a target="_blank" style="text-decoration:underline;
                            font-size:14px;" href="{{ $file->filePath }}">
                             <i class="fa fa-external-link"></i>
                              {{ mb_substr(html_entity_decode($file->fileName),0,10,"utf-8") }}
                            </a>
                        </td>
                        <!-- <td data-field="fileOptions">
                            <a style="font-size:18px; margin:0 10px;"
                                id="delete-{{ $key+1 }}" data-id="{{ $file->id }}"
                                role="button" class="delete_confirm"
                             >
                              <i class="fa fa-trash"></i>
                            </a>
                            
                            <a  style="font-size:18px;"
                                id="lock-{{ $key+1 }}" data-id="{{ $file->id }}"
                                role="button" class="lock_confirm">
                                
                                @if( count(\App\LockFile::where('fileId','=',$file->id)->get()) )
                                    <i class="fa fa-lock"></i>
                                @else
                                    <i class="fa fa-unlock"></i>
                                @endif
                            </a>
                        </td> -->
                    </tr>
                    
                    @endforeach
                </tbody>
              
            </table>
                {{ $data['userFiles']->links()  }} 

                </div>  <!-- end category  -->
            @endforeach
                
    </div>
</div>

<script src="{{ asset('assets/js/tables.min.js') }}"></script>

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

        (new FrontBox).yes_no("are you sure you want to delete this file ?",
                              "<i class='fa fa-trash'></i> Confirm File Delete").callback(function(btn){

            if(btn == 'yes' ){
              $.ajax({
                  
                        url: window.location+'/delete',
                        type: 'DELETE',
                        dataType: "JSON",
                        data: {
                            "id": id,
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function (){
                            $('#tr-' + tr).hide('slow').remove();
                            console.log("deleted");
                        }
                });

                console.log("It failed");
            }
        });
    });

    
    // Lock Question
    $(".lock_confirm").click(function() {

        (new FrontBox).text("Please Insert Password (Leave empty to unlock):",
                              "<i class='fa fa-lock'></i> Lock|unLock File  ").callback(function(btn,ans){

            if(btn == 'ok' ){
              $.ajax({
                        url: window.location+'/lock',
                        type: 'PUT',
                        dataType: "JSON",
                        data: {
                            "eid": eid,
                            "password":ans,
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function (){
                            if($('#lock-' + etr + ' i').hasClass('fa fa-unlock') && ans.val != ''){
                                $('#lock-' + etr + ' i')
                                    .removeClass('fa fa-unlock').addClass('fa fa-lock')
                                    .css('color','red');
                            }else if($('#lock-' + etr + ' i').hasClass('fa fa-lock') && ans.val != ''){
                                $('#lock-' + etr + ' i')
                                    .removeClass('fa fa-lock').addClass('fa fa-unlock')
                                    .css('color','red');
                                
                            }else if($('#lock-' + etr + ' i').hasClass('fa fa-lock') && ans.val == ''){
                                $('#lock-' + etr + ' i')
                                    .removeClass('fa fa-lock').addClass('fa fa-unlock')
                                    .css('color','red');
                                
                            }
                                console.log("locked");

                        }
                });

                console.log("It failed");
            }
        });
    });

    
 
        
});
// for toggle category
$('.panel-heading').on('click', function (e) {
        e.preventDefault();
        var elem = $(this).parent().find('#table-pagination');
        console.log(elem);
        elem.toggle('slow');
    });

</script>
@endsection
