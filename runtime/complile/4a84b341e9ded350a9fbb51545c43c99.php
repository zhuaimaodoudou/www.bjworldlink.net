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
			<li class="layui-this" lay-id="t1">留言列表</li>
		</ul>
		<div class="layui-tab-content">
			<div class="layui-tab-item layui-show">
				<form action="<?php echo \core\basic\Url::get('/admin/Message/index');?>" method="get" class="layui-form">
					<div class="layui-form-item nospace">
						<div class="layui-input-inline">
							<?php echo $this->getVar('pathinfo');?>
							<select name="field">
								<option value="">全部</option>
								<?php $num = 0;foreach ($this->getVar('fields') as $key => $value) { $num++;?>
								<option value="<?php echo $value->name; ?>"><?php echo $value->description; ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="layui-input-inline">
							<input type="text" name="keyword" value="<?php echo get('keyword');?>" placeholder="请输入搜索关键字"
								class="layui-input">
						</div>
						<div class="layui-input-inline">
							<button class="layui-btn" lay-submit>搜索</button>
							<a class="layui-btn layui-btn-primary" href="<?php echo \core\basic\Url::get('/admin/Message/index');?>">清除搜索</a>
						</div>
					</div>
				</form>

				<form action="<?php echo \core\basic\Url::get('/admin/Message/index');?>" method="post" id="contentForm" name="contentForm"
					class="layui-form" onkeydown="if(event.keyCode==13) return false;">
					<input type="hidden" name="formcheck" value="<?php echo $this->getVar('formcheck');?>">
					<table class="layui-table">
						<thead>
							<tr>
								<th style="width:20px"><input type="checkbox" class="checkbox" lay-ignore id="checkall"
										title="全选"></th>
								<th style="width:30px">序号</th>
								<?php $num = 0;foreach ($this->getVar('fields') as $key => $value) { $num++;?>
								<?php if ($value->status) {?>
								<th><?php echo $value->description; ?></th>
								<?php } ?>
								<?php } ?>
								<th>留言时间</th>
								<th>审核</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
							<?php $num = 0;foreach ($this->getVar('messages') as $key => $value) { $num++;?>
							<tr>
								<td>
									<input type="checkbox" class="checkbox checkitem" lay-ignore name="list[]"
										value="<?php echo $value->id; ?>">
									<input type="hidden" name="listall[]" value="<?php echo $value->id; ?>">
								</td>
								<td><?php echo @(PAGE-1)*PAGESIZE+$num; ?></td>
								<?php $num2 = 0;foreach ($this->getVar('fields') as $key2 => $value2) { $num2++;?>
								<?php if ($value2->status) {?>
								<?php   $type=$value2->type ?>
								<?php   $field=$value2->name ?>
								<?php if ($type == 'img' && $value->$field!='') {?>
								<td>
									<a href="<?php echo $value->$field; ?>" target="_blank">
										<img src="<?php echo $value->$field; ?>" alt="">
									</a>
								</td>
								<?php } ?>
								<?php if ($type == 'file' && $value->$field!='') {?>
								<td>
									<a href="<?php echo $value->$field; ?>" target="_blank">查看附件</a>
								</td>
								<?php } ?>

								<?php if ($type == 'text' && $value->$field!='') {?>
								<td><?php echo $value->$field; ?></td>
								<?php } ?>
								<?php } ?>
								<?php } ?>
								<td>
									<?php echo $value->create_time; ?>
								</td>
								<td>
									<?php if ($value->status) {?>
									<a href="<?php echo \core\basic\Url::get('/admin/'.C.'/mod/id/'.$value->id.'/field/status/value/0');?>"><i
											class='fa fa-toggle-on' title="点击前端隐藏"
											style="vertical-align:middle"></i></a>
									<?php } else { ?>
									<a href="<?php echo \core\basic\Url::get('/admin/'.C.'/mod/id/'.$value->id.'/field/status/value/1');?>"><i
											class='fa fa-toggle-off' title="点击前端显示"
											style="vertical-align:middle"></i></a>
									<?php } ?>
								</td>
								<td>
									<?php echo get_btn_mod($value->id,'id','详情&回复');?>
									<?php echo get_btn_del($value->id);?>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>

					<div class="layui-btn-group">
						<?php if (check_level('del')) {?>
						<button type="submit" name="submit" onclick="return setDelAction();"
							class="layui-btn layui-btn-sm">批量删除</button>
						<?php } ?>
						<?php if (session('ucode')==10001 && $this->getVar('messages')) {?>
						<a href="<?php echo \core\basic\Url::get('/admin/Message/clear');?>" onclick='return confirm("您确定要清空么？")'
							class="layui-btn layui-btn-sm">清空全部记录</a>
						<?php } ?>
						<?php if ($this->getVar('messages')) {?>
						<a href="<?php echo \core\basic\Url::get('/admin/Message/index/export/1');?>" class="layui-btn layui-btn-sm">导出全部记录</a>
						<?php } ?>
					</div>
					<script>
						function setDelAction() {
							document.contentForm.action = "<?php echo \core\basic\Url::get('/admin/Message/del');?>";
							return confirm("您确定要删除选中的内容么？");
						}
					</script>

					<div class="page">
						<?php echo $this->getVar('pagebar');?>
					</div>
				</form>
			</div>
		</div>
	</div>
	<?php } ?>
	<?php if ($this->getVar('mod')) {?>
	<div class="layui-tab layui-tab-brief" lay-filter="tab">
		<ul class="layui-tab-title">
			<li class="layui-this">留言详情</li>
		</ul>
		<div class="layui-tab-content">
			<div class="layui-tab-item layui-show">
				<form action="<?php echo \core\basic\Url::get('/admin/Message/mod/id/'.get('id').'');?><?php echo $this->getVar('backurl');?>" method="post" class="layui-form">
					<input type="hidden" name="formcheck" value="<?php echo $this->getVar('formcheck');?>">
					<table class="layui-table table-two">
						<thead>
						</thead>
						<tbody>
							<?php $num = 0;foreach ($this->getVar('fields') as $key => $value) { $num++;?>
							<tr>
								<th><?php echo $value->description; ?></th>
								<?php   $field=$value->name ?>
								<?php   $type=$value->type ?>
								<?php if ($type == 'file' && $this->getVar('message')->$field!='') {?>
								<td><a href="<?php echo @$this->getVar('message')->$field;?>" target="_blank">点击查看</a></td>
								<?php } ?>
								<?php if ($type == 'img' && $this->getVar('message')->$field!='') {?>
								<td><a href="<?php echo @$this->getVar('message')->$field;?>">
									<img src="<?php echo @$this->getVar('message')->$field;?>" target="_blank" alt="">
								</a></td>
								<?php } ?>
								<?php if ($type == 'text' && $this->getVar('message')->$field!='') {?>
								<td><?php echo @$this->getVar('message')->$field;?></td>
								<?php } ?>
							</tr>
							<?php } ?>
							<tr>
								<th>时间</th>
								<td><?php echo @$this->getVar('message')->create_time;?></td>
							</tr>
							<tr>
								<th>访客信息</th>
								<td>
									IP:<a
										href="http://ip.taobao.com/ipSearch.html?ipAddr=<?php echo long2ip($value->user_ip);?>"
										target="_blank" title="点击查看归属地"><?php echo long2ip($this->getVar('message')->user_ip);?></a>；
									浏览器:<?php echo @$this->getVar('message')->user_bs;?>；
									操作系统:<?php echo @$this->getVar('message')->user_os;?>
								</td>
							</tr>
							<?php if ($this->getVar('message')->username) {?>
							<tr>
								<th>会员账号</th>
								<td><?php echo @$this->getVar('message')->username;?>(<?php echo @$this->getVar('message')->nickname;?>)</td>
							</tr>
							<?php } ?>
							<tr>
								<th>回复内容</th>
								<td><textarea name="recontent" placeholder="请输入回复内容"
										class="layui-textarea"><?php echo @$this->getVar('message')->recontent;?></textarea></td>
							</tr>
							<tr>
								<th>状态</th>
								<td>
									<input type="radio" name="status" value="1" title="显示"
										<?php if ($this->getVar('message')->status==1) {?>checked="checked"<?php } ?>>
									<input type="radio" name="status" value="0" title="隐藏"
										<?php if ($this->getVar('message')->status==0) {?>checked="checked"<?php } ?>>
								</td>
							</tr>
						</tbody>
					</table>
					<div class="layui-form-item">
						<div class="layui-input-block">
							<button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
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
  1 => 'F:/phpEnv/www/www.text.com/apps/admin/view/default/common/foot.html',
); ?>