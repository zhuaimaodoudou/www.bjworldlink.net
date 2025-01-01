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
<!-- 引入编辑器文件 -->
<?php if (QINIU_OPEN == 'true') {?>
<script type="text/javascript" charset="utf-8" src="<?php echo CORE_DIR;?>/extend/qiniu_ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo CORE_DIR;?>/extend/qiniu_ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="<?php echo CORE_DIR;?>/extend/qiniu_ueditor/lang/zh-cn/zh-cn.js"></script>
<?php } else { ?>
<script type="text/javascript" charset="utf-8" src="<?php echo CORE_DIR;?>/extend/ueditor/ueditor.config.js?v=v2.0.1"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo CORE_DIR;?>/extend/ueditor/ueditor.all.min.js?v=v2.0.1"> </script>
<script type="text/javascript" charset="utf-8" src="<?php echo CORE_DIR;?>/extend/ueditor/lang/zh-cn/zh-cn.js?v=1.3.5"></script>

<?php } ?>
<script>
//初始化编辑器
$(document).ready(function (e) {
  const editor = document.querySelector('#editor');
  if(editor){
    var ue = UE.getEditor('editor',{
    maximumWords:30000 
  });
  }

})
</script>


<script type="text/javascript">
   <!-- 解决源码模式无法保存 -->
  function editor_init() {
      $('#edit').submit(function () {
          editor=UE.getEditor('editor');
          if(editor.queryCommandState('source')==1) editor.execCommand('source');
      })
  }
 
  <!-- 点击后添加到编辑器 -->
  $(".addedit").on("click",'img',function(){
      editor=UE.getEditor('editor');
    $img = $(this).attr("src");
    editor.execCommand('inserthtml',"<img src='"+$img+"'>");
   });

</script>

<script type="text/javascript">editor_init();</script>
<style>
    .el-textarea,
    .el-textarea textarea {
        min-height: 100px !important;
    }
