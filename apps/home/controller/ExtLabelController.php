<?php
/**
 * @copyright (C)2020-2099 Hnaoyun Inc.
 * @author XingMeng
 * @email hnxsh@foxmail.com
 * @date 2020年3月8日
 *  个人扩展标签可编写到本类中，升级不会覆盖
 */
namespace app\home\controller;

use core\basic\Controller;
use core\basic\Url;
use app\home\model\ParserModel;

class ExtLabelController extends Controller
{

    protected $content;

    protected $model;

    public function __construct()
    {
        $this->model = new ParserModel();
    }

    /* 必备启动函数 */
    public function run($content)
    {
        // 接收数据
        $this->content = $content;
        
        // 执行个人自定义标签函数
        $this->test();
        
        //快速url
        $this->fastUrl();
        
        //快速标题
        $this->fastTitle();

        //转换日期
        $this->transtime();

        // 返回数据
        return $this->content;
    }

    // 测试扩展单个标签
    private function test()
    {
        $this->content = str_replace('{pboot:userip}', get_user_ip(), $this->content);
    }

    //解析快速URL{@about.1}{@list.2}{@content.3}
    private function fastUrl(){
        $url_break_char = $this->config('url_break_char') ?: '_';
        $url_rule_sort_suffix = $this->config('url_rule_sort_suffix') ? true : null;
        $url_rule_content_path = $this->config('url_rule_content_path') ? true : false;

        $pattern = '/\{\@(about|list|content)\.([a-z0-9_]+)\}/';
        if (preg_match($pattern, $this->content, $matches)) {
            $this->content = preg_replace_callback(
                $pattern, 
                function($matches) use ( $url_break_char, $url_rule_suffix, $url_rule_sort_suffix ){
                    switch ($matches[1]){
                        case 'about';
                            $data = $this->model->getSort($matches[2]);
                            $data->urlname = $data->urlname ?: 'about';
                            if($data->outlink){
                                $link = $data->outlink;
                            }else{
                                if ($data->filename) {
                                    $link = Url::home($data->filename);
                                } else {
                                    $link = Url::home($data->urlname . $url_break_char . $data->scode);
                                }
                            }
                            return $link;
                            break;
                        case 'list';
                            $data = $this->model->getSort($matches[2]);
                            $data->urlname = $data->urlname ?: 'list';
                            if($data->outlink){
                                $link = $data->outlink;
                            }else{
                                if ($data->filename) {
                                    $link = Url::home($data->filename);
                                } else {
                                    $link = Url::home($data->urlname . $url_break_char . $data->scode);
                                }
                            }
                            return $link;
                            break;
                        case 'content';
                            $data = $this->model->getContent($matches[2]);
                            $data->urlname = $data->urlname ?: 'list';
                            if ($data->sortfilename && $data->filename) {
                                $link = Url::home($data->sortfilename  . '/' . $data->filename, true);
                            } elseif ($data->sortfilename) {
                                $link = Url::home($data->sortfilename  . '/' . $data->id, true);
                            } elseif ($data->filename) {
                                $link = Url::home($data->urlname . $url_break_char . $data->scode . '/' . $data->filename, true);
                            } else {
                                $link = Url::home($data->urlname . $url_break_char . $data->scode . '/' . $data->id, true);
                            }
                            return $link;
                            break;
                    }
                },
                $this->content);
        }
    }

    //解析快速标题{@title.id}
    private function fastTitle(){
        $pattern = '/\{\@(title)\.([a-z0-9_]+)\}/';
        if (preg_match($pattern, $this->content, $matches)) {
            $this->content = preg_replace_callback(
                $pattern,
                function($matches){
                    $data = $this->model->getMultContent($matches[2]);
                    return $data[0]->title;
            },$this->content);
        }
    }

    //转换日期
    private function transtime(){
        $pattern = '/\{transtime\s?\(([^\}]+)\)\}/';
        if (preg_match($pattern, $this->content, $matches)) {
            $this->content = preg_replace_callback(
                $pattern,
                function($matches){
                    $time = strtotime($matches[1]);
                    $otime = date("Y-m-d H:i",$time);
                    $rtime = date("m-d H:i",$time);
                    $htime = date("H:i",$time); 
                    $time = time() - $time;
                    if ($time < 60){
                        $str = '刚刚';
                    }
                    elseif ($time < 60 * 60){
                        $min = floor($time/60);
                        $str = $min.'分钟前';
                    }elseif ($time < 60 * 60 * 24){
                        $h = floor($time/(60*60));
                        $str = $h.'小时前 '.$htime;
                    }elseif ($time < 60 * 60 * 24 * 3){
                        $d = floor($time/(60*60*24));
                        if($d==1)
                            $str = '昨天 '.$rtime;
                        else
                            $str = '前天 '.$rtime;
                    }else{
                        $str = $otime;
                    }
                    return $str;
                },
                $this->content);
        }
    }
}