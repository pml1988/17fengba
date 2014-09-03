<?php
/********************
 用户类
 *******************/
class muser extends ci_model {
    
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('mdb','',true);
        $this->load->model('muserlog','',true);
    }
    
    public function adduser($data,$info) //添加用户
    {
        $type=$info['type'];//获取类型是邮箱注册，还是手机注册,1:邮箱 ;2:手机
        $resultnum=array();
        if($type==1) {//邮箱注册
            $resultnum=$this->get_user(array('email'=>$data['email']));
            if($resultnum) {
                return 'haveemail';
            }
        }else {//手机注册
            $resultnum=$this->get_user(array('telephone'=>$data['telephone']));
            if($resultnum) {
                return 'havetelephone';
            }
        }
        if(strpos($data['username'],'admin')) {
            return 'haveusername';
        }
        if(get_user(array('username'=>$data['username']))) {
            return 'haveusername';   
        }
        $user_id=$this->mdb->dataadd('userlist',$data);
        $desc="";
        $t=date('Y-m-d H:i:s',$time());
        if($type==1) {
            $desc="邮箱".$data['email']."在".$t."注册";
        }else {
            $desc="手机号".$data['telephone']."在".$t."注册";
        }
        $this->muserlog->add(array('action'=>'reg','desc'=>$desc));//插入日志
        return 'ok';
    }
    
    //查找用户
    public function get_user($where,$field,$limit=1) {
      if($field) {
        $filed='uid,email,telephone,username,password,'+
               'status,emailstatus,phonestatus,avatarstatus,groupid,'+
               'regdate,group,rand,logindate';
      }
      $res=$this->mdb->dataselect('userlist',$where,$filed,$limit);
      return $res;
    }
        
    //随机数算法
    public function randmake($strlength=4){
        $rand='';
        $str='0123456789abcdefghigklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz';
        for($i=0;$i<$strlength;$i++){
                $rand.=$str[mt_rand(0,41)];
        }
        return $rand;
    }    
    
    //密码加密算法
    public function passwordrand($password,$rands) {
            $pwd = md5($password.'##'.$rands);
            return $pwd;
    }
}

