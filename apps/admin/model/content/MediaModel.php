<?php
/**
 * @author 9029855@qq.com
 * 图片管理器模型类
 */
namespace app\admin\model\content;

use core\basic\Model;

class MediaModel extends Model
{
    //获取素材库列表
    public function getList(){
        return parent::table('ay_media')->where("type='image'")->order('id desc')->page()->select();
    }

    // 查找素材库
    public function findList($field, $keyword)
    {
        return parent::table('ay_media')->where("type='image'")->like($field, $keyword)->order('id asc')->page()->select();
    }

    //插入素材库
    public function add($data){
        return parent::table('ay_media')->autoTime()->insert($data);
    }

    //删除素材库
    public function del($id){
        return parent::table('ay_media')->where("id=$id")->delete();
    }

    //删除素材库
    public function delpic($where){
        return parent::table('ay_media')->where($where)->delete();
    }

    //查询素材库
    public function findFile($where){
        return parent::table('ay_media')->where($where)->find();
    }

    //获取最近上传的图片
    public function getLastPic($num){
        return parent::table('ay_media')->where("type='image'")->order('id desc')->limit($num)->select();
    }


}