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
            <a style="padding-top:10px;" class="navbar-brand" href="<?php echo e(asset('/')); ?>">
                Files-Admin
            </a>
        </div>
        

        <ul class="nav navbar-right top-nav">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-user"></i> <?php echo e(Auth::User()->username); ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="<?php echo e(asset('/user/'.Auth::User()->username.'/dashboard')); ?>"><i class="fa fa-fw fa-user"></i> Home</a>
                        </li>
                        <li>
                            <a href="<?php echo e(asset('/user/'.Auth::User()->username.'/setting')); ?>"><i class="fa fa-fw fa-user"></i> Setting</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="<?php echo e(asset('/logout')); ?>">
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
                    

                    <li class="<?php echo e($data['active'] === 'dashboard' ? 'selected' : ''); ?>">
                        <a href="<?php echo e(asset('/admin/dashboard')); ?>">
                            <i class="fa fa-tachometer"></i>
                            Dashboard
                        </a>
                    </li>


                    <li class="<?php echo e($data['active'] === 'upload' ? 'selected' : ''); ?>">
                        <a href="<?php echo e(asset('/admin/upload')); ?>">
                            <i class="fa fa-fw fa-cloud-upload"></i> Upload Setting</a>
                        </li>               
                        
                        <li class="<?php echo e($data['active'] === 'users' ? 'selected' : ''); ?>">
                            <a href="<?php echo e(asset('/admin/user')); ?>">
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
                            <ul id="demo" class="<?php echo e(@$data['ul'] === 'files' ? 'expand' : 'collapse'); ?>">
                                <li class="<?php echo e($data['active'] === 'files' ? 'selected' : ''); ?>">
                                    <a href="<?php echo e(asset('/admin/file')); ?>">
                                        <i class="fa fa-fw fa-user"></i> Files </a>
                                    </li>                        
                                    
                                    <li class="<?php echo e($data['active'] === 'guestFiles' ? 'selected' : ''); ?>">
                                        <a href="<?php echo e(asset('/admin/category')); ?>">
                                            <i class="fa fa-fw fa-book"></i> Categories </a>
                                        </li>
                                        
                                    </ul>
                                </li>

                                

                            </ul>
                        </div>
                        <!-- /.navbar-collapse -->
                    </nav>
