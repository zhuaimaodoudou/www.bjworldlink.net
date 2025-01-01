<?php
/**
 * @copyright (C)2016-2099 Hnaoyun Inc.
 * @author XingMeng
 * @email hnxsh@foxmail.com
 * @date 2017年12月26日
 *  内容栏目模型类
 */
namespace app\admin\model\content;

use core\basic\Model;

class ContentSortModel extends Model
{

    // 存储分类及子编码
    protected $scodes = array();

    // 获取内容栏目列表
    public function getList()
    {
        $field = array(
            'a.*',
            'b.type',
            'b.urlname',
            '(select count(*) from ay_content c where c.scode=a.scode) wzcount'
        );
        $join = array(
            'ay_model b',
            'a.mcode=b.mcode',
            'LEFT'
        );
        $result = parent::table('ay_content_sort a')->field($field)
            ->where("a.acode='" . session('acode') . "'")
            ->join($join)
            ->order('a.pcode,a.sorting,a.id')
            ->select();
        $tree = get_tree($result, 0, 'scode', 'pcode');
        return $tree;
    }

    // 获取内容栏目选择列表
    public function getSelect()
    {
        $result = parent::table('ay_content_sort')->field('pcode,scode,name')
            ->where("acode='" . session('acode') . "'")
            ->order('pcode,sorting,id')
            ->select();
        $tree = get_tree($result, 0, 'scode', 'pcode');
        return $tree;
    }

    // 获取单页内容栏目选择列表
    public function getSingleSelect()
    {
        $field = array(
            'a.pcode',
            'a.scode',
            'a.name',
            'a.outlink'
        );
        $join = array(
            'ay_model b',
            'a.mcode=b.mcode',
            'LEFT'
        );
        $result = parent::table('ay_content_sort a')->field($field)
            ->where('b.type=1')
            ->where("a.outlink=''")
            ->where("a.acode='" . session('acode') . "'")
            ->notIn('a.scode', 'select scode from ay_content')
            ->join($join)
            ->order('a.pcode,a.sorting,a.id')
            ->select();
        return $result;
    }

    // 获取列表内容栏目选择列表
    public function getListSelect($mcode)
    {
        $field = array(
            'a.pcode',
            'a.scode',
            'a.name',
            'a.outlink'
        );
        $join = array(
            'ay_model b',
            'a.mcode=b.mcode',
            'LEFT'
        );
        $result = parent::table('ay_content_sort a')->field($field)
            ->where('b.type=2')
            ->where("a.outlink=''")
            ->where("a.mcode='$mcode'")
            ->where("a.acode='" . session('acode') . "'")
            ->join($join)
            ->order('a.pcode,a.sorting,a.id')
            ->select();
        $tree = get_tree($result, 0, 'scode', 'pcode');
        // 对于父栏目非列表的栏目进行追加到后面
        foreach ($result as $value) {
            if ($value->pcode != 0 && result_value_search($value->pcode, $result, 'scode') === false) {
                $value->son = get_tree($result, $value->scode, 'scode', 'pcode');
                $tree[] = $value;
            }
        }
        return $tree;
    }

    // 检查内容栏目
    public function checkSort($where)
    {
        return parent::table('ay_content_sort')->field('id')
            ->where($where)
            ->find();
    }

    // 获取内容栏目详情
    public function getSort($scode)
    {
        $field = array(
            'a.*',
            'b.type'
        );
        $join = array(
            'ay_model b',
            'a.mcode=b.mcode',
            'LEFT'
        );
        return parent::table('ay_content_sort a')->field($field)
            ->where("a.scode='$scode'")
            ->where("a.acode='" . session('acode') . "'")
            ->join($join)
            ->find();
    }

    // 获取最后一个code
    public function getLastCode()
    {
        return parent::table('ay_content_sort')->order('id DESC')->value('scode');
    }

    // 添加内容栏目
    public function addSort(array $data)
    {
        return parent::table('ay_content_sort')->autoTime()->insert($data);
    }

    // 删除内容栏目及内容
    public function delSort($scode)
    {
        $this->scodes = array(); // 先清空
        $scodes = $this->getSubScodes($scode); // 获取全部子类
        $this->delContent($scodes);
        return parent::table('ay_content_sort')->in('scode', $scodes)
            ->where("acode='" . session('acode') . "'")
            ->delete();
    }

    // 移动栏目到指定栏目
    public function moveSort($scode, $data)
    {
        return parent::table('ay_content_sort')->autoTime()
            ->in('scode', $scode)
            ->where("acode='" . session('acode') . "'")
            ->update($data);
    }

    // 复制栏目到指定栏目
    public function copySort($scodes, $pcode)
    {
        // 查找出要复制的栏目内容
        $data = parent::table('ay_content_sort')
            ->in('scode', $scodes)
            ->order('pcode,sorting,id')
            ->select(1);

        foreach ($data as $key => $value) {
            //查找出当前栏目下的所有内容
            $dataContent = parent::table('ay_content')
                ->where('scode=' . $value['scode'])
                ->select(1);
 
            $lastcode = $this->getLastCode();
            $scode = get_auto_code($lastcode);

            // 去除主键并修改栏目编码以及父栏目编码
            unset($value['id']);
            $value['scode'] = $scode;
            $value['pcode'] = $pcode;
            
            // 栏目插入操作
            $result = parent::table('ay_content_sort')->insert($value);
            
            foreach ($dataContent as $key => $valuec) {
                // 查找扩展内容
                $extdata = parent::table('ay_content_ext')->where('contentid=' . $valuec['id'])->find(1);
                
                // 去除主键并修改栏目
                unset($valuec['id']);
                $valuec['scode'] = $value['scode'];
                
                // 插入主内容
                $id = parent::table('ay_content')->insertGetId($valuec);
                
                // 插入扩展内容
                if ($id && $extdata) {
                    unset($extdata['extid']);
                    $extdata['contentid'] = $id;
                    $result = parent::table('ay_content_ext')->insert($extdata);
                } else {
                    $result = $id;
                }
            }    
        }
        return $result;
    }

