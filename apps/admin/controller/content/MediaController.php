<?php
/**
 * @author 9029855@qq.com
 * 素材库操作类
 */
namespace app\admin\controller\content;

use core\basic\Controller;
use app\admin\model\content\MediaModel;

class MediaController extends Controller
{
    private $model;
    private $flag;

    public function __construct()
    {
        $this->model = new MediaModel();
        $this->flag = false;
    }
    

    public function index()
    {
        $this->flag = true;
        $func       = get('func');
        $num        = get('num');   
        $inputId    = get('inputId');
        $info = array(
            'num'      => $num,
            'func'     => $func,
            'inputId'  => $inputId,
        );
        $this->assign('info',$info);
        //侧边栏目录栏目
        $dirImage = trim(STATIC_DIR.'/upload/image','/');
        $dirArr  = $this->getDir($dirImage);
        $dirArr2 = [];
        foreach ($dirArr as $key => $val) {
            $dirArr2[$val['id']] = $val['dirpath'];
        }
        foreach ($dirArr as $key => $val) {
            $countFile = 0;
            $dirfileArr = glob("{$val['dirpath']}/*");
            if (empty($dirfileArr)) {
                empty($dirfileArr) && @rmdir($val['dirpath']);
                $dirArr[$key] = [];
                continue;
            }
            $dirfileArr2 = glob("{$val['dirpath']}/*.*"); // 文件数量
            $countFile = count($dirfileArr2);
            $dirname = preg_replace('/([^\/]+)$/i', '', $val['dirpath']);
            $arr_key = array_search(trim($dirname, '/'), $dirArr2);
            if (!empty($arr_key)) {
                $dirArr[$key]['pId'] = $arr_key;
            } else {
                $dirArr[$key]['pId'] = 0;
            }
            $dirArr[$key]['name'] = preg_replace('/^(.*)\/([^\/]+)$/i', '${2}', $val['dirpath']);
            !empty($countFile) && $dirArr[$key]['name'] .= "({$countFile})";
        }
        $zNodes = str_replace("\\/", "/", json_encode($dirArr,true));
        $this->assign('zNodes', $zNodes);
        $this->display('content/media_index.html');
    }

    //图库在线管理 - 左侧树形目录结构
    public function picture_folder()
    {
        $func       = get('func');
        $num        = get('num');   
        $inputId    = get('inputId');
        $info = array(
            'num'      => $num,
            'func'     => $func,
            'inputId'  => $inputId,
        );
        $this->assign('info',$info);
        //侧边栏目录栏目
        $dirImage = trim(STATIC_DIR.'/upload/image','/');
        $dirArr  = $this->getDir($dirImage);
        $dirArr2 = [];
        foreach ($dirArr as $key => $val) {
            $dirArr2[$val['id']] = $val['dirpath'];
        }
        foreach ($dirArr as $key => $val) {
            $countFile = 0;
            $dirfileArr = glob("{$val['dirpath']}/*");
            if (empty($dirfileArr)) {
                empty($dirfileArr) && @rmdir($val['dirpath']);
                $dirArr[$key] = [];
                continue;
            }
            $dirfileArr2 = glob("{$val['dirpath']}/*.*"); // 文件数量
            $countFile = count($dirfileArr2);
            $dirname = preg_replace('/([^\/]+)$/i', '', $val['dirpath']);
            $arr_key = array_search(trim($dirname, '/'), $dirArr2);
            if (!empty($arr_key)) {
                $dirArr[$key]['pId'] = $arr_key;
            } else {
                $dirArr[$key]['pId'] = 0;
            }
            $dirArr[$key]['name'] = preg_replace('/^(.*)\/([^\/]+)$/i', '${2}', $val['dirpath']);
            !empty($countFile) && $dirArr[$key]['name'] .= "({$countFile})";
        }
        $zNodes = str_replace("\\/", "/", json_encode($dirArr,true));
        $this->assign('zNodes', $zNodes);
        $this->display('content/picture_folder.html');
    }

