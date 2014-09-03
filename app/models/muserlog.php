<?php
/**************************
 用户日志类
 **************************/
class muserlog extends ci_model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('mdb','',true);
        $this->db_table='user_log';
        $this->db_filed='id,device_type,ctime,action,desc';
    }
    
    //获取日志
    public function get($where=array(),$limit=20,$offset=0,$field='') {
        $field=$filed?$field:$this->db_filed;
        $data=$this->mdb->dataselect($this->db_table,$where,$field,$limit,$offset);
        $arr=array();
        foreach($data as $v) {
            $arr[]=$v;
        }
        return $arr;
    }
    
    //统计日志
    public function count($where=array()) {
        return $this->mdb->countnum($this->db_table,$where);
    }
    
    //添加日志
    public function add($data) {
        $res=false;
        if($data) {
            $data['ctime']=time();
            $this->mdb->dataadd($this->db_table,$data);
        }
        return $res;
    }
}
