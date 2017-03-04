 <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

          <!-- Sidebar user panel (optional) -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="<?php echo ADMIN_THEME_PATH; ?>dist/img/avatar5.png" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
              <p><?php echo ucfirst($this->session->userdata('admin_name'));?></p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>

          <!-- search form (Optional) -->
          <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>
          <!-- /.search form -->

          <!-- Sidebar Menu -->
          <ul class="sidebar-menu">
            <li class="treeview">
              <a href="#"><i class='fa fa-link'></i> <span>Configuration</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <!-- <li><a href="<?php //echo site_url('admin/looking-list');?>">Looking For</a></li>
                <li><a href="<?php //echo site_url('admin/gender-list');?>">Genders</a></li> -->
                <li><a href="<?php echo site_url('#');?>">Permission</a></li>
                <li><a href="<?php echo site_url('admin/attribute-list');?>"><span>Manage Atrributes</span></a></li>
                <li><a href="<?php echo site_url('#');?>"><span>Accounts</span></a></li>
              </ul>
            </li>
            <!-- Optionally, you can add icons to the links -->
            <li class="active"><a href="<?php echo site_url('#');?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
            <li class="active">
                <a href="<?php echo site_url('admin');?>/#">
                    <i class="fa fa-dashboard"></i> 
                    <span>Report Profiles</span>
                </a>
            </li>

            <li class="active"><a href="<?php echo site_url('admin/user-list');?>"><i class="fa fa-users"></i> <span>Users</span></a></li>            
<!--            <li class="treeview">
              <a href="#"><i class='fa fa-link'></i> <span>Multilevel</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="#">Link in level 2</a></li>
                <li><a href="#">Link in level 2</a></li>
              </ul>
            </li>-->
            <li  class="treeview active"><a href="<?php echo site_url('admin/#');?>"><i class="fa fa-files-o"></i> <span>Gallery Image's</span></a></li>            
            <li  class="treeview active"><a href="<?php echo site_url('admin/#');?>"><i class="fa fa-files-o"></i> <span>Content Page</span></a></li>            
            <li  class="treeview active"><a href="<?php echo site_url('admin/#');?>"><i class="fa fa-files-o"></i> <span>Events</span></a></li>            
            
            <li class="treeview">
              <a href="<?php echo site_url('admin/#');?>"><i class='fa fa-link'></i> <span>Forum</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li  class="treeview active"><a href="<?php echo site_url('admin/#');?>"><i class="fa fa-files-o"></i> <span>Forum Category</span></a></li>            
            <li  class="treeview active"><a href="<?php echo site_url('admin/#');?>"><i class="fa fa-files-o"></i> <span>Forum Report</span></a></li>            
            <li  class="treeview active"><a href="<?php echo site_url('admin/#');?>"><i class="fa fa-files-o"></i> <span>Forum Suspended User</span></a></li>            
              </ul>
            </li>
            
            <li  class="treeview active"><a href="<?php echo site_url('admin/#');?>"><i class="fa fa-files-o"></i> <span>Contact Form Data</span></a></li>            
            </ul><!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
      </aside>