    //图库在线管理 - 图片列表显示
    public function get_images_path()
    {
        $images_path = get('images_path')?:'static/upload';
        if ( strpos($images_path,'static/upload')<0 ) {
            error('非法访问！');
        }
        $this->flag = get('flag')?true:false;
        $func = get('func');
        $num  = get('num');
        $info = array(
            'num'  => $num,
            'func' => empty($func) ? 'undefined' : $func,
        );
        $this->assign('flag',$this->flag);
        $this->assign('info',$info);
        // 常用图片
        $common_pic = [];
        $arr1 = explode('/', $images_path);

        //只有一级目录才显示常用图片
        if (count($arr1)<=3) { 
            //$common_pic = $this->model->getLastPic(10);
            $common_pic = $this->model->getList();
        }
        $this->assign('common_pic', $common_pic);
        
        // 图片列表
        $images_data = glob($images_path.'/*');
        $list = [];
        if (!empty($images_data)) {
            // 图片类型数组
            $image_type = "jpg|gif|png|bmp|jpeg|ico";
            $image_ext = str_replace('|', ',', $image_type);
            $image_ext = explode(",",$image_ext);
            // 处理图片
            foreach ($images_data as $key => $file) {
                $fileArr = explode('.', $file);    
                $ext = end($fileArr);
                $ext = strtolower($ext);
                if (in_array($ext, $image_ext)) {
                    $list[$key]['path'] = '/'.$file;
                    $list[$key]['time'] = @filemtime($file);
                }
            }
        }
        // 图片选择的时间从大到小排序
        $list_time = array_column($list,'time');
        array_multisort($list_time,SORT_DESC,$list);
        // 返回数据
        $this->assign('list', $list);
        $this->assign('path_directory', $images_path);
        $this->display('content/media.html');
    }
    /**
     * 提取上传图片目录下的所有图片
     * @param string $directory 目录路径
     * @param string $dir_name 显示的目录前缀路径
     * @param array $arr_file 是否删除空目录
     * @param num $num 数量
     */
    private function getDir($directory, &$arr_file = array(), &$num = 0) {
        $mydir = glob($directory.'/*', GLOB_ONLYDIR);
        $func = get('func');
        if(!isset($func)){
            $func='';
        }else{
            $func='/func/'.$func;
        }
        $num  = get('num');
        if(!isset($num)){
            $pnum='';
        }else{
            $pnum='/num/'.$num;
        }
        if($this->flag){
            $flag = '/flag/1';
        }
        if (0 <= $num) {
            $dirpathArr = explode('/', $directory);
            $level = count($dirpathArr);
            $open = (1 >= $level) ? true : false;
            $fileList = glob($directory.'/*');
            $total = count($fileList); // 目录是否存在任意文件，否则删除该目录
            if (!empty($total)) {
                $isExistPic = $this->isExistPic($directory);
                if (!empty($isExistPic)) {
                    $arr_file[] = [
                        'id'        => $num,
                        'url'       => url('admin/Media/get_images_path/pagesize/30'.$flag.$pnum.$func).'&images_path='.$directory,
                        //'url'       => url('admin/Media/get_images_path'.$pnum.$func.'/images_path/'.$directory),
                        'target'    => 'content_body',
                        'isParent'  => true,
                        'open'      => $open,
                        'dirpath'   => $directory,
                        'level'     => $level,
                        'total'     => $total,
                    ];
                }
            } else {
                @rmdir("$directory");
            }
        }
        if (!empty($mydir)) {
            foreach ($mydir as $key => $dir) {
                $num++;
                $dirname = str_replace('\\', '/', $dir);
                $dirArr  = explode('/', $dirname);
                $dir     = end($dirArr);
                $mydir2  = glob("$directory/$dir/*", GLOB_ONLYDIR);
                if(!empty($mydir2) AND ($dir != ".") AND ($dir != "..")){
                    $this->getDir("$directory/$dir", $arr_file, $num);
                }else if(($dir != ".") AND ($dir != "..")){
                    $dirpathArr = explode('/', "$directory/$dir");
                    $level = count($dirpathArr);
                    $fileList = glob("$directory/$dir/*"); // 目录是否存在任意文件，否则删除该目录
                    $total = count($fileList);
                    if (!empty($total)) {
                         // 目录是否存在图片文件，否则删除该目录
                        $isExistPic = $this->isExistPic("$directory/$dir");
                        if (!empty($isExistPic)) {
                            $arr_file[] = [
                                'id'        => $num,
                                'url'       => url('admin/Media/get_images_path/pagesize/30'.$flag.$pnum.$func).'&images_path='.$directory.'/'.$dir,
                                //'url'       => url('admin/Media/get_images_path'.$pnum.$func.'/images_path/'.$directory.'/'.$dir),
                                'target'    => 'content_body',
                                'isParent'  => false,
                                'open'      => false,
                                'dirpath'   => "$directory/$dir",
                                'level'     => $level,
                                'icon'      => '/apps/admin/view/default/js/plugins/ztree/css/zTreeStyle/img/dir_close.png',
                                'iconOpen'  => '/apps/admin/view/default/js/plugins/ztree/css/zTreeStyle/img/dir_open.png',
                                'iconClose' => '/apps/admin/view/default/js/plugins/ztree/css/zTreeStyle/img/dir_close.png',
                                'total'     => $total,
                            ];
                        }
                    } else {
                        @rmdir("$directory/$dir");
                    }
                }
            }
        }
        return $arr_file;
    }

