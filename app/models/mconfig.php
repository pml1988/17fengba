<?php
/******************
 配置
 *****************/
class mconfig extends ci_model {
    public function __construct() {
       parent::__construct();
       $this->load->helper('url');
       $this->load->model('mdb','',true);
    }
    
    //获取配置
    public function get_cfg() {
        $data=array();
        $data['baseurl']=base_url();//网址
        $data['cookie_userid']=$this->input->cookie('user_id',true);//检查登陆 cookie_Id
        $data['username']=$this->input->cookie('username',true);//检查登陆 username
        $data['webtitle']='一起疯吧'; //网站标题
        $data['webkeywords']='一起疯吧';//网站关键词
        $data['webdescription']='一起疯吧';//网站描述
        return $data;
    }
}