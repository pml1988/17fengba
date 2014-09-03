<?php
/**************
数据库操作类
 ****************/
class mdb extends ci_model{
    
    public function __construct() {
        parent::__construct();
    }
    
/**********************
*函数用途：查询数据
*@tablename 需要查询表的名称
*@where 查询条件数组       如：array('id'=>$id)
*@data  查询的字段字符串   如：id,username
*@limit 查询返回的记录数，默认为1条
*@offset 结果集指针
*@orderby 排序数组
*@orderby 分组，可以是字符串字段，也可以是只包含键值的数组
*返回值：结果集数组  或者 false
**********************/
    function dataselect($tablename,$where=array(),$data='',$limit=1,$offset=0,$orderby=array(),$groupby='') {
        if($data){
		$this->db->select($data);    //结果集字段
	}
        //查询条件语句
        if($where){
		foreach($where as $k=>$v){
			if(strpos($k,'like')!==false){
				$k=str_replace(" like","",$k);
				$this->db->like($k, $v);
			}elseif(strpos($k,' in')!==false){
					$k=str_replace(" in","",$k);
					$this->db->where_in($k, $v);
			}elseif(strpos($k,'not')!==false){
					$k=str_replace(" not","",$k);
					$this->db->where_not_in($k, $v);
			}elseif(strpos($k,'or')!==false){
					$k=str_replace(" or","",$k);
					$this->db->or_where($k, $v);
			}else{
				$this->db->where($k, $v);
			}
		}
	}
        
        //分组
	if($groupby){
		$this->db->group_by($groupby);
	}
        
        //排序
	if($orderby){
		foreach($orderby as $k=>$v){
			$this->db->order_by($k, $v);
		}
	}
        
        $query = $this->db->get($tablename,$limit,$offset);
        
        if($query->num_rows()>0){    //如果有数据
		$arr=array();
		foreach ($query->result_array() as $row)
		{
			$arr[]=$row;         //输出数组
		}
		return $arr;
	}else{
		return array();            //否则返回空
	}
    }
    
    
    /**********************
*函数用途：插入数据
*@$tablename 需要查询表的名称
*@data  需要插入的数据  如：array('name'=>$name)
*返回值：最后一次插入的id
**********************/
function dataadd($tablename,$data) {
	if($data){
		$pd=current($data);   //判断是单条插入，还是多条插入
		if(is_array($pd)){
			$this->db->insert_batch($tablename, $data);
		}else{
			$this->db->insert($tablename, $data);
		}
		$res=$this->db->insert_id();
	}else{
		$res=false;
	}
	return $res;
}


/**********************
*函数用途：修改数据
*@$tablename 需要查询表的名称
*@data  需要更新的数据数组      如：array('name'=>$name)
*@where 设定修改语句的条件数组  如：array('name'=>$name)
*返回值：true / false
**********************/
function dataedit($tablename,$data,$where) {
	if($data){
		$res=$this->db->update($tablename, $data, $where);
	}else{
		$res=false;
	}
	return $res;
}

/**********************
*函数用途：删除数据
*@$tablename 需要查询表的名称
*@where 设定修改语句的条件数组  如：array('name'=>$name)
*返回值：true / false
**********************/
function datadel($tablename,$where) {
	if($where){
		$res=$this->db->delete($tablename, $where);
	}else{
		$res=false;
	}
	return $res;
}

/**********************
*函数用途：统计符合条件的记录的条数
*@$table   表名
*@$where   查询条件
*返回值：  返回一个记录的总数
**********************/
function countnum($tablename,$where=array()) {
	//查询条件语句
	//查询条件语句
	if($where){
		foreach($where as $k=>$v){
			if(strpos($k,'like')!==false){
				$k=str_replace(" like","",$k);
				$this->db->like($k, $v);
			}elseif(strpos($k,' in')!==false){
					$k=str_replace(" in","",$k);
					$this->db->where_in($k, $v);
			}elseif(strpos($k,'not')!==false){
					$k=str_replace(" not","",$k);
					$this->db->where_not_in($k, $v);
			}elseif(strpos($k,'or')!==false){
					$k=str_replace(" or","",$k);
					$this->db->or_where($k, $v);
			}else{
				$this->db->where($k, $v);
			}
		}
	}
	$this->db->from($tablename);
	$res=$this->db->count_all_results();
	Return $res;
}

    
}