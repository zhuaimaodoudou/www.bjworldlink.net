<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta name="renderer"  content="webkit">
  <title><?php echo CMSNAME;?>管理中心-V<?php echo APP_VERSION;?></title>
  <link rel="shortcut icon" href="<?php echo SITE_DIR;?>/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="<?php echo APP_THEME_DIR;?>/layui/css/layui.css?v=v2.5.4">
  <link rel="stylesheet" href="<?php echo APP_THEME_DIR;?>/font-awesome/css/font-awesome.min.css?v=v4.7.0" type="text/css">
  <link rel="stylesheet" href="<?php echo APP_THEME_DIR;?>/css/comm.css?v=v3.0.6">
  <link href="<?php echo APP_THEME_DIR;?>/css/jquery.treetable.css" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="<?php echo APP_THEME_DIR;?>/js/jquery-1.12.4.min.js"></script>
  <script type="text/javascript" src="<?php echo APP_THEME_DIR;?>/js/jquery.treetable.js"></script>
  <script type="text/javascript" src="<?php echo APP_THEME_DIR;?>/js/xm-select.js"></script>
  <link rel="stylesheet" href="<?php echo APP_THEME_DIR;?>/plugins/css/element-ui@2.15.14.css">
  <script src="<?php echo APP_THEME_DIR;?>/plugins/js/vue.min.js"></script>
  <script src="<?php echo APP_THEME_DIR;?>/plugins/js/element-ui@2.15.14.js"></script>
</head>

<body class="layui-layout-body">

<!--定义部分地址方便JS调用-->
<div style="display: none">
	<span id="controller" data-controller="<?php echo C;?>"></span>
	<span id="url" data-url="<?php echo URL;?>"></span>
	<span id="preurl" data-preurl="<?php echo url('/admin',false);?>"></span>
	<span id="sitedir" data-sitedir="<?php echo SITE_DIR;?>"></span>
	<span id="mcode" data-mcode="<?php echo get('mcode');?>"></span>
</div>

