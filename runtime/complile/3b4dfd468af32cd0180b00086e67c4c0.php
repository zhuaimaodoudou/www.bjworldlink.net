<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<title>在线管理</title>
<link rel="stylesheet" type="text/css" href="<?php echo APP_THEME_DIR;?>/js/plugins/webuploader/css/style.css?v=1.0">
<link rel="stylesheet" href="<?php echo APP_THEME_DIR;?>/js/plugins/ztree/css/iframe.css?v=1.0">
<link rel="stylesheet" href="<?php echo APP_THEME_DIR;?>/js/plugins/ztree/css/zTreeStyle/zTreeStyle.css?v=1.0" type="text/css">
<style type="text/css">
.ztree li{line-height:22px;}
.ztree .node_name{font-size:13px !important;}
.hover{line-height:22px;}
</style>
</head>
<body>
<div class="ui-layout-west area manage-area" id="manage_area">
    <div id="tree" class="ztree"></div>
</div>
<div class="ui-layout-center" style="position: relative; padding-bottom:80px;">
    <ul class="tabs" style="position: absolute; bottom:15px; right:40px;">
        <li id="saveBtn">确定使用</li>
    </ul>
    <iframe name="content_body" id="content_body" src="<?php echo \core\basic\Url::get('/admin/Media/get_images_path/pagesize/30/num/'.$this->vars['info']['num'].'/func/'.$this->vars['info']['func'].'');?>" width="100%" height="100%" frameborder="0"></iframe>
</div>
<script type="text/javascript" src="<?php echo APP_THEME_DIR;?>/js/jquery-1.12.4.min.js?v=1.0"></script>
<script src="<?php echo APP_THEME_DIR;?>/js/jquery.layout-latest.min.js?v=1.0"></script>
<script type="text/javascript" src="<?php echo APP_THEME_DIR;?>/js/plugins/ztree/js/jquery.ztree.core.min.js?v=1.0"></script>
<script type="text/javascript" src="<?php echo APP_THEME_DIR;?>/layui/layui.all.js?v=v2.5.4"></script>
<script type="text/javascript">
    var myLayout;
    jQuery(document).ready(function () {
        myLayout = jQuery("body").layout({
        /*  全局配置 */
            closable:                   true    /* 是否显示点击关闭隐藏按钮*/
        ,   resizable:                  true    /* 是否允许拉动*/
        ,   maskContents:               true    /* 加入此参数，框架内容页就可以拖动了*/
        /*  顶部配置 */
        ,   north__spacing_open:        0       /* 顶部边框大小*/
        /*  底部配置 */
        ,   south__spacing_open:        0       /* 底部边框大小*/
        /*  some pane-size settings*/
        ,   west__minSize:              200     /*左侧最小宽度*/
        ,   west__maxSize:              500     /*左侧最大宽度*/
        /*  左侧配置 */
        ,   west__slidable:             false
        ,   west__animatePaneSizing:    false
        ,   west__fxSpeed_size:         "slow"  /* 'fast' animation when resizing west-pane*/
        ,   west__fxSpeed_open:         1000    /* 1-second animation when opening west-pane*/
        ,   west__fxSettings_open:      { easing: "easeOutBounce" } // 'bounce' effect when opening*/
        ,   west__fxName_close:         "none"  /* NO animation when closing west-pane*/
        ,   stateManagement__enabled:   false   /*是否读取cookies*/
        ,   showDebugMessages:          false 
        }); 
    });

    var zNodes = <?php echo $this->getVar('zNodes');?>;

    var setting = {
        view:{
            dblClickExpand:false
            ,showLine:true
        },
        data:{
            simpleData:{
                enable:true
            }
        },
        callback:{
            beforeExpand:beforeExpand
            ,onExpand:onExpand
            ,onClick:onClick
        }
    };
    var curExpandNode=null;
    function beforeExpand(treeId,treeNode) {
        var pNode=curExpandNode?curExpandNode.getParentNode():null;
        var treeNodeP=treeNode.parentTId?treeNode.getParentNode():null;
        var zTree=$.fn.zTree.getZTreeObj("tree");
        for(var i=0,l=!treeNodeP?0:treeNodeP.children.length;i<l; i++){
            if(treeNode!==treeNodeP.children[i]){zTree.expandNode(treeNodeP.children[i],false);}
        };
        while (pNode){
            if(pNode===treeNode){break;}
            pNode=pNode.getParentNode();
        };
        if(!pNode){singlePath(treeNode);}
    };
    function singlePath(newNode) {
        if (newNode === curExpandNode) return;
        if (curExpandNode && curExpandNode.open==true) {
            var zTree = $.fn.zTree.getZTreeObj("tree");
            if (newNode.parentTId === curExpandNode.parentTId) {
                zTree.expandNode(curExpandNode, false);
            } else {
                var newParents = [];
                while (newNode) {
                    newNode = newNode.getParentNode();
                    if (newNode === curExpandNode) {
                        newParents = null;
                        break;
                    } else if (newNode) {
                        newParents.push(newNode);
                    }
                }
                if (newParents!=null) {
                    var oldNode = curExpandNode;
                    var oldParents = [];
                    while (oldNode) {
                        oldNode = oldNode.getParentNode();
                        if (oldNode) {
                            oldParents.push(oldNode);
                        }
                    }
                    if (newParents.length>0) {
                        zTree.expandNode(oldParents[Math.abs(oldParents.length-newParents.length)-1], false);
                    } else {
                        zTree.expandNode(oldParents[oldParents.length-1], false);
                    }
                }
            }
        }
        curExpandNode = newNode;
    };
    function onExpand(event,treeId,treeNode){curExpandNode=treeNode;};
    function onClick(e,treeId,treeNode){
        var zTree=$.fn.zTree.getZTreeObj("tree");
        zTree.expandNode(treeNode,null,null,null,true);
    }
    $(function(){
        $.fn.zTree.init($("#tree"),setting,zNodes);
        //$(".ui-layout-north li:first-child").click();
        $("#tree>li:first-child>span.button").click();
    });
