<?php
/*******************
板块类
********************/
class mblock extends ci_model {
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('mdb','',true);
        $this->config->load('global_array');
        $this->db_table='common_block';
        $this->db_field='bid,name,parent_bid,threads,posts,todayposts';
    }
    
    //添加板块
    public function addblock($data) {

        $arr= $this->mdb->dataadd($this->db_table,$data);
        
        return $arr;
    }
    
    //添加帖子数
    public function insertposts()  {
        
    }
}
