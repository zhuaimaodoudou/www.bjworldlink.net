<?php
/**
 * @ copyright (C)2016-2099 Hnaoyun Inc.
 * @ author XingMeng
 * @ email hnxsh@foxmail.com
 * @ date 2017年4月14日
 * 公共处理函数
 */
use core\basic\Config;

// 获取字符串型自动编码
function get_auto_code($string, $start = '1')
{
    if (! $string)
        return $start;
    if (is_numeric($string)) { // 如果纯数字则直接加1
        return sprintf('%0' . strlen($string) . 's', $string + 1);
    } else { // 非纯数字则先分拆
        $reg = '/^([a-zA-Z-_]+)([0-9]+)$/';
        $str = preg_replace($reg, '$1', $string); // 字母部分
        $num = preg_replace($reg, '$2', $string); // 数字部分
        return $str . sprintf('%0' . (strlen($string) - strlen($str)) . 's', $num + 1);
    }
}

// 获取指定分类列表
function get_type($tcode)
{
    $type_model = model('admin.system.Type');
    if (! ! $result = $type_model->getItem($tcode)) {
        return $result;
    } else {
        return array();
    }
}

//获取指定栏目的模型编号
function get_mcode($scode)
{
    $content_model = model('admin.content.Content');
    return $content_model->findMcode($scode);
    
}
// 获取指定栏目下内容列表
function get_list($mcode,$scode)
{
    $content_model = model('admin.content.Content');
    if (! ! $result = $content_model->findRelation($mcode,$scode)) {
        return $result;
    } else {
        return array();
    }
}

// 生成区域选择
function make_area_Select($tree, $selectid = null)
{
    $list_html = '';
    global $blank;
    foreach ($tree as $values) {
        // 默认选择项
        if ($selectid == $values->acode) {
            $select = "selected='selected'";
        } else {
            $select = '';
        }
        
        // 禁用父栏目选择功能
        if ($values->son) {
            $disabled = "disabled='disabled'";
        } else {
            $disabled = '';
        }
        $list_html .= "<option value='{$values->acode}' $select $disabled>{$blank}{$values->acode} {$values->name}";
        
        // 子菜单处理
        if ($values->son) {
            $blank .= '　　';
            $list_html .= make_area_Select($values->son, $selectid);
        }
    }
    // 循环完后回归位置
    $blank = substr($blank, 0, - 6);
    return $list_html;
}

// 检测指定的方法是否拥有权限
function check_level($btnAction, $isPath = false)
{
    $user_level = session('levels');
    if ($isPath) {
        if (in_array($btnAction, $user_level)) {
            return true;
        }
    } else {
        if (in_array('/' . M . '/' . C . '/' . $btnAction, $user_level) || session('id') == 1) {
            return true;
        }
    }
}

// 获取返回按钮
function get_btn_back($btnName = '返 回')
{
    if (! ! $backurl = get('backurl')) {
        $url = base64_decode($backurl);
    } elseif (isset($_SERVER["HTTP_REFERER"])) {
        $url = $_SERVER["HTTP_REFERER"];
    } else {
        $url = url('/' . M . '/' . C . '/index');
    }
    
    $btn_html = "<a href='" . $url . "' class='layui-btn layui-btn-primary'>$btnName</a>";
    return $btn_html;
}

// 获取新增按钮
function get_btn_add($btnName = '新 增')
{
    $user_level = session('levels');
    if (! in_array('/' . M . '/' . C . '/add', $user_level) && session('id') != 1)
        return;
    $btn_html = "<a href='" . url("/" . M . '/' . C . "/add") . get_btn_qs() . "' class='layui-btn layui-btn-primary'>$btnName</a>";
    return $btn_html;
}

// 获取更多按钮
function get_btn_more($idValue, $id = 'id', $btnName = '详情')
{
    $btn_html = "<a href='" . url("/" . M . '/' . C . "/index/$id/$idValue") . "' class='layui-btn layui-btn-xs layui-btn-primary' title='$btnName'>$btnName</a>";
    return $btn_html;
}

