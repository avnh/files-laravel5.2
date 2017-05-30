@extends('admin.index')

@section('admin.main')
<div class="row">
    <div class="col-lg-12">
        <h4 class="page-header">
            <i class="fa fa-tachometer"></i> Dashboard
        </h4>

    </div>
</div>
<!-- /.row -->

<div class="row">

    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i style="font-size:20px;" class="fa fa-globe"></i> Website Statistics
            </div>
            <div class="panel-body">
                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i style="font-size:45px;" class="fa fa-users fa-stack-2x"></i>
                                </div>
                                <div class="col-xs-9">
                                    <div class="huge">{{ $data["usersTotal"]  }}</div>
                                    <div>Total Users</div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i style="font-size:45px" class="fa fa-cloud-upload fa-stack-2x"></i>
                                </div>
                                <div class="col-xs-9 ">
                                    <div class="huge">{{ $data['uploadedFiles'] }}</div>
                                    <div>Total Uploaded Files</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                  <i style="font-size:45px" class="fa fa-cloud-download fa-stack-2x"></i>
                              </div>
                              <div class="col-xs-9">
                                <div class="huge">{{ $data['totalDownloadedFiles'] }} </div>
                                <div>Total Downloaded Files</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            
            
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i style="font-size:20px;" class="fa fa-hdd-o"></i> Server Disk Space Status
        </div>
        <div class="panel-body">
           
            <div class="col-lg-4 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i style="font-size:45px" class="fa fa-hdd-o fa-stack-2x"></i>
                            </div>
                            <div class="col-xs-9 ">
                                <div class="huge">{{ $data['disk_total_space'] }}</div>
                                <div>Total Disk Space</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i style="font-size:45px" class="fa fa-hdd-o fa-stack-2x"></i>
                            </div>
                            <div class="col-xs-9 ">
                                <div class="huge">{{ $data['disk_free_space'] }}</div>
                                <div>Free Disk Size</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="panel panel-yellow">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i style="font-size:45px" class="fa fa-hdd-o fa-stack-2x"></i>
                            </div>
                            <div class="col-xs-9 ">
                                <div class="huge">{{ $data['disk_used_space'] }}</div>
                                <div>Used Disk Space</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            
        </div>
    </div>
</div>

</div>
<!-- /.row -->

@endsection
