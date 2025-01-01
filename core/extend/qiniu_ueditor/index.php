<?php
if (!defined('puyuetian'))
	exit('403');

$path = $_G['SYSTEM']['PATH'] . '/app/baidu_ueditor/php/' . $_G['GET']['PHP'] . '.php';
if (file_exists($path)) {
	require $path;
}
