<?php
/***********************
 登陆页
*************************/
class login extends ci_controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('func',array('url'=>base_url()));
        $this->load->model('mconfig');
        $this->load->model('muser');
        $this->load->lang('error');
    }
    
    
    public function index() {
        $this->judgelogin();
        $todo=$this->input->post('todo');
        $msg='';
        if($todo=='go') { //如果已经发送过请求
            $msg=$this->_login();            
        }
        $data=$this->mconfig->get_cfg();//获取配置
        $data['msg']=$msg;
        $this->load->view('login',$data);
    }
    
    //判断登陆
    private function _login() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $user_arr=$this->muser->get_user(array('username'=>$username));
        if(!$user_arr) {
            return 'errorusname';
        }
        //判断密码是否正确
	$rand=$user_arr[0]['rand'];
        if($this->muser->passwordrand($password,$rand)!=$user_arr[0]['password']) {
            return 'errorpwd';
        }
        if($user_arr[0]['status']!=1) { //状态(1:正常;0:未验证;2:冻结)
            return 'lockusername';
        }
        setcookie('user_id',$user_arr[0]['uid'],0,'/');
        setcookie('username',$user_arr[0]['username'],0,'/');
        setcookie('group',$user_arr[0]['group'],0,'/'); 
        redirect('index');//跳转到主页
        return true;
    }
    
    //判断登陆
    private function judgelogin() {
        //如果有登陆，则直接跳转到主页
        if($this->input->cookie('user_id')) {
            redirect('index');
            exit();
        }
        return true;
    }
}