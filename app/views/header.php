<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*******************
 头部
 ******************/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1"  />
<base href="<?php if(isset($baseurl)) {echo $baseurl;}  ?>" />
<title><?php if(isset($webtitle)) {echo $webtitle;} ?></title>
<link href="css/header.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="js/jquery.js"></script>
<script language="javascript" type="text/javascript" src="js/header.js"></script>
</head>
<body>
    <!-- 导航栏-->
    <div id="top_bg" >
        <div id="top" >
                <a class="logo" href="<?php if(isset($baseurl)) {echo $baseurl;}  ?>" title="返回首页"><img src="images/logo.png"></a>
                <a class="home" href="<?php if(isset($baseurl)) {echo $baseurl;}  ?>" style="color:white;margin-left:20px;font-weight:bold;" target="_blank">首页</a>
                <div class="nav_z">
                    <ul id="navul" class="cl">
                        <li >
                            <a >活动</a>                    
                            <ul >
                                <li><a href="#"><img src="images/icon.gif">俱乐部活动</a></li>
                                <li><a href="#"><img src="images/icon.gif">自由约伴</a></li>
                                <li><a href="#"><img src="images/icon.gif">徒步一族</a></li>
                                <li><a href="#"><img src="images/icon.gif">骑行一族</a></li>
                                <li><a href="#"><img src="images/icon.gif">自驾一族</a></li>
                            </ul>
                        </li>
                        <li >
                            <a>资讯</a>
                            <ul >                               
                                <li><a href="#"><img src="images/icon.gif">户外资讯</a></li>
                                <li><a href="#"><img src="images/icon.gif">装备频道</a></li>
                                <li><a href="#"><img src="images/icon.gif">户外百科</a></li>
                                <li><a href="#"><img src="images/icon.gif">游记攻略</a></li>
                            </ul>
                        </li>
                        <li >
                            <a>社区</a>
                            <ul >                               
                                <li><a href="#"><img src="images/icon.gif">活动分享</a></li>
                                <li><a href="#"><img src="images/icon.gif">行摄天下</a></li>
                                <li><a href="#"><img src="images/icon.gif">美食一族</a></li>
                                <li><a href="#"><img src="images/icon.gif">爱车一族</a></li>
                            </ul>
                        </li>    
                    </ul> 
                </div><!--导航结束-->
                <script  type="text/javascript"> 
		$(".navbg").capacityFixed();
                </script>
                
                
                <div id="profile" class="profile">
                  <a href="<?php echo $baseurl; ?>login" target="_blank">登陆</a>
                 <img style="background-color:#fff;width:2px;height:10px;"></img>
                 <a href="#" target="_blank">注册</a>
                </div>
        </div>
    </div>
    <div style="margin: 67px 0" >


    