</script>

<script type="text/javascript">
    // 点击确认使用
    $("#saveBtn").click(function(){
        var frm = $("#content_body").contents();
        // 将选中的图片拼装数组
        var images_array = [];
        frm.find("#list li").each(function(){
            var val = $(this).attr("data-url");
            if($(this).hasClass("selected")){
                images_array.push(val);
            }
        });
        // 若未选择图片就点确认则提示
        if (!images_array.length) {
            layer.msg('请选择图片~~', {icon: 2,time: 1000});
            return false;
        }
        if('' != callback && 'index.php' != callback){
            var str = "<?php echo @$this->vars['info']['func'];?>";
            var info = str.replace('.', '');
            function info_call_back(pathObj){}            
        }
        // 调用父级方法，传入图片数据
        var callback = "<?php echo @$this->vars['info']['func'];?>";
        var inputId = "<?php echo @$this->vars['info']['inputId'];?>";
        var num = <?php echo @$this->vars['info']['num'];?>;
        if(num > 0){
            if (num == 1 && undefined != images_array[0]) {
                $('#'+inputId, window.parent.document).val(images_array[0]);
                $('#'+inputId+'_box', window.parent.document).html("<dl><dt><img src='"+images_array[0]+"' data-url='"+images_array[0]+"' ></dt><dd>删除</dd></dl>");
            }else if ( num > 1) {
                if($('#'+inputId, window.parent.document).val() ==''){
                    $('#'+inputId, window.parent.document).val(images_array.join(','));
                }else{
                    $('#'+inputId, window.parent.document).val($('#'+inputId, window.parent.document).val()+","+images_array.join(','));
                }
                var html = '';
                for ( var i = 0; i <images_array.length; i++){
                    var reg = /\w+\.\w{2,4}/;
                    var picname = images_array[i].match(reg);
                    html += "<dl><dt><img src='"+images_array[i]+"' data-url='"+images_array[i]+"' ><br/><input type='text' value='"+picname+"'></dt><dd>删除</dd></dl>";
                }
                $('#'+inputId+'_box', window.parent.document).append(html);
            }
            window.parent.layer.closeAll();
        }
        

    });
</script>
</body>
</html><?php return array (
); ?>