    // 多语言复制
    public function copyAll($ids,$acode)
    {
        // 查找出要复制的栏目内容
        $data = parent::table('ay_content_sort')
            ->in('id', $ids)
            ->order('pcode,sorting,id')
            ->select(1);

        $lastcode = $this->getLastCode();

        foreach ($data as $key => $value) {
            //查找出当前栏目下的所有内容
            $dataContent = parent::table('ay_content')
                ->where('scode=' . $value['scode'])
                ->select(1);

            // 去除主键并修改栏目编码以及父栏目编码
            unset($value['id']);
            $value['acode'] = $acode;
            $value['scode'] += $lastcode;

            //顶级栏目不修改副栏目编码
            if($value['pcode'] != 0){
                $value['pcode'] += $lastcode;
            }
  
            // 栏目插入操作
            $result = parent::table('ay_content_sort')->insert($value);
            
            foreach ($dataContent as $key => $valuec) {
                // 查找扩展内容
                $extdata = parent::table('ay_content_ext')->where('contentid=' . $valuec['id'])->find(1);
                
                // 去除主键并修改栏目
                unset($valuec['id']);
                $valuec['scode'] = $value['scode'];
                $valuec['acode'] = $acode;
                
                // 插入主内容
                $id = parent::table('ay_content')->insertGetId($valuec);
                
                // 插入扩展内容
                if ($id && $extdata) {
                    unset($extdata['extid']);
                    $extdata['contentid'] = $id;
                    $result = parent::table('ay_content_ext')->insert($extdata);
                } else {
                    $result = $id;
                }
            }    
        }
        return $result;
    }
    // 批量删除栏目及内容
    public function delSortList($scodes)
    {
        $this->scodes = array(); // 先清空
        foreach ($scodes as $value) {
            $allscode = $this->getSubScodes($value); // 获取全部子类
        }
        $this->delContent($allscode);
        return parent::table('ay_content_sort')->in('scode', $allscode)
            ->where("acode='" . session('acode') . "'")
            ->delete();
    }

    // 修改内容栏目资料
    public function modSort($scode, $data, $modsub = false)
    {
        if ($modsub) {
            // 同步修改子栏目模型及模板
            $scodes = $this->getSubScodes($scode);
            $subdata = array(
                'mcode' => $data['mcode'],
                'listtpl' => $data['listtpl'],
                'contenttpl' => $data['contenttpl']
            );
            parent::table('ay_content_sort')->in('scode', $scodes)
                ->where("acode='" . session('acode') . "'")
                ->update($subdata);
        }
        $result = parent::table('ay_content_sort')->autoTime()
            ->where("scode='$scode'")
            ->where("acode='" . session('acode') . "'")
            ->update($data);
        return $result;
    }

    // 修改内容栏目排序
    public function modSortSorting($id, $data)
    {
        $result = parent::table('ay_content_sort')->autoTime()
            ->where("id='$id'")
            ->where("acode='" . session('acode') . "'")
            ->update($data);
        return $result;
    }

    //修改栏目标题
    public function modSortName($id, $data)
    {
        $result = parent::table('ay_content_sort')->autoTime()
            ->where("id='$id'")
            ->where("acode='" . session('acode') . "'")
            ->setField("name",$data);
        return $result;
    }

    // 查找指定单页内容
    public function findContent($scode)
    {
        return parent::table('ay_content')->where("scode='$scode'")->find();
    }

    // 添加单篇文章
    public function addSingle(array $data)
    {
        return parent::table('ay_content')->autoTime()->insert($data);
    }

    // 删除指定栏目文章
    public function delContent($scodes)
    {
        return parent::table('ay_content')->in('scode', $scodes)->delete();
    }

    // 分类子类集
    private function getSubScodes($scode)
    {
        if (! $scode) {
            return;
        }
        $this->scodes[] = $scode;
        $subs = parent::table('ay_content_sort')->where("pcode='$scode'")->column('scode');
        if ($subs) {
            foreach ($subs as $value) {
                $this->getSubScodes($value);
            }
        }
        return $this->scodes;
    }

    // 检查自定义URL名称
    public function checkFilename($filename, $where = array())
    {
        return parent::table('ay_content_sort')->field('id')
            ->where("filename='$filename'")
            ->where($where)
            ->find();
    }

    // 检查URL名字冲突
    public function checkUrlname($filename)
    {
        return parent::table('ay_model')->field('id')
            ->where("urlname='$filename'")
            ->find();
    }

    // 获取当前主题
    public function getTheme()
    {
        return parent::table('ay_site')->where("acode='" . session('acode') . "'")->value('theme');
    }
    
    public function getImage()
    {
        return parent::table('ay_content_sort')->column('pic,ico');
    }
}