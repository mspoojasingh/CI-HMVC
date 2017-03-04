<?php
    $this->load->view('header');
    $this->load->view('sidebar');
?>
<div class="content-wrapper" >
    <?php $this->load->view('breadcrum');?>
    <div class="content">
            <?php $this->load->view($module.'/'.$view); ?>
    </div>
</div>
<?php $this->load->view('footer'); ?>