<div class="layui-layout layui-layout-admin">
  <div class="layui-header">
    <div class="layui-logo">
    <a href="<?php echo \core\basic\Url::get('/admin/Index/home');?>">
    <img src="<?php echo APP_THEME_DIR;?>/images/logo.png" height="30">
	    后台首页
	   	<?php if (LICENSE==3) {?>
	   		<span class="layui-badge">SVIP</span>
	   	<?php } else { ?>
	   		<span class="layui-badge layui-bg-gray">V<?php echo APP_VERSION;?></span>	
	   	<?php } ?>
    </a>
    </div>
    
    <ul class="menu">
    	<li class="menu-ico" title="显示或隐藏侧边栏"><i class="fa fa-bars" aria-hidden="true"></i></li>
	</ul>
	<?php if (!$this->getVar('one_area')) {?>
	<form method="post" action="<?php echo \core\basic\Url::get('/admin/Index/area');?>" class="area-select">
		<input type="hidden" name="formcheck" value="<?php echo $this->getVar('formcheck');?>" > 
		<div class="layui-col-xs8">
		   <select name="acode">
		       <?php echo $this->getVar('area_html');?>
		   </select>
		</div>
		<div class="layui-col-xs4">
		 	<button type="submit" class="layui-btn layui-btn-sm">切换</button>
		</div>
   	</form>
 	<?php } ?>

    <ul class="layui-nav layui-layout-right">
    
       <li class="layui-nav-item layui-hide-xs">
      	 <a href="<?php echo SITE_DIR;?>/" target="_blank"><i class="fa fa-home" aria-hidden="true"></i> 网站主页</a>
       </li>

       <li class="layui-nav-item layui-hide-xs">
       		<a href="<?php echo \core\basic\Url::get('/admin/Index/clearCache');?>" class="ajaxlink"><i class="fa fa-trash-o" aria-hidden="true"></i> 清理缓存</a>
       </li>
       
       <li class="layui-nav-item layui-hide-xs">
	        <a href="javascript:;">
	          <i class="fa fa-user-circle-o" aria-hidden="true"></i> <?php echo session('realname');?>
	        </a>
	        <dl class="layui-nav-child">
	          <dd><a href="<?php echo \core\basic\Url::get('/admin/Index/ucenter');?>"><i class="fa fa-address-card-o" aria-hidden="true"></i> 密码修改</a></dd>
	          <dd><a href="<?php echo \core\basic\Url::get('/admin/Index/loginOut');?>"><i class="fa fa-sign-out" aria-hidden="true"></i> 退出登录</a></dd>
	          <?php if (session('ucode')==10001) {?>
	          	<dd><a href="<?php echo \core\basic\Url::get('/admin/Index/clearSession');?>" class="ajaxlink"><i class="fa fa-trash-o" aria-hidden="true"></i> 清理会话</a></dd>
	          <?php } ?>
	        </dl>
      </li>
    </ul>
  </div>
  
  <div class="layui-side layui-bg-black">
    <div class="layui-side-scroll">
      <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
      <ul class="layui-nav layui-nav-tree" id="nav" lay-shrink="all">
	   <?php $num = 0;foreach ($this->getVar('menu_tree') as $key => $value) { $num++;?>
        <li class="layui-nav-item nav-item <?php if ($this->getVar('primary_menu_url')==$value->url) {?>layui-nav-itemed<?php } ?>">
          <a class="" href="javascript:;"><i class="fa <?php echo $value->ico; ?>" aria-hidden="true"></i><?php echo $value->name; ?></a>
          <dl class="layui-nav-child">
			<?php if ($value->mcode=='M130') {?>
				 <?php $num3 = 0;foreach ($this->getVar('menu_models') as $key3 => $value3) { $num3++;?>
				 	<?php if ($value3->type==1) {?>
						<dd><a href="<?php echo \core\basic\Url::get('/admin/Single/index/mcode/'.$value3->mcode.'');?>"><i class="fa fa-file-text-o" aria-hidden="true"></i><?php echo $value3->name; ?>内容</a></dd>
					<?php } ?>
					<?php if ($value3->type==2) {?>
						<dd><a href="<?php echo \core\basic\Url::get('/admin/Content/index/mcode/'.$value3->mcode.'');?>"><i class="fa fa-file-text-o" aria-hidden="true"></i><?php echo $value3->name; ?>内容</a></dd>
					<?php } ?>
				 <?php } ?>
			<?php } else { ?>
				<?php $num2 = 0;foreach ($value->son as $key2 => $value2) { $num2++;?>
					<?php if (!isset($value2->status)|| $value2->status==1) {?>
	            		<dd><a href="<?php echo \core\basic\Url::get(''.$value2->url.'');?>"><i class="fa <?php echo $value2->ico; ?>" aria-hidden="true"></i><?php echo $value2->name; ?></a></dd>
	            	<?php } ?>
				<?php } ?>
				
				<!-- <?php if ($value->mcode=='M101' && session('ucode')==10001) {?>
					<dd><a href="<?php echo \core\basic\Url::get('/admin/Upgrade/index');?>"><i class="fa fa-cloud-upload" aria-hidden="true"></i>在线更新</a></dd>
				<?php } ?> -->
		    <?php } ?>
          </dl>
        </li>
		<?php } ?>
		
		<li style="height:1px;background:#666" class="layui-hide-sm"></li>
		
		<li class="layui-nav-item layui-hide-sm">
		 <a href="<?php echo SITE_DIR;?>/" target="_blank"><i class="fa fa-home" aria-hidden="true"></i> 网站主页</a>
		</li>
		
		<li class="layui-nav-item layui-hide-sm">
          <a href="<?php echo \core\basic\Url::get('/admin/Index/ucenter');?>"><i class="fa fa-address-card-o" aria-hidden="true"></i> 资料修改</a>
        </li>
        
        <li class="layui-nav-item layui-hide-sm">
         <a href="<?php echo \core\basic\Url::get('/admin/Index/clearCache');?>"><i class="fa fa-trash-o" aria-hidden="true"></i> 清理缓存</a>
        </li>
        
        <li class="layui-nav-item layui-hide-sm">
         <a href="<?php echo \core\basic\Url::get('/admin/Index/loginOut');?>"><i class="fa fa-sign-out" aria-hidden="true"></i> 退出登录</a>
        </li>

      </ul>
    </div>
  </div>
<div class="layui-body" style="padding:0;">
    <div class="ui-layout-west area manage-area" id="manage_area">
        <div id="tree" class="ztree"></div>
    </div>
    <div class="ui-layout-center" style="position: relative; padding-bottom:80px;">
        <ul class="tabs" style="position: absolute; bottom:15px; right:40px;">
            <!-- <li id="saveBtn">上传图片</li> -->
            <button type="button" class="layui-btn uploadmuti" data-des="pics">
                <i class="layui-icon">&#xe67c;</i>上传多图
            </button>
        </ul>
        <iframe name="content_body" id="content_body" src="<?php echo \core\basic\Url::get('/admin/Media/get_images_path/pagesize/30/flag/1/num/'.$this->vars['info']['num'].'/func/'.$this->vars['info']['func'].'');?>" width="100%" height="100%" frameborder="0"></iframe>
    </div>
