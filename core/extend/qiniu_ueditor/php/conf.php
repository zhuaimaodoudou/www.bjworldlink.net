<?php

/*
 * @description   文件上传方法
 * @author widuu  http://www.widuu.com
 * @mktime 08/01/2014
 */

require '../../../init.php';
use core\basic\Config;
use app\admin\model\system\ConfigModel;

$ConfigModel = new ConfigModel();
$config = $ConfigModel -> getList();

$qiniu_access_key = $config['qiniu_access_key']['value'];
$qiniu_secret_key = $config['qiniu_secret_key']['value'];
$qiniu_bucket 	  = $config['qiniu_bucket']['value'];
$qiniu_url		  = $config['qiniu_url']['value']; 
 
global $QINIU_ACCESS_KEY;
global $QINIU_SECRET_KEY;

$QINIU_UP_HOST	= 'http://up.qiniu.com';
$QINIU_RS_HOST	= 'http://rs.qbox.me';
$QINIU_RSF_HOST	= 'http://rsf.qbox.me';

//配置$QINIU_ACCESS_KEY和$QINIU_SECRET_KEY 为你自己的key
$QINIU_ACCESS_KEY	= $qiniu_access_key;
$QINIU_SECRET_KEY	= $qiniu_secret_key;

//配置bucket 若不知道请到七牛云平台上查看
$BUCKET = $qiniu_bucket;

//配置你的域名访问地址 修改your qiniu domain name里的内容，无需清除结尾斜线
$HOST  = "http://".$qiniu_url."/";

//上传超时时间
$TIMEOUT = "3600";

//保存规则
$SAVETYPE = "date";

//开启水印
$USEWATER = false;
$WATERIMAGEURL = "http://gitwiduu.u.qiniudn.com/ueditor-bg.png"; //七牛上的图片地址
//水印透明度
$DISSOLVE = 50;
//水印位置
$GRAVITY = "SouthEast";
//边距横向位置
$DX  = 10;
//边距纵向位置
$DY  = 10;

function urlsafe_base64_encode($data){
	$find = array('+', '/');
	$replace = array('-', '_');
	return str_replace($find, $replace, base64_encode($data));
}


