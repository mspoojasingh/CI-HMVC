<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Dashboard
    <small>Attribute</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo site_url($module_root.'/attribute-form');?>"><i class="fa fa-plus-square-o"></i>Add</a></li>
    <li class="active"><a href="<?php echo site_url($module_root.'/attribute-list');?>"><i class="fa fa-list"></i>List</a></li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <!-- Alert Message -->
  <?php
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
  <?php
  if(!isset($AttributeValue[0]))
    $AttributeValue = $AttributeValue;
  else
    $AttributeValue = $AttributeValue[0];
  ?>
  <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-md-12">
      <!--general form elements disabled-->
      <div class="box box-warning">
        <div class="box-body">
          <form role="form" method="post" action="">
            <div class="form-group">
              <label>Parent Attribute</label>
              
              <select name="parent_id" class="form-control">
                  <option value="0">Select</option>
                <?php
                foreach($parentAttributes as $val){
                    if($AttributeValue['parent_id']==$val['id']) { ?>
                  <option value="<?php echo $val['id']; ?>" selected="selected"><?php echo $val['title']; ?></option>
                    <?php }else{ ?>
                    <option value="<?php echo $val['id']; ?>"><?php echo $val['title']; ?></option>
                <?php }
               }
                ?>
              </select>
            </div>
            <!-- text input -->
            <div class="form-group">
                <label>Title<span style="color:red;">*</span></label>
              <input type="text" class="form-control" placeholder="Title" name="title" id="title" value="<?php echo $AttributeValue['title']?>"/>
            </div>
            <div class="form-group">
              <label>Short Description</label>
              <input type="text" class="form-control" placeholder="Short Description" name="short_desc" id="title" value="<?php echo $AttributeValue['short_desc']?>"/>
            </div>
            <div class="form-group">
              <label>Ordering</label>
              <input type="text" class="form-control" placeholder="Ordering" name="ordering" id="title" value="<?php echo $AttributeValue['ordering']?>"/>
              <input type="hidden" class="form-control" placeholder="Id" name="id" id="id" value="<?php echo $AttributeValue['id']?>"/>
            </div>
            <div class="form-group">              
              <button type="submit" class="btn btn-default" name="save" id="save"> Save </button>
            </div>
          </form>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!--/.col (right) -->
  </div>
</section><!-- /.content -->