</div>
<input type="hidden" id="do_check" data-url="<?php echo \core\basic\Url::get('/admin/Upgrade/check');?>">
<input type="hidden" id="do_down" data-url="<?php echo \core\basic\Url::get('/admin/Upgrade/down');?>">
<input type="hidden" id="do_update" data-url="<?php echo \core\basic\Url::get('/admin/Upgrade/update');?>">
<input type="hidden" id="check_version" data-url="/index.php?p=upgrade/check&version=<?php echo APP_VERSION;?>.<?php echo RELEASE_TIME;?>.<?php echo $this->getVar('revise');?>&branch=<?php echo $this->getVar('branch');?>&snuser=<?php echo $this->getVar('snuser');?>&site=<?php echo $this->getVar('site');?>">
<input type="hidden" id="check_cache" data-url="<?php echo \core\basic\Url::get('/admin/Upgrade/checkCache');?>">
</div>

<script type="text/javascript" src="<?php echo APP_THEME_DIR;?>/layui/layui.all.js?v=v2.5.4"></script>
<script type="text/javascript" src="<?php echo APP_THEME_DIR;?>/js/comm.js?v=v3.1.1"></script>

<script type="text/javascript" src="<?php echo APP_THEME_DIR;?>/js/mylayui.js?v=v3.1.0"></script>

<!-- <script type="text/javascript" src="https://www.pbootcms.com/res/v1/js/update.js?v=v3.1.3" ></script> -->
<!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
<!--[if lt IE 9]>
  <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
  <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

</body>
</html>

<link rel="stylesheet" type="text/css" href="<?php echo APP_THEME_DIR;?>/js/plugins/webuploader/css/style.css?v=1.0">
<link rel="stylesheet" href="<?php echo APP_THEME_DIR;?>/js/plugins/ztree/css/iframe.css?v=1.0">
<link rel="stylesheet" href="<?php echo APP_THEME_DIR;?>/js/plugins/ztree/css/zTreeStyle/zTreeStyle.css?v=1.0" type="text/css">
<script src="<?php echo APP_THEME_DIR;?>/js/jquery.layout-latest.min.js?v=1.0"></script>
<script type="text/javascript" src="<?php echo APP_THEME_DIR;?>/js/plugins/ztree/js/jquery.ztree.core.min.js?v=1.0"></script>
<script type="text/javascript">
    var myLayout;
    jQuery(document).ready(function () {
        myLayout = jQuery(".layui-body").layout({
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
        $(".ui-layout-north li:first-child").click();
    });
</script>
<script type="text/javascript">
    layui.use(['element','upload'], function(){
      var element = layui.element;
      var upload = layui.upload;
    
      var sitedir=$('#sitedir').data('sitedir');
      var uploadurl = $("#preurl").data('preurl')+'/index/upload';
      //执行多图片上传实例
      var files='';
    //   var html='';
      var uploadsInst = upload.render({
        elem: '.uploadmuti' //绑定元素
        ,url: uploadurl //上传接口
        ,field: 'upload' //字段名称
        ,multiple: true//多文件上传
        ,accept: 'images' //接收文件类型 images（图片）、file（所有文件）、video（视频）、audio（音频）
        ,acceptMime: 'image/*'
        ,before: function(obj){ 
           layer.load(); //上传loading
        }
        ,done: function(res){
           if(res.code==1){
            if(files){
                files+=','+res.data[0];
            }else{
                files+=res.data[0];
            }
            //    html += "<dl><dt><img src='"+sitedir+res.data[0]+"' data-url='"+res.data[0]+"'></dt><dd>删除</dd></dl>";
           }else{
               layer.msg('有文件上传失败：'+res.data); 
           } 
        }
          ,allDone: function(obj){
              var item = this.item;
              var des=$(item).data('des');
              layer.closeAll('loading'); //关闭loading
            if(files!=''){
                var files = '/abc/acb.jpg,/aaa/abc.png';
                var folder = files.substr(0,files.indexOf(','));
                folder = folder.substr(0,folder.lastIndexOf('/')+1);
                layer.msg('成功上传'+obj.successful+'个文件！',{time:500},function(){
                    //location.href='<?php echo \core\basic\Url::get('/admin/Media/media_list');?>&images_path='+folder;
                    location.reload();
                });
                files='';
                //html='';
            }else{
                layer.msg('全部上传失败！'); 
            }
         }
        ,error: function(){
            layer.closeAll('loading'); //关闭loading
            layer.msg('上传发生错误！'); 
        }
      });
    });
</script>
<?php return array (
  0 => 'F:/phpEnv/www/www.text.com/apps/admin/view/default/common/head.html',
  1 => 'F:/phpEnv/www/www.text.com/apps/admin/view/default/common/foot.html',
); ?>