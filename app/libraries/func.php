<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//一些经常使用的函数
class func {

    public function __construct($url='')
    {
		if($url){
			$this->baseurl=$url['url'];
		}else{
			$this->baseurl='';
		}
    }

	//获得IP
	function getIp(){

        if (getenv('HTTP_CLIENT_IP'))
        {
            $ip = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR'))
        {
            list($ip) = explode(',', getenv('HTTP_X_FORWARDED_FOR'));
        } elseif (getenv('REMOTE_ADDR'))
        {
            $ip = getenv('REMOTE_ADDR');
        }
        else
        {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
	//截取字符串
/**
 * utf-8、gb2312都支持的汉字截取函数
 *
 * @param string $string      要截取的字符串
 * @param integer $sublen     要截取的长度
 * @param integer $start      从什么位置开始截取
 * @param string $code        字符的编码
 * @return string
 */

	function cut_str($string,$sublen,$start=0,$code='UTF-8')
	{
		 if($code=='UTF-8')
		 {
			  $pa="/[x01-x7f]|[xc2-xdf][x80-xbf]|xe0[xa0-xbf][x80-xbf]|[xe1-xef][x80-xbf][x80-xbf]|xf0[x90-xbf][x80-xbf][x80-xbf]|[xf1-xf7][x80-xbf][x80-xbf][x80-xbf]/";
			  preg_match_all($pa,$string,$t_string);

			  if(count($t_string[0])-$start>$sublen) return join('',array_slice($t_string[0],$start,$sublen))."...";
			  return join('',array_slice($t_string[0],$start,$sublen));
		 }else{
			$start=$start*2;
			$sublen=$sublen*2;
			$strlen=strlen($string);
			$tmpstr='';

			  for($i=0;$i<$strlen;$i++)
			  {
				   if($i>=$start&&$i<($start+$sublen))
				   {
						if(ord(substr($string,$i,1))>129)
						{
							$tmpstr.=substr($string,$i,2);
						}
						else
						{
							$tmpstr.=substr($string,$i,1);
						}
				   }
				   if(ord(substr($string,$i,1))>129) $i++;
			  }
			if(strlen($tmpstr)<$strlen ) $tmpstr.="...";
			return $tmpstr;
		 }
	}
/******************************************************************
* PHP截取UTF-8字符串，解决半字符问题。
* 英文、数字（半角）为1字节（8位），中文（全角）为3字节
* @return 取出的字符串, 当$len小于等于0时, 会返回整个字符串
* @param $str 源字符串
* $len 左边的子串的长度
****************************************************************/
function utf_substr($str,$len)
{
	for($i=0;$i<$len;$i++)
	{
		$temp_str=substr($str,0,1);
	if(ord($temp_str) > 127)
	{
		$i++;
		if($i<$len)
		{
			$new_str[]=substr($str,0,3);
			$str=substr($str,3);
		}
	}
	else
	{
		$new_str[]=substr($str,0,1);
		$str=substr($str,1);
	}
	}
	return join($new_str);
}

	/*
	*作用：将数组变成字符串
	*主要用于传递的多选框取值
	*/
	function arr_str($sep,$arr,$url)
	{
	   $test="";
	   if(is_array($arr))
	   {
		 foreach($arr as $k=>$v){
			 if($url){
				 $v="<a href='".$url.$k."'>".$v."</a>";
			 }
			 if($test){
				$test.=$sep.$v;
			 }else{
				$test=$v;
			 }
		 }
	   }
	   return $test;
	}
	/*
	*将字符串转化成数组
	*参数$sep   分割符
	*参数$str   字符串变量
	*/
	function str_arr($sep,$str)
	{
		$arr=array();
		if($str!="" || $str!=NULL)
		{
			$arr=explode($sep,$str);
		}
		return $arr;
	}
	/*
	根据键值，获得键名
	参数$arr数据的数组
	参数$sid传递值
	*/
	function arr_key($arr,$sid)
	{
	   $title="";
	   foreach ($arr as $key => $value)
	   {
		  if((string)$value==(string)$sid)
		  {
			$title=$key;
			return $title;
		  }
		  else
		  {
			$title="";
		  }
	   }
	   return $title;
	}
	/*
	生成多选框列表
	参数$arr多选框列表的数据的数组
	参数$tb_l多选框列表的名称
	参数$sel赋值(多个内容用英文,号隔开)
	*/
	function checkbox($arr,$tb_l,$sel,$jstest="")
	{
	   $selarr=$this->str_arr(",",$sel);   //将字符串转化成数组
	   $test="";
	   foreach ($arr as $key => $value)
	   {
		  if($this->arr_key($selarr,$key)!=="")   //查询
		  {
			  $checked=" checked ";
		  }
		  else
		  {
			  $checked=" ";
		  }
		  $test.="<input name=\"".$tb_l."[]\" type=\"checkbox\" value=\"".$key."\" ".$checked.$jstest.">".$value."  ";
	   }
	   return $test;
	}
	/*
	生成单选框列表
	参数$arr单选框列表的数据的数组
	参数$tb_l单选框列表的名称
	参数$sel赋值(多个内容用英文,号隔开)
	*/
	function radio($arr,$tb_l,$sel="",$jstest="")
	{
	   $test="";
	   foreach ($arr as $key => $value)
	   {
		  if($sel==$key)   //查询
		  {
			  $checked=" checked ";
		  }
		  else
		  {
			  $checked=" ";
		  }
		  $test.="<input name=\"".$tb_l."\" type=\"radio\" value=\"".$key."\" ".$checked.$jstest.">".$value."  ";
	   }
	   return $test;
	}

	/*
	生成下拉选项列表,数组的键名是值，键值是显示
	参数$arr下拉框的数据的数组
	参数$tb_l下拉框的名称
	参数$sel下拉框的当前的值
	参数$msg主要用于添加js判断
	*/
	function option($arr,$tb_l,$sel="",$msg="")
	{
	   $test="<select name=".$tb_l." id=".$tb_l." ".$msg.">";
	   $test.="<option value=\"\">请选择</option>";
	   foreach ($arr as $key => $value)
	   {
		  $test.="<option value=\"".$key."\" ";
		  if($key==$sel)
		  {
		  $test.=" selected ";
		  }
		  $test.=">".$value."</option>";
	   }
	   $test.="<select>";

	   return $test;
	}
	/*
	快速生成载入js的函数
	*/
	function jstest($js)
	{
	    $test="";
		$arr=$this->str_arr(",",$js);   //将字符串转化成数组
		foreach($arr as $v){
			$test.='
			<script type="text/javascript" src="'.$this->baseurl.'js/'.$v.'.js"></script>
			';
		}
	    return $test;
	}
	/*
	快速生成载入css的函数
	*/
	function csstest($js)
	{
	    $test="";
		$arr=$this->str_arr(",",$js);   //将字符串转化成数组
		foreach($arr as $v){
			$test.='
			<link href="'.$this->baseurl.'css/'.$v.'.css" rel="stylesheet" type="text/css" />
			';
		}
	    return $test;
	}

	//验证用户名算法,邮箱
	function chk_email($str){
		if(!$str){
			return false;
		}
		if(strpos($str,"@")===false){
			return false;
		}
		return true;
	}
	//验证手机算法,手机号码，只能11正位整数
	function chk_mobile($str){
		if(!$str){
			return false;
		}
		if(!preg_match("/^1[34568]+\d{9}/u", $str)){
			return false;
		}
		if(strlen($str)!=11){
			return false;
		}
		return true;
	}
	//验证密码算法,只能小写字母,大写字母,数字,下划线，长度在6-20位之间
	function chk_psw($str){
		if(!$str){
			return false;
		}
		if(!preg_match("/^[a-za-z0-9_]+$/u", $str)){
			return false;
		}
		if(strlen($str)<6 || strlen($str)>20){
			return false;
		}
		return true;
	}
	//验证昵称算法,不能超过10个字符
	function chk_nickname($str) {
		if(!$str){
			return false;
		}
		$str_len = mb_strlen($str,'utf8');
		if($str_len > 30 || $str_len <3){
			return false;
		}
		return true;
	}
	//验证正整数
	function chk_nums($str) {
		if(!$str){
			return false;
		}
		if(!preg_match("/^[0-9]*[1-9][0-9]*$/u", $str)){
			return false;
		}
		return true;
	}
	//验证体重算法,只能正浮点数，不能大于200kg,小于30kg
	function chk_weight($str) {
		if(!$str){
			return false;
		}
		if(!preg_match("/^(([0-9]+\\.[0-9]*[1-9][0-9]*)|([0-9]*[1-9][0-9]*\\.[0-9]+)|([0-9][1-9]*[0-9]*))$/u", $str)){
			return false;
		}
		if($str>200 || $str<30){
			return false;
		}
		return true;
	}
	//验证性别算法,只能0，1
	function chk_sex($str) {
		if(!preg_match("/^[0-1]+$/u", $str)){
			return false;
		}
		if(strlen($str)!=1){
			return false;
		}
		return true;
	}
	//验证生日算法,只能 年-月-日 不能少于1岁和大于100岁
	function chk_date($str) {
		if(!$str){
			return false;
		}
		if(!preg_match("/^(19|20)[0-9]{2}-(0[1-9])|([1-9])|(1[0-2])-(0[1-9])|([1-9])|([12][0-9])|(3[01])$/u",$str)){
			return false;
		}
		$userdate=getdate(strtotime($str));
		$sysdate=getdate();
		$age=$sysdate['year'] - $userdate['year'];
		if($age>100 || $age<1){
			return false;
		}
		return true;
	}

//转化成货币来输出
	function doFormatMoney($m){
		//Return money_format($money);  windows无法执行
	$tmp=explode(".",$m);
	$money=$tmp[0];
    $tmp_money = strrev($money);
    $format_money = "";
    for($i = 3;$i<strlen($money);$i+=3){
        $format_money .= substr($tmp_money,0,3).",";
         $tmp_money = substr($tmp_money,3);
     }
    $format_money .=$tmp_money;
	$format_money = strrev($format_money);
/*
	if(isset($tmp[1])){
		$format_money = $format_money.".".$tmp[1];
	}
*/
    return $format_money;
}

//随机数算法
	function randmake($strlength=4){
		$rand='';
		$str='0123456789abcdefghigklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz';
		for($i=0;$i<$strlength;$i++){
			$rand.=$str[mt_rand(0,41)];
		}
		return $rand;
	}

//utf-8字符长度
function utf8_strlen($string = null) {
	// 将字符串分解为单元
	preg_match_all("/./us", $string, $match);
	// 返回单元个数
	return count($match[0]);
}

		function redirect($url = '', $msg) {
		if(!$msg) {
			header("location: ".$url);
			exit;
		}else {
			$url = $url ? "location.href='$url';" : "if(history.length<=1){location.href='$url';}else{history.go(-1);}";
			$msg = <<<EOD
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
	<!--<meta http-equiv="refresh" content="10; url=$url" />-->
	<title>页面跳转</title>
<style type="text/css">
html,body {padding:0px; margin:0px; font-family:arial; padding:0px; margin:0px; list-style:none; line-height:25px; font-size:12px}
a {color:#666; text-decoration:none}
a:hover {color:#157dcc; text-decoration:none}
.msg {margin:15px}
.msg h1 {font-size:14px; color:#09c; line-height:35px; margin:0px; padding:0px; display:none}
.msg div {border-top:4px solid #DEEFFA; border-bottom:4px solid #deeffa; background:#F2F9FD; text-align:center}
.msg div h2 {color:#090; line-height:25px; font-size:14px; padding:0px 15px}
.msg div h2 span {color:#2366A8; font-size:14px}
.msg div a {color:#666; text-decoration:underline}
#timer {padding:0px 2px; font-weight:normal; font-style:normal}
</style>
</head>
<body>
	<div class="msg">
		<h1>提示</h1>
		<div>
			<h2>$msg<span><i id="timer">2</i> 秒钟后为您跳转！</span></h2>
			<script language="javascript">var i = 2; var time = setInterval("i--; document.getElementById('timer').innerHTML = i; if(i == 0){{$url} window.clearInterval(time)}", 1000);</script>
			<p><a href="javascript:void(0);" onclick="$url">如果您的浏览器没有自动跳转，请点击这里。</a></p>
		</div>
	</div>
</body>
</html>
EOD;
			die($msg);
		}
	}
	
	function num2Letter($num) {
		$num = intval($num);
		if ($num <= 0) return false;
		$letterArr = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
		$letter = '';
		do {
			$key = ($num - 1) % 26;
			$letter = $letterArr[$key] . $letter;
			$num = floor(($num - $key) / 26);
		} while ($num > 0);
		return $letter;
	}
}