// 获取删除按钮
function get_btn_del($idValue, $id = 'id', $btnName = '删除')
{
    $user_level = session('levels');
    if (! in_array('/' . M . '/' . C . '/del', $user_level) && session('id') != 1)
        return;
    $btn_html = "<a href='" . url('/' . M . '/' . C . "/del/$id/$idValue") . "' onclick='return confirm(\"您确定要删除么？\")' class='layui-btn layui-btn-xs layui-btn-danger' title='$btnName'>$btnName</a>";
    return $btn_html;
}

// 获取修改按钮
function get_btn_mod($idValue, $id = 'id', $btnName = '修改')
{
    $user_level = session('levels');
    if (! in_array('/' . M . '/' . C . '/mod', $user_level) && session('id') != 1)
        return;
    $btn_html = "<a href='" . url("/" . M . '/' . C . "/mod/$id/$idValue") . get_btn_qs() . "'  class='layui-btn layui-btn-xs'>$btnName</a>";
    return $btn_html;
}

// 获取其它按钮
function get_btn($btnName, $theme, $btnAction, $idValue, $id = 'id')
{
    $user_level = session('levels');
    if (! in_array('/' . M . '/' . C . '/' . $btnAction, $user_level) && session('id') != 1)
        return;
    $btn_html = "<a href='" . url("/" . M . '/' . C . "/$btnAction/$id/$idValue") . get_btn_qs() . "'  class='layui-btn layui-btn-xs $theme'>$btnName</a>";
    return $btn_html;
}

// 获取按钮返回参数
function get_btn_qs()
{
    if (isset($_SERVER["QUERY_STRING"]) && ! ! $qs = $_SERVER["QUERY_STRING"]) {
        return "&backurl=" . base64_encode(URL);
    } else {
        return "?backurl=" . base64_encode(URL);
    }
}

// 获取返回URL
function get_backurl()
{
    if (! ! $backurl = get('backurl')) {
        if (isset($_SERVER["QUERY_STRING"]) && ! ! get('p')) {
            return "&backurl=" . $backurl;
        } else {
            return "?backurl=" . $backurl;
        }
    } else {
        return;
    }
}

// 获取返回tab跳转地址
function get_tab($tid)
{
    if (isset($_SERVER["QUERY_STRING"]) && ! ! get('p')) {
        return "&#tab=" . $tid;
    } else {
        return "?#tab=" . $tid;
    }
}

// 缓存语言信息
function cache_config($refresh = false)
{
    // 系统配置缓存
    $config_cache = RUN_PATH . '/config/' . md5('config') . '.php';
    if (! file_exists($config_cache) || $refresh) {
        $model = model('admin.system.Config');
        $config = $model->getConfig();
        unset($config['sn']);
        unset($config['sn_user']);
        Config::set(md5('config'), $config, false, true);
    }
    
    // 多语言缓存
    $lg_cache = RUN_PATH . '/config/' . md5('area') . '.php';
    if (! file_exists($lg_cache) || $refresh) {
        $model = model('admin.system.Config');
        $area = $model->getAreaTheme(); // 获取所有语言
        $map = array();
        foreach ($area as $key => $value) {
            $map[$value['acode']] = $value;
        }
        if (! $map) {
            error('系统没有任何可用区域，请核对后再试！');
        }
        $lgs['lgs'] = $map;
        Config::set(md5('area'), $lgs, false, true);
    }
}

// 获取默认语言
function get_default_lg()
{
    $default = current(Config::get('lgs'));
    return $default['acode'];
}

// 获取当前语言并进行安全处理
function get_lg()
{
    $lg = cookie('lg');
    if (! $lg || ! preg_match('/^[\w\-]+$/', $lg)) {
        $lg = get_default_lg();
        cookie('lg', $lg);
    }
    return $lg;
}

// 获取当前语言主题
function get_theme()
{
    $lgs = Config::get('lgs');
    $lg = get_lg();
    return $lgs[$lg]['theme'];
}

