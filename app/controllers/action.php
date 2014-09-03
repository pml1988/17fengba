<?php

class action extends ci_controller{
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('func',array('url'=>base_url()));
        $this->load->model('mblock');
    }
    
    public function addBlock() {
        $block=$this->config->item('block');
        $activity=$this->config->item('activity');
        $infomation=$this->config->item('infomation');
        $bbs=$this->config->item('bbs');

        for($i=0;$i<count($block);$i++) {

            $data_parent=array('bid'=>$i+1,'name'=>$block[$i+1],'parent_bid'=>0);
            $data[]=$data_parent;
        }
        
        for($i=0;$i<count($activity);$i++) {
            $data_parent=array('bid'=>$i+1,'name'=>$activity[$i+1],'parent_bid'=>1);
            $data[]=$data_parent;
        }
        for($i=0;$i<count($infomation);$i++) {
            $data_parent=array('bid'=>$i+1,'name'=>$infomation[$i+1],'parent_bid'=>2);
            $data[]=$data_parent;
        }
        for($i=0;$i<count($bbs);$i++) {
            $data_parent=array('bid'=>$i+1,'name'=>$bbs[$i+1],'parent_bid'=>3);
            $data[]=$data_parent;
        }
       // var_dump($data);
        var_dump( $this->mblock->addblock($data));
    }
    
    
}



?>
     
     