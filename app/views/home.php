<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*******************
 首页
 ******************/
?>
<?php $this->load->view('header'); ?>

<link href="css/home.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/home.js"></script>

<div class="top_box_layout">
    <div class="box">
            <ol></ol>
            <ul>
            <li class="active" style="left:0;z-index:11;"><img src="images/1.jpg" /><span style="display:none">图片1</span></li>
            <li><img src="images/2.jpg" /><span style="display:none">图片2</span></li>
            <li><img src="images/3.jpg" /><span style="display:none">图片3</span></li>
            <li><img src="images/4.jpg" /><span style="display:none">图片4</span></li>
        </ul>
    </div>
    <div class="notice_hot_layout" >
        
    </div>
</div>




<?php $this->load->view('footer'); ?>