// 推送百度
function post_baidu($api, $urls)
{
    $ch = curl_init();
    $options = array(
        CURLOPT_CONNECTTIMEOUT => 30,
        CURLOPT_TIMEOUT => 90,
        CURLOPT_URL => $api,
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => implode("\n", $urls),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: text/plain'
        )
    );
    curl_setopt_array($ch, $options);
    $result = json_decode(curl_exec($ch));
    return $result;
}


// 获取删除sub按钮 @mk-sldesort
function get_btn_subdel($gidValue, $idValue, $gid = 'gid', $id = 'id', $btnName = '删除')
{
    $user_level = session('levels');
    // if (! in_array('/' . M . '/' . C . '/subdel', $user_level) && session('id') != 1)
    //     return;
    $btn_html = "<a href='" . url('/' . M . '/' . C . "/subdel/$gid/$gidValue/$id/$idValue") . "' onclick='return confirm(\"您确定要删除么？\")' class='layui-btn layui-btn-xs layui-btn-danger' title='$btnName'>$btnName</a>";
    return $btn_html;
}

// 获取修改sub按钮 @mk-sldesort
function get_btn_submod($gidValue, $idValue, $gid = 'gid', $id = 'id', $btnName = '修改')
{
    $user_level = session('levels');
    // if (! in_array('/' . M . '/' . C . '/submod', $user_level) && session('id') != 1)
    //     return;
    $btn_html = "<a href='" . url("/" . M . '/' . C . "/submod/$gid/$gidValue/$id/$idValue") . get_btn_qs() . "'  class='layui-btn layui-btn-xs'>$btnName</a>";
    return $btn_html;
}

/**
* 浏览器友好的变量输出
* @access public
* @param  mixed         $var 变量
* @param  boolean       $echo 是否输出 默认为true 如果为false 则返回输出字符串
* @param  string        $label 标签 默认为空
* @param  integer       $flags htmlspecialchars flags
* @return void|string
*/
function dump($var, $echo = true, $label = null, $flags = ENT_SUBSTITUTE)
{
   $label = (null === $label) ? '' : rtrim($label) . ':';

   ob_start();
   var_dump($var);

   $output = ob_get_clean();
   $output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);

   if (PHP_SAPI == 'cli') {
       $output = PHP_EOL . $label . $output . PHP_EOL;
   } else {
       if (!extension_loaded('xdebug')) {
           $output = htmlspecialchars($output, $flags);
       }
       $output = '<pre>' . $label . $output . '</pre>';
   }
   if ($echo) {
       echo($output);
       return;
   }
   return $output;
}
/**
* 数组指定键返回数组，该函数会根据情况自动判断返回一维还是多维
* @param type $list  多维数组
* @param type $field 指定返回数组的键
* @param type $value_key 填键则返回指定键，否则返回数组
* @return type
* author sugao
*/
function fieldAsKey($list, $field, $value_key = 1) {
    $return = [];
    $single = true;
    foreach ($list as $info) {
        $info_key = $info[$field];
        if (!is_numeric($value_key)) {
            $info_value = $info[$value_key];
        } else {
            $info_value = $info;
        }
        if (isset($return[$info_key]) && $single) {
            //只要有一个，那么原来的所有的单个的就要重写
            foreach ($return as $single_key => $single_info) {
                unset($return[$single_key]);
                $return[$single_key][] = $single_info;
            }
            $return[$info_key][] = $info_value;
            $single = false;
        } else {
            if ($single) {
                $return[$info_key] = $info_value;
            } else {
                $return[$info_key][] = $info_value;
            }
        }
    }
    return $return;
}
//对象转数组,使用get_object_vars返回对象属性组成的数组
function object2Array($obj) {
    $arr = is_object($obj) ? get_object_vars($obj) : $obj;
    if (is_array($arr)) {
        return array_map(__FUNCTION__, $arr);
    } else {
        return $arr;
    }
}
