<?php
if (!defined('puyuetian'))
	exit('403');

if ($_G['GET']['C'] == 'edit' || $_G['GET']['C'] == 'read') {
	$h = '<script src="app/baidu_ueditor/ueditor.config.js"></script><script src="app/baidu_ueditor/ueditor.all.min.js"></script><script>$(function() {';
	$f = '});</script>';
	if ($_G['GET']['C'] == 'edit') {
		$_G['SET']['EMBED_FOOT'] .= $h . $_G['SET']['APP_BAIDU_UEDITOR_EMBED_EDIT'] . $f;
	} else {
		$_G['SET']['EMBED_FOOT'] .= $h . $_G['SET']['APP_BAIDU_UEDITOR_EMBED_READ'] . $f;
	}
	unset($h, $f);
}
