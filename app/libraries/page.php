<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class page
{
//function minupage($array)     : 构造函数，参数( 数组(total总页数，perpage每页显示行数，nowindex当前页,url地址,ajax模式) )
/**
* config ,public
*/
var $page_name="page";//page标签，用来控制url页。比如说xxx.php?PB_page=2中的PB_page
var $pre_page='<';//上一页
var $next_page='>';//下一页
var $first_page='First';//首页
var $last_page='Last';//尾页
var $format_left='';
var $format_right='';
var $is_ajax=false;//是否支持AJAX分页模式
var $style="";      //页码的样式
var $nowindex_style="";  //当前页的样式
var $pro_style="";  //上一页样式
var $next_style=""; //下一页样式
var $first_style=""; //首页样式
var $last_style="";  //尾页样式
var $lab="";         //突出显示

/**
* private
*
*/

var $pagebarnum=5;//控制每页显示的页码个数。
var $totalpage=0;//总页数
var $ajax_action_name='';//AJAX动作名
var $nowindex=1;//当前页
var $url="";//url地址头
var $offset=0;

/**
   * constructor构造函数
   *
   * @param array $array['total'],$array['perpage'],$array['nowindex'],$array['url'],$array['ajax']...
   */
function __construct($array)
{
   if(is_array($array)){
     if(!array_key_exists('total',$array))$this->error(__FUNCTION__,'need a param of total');
     $total=intval($array['total']);
     $perpage=(array_key_exists('perpage',$array))?intval($array['perpage']):10;
     $nowindex=(array_key_exists('nowindex',$array))?intval($array['nowindex']):'';
     $url=(array_key_exists('url',$array))?$array['url']:'';
	 $style=(array_key_exists('style',$array))?$array['style']:'';
	 $nowindex_style=(array_key_exists('nowindex_style',$array))?$array['nowindex_style']:'';
	 $pro_style=(array_key_exists('pro_style',$array))?$array['pro_style']:'';
	 $next_style=(array_key_exists('next_style',$array))?$array['next_style']:'';
	 $first_style=(array_key_exists('first_style',$array))?$array['first_style']:'';
	 $last_style=(array_key_exists('last_style',$array))?$array['last_style']:'';
	 $lab=(array_key_exists('lab',$array))?$array['lab']:'';

	 $pre_page=(array_key_exists('pre_page',$array))?$array['pre_page']:'';
	 $next_page=(array_key_exists('next_page',$array))?$array['next_page']:'';
	 $first_page=(array_key_exists('first_page',$array))?$array['first_page']:'';
	 $last_page=(array_key_exists('last_page',$array))?$array['last_page']:'';
	 $pagebarnum=(array_key_exists('pagebarnum',$array))?$array['pagebarnum']:'';
   }else{
	 echo "page param error";
	 exit(0);
   }
   if((!is_int($total))||($total<0))$this->error(__FUNCTION__,$total.' is not a positive integer!');
   if((!is_int($perpage))||($perpage<=0))$this->error(__FUNCTION__,$perpage.' is not a positive integer!');
   if(!empty($array['page_name']))$this->set('page_name',$array['page_name']);//设置pagename
   $this->_set_nowindex($nowindex);//设置当前页
   $this->_set_url($url);//设置链接地址
   $this->totalpage=ceil($total/$perpage);   //总页数
   $this->offset=($this->nowindex-1)*$perpage;
   if($style){$this->_set_style($style);}
   if($nowindex_style){$this->_set_nowindex_style($nowindex_style);}
   if($pro_style){$this->_set_pro_style($pro_style);}
   if($next_style){$this->_set_next_style($next_style);}
   if($first_style){$this->_set_first_style($first_style);}
   if($last_style){$this->_set_last_style($last_style);}
   if($lab){$this->_set_lab($lab);}

   if($pre_page){$this->_set_pre_page($pre_page);}
   if($next_page){$this->_set_next_page($next_page);}
   if($first_page){$this->_set_first_page($first_page);}
   if($last_page){$this->_set_last_page($last_page);}
   if($pagebarnum){$this->_set_pagebarnum($pagebarnum);}

   if(!empty($array['ajax']))$this->open_ajax($array['ajax']);//打开AJAX模式
}

/**
   * 控制分页显示风格（你可以增加相应的风格）
   *
   * @param int $mode
   * @return string
   */
function show($mode=1,$url='')
{
   switch ($mode)
   {
   case '1':
     return $this->get_pre_page($this->pro_style).$this->nowbar($this->style,$this->nowindex_style).$this->get_next_page($this->next_style).'第'.$this->select($url).'页'."<script>function open_select(obj){location.href=obj.value;}</script>";
     break;
   case '2':
     return $this->get_first_page($this->first_style).$this->get_pre_page($this->pro_style).'[第'.$this->nowindex.'页]'.$this->get_next_page($this->next_style).$this->get_last_page($this->last_style).'第'.$this->select($url).'页'."<script>function open_select(obj){location.href=obj.value;}</script>";
     break;
   case '3':
     return $this->get_first_page($this->first_style).$this->get_pre_page($this->pro_style).$this->get_next_page($this->next_style).$this->get_last_page($this->last_style);
     break;
   case '4':
     return $this->get_pre_page($this->pro_style).$this->nowbar($this->style,$this->nowindex_style).$this->get_next_page($this->next_style);
     break;
   }

}

/**
   * 设定类中指定变量名的值，如果改变量不属于这个类，将throw一个exception
   *
   * @param string $var
   * @param string $value
   */
function set($var,$value)
{
   if(in_array($var,get_object_vars($this)))
     $this->$var=$value;
   else {
   $this->error(__FUNCTION__,$var." does not belong to PB_Page!");
   }

}

/**
   * 打开倒AJAX模式
   *
   * @param string $action 默认ajax触发的动作。
   */
function open_ajax($action)
{
   $this->is_ajax=true;
   $this->ajax_action_name=$action;
}
/**
   * 获取显示"下一页"的代码
   *
   * @param string $style
   * @return string
   */
function get_next_page($style='')
{
   if($this->nowindex<$this->totalpage){
   return $this->_get_link($this->_get_url($this->nowindex+1),$this->next_page,$style);
   }
   return '';
}

/**
   * 获取显示“上一页”的代码
   *
   * @param string $style
   * @return string
   */
function get_pre_page($style='')
{
   if($this->nowindex>1){
   return $this->_get_link($this->_get_url($this->nowindex-1),$this->pre_page,$style);
   }
   return '';
}

/**
   * 获取显示“首页”的代码
   *
   * @return string
   */
function get_first_page($style='')
{
   if($this->nowindex==1){
       return '';
   }
   return $this->_get_link($this->_get_url(1),$this->first_page,$style);
}

/**
   * 获取显示“尾页”的代码
   *
   * @return string
   */
function get_last_page($style='')
{
   if($this->nowindex==$this->totalpage){
       return '';
   }
   return $this->_get_link($this->_get_url($this->totalpage),$this->last_page,$style);
}

function nowbar($style='',$nowindex_style='')
{
   $plus=ceil($this->pagebarnum/2);
   if($this->pagebarnum-$plus+$this->nowindex>$this->totalpage)$plus=($this->pagebarnum-$this->totalpage+$this->nowindex);
   $begin=$this->nowindex-$plus+1;
   $begin=($begin>=1)?$begin:1;
   $return='';

   //翻页超过2的，显示首页
   if(intval($begin) > 2){
		$return.=$this->_get_text($this->_get_link($this->_get_url(1),1,$style));
		$return.="..";
   }

   for($i=$begin;$i<$begin+$this->pagebarnum;$i++)
   {
   if($i<=$this->totalpage){
     if($i!=$this->nowindex){
         $return.=$this->_get_text($this->_get_link($this->_get_url($i),$i,$style));
	 }
     else{
		 if($nowindex_style){$class_test=' class="'.$nowindex_style.'"';}
         $return.=$this->_get_text('<span '.$class_test.'>'.$i.'</span>');
	 }
   }else{
     break;
   }
   $return.="\n";
   }

   $nownum=($this->totalpage-$this->nowindex);

   if($nownum>$this->pagebarnum){
		$return.="..";
		$return.=$this->_get_text($this->_get_link($this->_get_url($this->totalpage),$this->totalpage,$style));
   }

   unset($begin);
   return $return;
}
/**
   * 获取显示跳转按钮的代码
   *
   * @return string
   */
function select($url)
{
   $return='<select name=";PB_Page_Select"  onChange=open_select(this)>';
   for($i=1;$i<=$this->totalpage;$i++)
   {
   if($i==$this->nowindex){
     $return.='<option value='.$url.$i.' selected>'.$i.'</option>';
   }else{
     $return.='<option value='.$this->_get_url($i).'>'.$i.'</option>';
   }
   }
   unset($i);
   $return.='</select>';
   return $return;
}

/**
   * 获取mysql 语句中limit需要的值
   *
   * @return string
   */
function offset()
{
   return $this->offset;
}

/*----------------private function (私有方法)-----------------------------------------------------------*/
/**
   * 设置url头地址
   * @param: String $url
   * @return boolean
   */
function _set_url($url="")
{
   if(!empty($url)){
       //手动设置
   $this->url=$url.((stristr($url,'/'))?'/':'/');
   }else{
       //自动获取
   if(empty($_SERVER['QUERY_STRING'])){
       //不存在QUERY_STRING时
     $this->url=$_SERVER['REQUEST_URI']."/";
   }else{
       //
     if(stristr($_SERVER['QUERY_STRING'],$this->page_name.'=')){
         //地址存在页面参数
     $this->url=str_replace($this->nowindex,'',$_SERVER['REQUEST_URI']);
     $last=$this->url[strlen($this->url)-1];
     if($last=='/'||$last=='/'){
         $this->url.='';
     }else{
         $this->url.='/';
     }
     }else{
         //
     $this->url=$_SERVER['REQUEST_URI'].'/';
     }//end if
   }//end if
   }//end if
}

/**
   * 设置当前页面
   *
   */
function _set_nowindex($nowindex)
{
   if(empty($nowindex)){
   //系统获取

   if(isset($_GET[$this->page_name])){
     $this->nowindex=intval($_GET[$this->page_name]);
   }
   }else{
       //手动设置
   $this->nowindex=intval($nowindex);
   }
}

//设置页码样式
function _set_style($style)
{
   if(!empty($style)){
	   $this->style=$style;
   }
}
//设置当前页样式
function _set_nowindex_style($nowindex_style)
{
   if(!empty($nowindex_style)){
	   $this->nowindex_style=$nowindex_style;
   }
}

//设置上一页样式
function _set_pro_style($pro_style)
{
   if(!empty($pro_style)){
	   $this->pro_style=$pro_style;
   }
}
//设置下一页样式
function _set_next_style($next_style)
{
   if(!empty($next_style)){
	   $this->next_style=$next_style;
   }
}
//设置首页样式
function _set_first_style($first_style)
{
   if(!empty($first_style)){
	   $this->first_style=$first_style;
   }
}
//设置尾页样式
function _set_last_style($last_style)
{
   if(!empty($last_style)){
	   $this->last_style=$last_style;
   }
}

//设置上一页
function _set_pre_page($pre_page)
{
   if(!empty($pre_page)){
	   $this->pre_page=$pre_page;
   }
}
//设置下一页
function _set_next_page($next_page)
{
   if(!empty($next_page)){
	   $this->next_page=$next_page;
   }
}
//设置首页
function _set_first_page($first_page)
{
   if(!empty($first_page)){
	   $this->first_page=$first_page;
   }
}
//设置尾页
function _set_last_page($last_page)
{
   if(!empty($last_page)){
	   $this->last_page=$last_page;
   }
}
//设置每页显示的页码个数
function _set_pagebarnum($pagebarnum)
{
   if(!empty($pagebarnum)){
	   $this->pagebarnum=$pagebarnum;
   }
}
//设置每页显示的页码个数
function _set_lab($lab)
{
   if(!empty($lab)){
	   $this->lab=$lab;
   }
}
/**
   * 为指定的页面返回地址值
   *
   * @param int $pageno
   * @return string $url
   */
function _get_url($pageno=1)
{
   return $this->url.$pageno;
}

/**
   * 获取分页显示文字，比如说默认情况下_get_text('<a href="">1</a>')将返回[<a href="">1</a>]
   *
   * @param String $str
   * @return string $url
   */
function _get_text($str)
{
   return $this->format_left.$str.$this->format_right;
}

/**
   * 获取链接地址
*/
function _get_link($url,$text,$style=''){
   $style=(empty($style))?'':'class="'.$style.'"';
   if($this->lab){
	   $text='<'.$this->lab.'>'.$text.'</'.$this->lab.'>';
   }else{
	   $text=$text;
   }
   if($this->is_ajax){
       //如果是使用AJAX模式
		return '<a '.$style.' href="javascript:'.$this->ajax_action_name.'(\''.$url.'\')">'.$text.'</a>';
   }else{
		return '<a '.$style.' href="'.$url.'">'.$text.'</a>';
   }
}
/**
   * 出错处理方式
*/
function error($function,$errormsg)
{
     die('Error in file <b>'.__FILE__.'</b> ,Function <b>'.$function.'()</b> :'.$errormsg);
}

/*
 * 计算前台页面的总页数
 * @param total  总记录数
 * @param num    每页的记录数
*/
function sumPage($total,$num)
{
  $nn=0;
  $nn=intval($total/$num);
  if((int)($total%$num)!=0)
  {
     $nn=$nn+1;
  }
  return $nn;
}

}