    /**
     * 检测指定目录是否存在图片
     * @param string $directory 目录路径
     * @param string $dir_name 显示的目录前缀路径
     * @param array $arr_file 是否删除空目录
     * @return boolean
     */
    private function isExistPic($directory, $dir_name='', &$arr_file = [])
    {
        if (!file_exists($directory) ) {
            return false;
        }
        if (!empty($arr_file)) {
            return true;
        }
        //图片类型数组
        $image_type = "jpg|gif|png|bmp|jpeg|ico";
        $image_ext = str_replace('|', ',', $image_type);
        $image_ext = explode(",",$image_ext);
        $mydir = dir($directory);
        while($file = $mydir->read())
        {
            if((is_dir("$directory/$file")) AND ($file != ".") AND ($file != "..")){
                if ($dir_name) {
                    return $this->isExistPic("$directory/$file", "$dir_name/$file", $arr_file);
                } else {
                    return $this->isExistPic("$directory/$file", "$file", $arr_file);
                }
            }
            else if(($file != ".") AND ($file != "..")){
                $fileArr = explode('.', $file);    
                $ext = end($fileArr);
                $ext = strtolower($ext);
                if (in_array($ext, $image_ext)) {
                    if ($dir_name) {
                        $arr_file[] = "$dir_name/$file";
                    } else {
                        $arr_file[] = "$file";
                    }
                    return true;
                }
            }
        }
        $mydir->close();
        return $arr_file;
    }



    public function single(){
        if (isset($_GET['keyword'])) {
            $result = $this->model->findList('original',get('keyword', 'vars'));
        } else {
            $result = $this->model->getList();
        }
        $this->assign('single', true);
        $this->assign('list', $result);
        $this->display('content/media.html');
    }

    public function multiple(){
        if (isset($_GET['keyword'])) {
            $result = $this->model->findList('original',get('keyword', 'vars'));
        } else {
            $result = $this->model->getList();
        }
        $this->assign('multiple', true);
        $this->assign('list', $result);
        $this->display('content/media.html');
    }

    //删除图片
    public function delpic(){
        $path = post('img');
        $path_url = trim_slash($path);
        if( $path=='' ){
            json(0,'参数异常.');
        }
        $where=array(
            'url'=>$path
        );
        if(file_exists($path_url)){
            @unlink($path_url);
            $this->model->delpic($where);
            json(1,'删除成功.');
        }else{
            if($this->model->delpic($where)){
                if (substr($path, 0, 4)=='http') {
                    json(1,'暂不支持删除OSS等远程文件，数据库记录已删除.');
                }else{
                    json(1,'文件不存在，数据库记录已删除.');
                }
            }else{
                json(0,'删除失败.');
            }
        }
    }


}