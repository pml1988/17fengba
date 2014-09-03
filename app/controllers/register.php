<?php
/************************
 *注册类
 ***********************/
class reg extends ci_controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('func',array('url'=>base_url()));
        $this->load->model('muser');
        $this->load->lang('error');
    }
    
    public function index() {
     $this->judgelogin();
     $todo=$this->input->post('todo');
     if($todo=='go') {
           //如果开始注册了，输出结果
           $msg=$this->_reg();
     }
     
    }
    
    //注册
    private function _reg() {
        $type=$this->input->post('type');//类型  1:邮箱 2：手机
        $email=$this->post->input('email');//邮箱
        $telephone=$this->post->input('telephone');//电话号码
        $username=$this->post->input('username');//用户名
        $password=$this->post->input('password');//密码
        $password2=$this->post->input('password2');//确认密码
        $yzm=$this->post->input('yzm');//验证码
        
        if(!$type) {
            return 'notype';
        }
        if($type==1) {
            if(!$this->func->chk_email($email)) {
                return 'erroremail';
            }
        }else {
            if(!$this->func->chk_mobile($telephone)) {
                return 'errorphone';
            }
        }
        if(!$this->func->chk_nickname($username)) {
            return 'errorusername';
        }
        if(!$this->func->chk_psw($password)) {
            return 'errorpassword';
        }
        if($password!=$password2) {
            return 'errorpassword2';
        }
        if($yzm!=$_SESSION['authnum_session']) {
            return 'erroryzm';
        }
        $rand=$this->muser->randmake();
        $data=array();
        $data['username'] = $username;
        $data['password'] = $this->muser->passwordrand($password,$rand);
        $data['email'] = $email;
        $data['telephone'] = $telephone;
        $data['status'] = 0;
        $data['emailstatus'] = 0;
        $data['phonestatus'] = 0;
        $data['avatarstatus'] = 0;
        $data['groupid'] = 3;
        $data['regdate'] = time();
        $data['group'] = 'user';
        $data['rand'] = $rand;
        $data['logindata'] = 0;
        
        $info=array();
        $info['type']=$type;
        return $this->muser->adduser($data,$info);
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