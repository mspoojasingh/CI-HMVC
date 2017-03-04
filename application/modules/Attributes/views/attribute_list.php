<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Attributes
    <small>Manage </small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo site_url($module_root.'/attribute-form');?>"><i class="fa fa-plus-square-o"></i> Add</a></li>
    <li class="active"><a href="<?php echo site_url($module_root.'/attribute-list');?>"><i class="fa fa-list"></i>List</a></li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <!-- Alert Message -->
  <?php //print_r($data);die;
  if(validation_errors()){ ?>
  <div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <?php echo validation_errors(); ?>
  </div>
  <?php } ?>
  <?php
  if($this->session->flashdata('msg')){ ?>
  <div class="alert alert-<?php echo $this->session->flashdata('flag'); ?> alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <?php echo $this->session->flashdata('msg'); ?>
  </div>
  <?php } ?>
  <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-md-12">
      <!-- general form elements disabled -->
      <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Filter By Parent Attribute</h3>
                  <form role="form" id="myForm" method="post" action="">
                      <?php //print_r($filter['parent_id']);?>
                        <select name="parent_id" class="form-control" onchange="getFilter();" >
                        <option value="">Select</option>
                        <?php
                        foreach($parentAttributes as $val){ 
                            if($filter['parent_id'] == $val['id']){ ?>
                            <option value="<?php echo $val['id']; ?>" selected="selected"><?php echo $val['title']; ?></option>
                                <?php }else{ ?>
                            <option value="<?php echo $val['id']; ?>"><?php echo $val['title']; ?></option>
                        <?php } 
                        } ?>
                        </select>
                    </form>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <?php if(isset($filter['parent_id'])) echo "<h6>Parent ID-:".$filter['parent_id']."</h6>"; ?>
                <?php
                if(!empty($data)){
                ?>
                  <table class="table table-bordered">
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Title</th>
                      <th style="width:20%;">Action</th>                
                      <th style="width:10%;">Ordering</th>                
                      <th style="width:10%;">ID</th>                
                    </tr>
                    <?php
                    $current_page = $this->uri->segment(3);
                    if($current_page=='')
                        $current_page = 1;
                    $i = ($current_page - 1)*$per_page+1;
                    foreach($data as $records){
                    ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $records['title']; ?></td>
                      <td>
                          <a href="<?php echo site_url("admin/attribute-form/".$records['id']);?>"   class="btn btn-primary btn-xs" >
                              <span class="glyphicon glyphicon-pencil">Edit</span>
                          </a>&nbsp;
                          <?php if($records['is_delete']!=1 && FALSE){ ?>
                          <a href="<?php echo site_url("admin/attribute-del/".$records['id']);?>" 
                             onclick="return confirm('Are you sure! You want to delete?');"  class="btn btn-danger btn-xs" >
                            <span class="glyphicon glyphicon-trash"></span>
                        </a>
                          <?php } ?>
                      </td>               
                      <td><?php echo $records['ordering']; ?></td>               
                      <td><?php echo $records['id']; ?></td>               
                    </tr> 
                    <?php
                    $i++;
                    }
                    ?>                   
                  </table>
                  <?php
                  }else{
                    echo "No data";
                  }
                  ?>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                  <?php echo $this->pagination->create_links(); ?>
                </div>
              </div><!-- /.box -->
    </div><!--/.col (right) -->
  </div>
</section><!-- /.content -->
<script>
    function getFilter(){
         document.getElementById("myForm").submit();
    }
    </script>
