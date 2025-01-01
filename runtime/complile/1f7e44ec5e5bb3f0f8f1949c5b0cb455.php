<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<style type="text/css">
#online{padding-top:0 !important;}
#online li img{vertical-align:middle;max-width:100%;max-height:106px;position:absolute;top:50%;transform:translate(-50%,-50%);left:50%;z-index:1;}
.saveBtn{display:inline-block;*display:inline;*zoom:1;margin-left:10px;padding:0 18px;height:40px;line-height:40px;cursor:pointer;text-align:center;background:#fff;border:1px solid #CFCFCF;border-radius:3px;color:#565656;font-size:14px;}
.tabs li:hover{color:#fff;background:#00B7EE;border-color:transparent;}
.nonepic{text-align:center;color:#888;margin-top:60px;}
.heading{clear:both;margin:20px 10px;}
.heading h2{color:#333333;font-size:15px;margin:0px;margin-bottom:10px;font-weight:normal;}
.heading hr{border:none;position:relative;margin:0px;height:1px;width:100%;background:#e5e5e5;}
.heading hr:before{height:2px;background:#666666;content:"";position:absolute;top:-1px;width:60px;left:0px;}
.tabs li span.icon-del{ display: block; position: absolute; bottom:0; right:0;  z-index: 2; padding:5px 10px; font-weight: normal; background:rgba(0,0,0,0.7); font-size:12px; color:#fff; }
/* .tabs li:hover span.icon-del{ display: block; } */
</style>
<link rel="stylesheet" href="<?php echo APP_THEME_DIR;?>/layui/css/layui.css?v=v2.5.4">
<link rel="stylesheet" href="<?php echo APP_THEME_DIR;?>/css/comm.css?v=v2.0.7">
<link href="<?php echo CORE_DIR;?>/extend/ueditor/dialogs/image/image.css?v=1.0" rel="stylesheet" type="text/css">
</head>
<body>
    <div class="ui-layout-west area manage-area" id="manage_area">
        <div id="tree" class="ztree"></div>
    </div>
    <div class="ui-layout-center" id="online">
        <ul id="list" class="tabs">
            <?php if ( count($this->getVar('common_pic'))>0 ) {?>
            <div class="heading">
                <h2>最新上传</h2>
                <hr>
            </div>
            <?php $num = 0;foreach ($this->getVar('common_pic') as $key => $value) { $num++;?>
                <li data-url="<?php echo $value->url; ?>">
                    <img src="<?php echo $value->url; ?>" />
                    <?php if ( $this->getVar('flag') ) {?>
                    <span class="icon-del">删除</span>
                    <?php } else { ?>
                    <span class="icon"></span>
                    <?php } ?>
                </li>
            <?php } ?>
            <div class="layui-clear"><br></div>
            <div class="page">
                <?php echo $this->getVar('pagebar');?>
            </div>
            <?php } ?>
            <div class="heading">
                 <h2>目录图片</h2>
                 <hr>
            </div>
            <?php if ( count($this->getVar('list'))<=0 ) {?>
                <div class='nonepic'>暂无图片可选择~</div>
            <?php } ?>
            <?php $num = 0;foreach ($this->getVar('list') as $key => $value) { $num++;?>
                <li data-url="<?php echo $value['path']; ?>">
                    <img src="<?php echo $value['path']; ?>"  />
                    <?php if ( $this->getVar('flag') ) {?>
                    <span class="icon-del">删除</span>
                    <?php } else { ?>
                    <span class="icon"></span>
                    <?php } ?>
                </li>
            <?php } ?>
        </ul>
    </div>
    <script type="text/javascript" src="<?php echo APP_THEME_DIR;?>/js/jquery-1.12.4.min.js"></script>
    <script type="text/javascript" src="<?php echo APP_THEME_DIR;?>/layui/layui.all.js?v=v2.5.4"></script>
    <script type="text/javascript">
        <?php if ( $this->getVar('flag') ) {?>
        $(function(){
            $(document).on('click','#list li span.icon-del',function(){
                var img = $(this).parent('li').data('url');
                var that = $(this).parent('li');
                console.log(img);
                $.post('<?php echo \core\basic\Url::get('/admin/Media/delpic/');?>',{
                    img:img
                },function(msg){
                    console.log(msg);
                    if(msg.code==1){
                        layer.msg(msg.data);
                        that.remove();
                    }
                },'json')
            })
        });
        <?php } else { ?>
        // 记录选择的图片
        $(function(){
            $(document).on('click','#list li',function(){
                var num = '<?php echo @$this->vars['info']['num'];?>';
                if (1 == num) {
                    // 当数量为1时，仅可选择一张图片
                    $("#list li").each(function(){
                        $(this).removeClass("selected")
                    });
                }
                // 给点击的图片加上Class
                $(this).toggleClass("selected");
            })
        })
        <?php } ?>
    </script>
</body>
</html><?php return array (
); ?>