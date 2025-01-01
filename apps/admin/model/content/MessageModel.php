<?php
/**
 * @copyright (C)2016-2099 Hnaoyun Inc.
 * @author XingMeng
 * @email hnxsh@foxmail.com
 * @date 2017年3月29日
 *  留言模型类
 */
namespace app\admin\model\content;

use core\basic\Model;

class MessageModel extends Model
{

    // 获取列表
    public function getList($page = true)
    {
        $field = array(
            'a.*',
            'b.username',
            'b.nickname',
            'b.headpic'
        );
        $join = array(
            'ay_member b',
            'a.uid=b.id',
            'LEFT'
        );
        return parent::table('ay_message a')->field($field)
            ->join($join)
            ->where("a.acode='" . session('acode') . "'")
            ->order('a.id DESC')
            ->decode(false)
            ->page($page)
            ->select();
    }

    // 获取指定字段的搜索列表
    public function findContent($extfield,$keyword,$page = true)
    {
        $field = array(
            'a.*',
            'b.username',
            'b.nickname',
            'b.headpic'
        );
        $join = array(
            'ay_member b',
            'a.uid=b.id',
            'LEFT'
        );
        return parent::table('ay_message a')->field($field)
            ->join($join)
            ->like("a.$extfield", $keyword)
            ->where("a.acode='" . session('acode') . "'")
            ->order('a.id DESC')
            ->decode(false)
            ->page($page)
            ->select();
    }

    //获取所有字段搜索列表
    public function findContentAll($keyword,$page = true)
    {
        $field = array(
            'a.*',
            'b.username',
            'b.nickname',
            'b.headpic'
        );
        $join = array(
            'ay_member b',
            'a.uid=b.id',
            'LEFT'
        );
        $fields = $this->getFormFieldByCode(1);
        $num = count($fields);
        $where = '';
        foreach ($fields as $key => $value){
            if($key < $num-1){
                $where .= "a.$value->name LIKE '%$keyword%' OR ";
            }else{
                $where .= "a.$value->name LIKE '%$keyword%'";
            } 
        }
        return parent::table('ay_message a')->field($field)
            ->join($join)
            ->where($where)
            ->where("a.acode='" . session('acode') . "'")
            ->order('a.id DESC')
            ->decode(false)
            ->page($page)
            ->select();
    }

    // 获取详情
    public function getMessage($id)
    {
        $field = array(
            'a.*',
            'b.username',
            'b.nickname',
            'b.headpic'
        );
        $join = array(
            'ay_member b',
            'a.uid=b.id',
            'LEFT'
        );
        return parent::table('ay_message a')->field($field)
            ->join($join)
            ->where("a.id=$id")
            ->where("a.acode='" . session('acode') . "'")
            ->find();
    }

    // 删除留言
    public function delMessage($id)
    {
        return parent::table('ay_message')->where("id=$id")
            ->where("acode='" . session('acode') . "'")
            ->delete();
    }
    
    // 执行批量删除
    public function delMessageList($ids)
    {
        return parent::table('ay_message')
            ->where("acode='" . session('acode') . "'")
            ->delete($ids);
    }

    // 修改留言
    public function modMessage($id, $data)
    {
        return parent::table('ay_message')->autoTime()
            ->where("id=$id")
            ->where("acode='" . session('acode') . "'")
            ->update($data);
    }

    // 获取表单字段
    public function getFormFieldByCode($fcode)
    {
        return parent::table('ay_form_field')->where("fcode='$fcode'")
            ->order('sorting ASC,id ASC')
            ->select();
    }

    // 获取留言数量
    public function getCount()
    {
        $rs = parent::table('ay_message')->field('count(*) as count')
            ->where("acode='" . session('acode') . "'")
            ->find();
        return $rs->count ?: 0;
    }

    // 删除留言
    public function clearMessage($where)
    {
        if(!$where){
            return parent::table('ay_message')->delete();
        } else {
            return parent::table('ay_message')->delete($where);
        }
    }
}