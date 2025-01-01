<?php

namespace app\api\controller;

use core\basic\Controller;
use core\basic\Model;
use app\admin\model\content\ContentModel;

class IndexController extends Controller {

    public function index() {
        json(0, '不存在的API');
    }

    function excel_upload() {
        $insert_fail_sign = 0; //1表示新增失败，0表示成功
        $this->model = new ContentModel();
        include ROOT_PATH . '/core/extend/excel/PHPExcel.php';
        if (empty($_POST['url'])) {
            json(0, 'url不存在！');
        }
        $scode = $_POST['scode'];
        if(!$scode){
             json(0, '请先选择要导入的栏目！');
        }
        $inputFileName = ROOT_PATH . $_POST['url'];
        $excelurl = str_replace("/", "\\", $inputFileName);
        $objPHPExcel = \PHPExcel_IOFactory::load($inputFileName);
        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
        //处理图片
        $imageFilePath = $save_path = DOC_PATH . STATIC_DIR . '/upload/image/' . date('Ymd') . '/'; //图片在本地存储的路径
        $only_root_file_path = '/static/upload/image/' . date('Ymd') . '/';
        if (!file_exists($imageFilePath)) {
            mkdir("$imageFilePath", 0777, true);
        }
        $active_sheet = $objPHPExcel->getActiveSheet(0);
        foreach ($active_sheet->getDrawingCollection() as $img) {
            if ($img instanceof \PHPExcel_Worksheet_Drawing) {
                list($startColumn, $startRow) = \PHPExcel_Cell::coordinateFromString($img->getCoordinates()); //获取图片所在行和列
                $imageFileName = $img->getCoordinates() . mt_rand(10000, 99999) . uniqid();
                $filename = $img->getPath();
                list($imagesx, $imagesy, $imageFormat) = getimagesize($filename);
                switch ($imageFormat) {
                    case 1: // GIF, not supported by BIFF8, we convert to PNG
                        $imageFileName .= '.gif';
                        imagegif(imagecreatefromstring(file_get_contents($filename)), $imageFilePath . $imageFileName);
                        break;
                    case 2: // JPEG
                        $imageFileName .= '.jpeg';
                        imagejpeg(imagecreatefromstring(file_get_contents($filename)), $imageFilePath . $imageFileName);
                        break;
                    case 3: // PNG
                        $imageFileName .= '.png';
                        imagepng(imagecreatefromstring(file_get_contents($filename)), $imageFilePath . $imageFileName);
                        break;
                    default:
                        continue 2;
                }
                $sheetData[$startRow][$startColumn] = $only_root_file_path . $imageFileName; //把图片插入到数组中
            }
        }
        $field_data = $sheetData[1]; //字段数据,['A'=>'x1','B'=>'x2','C'=>'x3']
        $field_data_keys = array_keys($field_data); //A,B,C
        //获取mcode
        $mcode = \core\basic\Db::table('ay_content_sort')->where('scode='.$scode)->value('mcode');
        $extfield_list = model('admin.content.ExtField')->getModelField($mcode); //数据库自定义的字段
        $ext_filed_description_name = fieldAsKey(object2Array($extfield_list), 'description', 'name'); //['x1'=>'x11','x2'=>'x22']
        for ($i = 2; $i <= count($sheetData); $i++) {
            $content_ext_data = [];
            foreach ($field_data_keys as $k) {
                if (!empty($sheetData[$i][$k]) && !empty($ext_filed_description_name[$field_data[$k]])) {
                    $content_ext_data[$ext_filed_description_name[$field_data[$k]]] = str_replace("'", "''", $sheetData[$i][$k]);
                }
            }
           
             $sheet_data_b = isset($sheetData[$i]['B']) ? str_replace("'", "''", $sheetData[$i]['B']) : '';
              $sheet_data_c = isset($sheetData[$i]['C']) ? str_replace("'", "''", $sheetData[$i]['C']) : '';
            // 构建数据
            $data = array(
                'acode' => 'cn',
                'scode' => $scode,
                'subscode' => '0',
                'title' => isset($sheetData[$i]['A']) ? $sheetData[$i]['A'] : '',
                'titlecolor' => '#333333',
                'subtitle' => '',
                'filename' => '',
                'author' => 'admin',
                'source' => '',
                'outlink' => '',
                'date' => date('Y-m-d H:i:s'),
                'ico' => $sheet_data_b,
                'pics' => '',
                'content' => $sheet_data_c,
                'tags' => '',
                'enclosure' => '',
                'keywords' => '',
                'description' => '',
                'sorting' => 255,
                'status' => 1,
                'istop' => 0,
                'isrecommend' => 0,
                'isheadline' => 0,
                'visits' => 0,
                'likes' => 0,
                'oppose' => 0,
                'create_user' => 'admin',
                'update_user' => 'admin'
            );
            // 执行添加
            if ($id = $this->model->addContent($data)) {
                // 扩展内容添加
                $array_merge_data = array_merge($content_ext_data, ['contentid' => $id]);
                $extid = \core\basic\Db::table('ay_content_ext')->insertGetId($array_merge_data);
                if (!$extid) {
                    $insert_fail_sign = 1;
                    break;
                }
            } else {
                $insert_fail_sign = 1;
                break;
            }
        }
        if ($insert_fail_sign) {
            json(0, '新增失败1！');
        } else {
            json(1, $data);
        }
    }

}

function ABC2decimal($abc) {
    $ten = 0;
    $len = strlen($abc);
    for ($i = 1; $i <= $len; $i++) {
        $char = substr($abc, 0 - $i, 1); //反向获取单个字符

        $int = ord($char);
        $ten += ($int - 65) * pow(26, $i - 1);
    }
    return $ten;
}