</style>
<?php if ($this->getVar('list')) {?>
<script type="text/javascript" src="<?php echo APP_THEME_DIR;?>/js/jquery.cookie.min.js"></script>
<?php } ?>
<div class="layui-body" id="app-vue">
    <?php if ($this->getVar('list')) {?>
    <div class="layui-tab layui-tab-brief" lay-filter="tab">
        <ul class="layui-tab-title">
            <li class="layui-this" lay-id="t1">栏目列表</li>
            <li lay-id="t2">栏目新增</li>
            <li lay-id="t3">批量新增</li>
        </ul>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <form action="<?php echo \core\basic\Url::get('/admin/ContentSort/mod');?>" method="post" id="sortForm" name="sortForm"
                    onkeydown="if(event.keyCode==13) return false;" class="layui-form">
                    <input type="hidden" name="formcheck" value="<?php echo $this->getVar('formcheck');?>">
                    <table class="layui-table" id="sortTable">
                        <thead>
                            <tr>
                                <th><input type="checkbox" lay-ignore id="checkall" title="全选"></th>
                                <th>栏目名称</th>
                                <th>编码</th>
                                <th>URL名称</th>
                                <th>模型</th>
                                <th>列表页模板</th>
                                <th>详情页模板</th>
                                <th>排序</th>
                                <th>状态</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <div>展开全部菜单 <i class='fa fa-toggle-off' id="openMenu" title="点击关闭"></i></div>
                            <?php $num = 0;foreach ($this->getVar('sorts') as $key => $value) { $num++;?>
                            <tr data-tt-id='<?php echo $value->scode; ?>' data-tt-parent-id="<?php echo $value->pcode; ?>">
                                <td>
                                    <input type="checkbox" class="checkitem" lay-ignore name="list[]"
                                        value="<?php echo $value->scode; ?>">
                                    <input type="hidden" name="listall[]" value="<?php echo $value->id; ?>">
                                </td>
                                <td class="layui-table-cell table-title ">
                                    <?php if ($value->son) {?>
                                    <i class="fa fa-folder-o" aria-hidden="true"></i>
                                    <?php } else { ?>
                                    <i class="fa fa-folder-open-o" aria-hidden="true"></i>
                                    <?php } ?>
                                    <input type="text" name="name[]" value="<?php echo $value->name; ?>" class="layui-input"
                                        style="width:auto">
                                    <?php if ($value->outlink) {?>
                                    <a href="<?php echo $value->outlink; ?>" target="_blank"><i class="fa fa-external-link"
                                            aria-hidden="true"></i></a>
                                    <?php } ?>
                                </td>
                                <td><?php echo $value->scode; ?></td>
                                <td><?php echo $value->filename; ?></td>
                                <td>
                                    <?php $num = 0;foreach ($this->getVar('allmodels') as $key2 => $value2) { $num++;?>
                                    <?php if ($value2->mcode==$value->mcode) {?>
                                    <?php echo $value2->name; ?>
                                    <?php } ?>
                                    <?php } ?>
                                </td>
                                <td><?php echo $value->listtpl; ?></td>
                                <td><?php echo $value->contenttpl; ?></td>
                                <td class="table-input"><input type="text" name="sorting[]" value="<?php echo $value->sorting; ?>"
                                        class="layui-input"></td>
                                <td>
                                    <?php if ($value->status) {?>
                                    <a href="<?php echo \core\basic\Url::get('/admin/'.C.'/mod/scode/'.$value->scode.'/field/status/value/0');?>"
                                        class="switch"><i class='fa fa-toggle-on' title="点击禁用"></i></a>
                                    <?php } else { ?>
                                    <a href="<?php echo \core\basic\Url::get('/admin/'.C.'/mod/scode/'.$value->scode.'/field/status/value/1');?>"
                                        class="switch"><i class='fa fa-toggle-off' title="点击启用"></i></a>
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if (!$value->outlink) {?>
                                    <?php  
                                    $Parser=new app\home\controller\ParserController();
                                    $link=$Parser->parserLink($value->type,$value->urlname,'list',$value->scode,$value->filename,'','');
                                    ?>
                                    <a href="<?php  echo $link?>" class="layui-btn layui-btn-xs layui-btn-primary"
                                        target="_blank">查看</a>
                                    <?php } ?>
                                    <?php echo get_btn_del($value->scode,'scode');?>
                                    <?php echo get_btn_mod($value->scode,'scode');?>

                                    <?php if (!$value->outlink) {?>
                                    <?php if ($value->type==1) {?>
                                    <?php  
                                    $value->urlContent='?p=Single/index/mcode/'.$value->mcode.'&field=b.name&keyword='.$value->name
                                    ?>
                                    <?php } else { ?>
                                    <?php  
                                    $value->urlContent='?p=Content/index/mcode/'.$value->mcode.'&scode='.$value->scode
                                    ?>
                                    <?php } ?>
                                    <a href="<?php echo $value->urlContent; ?>" class="layui-btn layui-btn-xs layui-btn-warm">查看内容</a>
                                    <?php } ?>

                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <div class="layui-input-inline">
                        <select name="pcode">
                            <option value="">请选择移动到栏目</option>
                            <option value="0">顶级栏目</option>
                            <?php echo $this->getVar('sort_select');?>
                        </select>
                    </div>
                    <script>
                        function setDelAction() {
                            document.sortForm.action = "<?php echo \core\basic\Url::get('/admin/ContentSort/del');?>";
                            return confirm("您确定要删除选中的栏目么？");
                        }
                    </script>
                    <button type="submit" name="submit" value="move" class="layui-btn">移动栏目</button>
                    <button type="submit" name="submit" value="copy" class="layui-btn">复制栏目</button>
                    <button type="submit" name="submit" value="name" class="layui-btn">保存标题</button>
                    <button type="submit" name="submit" value="sorting" class="layui-btn">保存排序</button>
                    <button type="submit" name="submit" onclick="return setDelAction();" class="layui-btn">批量删除</button>

                    <?php if (!$this->getVar('one_area')) {?>
                    <div class="layui-input-inline layui-col-md-offset3">
                        <select name="acode">
                            <option value="">复制到其他语言</option>
                            <?php echo $this->getVar('area_htmlS');?>
                        </select>
                    </div>
                    <button type="submit" name="submit" value="copyall" class="layui-btn">复制到其他语言</button>
                    <?php } ?>


                </form>
            </div>
            <div class="layui-tab-item">
                <form action="<?php echo \core\basic\Url::get('/admin/ContentSort/add');?>" method="post" class="layui-form" lay-filter="sort">
                    <input type="hidden" name="formcheck" value="<?php echo $this->getVar('formcheck');?>">
                    <div class="layui-tab">
                        <ul class="layui-tab-title">
                            <li class="layui-this">基本选项</li>
                            <li>高级选项</li>
                        </ul>
                        <div class="layui-tab-content">
                            <div class="layui-tab-item layui-show">
                                <div class="layui-form-item">
                                    <label class="layui-form-label">父栏目</label>
                                    <div class="layui-input-block">
                                        <select name="pcode">
                                            <option value="0">顶级栏目</option>
                                            <?php echo $this->getVar('sort_select');?>
                                        </select>
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">栏目名称 <span class="layui-text-red">*</span></label>
                                    <div class="layui-input-block">
                                        <input type="text" name="name" required lay-verify="required"
                                            placeholder="请输入栏目名称" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">URL名称</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="filename" placeholder="请输入URL名称，如:test，test/a/b/c"
                                            class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">内容模型 <span class="layui-text-red">*</span></label>
                                    <div class="layui-input-block">
                                        <select name="mcode" lay-filter="model" lay-verify="required">
                                            <option value="">请选择内容模型</option>
                                            <?php $num = 0;foreach ($this->getVar('models') as $key => $value) { $num++;?>
                                            <option value="<?php echo $value->mcode; ?>" data-type="<?php echo $value->type; ?>"
                                                data-listtpl="<?php echo $value->listtpl; ?>" data-contenttpl="<?php echo $value->contenttpl; ?>"><?php echo $value->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" value="1" name="type" id="type">
                                <div class="layui-form-item">
                                    <label class="layui-form-label">列表页模板</label>
                                    <div class="layui-input-block">
                                        <select name="listtpl" id="listtpl">
                                            <option value="">无</option>
                                            <?php $num = 0;foreach ($this->getVar('tpls') as $key => $value) { $num++;?>
                                            <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">详情页模板</label>
                                    <div class="layui-input-block">
                                        <select name="contenttpl" id="contenttpl">
                                            <option value="">无</option>
                                            <?php $num = 0;foreach ($this->getVar('tpls') as $key => $value) { $num++;?>
                                            <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">状态</label>
                                    <div class="layui-input-block">
                                        <input type="radio" name="status" value="1" title="显示" checked>
                                        <input type="radio" name="status" value="0" title="隐藏">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">浏览权限</label>
                                    <div class="layui-input-block">
                                        <select name="gid">
                                            <option value="">不限制</option>
                                            <?php $num = 0;foreach ($this->getVar('groups') as $key => $value) { $num++;?>
                                            <option value="<?php echo $value->id; ?>"><?php echo $value->gname; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">权限类型</label>
                                    <div class="layui-input-block">
                                        <select name="gtype" id="gtype">
                                            <option value="1">小于</option>
                                            <option value="2">小于等于</option>
                                            <option value="3">等于</option>
                                            <option value="4" selected>大于等于</option>
                                            <option value="5">大于</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="layui-tab-item">
                                <div class="layui-form-item">
                                    <label class="layui-form-label">栏目副名称</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="subname" placeholder="请输入栏目副名称" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">跳转链接</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="outlink" placeholder="请输入跳转链接" class="layui-input">
                                    </div>
                                </div>
                       
                                <div class="layui-form-item">
                                    <label class="layui-form-label">栏目缩略图</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="ico" id="ico" placeholder="请上传栏目缩略图"
                                            class="layui-input">
                                    </div>
                                    <button type="button" class="layui-btn upload" data-des="ico">
                                        <i class="layui-icon">&#xe67c;</i>上传图片
                                    </button>
                                    <a class="layui-btn layui-btn-warm" onclick="GetPictureFolder(1,'ico');">图库</a>
                                    <div id="ico_box" class="pic"></div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">栏目大图</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="pic" id="pic" placeholder="请上传栏目大图"
                                            class="layui-input">
                                    </div>
                                    <button type="button" class="layui-btn upload" data-des="pic">
                                        <i class="layui-icon">&#xe67c;</i>上传图片
                                    </button>
                                    <a class="layui-btn layui-btn-warm" onclick="GetPictureFolder(1,'pic');">图库</a>
                                    <div id="pic_box" class="pic"></div>
                                </div>
                                <div style="padding: 15px 0">
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">栏目扩展1</label>
                                        <div v-if="def1_type === 'textarea'" class="layui-input-block">
                                            <el-input type="textarea" autosize placeholder="请输入栏目扩展1内容" v-model="def1"
                                                maxlength="1000" show-word-limit>
                                        </div>
                                        <div v-if="def1_type === 'img'" class="layui-input-block">
                                            <el-upload name="upload" class="upload-demo"
                                                action="<?php echo \core\basic\Url::get('/admin/index/upload');?>" :file-list="def1Imgs"
                                                :on-remove="def1HandleRemove" :on-success="def1HandleSuccess"
                                                list-type="picture">
                                                <el-button type="primary">上传图片</el-button>
                                                <div slot="tip" class="el-upload__tip">上传文件大小不建议超过500k</div>
                                            </el-upload>

                                        </div>
                                        <div v-if="def1_type === 'file'" class="layui-input-block">
                                            <el-upload name="upload" class="upload-demo"
                                                action="<?php echo \core\basic\Url::get('/admin/index/upload');?>" :file-list="def1Files"
                                                :on-remove="def1HandleRemove" :on-success="def1HandleSuccess"
                                                list-type="text">
                                                <el-button type="primary">上传附件</el-button>
                                            </el-upload>

                                        </div>

                                        <div v-show="def1_type === 'editor'" class="layui-input-block">
                                            <p>使用编辑器，请多等待一下，如果上传后无内容，请重新编辑，重新编辑是有内容的</p>
                                            <textarea type="text/plain" name="def1" ref="def1" v-model="def1"
                                                id="editor_1" style="width:100%;height:360px;"> </textarea>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">扩展1的类型</label>
                                        <input type="hidden" name="def1_type" v-model="def1_type">
                                        <el-select v-model="def1_type" placeholder="请选择栏目扩展1的类型">
                                            <el-option v-for="item in defOptions" :key="item.value" :label="item.label"
                                                :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>

                                <div style="padding: 15px 0">
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">栏目扩展2</label>

                                        <div v-if="def2_type === 'textarea'" class="layui-input-block">
                                            <el-input type="textarea" autosize placeholder="请输入栏目扩展2内容" v-model="def2"
                                                maxlength="1000" show-word-limit>
                                        </div>
                                        <div v-if="def2_type === 'img'" class="layui-input-block">
                                            <el-upload name="upload" class="upload-demo" :on-remove="def2HandleRemove"
                                                action="<?php echo \core\basic\Url::get('/admin/index/upload');?>" :file-list="def2Imgs"
                                                :on-success="def2HandleSuccess" list-type="picture">
                                                <el-button type="primary">上传图片</el-button>
                                                <div slot="tip" class="el-upload__tip">上传文件大小不建议超过500k</div>
                                            </el-upload>

                                        </div>
                                        <div v-if="def2_type === 'file'" class="layui-input-block">
                                            <el-upload name="upload" class="upload-demo"
                                                action="<?php echo \core\basic\Url::get('/admin/index/upload');?>" :file-list="def2Files"
                                                :on-remove="def2HandleRemove" :on-success="def2HandleSuccess"
                                                list-type="text">
                                                <el-button type="primary">上传附件</el-button>
                                            </el-upload>

                                        </div>

                                        <div v-show="def2_type === 'editor'" class="layui-input-block">
                                            <p>使用编辑器，请多等待一下，如果上传后无内容，请重新编辑，重新编辑是有内容的</p>
                                            <textarea type="text/plain" name="def2" ref="def2" v-model="def2"
                                                id="editor_2" style="width:100%;height:360px;"> </textarea>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">扩展2的类型</label>
                                        <input type="hidden" name="def2_type" v-model="def2_type">
                                        <el-select v-model="def2_type" placeholder="请选择栏目扩展2的类型">
                                            <el-option v-for="item in defOptions" :key="item.value" :label="item.label"
                                                :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>

                                <div style="padding: 15px 0">
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">栏目扩展3</label>
                                        <div v-if="def3_type === 'textarea'" class="layui-input-block">
                                            <el-input type="textarea" autosize placeholder="请输入栏目扩展3内容" v-model="def3"
                                                maxlength="1000" show-word-limit>
                                        </div>
                                        <div v-if="def3_type === 'img'" class="layui-input-block">
                                            <el-upload name="upload" class="upload-demo"
                                                action="<?php echo \core\basic\Url::get('/admin/index/upload');?>" :file-list="def3Imgs"
                                                :on-remove="def3HandleRemove" :on-success="def3HandleSuccess"
                                                list-type="picture">
                                                <el-button type="primary">上传图片</el-button>
                                                <div slot="tip" class="el-upload__tip">上传文件大小不建议超过500k</div>
                                            </el-upload>

                                        </div>
                                        <div v-if="def3_type === 'file'" class="layui-input-block">
                                            <el-upload name="upload" class="upload-demo"
                                                action="<?php echo \core\basic\Url::get('/admin/index/upload');?>" :file-list="def3Files"
                                                :on-remove="def3HandleRemove" :on-success="def3HandleSuccess"
                                                list-type="text">
                                                <el-button type="primary">上传附件</el-button>
                                            </el-upload>

                                        </div>
                                        <div v-show="def3_type === 'editor'" class="layui-input-block">
                                            <p>这个可以正常编辑，不需要等待</p>
                                            <textarea type="text/plain" name="def3" ref="def3" v-model="def3"
                                                id="editor_3" style="width:100%;height:360px;"> </textarea>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">扩展3的类型</label>
                                        <input type="hidden" name="def3_type" v-model="def3_type">
                                        <el-select v-model="def3_type" placeholder="请选择栏目扩展3的类型">
                                            <el-option v-for="item in defOptions" :key="item.value" :label="item.label"
                                                :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">权限不足提示</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="gnote" placeholder="请输入权限不足时提示文本" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">SEO标题</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="title" placeholder="请输入栏目SEO标题，需前端调用"
                                            class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">SEO关键字</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="keywords" placeholder="请输入栏目SEO关键字，需前端调用"
                                            class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">SEO描述</label>
                                    <div class="layui-input-block">
                                        <textarea name="description" placeholder="请输入栏目SEO描述，需前端调用"
                                            class="layui-textarea"></textarea>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <button class="layui-btn" lay-submit>立即提交</button>
                            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- 批量新增 -->
            <div class="layui-tab-item">
                <form action="<?php echo \core\basic\Url::get('/admin/ContentSort/add');?>" method="post" class="layui-form" lay-filter="sort">
                    <input type="hidden" name="formcheck" value="<?php echo $this->getVar('formcheck');?>">
                    <div class="layui-form-item">
                        <label class="layui-form-label">父栏目</label>
                        <div class="layui-input-block">
                            <select name="pcode">
                                <option value="0">顶级栏目</option>
                                <?php echo $this->getVar('sort_select');?>
                            </select>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">栏目名称</label>
                        <div class="layui-input-block">
                            <input type="text" name="multiplename" required lay-verify="required"
                                placeholder="请输入栏目名称，多个栏目用逗号隔开" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">内容模型</label>
                        <div class="layui-input-block">
                            <select name="mcode" lay-filter="model" lay-verify="required">
                                <option value="">请选择内容模型</option>
                                <?php $num = 0;foreach ($this->getVar('models') as $key => $value) { $num++;?>
                                <option value="<?php echo $value->mcode; ?>" data-type="<?php echo $value->type; ?>" data-listtpl="<?php echo $value->listtpl; ?>"
                                    data-contenttpl="<?php echo $value->contenttpl; ?>"><?php echo $value->name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" value="1" name="type" id="type">
                    <div class="layui-form-item">
                        <label class="layui-form-label">列表页模板</label>
                        <div class="layui-input-block">
                            <select name="listtpl" id="listtpl">
                                <option value="">无</option>
                                <?php $num = 0;foreach ($this->getVar('tpls') as $key => $value) { $num++;?>
                                <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">详情页模板</label>
                        <div class="layui-input-block">
                            <select name="contenttpl" id="contenttpl">
                                <option value="">无</option>
                                <?php $num = 0;foreach ($this->getVar('tpls') as $key => $value) { $num++;?>
                                <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">状态</label>
                        <div class="layui-input-block">
                            <input type="radio" name="status" value="1" title="显示" checked>
                            <input type="radio" name="status" value="0" title="隐藏">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <button class="layui-btn" lay-submit>立即提交</button>
                            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php } ?>
    <?php if ($this->getVar('mod')) {?>
    <div class="layui-tab layui-tab-brief" lay-filter="tab">
        <ul class="layui-tab-title">
            <li class="layui-this">栏目修改</li>
        </ul>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <form action="<?php echo \core\basic\Url::get('/admin/ContentSort/mod/scode/'.get('scode').'');?><?php echo $this->getVar('backurl');?>" method="post"
                    class="layui-form" lay-filter="sort">
                    <input type="hidden" name="formcheck" value="<?php echo $this->getVar('formcheck');?>">
                    <div class="layui-tab">
                        <ul class="layui-tab-title">
                            <li class="layui-this">基本选项</li>
                            <li>高级选项</li>
                        </ul>
                        <div class="layui-tab-content">
                            <div class="layui-tab-item layui-show">
                                <div class="layui-form-item">
                                    <label class="layui-form-label">父栏目</label>
                                    <div class="layui-input-block">
                                        <select name="pcode" id="pcode">
                                            <option value="0">顶级栏目</option>
                                            <?php echo $this->getVar('sort_select');?>
                                        </select>
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">栏目名称 <span class="layui-text-red">*</span></label>
                                    <div class="layui-input-block">
                                        <input type="text" name="name" required lay-verify="required"
                                            value="<?php echo @$this->getVar('sort')->name;?>" placeholder="请输入栏目名称" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">URL名称 </label>
                                    <div class="layui-input-block">
                                        <input type="text" name="filename" value="<?php echo @$this->getVar('sort')->filename;?>"
                                            placeholder="请输入URL名称，如:test，test/a/b/c" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">内容模型 <span class="layui-text-red">*</span></label>
                                    <div class="layui-input-block">
                                        <select name="mcode" lay-filter="model" lay-verify="required">
                                            <option value="">请选择内容模型</option>
                                            <?php $num = 0;foreach ($this->getVar('models') as $key => $value) { $num++;?>
                                            <option value="<?php echo $value->mcode; ?>" <?php if ($value->mcode==$this->getVar('sort')->mcode) {?>selected<?php } ?> data-type="<?php echo $value->type; ?>" data-listtpl="<?php echo $value->listtpl; ?>" data-contenttpl="<?php echo $value->contenttpl; ?>"><?php echo $value->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" name="type" id="type" value="<?php echo @$this->getVar('sort')->type;?>">
                                <div class="layui-form-item">
                                    <label class="layui-form-label">列表页模板</label>
                                    <div class="layui-input-block">
                                        <select name="listtpl" id="listtpl">
                                            <option value="<?php echo @$this->getVar('sort')->listtpl;?>"><?php echo @$this->getVar('sort')->listtpl;?></option>
                                            <option value="">无</option>
                                            <?php $num = 0;foreach ($this->getVar('tpls') as $key => $value) { $num++;?>
                                            <?php if ($value!=$this->getVar('sort')->listtpl) {?>
                                            <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                            <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">详情页模板</label>
                                    <div class="layui-input-block">
                                        <select name="contenttpl" id="contenttpl">
                                            <option value="<?php echo @$this->getVar('sort')->contenttpl;?>"><?php echo @$this->getVar('sort')->contenttpl;?></option>
                                            <option value="">无</option>
                                            <?php $num = 0;foreach ($this->getVar('tpls') as $key => $value) { $num++;?>
                                            <?php if ($value!=$this->getVar('sort')->contenttpl) {?>
                                            <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                            <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">同步子栏目模板</label>
                                    <div class="layui-input-block">
                                        <input type="radio" name="modsub" value="1" title="是">
                                        <input type="radio" name="modsub" value="0" title="否" checked>
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">状态</label>
                                    <div class="layui-input-block">
                                        <input type="radio" name="status" value="1" title="显示"
                                            <?php if ($this->getVar('sort')->status==1) {?>checked="checked"<?php } ?>>
                                        <input type="radio" name="status" value="0" title="隐藏"
                                            <?php if ($this->getVar('sort')->status==0) {?>checked="checked"<?php } ?>>
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">浏览权限</label>
                                    <div class="layui-input-block">
                                        <select name="gid">
                                            <option value="">不限制</option>
                                            <?php $num = 0;foreach ($this->getVar('groups') as $key => $value) { $num++;?>
                                            <option value="<?php echo $value->id; ?>" <?php if ([$sort->
                                                gid]==$value->id) {?>selected="selected"<?php } ?>><?php echo $value->gname; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">权限类型</label>
                                    <div class="layui-input-block">
                                        <select name="gtype" id="gtype">
                                            <option value="1" <?php if ($this->getVar('sort')->gtype==1) {?>selected="selected"<?php } ?>>小于
                                            </option>
                                            <option value="2" <?php if ($this->getVar('sort')->gtype==2) {?>selected="selected"<?php } ?>>小于等于
                                            </option>
                                            <option value="3" <?php if ($this->getVar('sort')->gtype==3) {?>selected="selected"<?php } ?>>等于
                                            </option>
                                            <option value="4" <?php if ([$sort->
                                                gtype]==4||(!$this->getVar('sort')->gtype)) {?>selected="selected"<?php } ?>>大于等于</option>
                                            <option value="5" <?php if ($this->getVar('sort')->gtype==5) {?>selected="selected"<?php } ?>>大于
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="layui-tab-item">
                                <div class="layui-form-item">
                                    <label class="layui-form-label">栏目副名称</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="subname" value="<?php echo @$this->getVar('sort')->subname;?>"
                                            placeholder="请输入栏目副名称" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">跳转链接</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="outlink" value="<?php echo @$this->getVar('sort')->outlink;?>" placeholder="请输入跳转链接"
                                            class="layui-input">
                                    </div>
                                </div>
                                
                                <div class="layui-form-item">
                                    <label class="layui-form-label">栏目缩略图</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="ico" id="ico" value="<?php echo @$this->getVar('sort')->ico;?>"
                                            placeholder="请上传栏目缩略图" class="layui-input">
                                    </div>
                                    <button type="button" class="layui-btn upload" data-des="ico">
                                        <i class="layui-icon">&#xe67c;</i>上传图片
                                    </button>
                                    <a class="layui-btn layui-btn-warm" onclick="GetPictureFolder(1,'ico');">图库</a>
                                    <div id="ico_box" class="pic">
                                        <dl>
                                            <dt><?php if ($this->getVar('sort')->ico) {?><img src='<?php echo SITE_DIR;?><?php echo @$this->getVar('sort')->ico;?>'
                                                    data-url="<?php echo @$this->getVar('sort')->ico;?>"></dt>
                                            <dd>删除</dd>
                                        </dl><?php } ?>
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">栏目大图</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="pic" id="pic" value="<?php echo @$this->getVar('sort')->pic;?>"
                                            placeholder="请上传栏目大图" class="layui-input">
                                    </div>
                                    <button type="button" class="layui-btn upload" data-des="pic">
                                        <i class="layui-icon">&#xe67c;</i>上传图片
                                    </button>
                                    <a class="layui-btn layui-btn-warm" onclick="GetPictureFolder(1,'pic');">图库</a>
                                    <div id="pic_box" class="pic">
                                        <dl>
                                            <dt><?php if ($this->getVar('sort')->pic) {?><img src='<?php echo SITE_DIR;?><?php echo @$this->getVar('sort')->pic;?>'
                                                    data-url="<?php echo @$this->getVar('sort')->pic;?>"></dt>
                                            <dd>删除</dd>
                                        </dl><?php } ?>
                                    </div>
                                </div>
                                <div style="padding: 15px 0;">
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">栏目扩展1</label>
                                        <div v-if="def1_type === 'textarea'" class="layui-input-block">
                                            <el-input type="textarea" autosize placeholder="请输入栏目扩展1内容" v-model="def1"
                                                maxlength="1000" show-word-limit>
                                        </div>
                                        <div v-if="def1_type === 'img'" class="layui-input-block">
                                            <el-upload name="upload" class="upload-demo"
                                                action="<?php echo \core\basic\Url::get('/admin/index/upload');?>" :file-list="def1Imgs"
                                                :on-remove="def1HandleRemove" :on-success="def1HandleSuccess"
                                                list-type="picture">
                                                <el-button type="primary">上传图片</el-button>
                                                <div slot="tip" class="el-upload__tip">上传文件大小不建议超过500k</div>
                                            </el-upload>

                                        </div>
                                        <div v-if="def1_type === 'file'" class="layui-input-block">
                                            <el-upload name="upload" class="upload-demo" :on-remove="def1HandleRemove"
                                                action="<?php echo \core\basic\Url::get('/admin/index/upload');?>" :file-list="def1Files"
                                                :on-success="def1HandleSuccess" list-type="text">
                                                <el-button type="primary">上传附件</el-button>
                                            </el-upload>

                                        </div>

                                        <div v-show="def1_type === 'editor'" class="layui-input-block">
                                            <textarea type="text/plain" name="def1" ref="def1" id="editor_1"
                                                style="width:100%;height:360px;"><?php echo decode_string($this->getVar('sort')->def1);?></textarea>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">扩展1的类型</label>
                                        <input type="hidden" name="def1_type" v-model="def1_type">
                                        <el-select v-model="def1_type" placeholder="请选择栏目扩展1的类型">
                                            <el-option v-for="item in defOptions" :key="item.value" :label="item.label"
                                                :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div style="padding: 15px 0;">
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">栏目扩展2</label>
                                        <div v-if="def2_type === 'textarea'" class="layui-input-block">
                                            <el-input type="textarea" autosize placeholder="请输入栏目扩展2内容" v-model="def2"
                                                maxlength="1000" show-word-limit>
                                        </div>
                                        <div v-if="def2_type === 'img'" class="layui-input-block">
                                            <el-upload name="upload" class="upload-demo" :on-remove="def2HandleRemove"
                                                action="<?php echo \core\basic\Url::get('/admin/index/upload');?>" :file-list="def2Imgs"
                                                :on-success="def2HandleSuccess" list-type="picture">
                                                <el-button type="primary">上传图片</el-button>
                                                <div slot="tip" class="el-upload__tip">上传文件大小不建议超过500k</div>
                                            </el-upload>

                                        </div>
                                        <div v-if="def2_type === 'file'" class="layui-input-block">
                                            <el-upload name="upload" class="upload-demo" :on-remove="def2HandleRemove"
                                                action="<?php echo \core\basic\Url::get('/admin/index/upload');?>" :file-list="def2Files"
                                                :on-success="def2HandleSuccess" list-type="text">
                                                <el-button type="primary">上传附件</el-button>
                                            </el-upload>

                                        </div>

                                        <div v-show="def2_type === 'editor'" class="layui-input-block">
                                            <textarea type="text/plain" name="def2" ref="def2" id="editor_2"
                                                style="width:100%;height:360px;"><?php echo decode_string($this->getVar('sort')->def2);?></textarea>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">扩展2的类型</label>
                                        <input type="hidden" name="def2_type" v-model="def2_type">
                                        <el-select v-model="def2_type" placeholder="请选择栏目扩展2的类型">
                                            <el-option v-for="item in defOptions" :key="item.value" :label="item.label"
                                                :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div style="padding: 15px 0;">
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">栏目扩展3</label>
                                        <div v-if="def3_type === 'textarea'" class="layui-input-block">
                                            <el-input type="textarea" autosize placeholder="请输入栏目扩展3内容" v-model="def3"
                                                maxlength="1000" show-word-limit>
                                        </div>
                                        <div v-if="def3_type === 'img'" class="layui-input-block">
                                            <el-upload name="upload" class="upload-demo" :on-remove="def3HandleRemove"
                                                action="<?php echo \core\basic\Url::get('/admin/index/upload');?>" :file-list="def3Imgs"
                                                :on-success="def3HandleSuccess" list-type="picture">
                                                <el-button type="primary">上传图片</el-button>
                                                <div slot="tip" class="el-upload__tip">上传文件大小不建议超过500k</div>
                                            </el-upload>

                                        </div>
                                        <div v-if="def3_type === 'file'" class="layui-input-block">
                                            <el-upload name="upload" class="upload-demo" :on-remove="def3HandleRemove"
                                                action="<?php echo \core\basic\Url::get('/admin/index/upload');?>" :file-list="def3Files"
                                                :on-success="def3HandleSuccess" list-type="text">
                                                <el-button type="primary">上传附件</el-button>
                                            </el-upload>

                                        </div>
                                        <div v-show="def3_type === 'editor'" class="layui-input-block">
                                            <textarea type="text/plain" name="def3" ref="def3" id="editor_3"
                                                style="width:100%;height:360px;"><?php echo decode_string($this->getVar('sort')->def3);?></textarea>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">扩展3的类型</label>
                                        <input type="hidden" name="def3_type" v-model="def3_type">
                                        <el-select v-model="def3_type" placeholder="请选择栏目扩展3的类型">
                                            <el-option v-for="item in defOptions" :key="item.value" :label="item.label"
                                                :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">权限不足提示</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="gnote" value="<?php echo @$this->getVar('sort')->gnote;?>"
                                            placeholder="请输入权限不足时提示文本" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">SEO标题</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="title" value="<?php echo @$this->getVar('sort')->title;?>"
                                            placeholder="请输入栏目SEO标题，需前端调用" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">SEO关键字</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="keywords" value="<?php echo @$this->getVar('sort')->keywords;?>"
                                            placeholder="请输入栏目SEO关键字，需前端调用" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">SEO描述</label>
                                    <div class="layui-input-block">
                                        <textarea name="description" placeholder="请输入栏目SEO描述，需前端调用"
                                            class="layui-textarea"><?php echo @$this->getVar('sort')->description;?></textarea>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <button class="layui-btn" lay-submit>立即提交</button>
                            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                            <?php echo get_btn_back();?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php } ?>
</div>
<script>
    function originPbootFunc() {

        //菜单全部展开
        var iscookie = $.cookie('openMenu');
        if (!iscookie) {
            $("#sortTable").treetable({ expandable: true, column: 1, indent: 20, stringCollapse: '收缩', stringExpand: '展开' });
            $('#openMenu.fa-toggle-on').removeClass('fa-toggle-on').addClass('fa-toggle-off');

        } else {
            $("#sortTable").treetable({ expandable: true, column: 1, indent: 20, stringCollapse: '收缩', stringExpand: '展开', initialState: "expanded" });
            console.log('展开');

            $('#openMenu.fa-toggle-off').removeClass('fa-toggle-off').addClass('fa-toggle-on');
        }

        $("#openMenu").click(function () {
            var iscookie = $.cookie('openMenu');

            if (iscookie) {
                $.removeCookie('openMenu');
            } else {
                $.cookie('openMenu', 'true');
            }
            location.reload();
        })
    }
    const def1Vue = new Vue({
        el: "#app-vue",
        data() {
            return {
                isList: "<?php if ($this->getVar('list')) {?>1<?php } ?>",
                def1_type: '<?php echo @$this->getVar('sort')->def1_type;?>' || "textarea",
                def1: `<?php echo @$this->getVar('sort')->def1;?>`,
                def2_type: '<?php echo @$this->getVar('sort')->def2_type;?>' || "textarea",
                def2: `<?php echo @$this->getVar('sort')->def2;?>`,
                def3_type: '<?php echo @$this->getVar('sort')->def3_type;?>' || "textarea",
                def3: `<?php echo @$this->getVar('sort')->def3;?>`,
                editor1: null,
                editor2: null,
                editor3: null,
                def1Imgs: [],
                def2Imgs: [],
                def3Imgs: [],
                def1Files: [],
                def2Files: [],
                def3Files: [],
                defOptions: [
                    {
                        value: 'textarea',
                        label: '文本类型',
                    },
                    {
                        value: 'img',
                        label: '图片类型',
                    },
                    {
                        value: 'file',
                        label: '附件类型',
                    },
                    {
                        value: 'editor',
                        label: '编辑器'
                    }
                ]
            }
        },
        created() {
            if (this.def1 && this.def1_type === "img") {
                const def1Imgs = this.def1.split(",")
                for (const item of def1Imgs) {
                    this.def1Imgs.push({
                        name: item,
                        url: item
                    })
                }
            }
            if (this.def2 && this.def2_type === "img") {
                const def2Imgs = this.def2.split(",")
                for (const item of def2Imgs) {
                    this.def2Imgs.push({
                        name: item,
                        url: item
                    })
                }
            }
            if (this.def3 && this.def3_type === "img") {
                const def3Imgs = this.def3.split(",")
                for (const item of def3Imgs) {
                    this.def3Imgs.push({
                        name: item,
                        url: item
                    })
                }
            }
            if (this.def1 && this.def1_type === "file") {
                const def1Files = this.def1.split(",")
                for (const item of def1Files) {
                    this.def1Files.push({
                        name: item,
                        url: item
                    })
                }
            }
            if (this.def2 && this.def2_type === "file") {
                const def2Files = this.def2.split(",")
                for (const item of def2Files) {
                    this.def2Files.push({
                        name: item,
                        url: item
                    })
                }
            }
            if (this.def3 && this.def3_type === "file") {
                const def3Files = this.def3.split(",")
                for (const item of def3Files) {
                    this.def3Files.push({
                        name: item,
                        url: item
                    })
                }
            }
        },
        mounted() {
            if (this.isList === '1') {
                originPbootFunc()
            }
            if (this.def1_type === 'editor') {
                this.editor1 = UE.getEditor('editor_1', {
                    maximumWords: 10000
                });
            }
            if (this.def2_type === 'editor') {
                this.editor2 = UE.getEditor('editor_2', {
                    maximumWords: 10000
                });
            }
            if (this.def3_type === 'editor') {
                this.editor3 = UE.getEditor('editor_3', {
                    maximumWords: 10000
                });
            }




        },
        methods: {
            def1HandleRemove(file, fileList) {
                if (this.def1_type === "img") {
                    this.def1Imgs = [];
                } else if (this.def1_type === "file") {
                    this.def1Files = [];
                }
            },
            def2HandleRemove(file, fileList) {
                if (this.def2_type === "img") {
                    this.def2Imgs = [];
                } else if (this.def2_type === "file") {
                    this.def2Files = [];
                }
            },
            def3HandleRemove(file, fileList) {
                if (this.def3_type === "img") {
                    this.def3Imgs = [];
                } else if (this.def3_type === "file") {
                    this.def3Files = [];
                }
            },
            def1HandleSuccess(res, uploadFile) {
                if (!res.code) {
                    ELEMENT.Message.error(res.data);
                } else {
                    if (this.def1_type === "img") {
                        this.def1Imgs = []
                        this.def1Imgs.push({
                            name: res.data.join(","),
                            url: res.data.join(",")
                        })
                    } else if (this.def1_type === "file") {
                        this.def1Files = []
                        this.def1Files.push({
                            name: res.data.join(","),
                            url: res.data.join(",")
                        })
                    }
                }
            },
            def2HandleSuccess(res, uploadFile) {
                if (!res.code) {
                    ELEMENT.Message.error(res.data);
                } else {
                    if (this.def2_type === "img") {
                        this.def2Imgs = [];
                        this.def2Imgs.push({
                            name: res.data.join(","),
                            url: res.data.join(",")
                        })
                    } else if (this.def2_type === "file") {
                        this.def2Files = [];
                        this.def2Files.push({
                            name: res.data.join(","),
                            url: res.data.join(",")
                        })
                    }
                }
            },
            def3HandleSuccess(res, uploadFile) {
                if (!res.code) {
                    ELEMENT.Message.error(res.data);
                } else {
                    if (this.def3_type === "img") {
                        this.def3Imgs = []
                        this.def3Imgs.push({
                            name: res.data.join(","),
                            url: res.data.join(",")
                        })
                    } else if (this.def3_type === "file") {
                        this.def3Files = []
                        this.def3Files.push({
                            name: res.data.join(","),
                            url: res.data.join(",")
                        })
                    }
                }
            },
            defTypeChangeFunc(oldVal, newVal, id) {
                console.log(oldVal, newVal);
                // 文本转图片
                if ((oldVal === 'textarea' || oldVal === 'editor') && newVal === "img") {
                    if(!this["def" + id]){
                        return;
                    }
                    this["def" + id +"Imgs"] = [{
                        name: this["def" + id],
                        url: this["def" + id],
                    }]
                }
                // 文本转附件
                if ((oldVal === 'textarea' || oldVal === 'editor') && newVal === "file") {
                    if(!this["def" + id]){
                        return;
                    }
                    // 文字转图片或者附件
                    console.log(this["def" + id +"Files"]);
                    this["def" + id +"Files"] = [{
                        name: this["def" + id],
                        url: this["def" + id],
                    }]
                }
                // 图片转附件
                if (oldVal === 'img' && newVal === "file") {
                    this["def" + id +"Files"] = this["def" + id +"Imgs"]
                }
                // 附件转图片
                if (oldVal === 'file' && newVal === "img") {
                    this["def" + id +"Imgs"] = this["def" + id +"Files"]
                }
                // 如果是转到编辑器
                if (newVal === 'editor') {
                    this["editor" + id] = UE.getEditor('editor_' + id, {
                        maximumWords: 10000
                    });
                } else {
                    this["editor" + id] = null;
                }
            }
        },
        watch: {
            def1(data) {
                this.$refs.def1.value = data;
            },
            def2(data) {
                this.$refs.def2.value = data;
            },
            def3(data) {
                this.$refs.def3.value = data;
            },
            def1Imgs(data) {
                const result = [];
                for (const item of data) {
                    result.push(item.url);
                }
                this.def1 = result.join(",")
            },
            def2Imgs(data) {
                const result = [];
                for (const item of data) {
                    result.push(item.url);
                }
                this.def2 = result.join(",")
            },
            def3Imgs(data) {
                const result = [];
                for (const item of data) {
                    result.push(item.url);
                }
                this.def3 = result.join(",")
            },
            def1Files(data) {
                const result = [];
                for (const item of data) {
                    result.push(item.url);
                }
                this.def1 = result.join(",")
            },
            def2Files(data) {
                const result = [];
                for (const item of data) {
                    result.push(item.url);
                }
                this.def2 = result.join(",")
            },
            def3Files(data) {
                const result = [];
                for (const item of data) {
                    result.push(item.url);
                }
                this.def3 = result.join(",")
            },
            def1_type(oldVal, newVal) {
                this.defTypeChangeFunc(newVal, oldVal, 1)
            },
            def2_type(oldVal, newVal) {
                this.defTypeChangeFunc(newVal, oldVal, 2)
            },
            def3_type(oldVal, newVal) {
                this.defTypeChangeFunc(newVal, oldVal, 3)
            }
        }
    })
</script>
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
<?php return array (
  0 => 'F:/phpEnv/www/www.text.com/apps/admin/view/default/common/head.html',
  1 => 'F:/phpEnv/www/www.text.com/apps/admin/view/default/common/ueditor.html',
  2 => 'F:/phpEnv/www/www.text.com/apps/admin/view/default/common/foot.html',
); ?>