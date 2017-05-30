       <!-- Navigation -->
       <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a style="padding-top:10px;" class="navbar-brand" href="{{ asset('/') }}">
                Files-Admin
            </a>
        </div>
        

        <ul class="nav navbar-right top-nav">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-user"></i> {{ Auth::User()->username }} <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{asset('/user/'.Auth::User()->username.'/dashboard')}}"><i class="fa fa-fw fa-user"></i> Home</a>
                        </li>
                        <li>
                            <a href="{{asset('/user/'.Auth::User()->username.'/setting')}}"><i class="fa fa-fw fa-user"></i> Setting</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="{{ asset('/logout') }}">
                                <i class="fa fa-sign-out"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav ">
                    

                    <li class="{{ $data['active'] === 'dashboard' ? 'selected' : '' }}">
                        <a href="{{ asset('/admin/dashboard') }}">
                            <i class="fa fa-tachometer"></i>
                            Dashboard
                        </a>
                    </li>


                    <li class="{{ $data['active'] === 'upload' ? 'selected' : '' }}">
                        <a href="{{ asset('/admin/upload') }}">
                            <i class="fa fa-fw fa-cloud-upload"></i> Upload Setting</a>
                        </li>               
                        
                        <li class="{{ $data['active'] === 'users' ? 'selected' : '' }}">
                            <a href="{{ asset('/admin/user') }}">
                                <i class="fa fa-users"></i>
                                Users Setting
                            </a>
                        </li>
                        
                        <li class="">
                            <a href="javascript:;"
                            data-toggle="collapse"
                            data-target="#demo">
                            <i class="fa fa-fw fa-files-o"></i> Files Setting
                            <b class="caret"></b></a>
                            <ul id="demo" class="{{ @$data['ul'] === 'files' ? 'expand' : 'collapse' }}">
                                <li class="{{ $data['active'] === 'files' ? 'selected' : '' }}">
                                    <a href="{{ asset('/admin/file')  }}">
                                        <i class="fa fa-fw fa-user"></i> Files </a>
                                    </li>                        
                                    
                                    <li class="{{ $data['active'] === 'guestFiles' ? 'selected' : '' }}">
                                        <a href="{{ asset('/admin/category') }}">
                                            <i class="fa fa-fw fa-book"></i> Categories </a>
                                        </li>
                                        
                                    </ul>
                                </li>

                                

                            </ul>
                        </div>
                        <!-- /.navbar-collapse -->
                    </nav>
