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

<div class="layui-body">
	<?php if ($this->getVar('list')) {?>
	<div class="layui-tab layui-tab-brief" lay-filter="tab">
	  <ul class="layui-tab-title">
	    <li class="layui-this" lay-id="t1"><?php echo $this->getVar('model_name');?>内容</li>
	  </ul>
	  <div class="layui-tab-content">
	  	   <div class="layui-tab-item layui-show">
	  	   		<form action="<?php echo \core\basic\Url::get('/admin/Single/index/mcode/'.get('mcode').'');?>" method="get" class="layui-form">
		  	   		<div class="layui-form-item nospace">
		  	   			<div class="layui-input-inline">
		  	   				<?php echo $this->getVar('pathinfo');?>
					       <select name="field" class="form-control input-sm" style="width:auto;">
					       		<option value="b.name" <?php if (get('field')=='b.name') {?>selected="selected" <?php } ?>>栏目名称</option>
                                <option value="a.title" <?php if (get('field')=='a.title') {?>selected="selected" <?php } ?> >文章标题</option>
                                <option value="a.content" <?php if (get('field')=='a.content') {?>selected="selected" <?php } ?>>文章内容</option>
                        	</select>
					    </div>
	                     <div class="layui-input-inline">
	                     	<input type="text" name="keyword"  value="<?php echo get('keyword');?>"  placeholder="请输入搜索关键字" class="layui-input">
	                     </div>
	                     <div class="layui-input-inline">
	                     	<button class="layui-btn" lay-submit>搜索</button>
	                     	<a class="layui-btn layui-btn-primary"  href="<?php echo \core\basic\Url::get('/admin/Single/index/mcode/'.get('mcode').'');?>">清除搜索</a>
	                     </div>
	                </div>
                </form>

	            <table class="layui-table">
	            	<thead>
	                    <tr>
	                    	<th>ID</th>
	                        <th>栏目</th>
	                        <th>标题</th>
	                        <th>缩略图</th>
	                        <th>时间</th>
	                        <th>状态</th>
	                        <th>访问量</th>
	                        <th>操作</th>
	                    </tr>
	                </thead>
	                <tbody>
	                    <?php $num = 0;foreach ($this->getVar('contents') as $key => $value) { $num++;?>
	                    <tr>
	                    	<td><?php echo $value->id; ?></td>
	                        <td title="<?php echo $value->scode; ?>"><?php echo substr_both($value->sortname,0,15);?></td>
	                        <td title="<?php echo $value->title; ?>">
		                        <?php echo substr_both($value->title,0,15);?>
		                        <?php if ($value->ico) {?>
		                        	<span class="layui-badge layui-bg-orange">缩</span>
		                        <?php } ?>
		                        <?php if ($value->pics) {?>
		                        	<span class="layui-badge">图</span>
		                        <?php } ?>
		                        <?php if ($value->outlink) {?>
	                            	<span class="layui-badge layui-bg-black">链</span>
	                            <?php } ?>
	                        </td>
	                        <td title="<?php echo $value->title; ?>">
	                        	<img src="<?php echo $value->ico; ?>" alt="" style="max-height: 60px;max-width: 60px">
	                        </td>
	                        <td><?php echo $value->date; ?></td>
	                        <td>
	                        <?php if ($value->status) {?>
		                        <a href="<?php echo \core\basic\Url::get('/admin/'.C.'/mod/id/'.$value->id.'/field/status/value/0');?>" class="switch"><i class='fa fa-toggle-on' title="点击关闭"></i></a>
		                        <?php } else { ?>
		                        <a href="<?php echo \core\basic\Url::get('/admin/'.C.'/mod/id/'.$value->id.'/field/status/value/1');?>" class="switch"><i class='fa fa-toggle-off' title="点击开启"></i></a>
		                    <?php } ?>
		                    </td>
		                    <td><?php echo $value->visits; ?></td>
	                        <td>
	                        	<?php if (!$value->outlink) {?>
		                        	<?php  
			                        	$Parser=new app\home\controller\ParserController();
			                        	$link=$Parser->parserLink(1,$value->urlname,'about',$value->scode,$value->filename,'','');
			                       	?>
		                        	<a href="<?php  echo $link?>" class="layui-btn layui-btn-xs layui-btn-primary"  target="_blank">查看</a>
	                        	<?php } ?>
	                        	
	                            <?php if (check_level('mod')) {?>
	                            	<a href="<?php echo \core\basic\Url::get('/admin/Single/mod/mcode/'.$value->mcode.'/id/'.$value->id.'');?><?php echo $this->getVar('btnqs');?>" class="layui-btn layui-btn-xs" >修改</a>
	                            	<?php if ($this->getVar('baidu_zz_token') && !$value->outlink) {?>
	                            		<a href="<?php echo \core\basic\Url::get('/admin/'.C.'/mod/baiduzz/'.$value->id.'');?>" class="layui-btn layui-btn-xs layui-btn-primary" >百度普通推送</a>
	                            	<?php } ?>
	                            	<?php if ($this->getVar('baidu_ks_token') && !$value->outlink) {?>
	                            		<a href="<?php echo \core\basic\Url::get('/admin/'.C.'/mod/baiduks/'.$value->id.'');?>" class="layui-btn layui-btn-xs layui-btn-primary" >百度快速推送</a>
	                            	<?php } ?>
	                            <?php } ?>
	                        </td>
	                    </tr>
	                    <?php } ?>
	                </tbody>
	            </table>
	  	   </div>
	  </div>
	 </div>
	<?php } ?> 
	
	<?php if ($this->getVar('mod')) {?>
	
	<div class="layui-tab layui-tab-brief" lay-filter="tab">
	  <ul class="layui-tab-title">
	    <li class="layui-this">单页修改</li>
	  </ul>
	  <div class="layui-tab-content">
	  	<div class="layui-tab-item layui-show">
	  		<form action="<?php echo \core\basic\Url::get('/admin/Single/mod/id/'.get('id').'');?><?php echo $this->getVar('backurl');?>" method="post" class="layui-form" id="edit" onsubmit="return modpicsname();">
	  			<input type="hidden" name="formcheck" value="<?php echo $this->getVar('formcheck');?>" > 
	  			<div class="layui-tab">
					  <ul class="layui-tab-title">
					    <li class="layui-this">基本内容</li>
					    <li>高级内容</li>
					  </ul>
					  <div class="layui-tab-content">
					    <div class="layui-tab-item layui-show">

			                <div class="layui-form-item">
			                     <label class="layui-form-label">内容标题   <span class="layui-text-red">*</span></label>
			                     <div class="layui-input-block">
			                     	<input type="text" name="title" required lay-verify="required" value="<?php echo @$this->getVar('content')->title;?>" placeholder="请输入内容标题" class="layui-input">
			                     </div>
			                </div>
			                
			                 <?php $num = 0;foreach ($this->getVar('extfield') as $key => $value) { $num++;?>
			                	<?php if ($value->type==1) {?> <!-- 单行文本 -->
			                	<div class="layui-form-item">
			                		<label class="layui-form-label"><?php echo $value->description; ?></label>
			                		<div class="layui-input-block">
				                    	<input type="text" name="<?php echo $value->name; ?>" value="<?php echo @$this->getVar('content')->{$value->name};?>"  placeholder="请输入<?php echo $value->description; ?>"  class="layui-input">
				                	</div>
				                </div>
			                	<?php } ?>
			                	
			                	<?php if ($value->type==2) {?><!-- 多行文本 -->
			                	<div class="layui-form-item">
			                		<label class="layui-form-label"><?php echo $value->description; ?></label>
			                		<div class="layui-input-block">
				                		<textarea name="<?php echo $value->name; ?>" class="layui-textarea" placeholder="请输入<?php echo $value->description; ?>"><?php  $name=$value->name;echo str_replace('<br>', "\r\n",$this->vars['content']->$name);?></textarea>
				                	</div>
				                </div>
			                	<?php } ?>
			                	
			                    <?php if ($value->type==3) {?><!-- 单选 -->
			                	<div class="layui-form-item">
			                		<label class="layui-form-label"><?php echo $value->description; ?></label>
			                		<div class="layui-input-block">
				                		<div>
	            						     <?php  
				                				$radios=explode(',',$value->value);
				                				$name=$value->name;
				                				foreach ($radios as $value2) {
				                					if($this->vars['content']->$name==$value2){
	                									echo '<input type="radio" name="'.$value->name.'" value="'.$value2.'" title="'.$value2.'" checked>';
	                								}else{
	                									echo '<input type="radio" name="'.$value->name.'" value="'.$value2.'" title="'.$value2.'">';
	                								}
	            								}
	            						     ?>
					                    </div>
				                	</div>
				                </div>
			                	<?php } ?>
			                	
			                    <?php if ($value->type==4) {?><!-- 多选 -->
			                	<div class="layui-form-item">
			                		<label class="layui-form-label"><?php echo $value->description; ?></label>
			                		<div class="layui-input-block">
				                		<div>
	            						     <?php  
				                				$checkboxs=explode(',',$value->value);
				                				$name=$value->name;
				                				echo '<input name="'.$value->name.'" type="hidden">';//占位清空
				                				$values=explode(',',$this->vars['content']->$name);
				                				foreach ($checkboxs as $value2) {
				                					if(in_array($value2,$values)){
	            										echo '<input type="checkbox" name="'.$value->name.'[]" value="'.$value2.'" title="'.$value2.'" checked>';
	            									}else{
	            										echo '<input type="checkbox" name="'.$value->name.'[]" value="'.$value2.'" title="'.$value2.'">';
	            									}
	            								}
	            						     ?>
					                    </div>
				                	</div>
				                </div>
			                	<?php } ?>
			                	
			                	<?php if ($value->type==5) {?><!-- 图片 -->
			                	<div class="layui-form-item">
			                		<label class="layui-form-label"><?php echo $value->description; ?></label>
			                		<div class="layui-input-inline">
				                     	<input type="text" name="<?php echo $value->name; ?>" id="<?php echo $value->name; ?>" value="<?php echo @$this->getVar('content')->{$value->name};?>" placeholder="请上传<?php echo $value->description; ?>"  class="layui-input">
				                     </div>
				                     <button type="button" class="layui-btn upload watermark" data-des="<?php echo $value->name; ?>">
									 	 <i class="layui-icon">&#xe67c;</i>上传图片
									 </button>
 									<a class="layui-btn layui-btn-warm" onclick="GetPictureFolder(1,'<?php echo $value->name; ?>');">图库</a>
									 <?php  $name=$value->name; ?>
									 <div id="<?php echo $value->name; ?>_box" class="pic"><dl><dt><?php if ($this->getVar('content')->$name) {?><img src='<?php echo SITE_DIR;?><?php echo @$this->getVar('content')->{$value->name};?>' data-url="<?php echo @$this->getVar('content')->{$value->name};?>"></dt><dd>删除</dd></dl><?php } ?></div>
				                </div>
			                	<?php } ?>
			                	
			                	<?php if ($value->type==6) {?><!-- 文件 -->
			                	<div class="layui-form-item">
			                		<label class="layui-form-label"><?php echo $value->description; ?></label>
			                		<div class="layui-input-inline">
				                     	<input type="text" name="<?php echo $value->name; ?>" id="<?php echo $value->name; ?>" value="<?php echo @$this->getVar('content')->{$value->name};?>" placeholder="请上传<?php echo $value->description; ?>"  class="layui-input">
				                     </div>
				                     <button type="button" class="layui-btn file" data-des="<?php echo $value->name; ?>">
									 	 <i class="layui-icon">&#xe67c;</i>上传文件
									 </button>
				                </div>
			                	<?php } ?>
			                	
			                	<?php if ($value->type==7) {?><!-- 日期 -->
				                <div class="layui-form-item">
				                     <label class="layui-form-label"><?php echo $value->description; ?></label>
				                     <div class="layui-input-block">
				                     	<input type="text" name="<?php echo $value->name; ?>" value="<?php echo @$this->getVar('content')->{$value->name};?>" readonly placeholder="请选择<?php echo $value->description; ?>"  class="layui-input datetime">
				                     </div>
				                </div>
			                	<?php } ?>
			                	
			                	<?php if ($value->type==8) {?><!-- 编辑器 -->
			                	<div class="layui-form-item">
			                		<label class="layui-form-label"><?php echo $value->description; ?></label>
			                		<div class="layui-input-block">
			                			<?php  
			                				$name=@$value->name;
			                			?>
				                		<script type="text/plain" id="editor_<?php echo $value->name; ?>" name="<?php echo $value->name; ?>" style="width:100%;height:240px;"><?php echo decode_string($this->getVar('content')->$name);?></script>
				                		<script>
											//初始化编辑器
											$(document).ready(function (e) {
												var ue = UE.getEditor('editor_<?php echo $value->name; ?>',{
													maximumWords:10000 
												});
											})
										</script>
				                	</div>
				                </div>
			                	<?php } ?>
			                	
			                	<?php if ($value->type==9) {?><!-- 下拉 -->
			                	<div class="layui-form-item">
			                		<label class="layui-form-label"><?php echo $value->description; ?></label>
			                		<div class="layui-input-block">
			                			<select name="<?php echo $value->name; ?>">
			                				<?php  
				                				$selects=explode(',',$value->value);
				                				$name=$value->name;
				                				foreach ($selects as $value2) {
				                					if($this->vars['content']->$name==$value2){
				                						echo '<option value="'.$value2.'" selected>'.$value2.'</option>';
	                								}else{
	                									echo '<option value="'.$value2.'">'.$value2.'</option>';
	                								}
	            								}
	            						    ?>
			                			</select>
				                	</div>
				                 </div>
			                	 <?php } ?>
			                	 <?php if ($value->type==10) {?><!-- 轮播 -->
			                	 <div class="layui-form-item ext_pics">
				                     <label class="layui-form-label"><?php echo $value->description; ?></label>
				                     <div class="layui-input-inline">
				                     	<input type="text" name="<?php echo $value->name; ?>" id="<?php echo $value->name; ?>" placeholder="请上传<?php echo $value->description; ?>"  class="layui-input" value="<?php echo @$this->getVar('content')->{$value->name};?>">
				                     </div>
				                     <button type="button" class="layui-btn uploads watermark" data-des="<?php echo $value->name; ?>">
									 	 <i class="layui-icon">&#xe67c;</i>上传多图
									 </button>
									<a class="layui-btn layui-btn-warm" onclick="GetPictureFolder(100,'<?php echo $value->name; ?>');">图库</a>
									 <div id="<?php echo $value->name; ?>_box" class="pic addedit">
									 	<dl></dl> <!-- 规避空内容拖动bug -->
									 	<?php  
									 		$name=$value->name;
										    if($this->getVar('content')->$name){
			                					$pics=explode(',',$this->getVar('content')->$name);
			                				}else{
			                					$pics = array();
			                				}
			                				foreach ($pics as $value1) {
			                					echo "<dl><dt><img src='".SITE_DIR.$value1."' data-url='".$value1."'><br/></dt><dd>删除</dd></dl></dl>";
		          							}
		         						 ?> 
									 </div>
				                </div>
				                <script type="text/javascript" src="<?php echo APP_THEME_DIR;?>/js/jquery.dragsort-0.5.2.min.js"></script>
								<script type="text/javascript">
								$("#<?php echo $value->name; ?>_box").dragsort({
									dragSelector: "dl",
									dragSelectorExclude: "input,textarea,dd",
									dragBetween: false,
									dragEnd: saveOrder,
									placeHolderTemplate: "<dl class='placeHolder'><dt></dt></dl>"
								});

								function saveOrder() {
									var data = $("#<?php echo $value->name; ?>_box dl dt img").map(function() {
										return $(this).data("url");
									}).get();
									$("input[name=<?php echo $value->name; ?>]").val(data.join(","));
								};
								</script>
			                	<?php } ?>
			                	<?php if ($value->type==11) {?><!-- 单选关联 -->
			                	<div class="layui-form-item">
			                		<label class="layui-form-label"><?php echo $value->description; ?></label>
			                		<div class="layui-input-block">
				                		<div>
	            						     <?php  
	            						     	$rcode = $value->value;
	            						     	$mcode = get_mcode($rcode);
	            						     	$relation = get_list($mcode,$rcode);
				                				$name=$value->name;
				                				foreach ($relation as $value2) {
				                					if($this->vars['content']->$name==$value2->id){
	                									echo '<input type="radio" name="'.$value->name.'" value="'.$value2->id.'" title="'.$value2->title.'" checked>';
	                								}else{
	                									echo '<input type="radio" name="'.$value->name.'" value="'.$value2->id.'" title="'.$value2->title.'">';
	                								}
	            								}
	            						     ?>
					                    </div>
				                	</div>
				                </div>
			                	<?php } ?>
			                	<?php if ($value->type==12) {?><!-- 多选关联 -->
			                	<div class="layui-form-item">
			                		<label class="layui-form-label"><?php echo $value->description; ?></label>
			                		<div class="layui-input-block">
				                		<div>
				                			<div id="<?php echo $value->name; ?>" class="xm-select-demo"></div>
				                			<input type="hidden" id="<?php echo $value->name; ?>-value" value="<?php echo @$this->getVar('content')->{$value->name};?>" name="<?php echo $value->name; ?>">
	            						     <?php  
	            						     	$rcode = $value->value;
	            						     	$mcode = get_mcode($rcode);
	            						     	$relation = get_list($mcode,$rcode);
				                				$name=$value->name;
	            						     ?>
	            						     <script>
	            						     	var <?php echo $value->name; ?> = xmSelect.render({
										        el: '#<?php echo $value->name; ?>',
										        toolbar: {
                                            		show: true,
                                            	},
                                            	autoRow: true,
										        filterable: true,
										        on: function(data){
										            var arr = data.arr;
										            var valuestr=[];
										            for(var i in arr){
										                valuestr.push(arr[i]['value']);
										            }
										            document.getElementById('<?php echo $value->name; ?>-value').value = valuestr.join(',');
										        },
										        data: [
										        	<?php  
										        	foreach ($relation as $value2) {
										        		$temp = explode(',',$this->vars['content']->$name);
										        		if(in_array($value2->id,$temp)){
										        			echo'{ name: "'.$value2->title.'", value: '.$value2->id.', selected: true},';
										        		}else{
										        			echo'{ name: "'.$value2->title.'", value: '.$value2->id.' },';
										        		}
										        	}
										        	?>
										        	]
										    	})
	            						     </script>	
	            						     
					                    </div>
				                	</div>
				                </div>
			                	<?php } ?>
			                	<?php if ($value->type==13) {?>
			                	<table id="tab11" class="layui-hide">
			                		<tbody>
					                	<tr>
					                		<td>
					                			<input type="text" value="" class="layui-input" />
					                		</td>
					                		<td>
					                			<input type="text" value="" class="layui-input"/>
					                		</td>
					                		<td>
					                			<a class="layui-btn layui-btn-sm layui-btn-danger" onClick="deltr(this)">删除属性</a>
					                		</td>
					                	</tr>
					                </tbody>
			                	</table>
			                	<input type="hidden" name="<?php echo $value->name; ?>" id="keyvalue" value="<?php echo @$this->getVar('content')->{$value->name};?>">
			                	<div class="layui-form-item">
			                		<label class="layui-form-label"><?php echo $value->description; ?></label>
			                		<div class="layui-input-block">
			                			<table class="layui-table" id="dynamicTable">
			                				<thead>
							                    <tr>
							                        <th>属性名</th>
							                        <th>属性值</th>
							                        <th>
							                        	<a class="layui-btn layui-btn-sm" id="btn_addtr">增加属性</a>
							                        </th>
							                    </tr>
							                </thead>
							                <tbody>
							                	<?php  
							                	$temp = $value->name;
							                	if($this->getVar('content')->$temp){
				                					$keyValue=explode(',',$this->getVar('content')->$temp);
				                				}else{
				                					$keyValue = array();
				                				}
				                				foreach ($keyValue as $value) {
													$d = explode('|',$value);
								                	echo '<tr><td><input type="text" value="'.$d[0].'" class="layui-input" /></td><td><input type="text" value="'.$d[1].'" class="layui-input"/></td><td><a class="layui-btn layui-btn-sm layui-btn-danger" onClick="deltr(this)">删除属性</a></td></tr>';
							                	}
				                				
							                	?>
							                </tbody>
			                			</table>
			                		</div>
			                	</div>
			                	<?php } ?>
			                <?php } ?>
							<div class="layui-form-item">
								<label class="layui-form-label">副标题</label>
								<div class="layui-input-block">
									<input type="text" name="subtitle" value="<?php echo @$this->getVar('content')->subtitle;?>" placeholder="请输入副标题" class="layui-input">
								</div>
							</div>
			                <div class="layui-form-item">
								<label class="layui-form-label">缩略图</label>
								<div class="layui-input-inline">
									<input type="text" name="ico" id="ico" value="<?php echo @$this->getVar('content')->ico;?>" placeholder="请上传缩略图"  class="layui-input">
								</div>
								<button type="button" class="layui-btn upload watermark" data-des="ico">
									 <i class="layui-icon">&#xe67c;</i>上传图片
								</button>
							   <a class="layui-btn layui-btn-warm" onclick="GetPictureFolder(1,'ico');">图库</a>
								<div id="ico_box" class="pic addedit"><?php if ($this->getVar('content')->ico) {?><dl><dt><img src="<?php echo SITE_DIR;?><?php echo @$this->getVar('content')->ico;?>" data-url="<?php echo @$this->getVar('content')->ico;?>"></dt><dd>删除</dd></dl><?php } ?></div>
						   </div>
						   
						   <div class="layui-form-item">
								<label class="layui-form-label">轮播多图</label>
								<div class="layui-input-inline">
									<input type="text" name="pics" id="pics" value="<?php echo @$this->getVar('content')->pics;?>" placeholder="请上传轮播多图"  class="layui-input">
								</div>
								<button type="button" class="layui-btn uploads watermark" data-des="pics">
									 <i class="layui-icon">&#xe67c;</i>上传多图
								</button>
									<a class="layui-btn layui-btn-warm" onclick="GetPictureFolder(100,'pics');">图库</a>
								<div id="pics_box" class="pic addedit">
									<dl></dl> <!-- 规避空内容拖动bug -->
									<?php  
									   if($this->getVar('content')->pics){
										   $pics=explode(',',$this->getVar('content')->pics);
									   }else{
										   $pics = array();
									   }
									   if($this->getVar('content')->picsname){
										   $picsname=explode(',',$this->getVar('content')->picsname);
									   }else{
										   $picsname = array();
									   }
									   foreach ($pics as $key=>$value) {
										   //需要留一个空，不然被解析为标签了
										   echo "<dl><dt><img src='".SITE_DIR.$value."' data-url='".$value."'><br/><input type='text' value='".$picsname[$key ]."' /></dt><dd>删除</dd></dl>";
									   }
									 ?>
								</div>
								<input type="hidden" name="picsname" value="<?php echo @$this->getVar('content')->picsname;?>" id="picsname">
						   </div>
			                <div class="layui-form-item">
			                     <label class="layui-form-label">内容</label>
			                     <div class="layui-input-block">
			                     	<script type="text/plain" id="editor" name="content" style="width:100%;height:240px;"><?php echo decode_string($this->getVar('content')->content);?></script>
			                     </div>
			                </div>
			                
			                <div class="layui-form-item">
			                     <label class="layui-form-label">tags</label>
			                     <div class="layui-input-block">
			                     	<input type="text" name="tags" placeholder="请输入文章tag，英文逗号隔开" value="<?php echo @$this->getVar('content')->tags;?>" class="layui-input">
			                     </div>
			                </div>
			                
			                <div class="layui-form-item">
			                     <label class="layui-form-label">作者</label>
			                     <div class="layui-input-block">
			                     	<input type="text" name="author" placeholder="请输入作者" value="<?php echo @$this->getVar('content')->author;?>" class="layui-input">
			                     </div>
			                </div>
			                
			                <div class="layui-form-item">
			                     <label class="layui-form-label">来源</label>
			                     <div class="layui-input-block">
			                     	<input type="text" name="source" placeholder="请输入来源" value="<?php echo @$this->getVar('content')->source;?>" class="layui-input">
			                     </div>
			                </div>
			                
			                
					    </div>
					    
					    <div class="layui-tab-item ">
							<div class="layui-form-item">
								<label class="layui-form-label">摘要</label>
								<div class="layui-input-block">
									<textarea name="note" placeholder="请输入摘要" class="layui-textarea"><?php echo @$this->getVar('content')->note;?></textarea>
								</div>
						   </div>
					   		 <div class="layui-form-item">
			                     <label class="layui-form-label">标题颜色</label>
			                     <div class="layui-input-inline">
			                     	<input type="text" name="titlecolor" value="<?php echo @$this->getVar('content')->titlecolor;?>" placeholder="请选择标题颜色"  class="layui-input jscolor {hash:true}">
			                     </div>
			                 </div>
			                 
			                 

			                 <div class="layui-form-item">
			                     <label class="layui-form-label">时间</label>
			                     <div class="layui-input-inline">
			                     	<input type="text" name="date" value="<?php echo @$this->getVar('content')->date;?>" readonly placeholder="请选择发布时间"  class="layui-input datetime">
			                     </div>
			                     <div class="layui-form-mid layui-word-aux">温馨提示：单页不支持定时发布！</div>
			                </div>
			                
			                <div class="layui-form-item">
		                		<label class="layui-form-label">附件</label>
		                		<div class="layui-input-inline">
			                     	<input type="text" name="enclosure" id="enclosure" value="<?php echo @$this->getVar('content')->enclosure;?>" placeholder="请上传附件"  class="layui-input">
			                     </div>
			                     <button type="button" class="layui-btn file" data-des="enclosure">
								 	 <i class="layui-icon">&#xe67c;</i>上传附件
								 </button>
			                </div>
			                <div class="layui-form-item">
			                     <label class="layui-form-label">点击量</label>
			                     <div class="layui-input-block">
			                     	<input type="text" name="visits" value="<?php echo @$this->getVar('content')->visits;?>" placeholder="" class="layui-input">
			                     </div>
			                 </div>
			                
			                <div class="layui-form-item">
			                     <label class="layui-form-label">SEO关键字</label>
			                     <div class="layui-input-block">
			                     	<input type="text" name="keywords" value="<?php echo @$this->getVar('content')->keywords;?>"  placeholder="请输入详情页SEO关键字" class="layui-input">
			                     </div>
			                </div>
			                
			                <div class="layui-form-item">
			                     <label class="layui-form-label">SEO描述</label>
			                     <div class="layui-input-block">
			                     	<textarea name="description" placeholder="请输入详情页SEO描述" class="layui-textarea"><?php echo @$this->getVar('content')->description;?></textarea>
			                     </div>
			                </div>
			                
			                <div class="layui-form-item">
			                     <label class="layui-form-label">状态</label>
			                     <div class="layui-input-block">
			                     	<input type="radio" name="status" value="1" title="显示" <?php if ($this->getVar('content')->status==1) {?> checked="checked"<?php } ?>>
									<input type="radio" name="status" value="0" title="隐藏" <?php if ($this->getVar('content')->status==0) {?> checked="checked"<?php } ?>>
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

<style>.placeHolder {border:dashed 2px gray; }</style>
<script type="text/javascript" src="<?php echo APP_THEME_DIR;?>/js/jquery.dragsort-0.5.2.min.js"></script>
<script type="text/javascript">
$("#pics_box").dragsort({
	dragSelector: "dl",
	dragSelectorExclude: "input,textarea,dd",
	dragBetween: false,
	dragEnd: saveOrder,
	placeHolderTemplate: "<dl class='placeHolder'><dt></dt></dl>"
});

function saveOrder() {
	var data = $("#pics_box dl dt img").map(function() {
		return $(this).data("url");
	}).get();
	var dataname = $("#pics_box dl dt input").map(function() {
		return $(this).val();
	}).get();
	$("input[name=pics]").val(data.join(","));
	$("input[name=picsname]").val(dataname.join(","));
};

function modpicsname(){
	traverseTable();
	var dataname = $("#pics_box dl dt input").map(function() {
		return $(this).val();
	}).get();
	var datanameLenght = dataname.length;
	var picsLenght = $("input[name=pics]").val().split(',').length;
	if(datanameLenght == 0 || picsLenght != datanameLenght){
		var reg = /[\u4E00-\u9FA5-_\w]+\.\w{2,4}/g;
		dataname = $("input[name=pics]").val().match(reg);
	}
	$("input[name=picsname]").val(dataname.join(","));
	return true;
}

</script>
<script type="text/javascript" src="<?php echo APP_THEME_DIR;?>/js/jscolor.js"></script>
<script type="text/javascript">
    $(function() {
        var show_count = 20; //要显示的条数
        var count = 1; //递增的开始值，这里是你的ID
        $("#btn_addtr").click(function() {
            var length = $("#dynamicTable tbody tr").length;
            if (length < show_count) //点击时候，如果当前的数字小于递增结束的条件
            {
                $("#tab11 tbody tr").clone().appendTo("#dynamicTable tbody"); //在表格后面添加一行
            }
        });
    });

    function deltr(opp) {
        var length = $("#dynamicTable tbody tr").length;
        if (length <= 1) {
        	layer.msg("至少保留一行", {icon: 5});
            
        } else {
            $(opp).parent().parent().remove(); //移除当前行
        }
    }
    function traverseTable(){
    	var arr=[];
    	$("#dynamicTable tbody tr").each(function(index,ele){
    		var str1 = $(ele).find('td').eq(0).find('input').val();
    		var str2 = $(ele).find('td').eq(1).find('input').val();
    		var str = `${str1}|${str2}`;
    		arr.push(str);
    	})
    	$('#keyvalue').val(arr);
    }
</script>
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