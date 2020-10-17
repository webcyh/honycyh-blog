<!DOCTYPE html>
<html lang="en">
<head>
	<!-- meta -->
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- title -->
	<title>严谨性|<?php echo $infoArr['网站标题']['info_value'] ?></title>
	<!-- 网站图标 -->
	<link rel="Shortcut Icon" href="/static/favicon.ico" type="image/x-icon" />
	<!-- 第三方插件样式 -->
	<link rel="stylesheet"    href="https://cdn.staticfile.org/font-awesome/4.7.0/css/font-awesome.css">
	<link rel="stylesheet" href="js/bootstrap-markdown/css/bootstrap-markdown.min.css?v=1.0.0">
	<!-- 自己的插件样式 -->
	<!-- 框架样式 -->
	<link rel="stylesheet" type="text/css"  href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css">
	<!-- 自己的主题样式 -->
	<link rel="stylesheet" type="text/css" href="/static/common.css">
	<link rel="stylesheet" href="/static/nav.css">
	<!-- 关于响应式的样式文件 -->
	<!-- 第三方js插件 -->
	<!-- 自定义的js插件 -->
	<script src="/static/jquery.simpleLoadMore.js"></script>
	<!-- js框架 -->
	<script src="https://cdn.bootcdn.net/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	<!-- 自己的主要js代码 -->
	<script src="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="/static/pjax.js"></script>
	<script src="https://cdn.bootcdn.net/ajax/libs/validate.js/0.8.0/validate.min.js"></script>

	<script  src="https://cdn.staticfile.org/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
	<script type="text/javascript" src="/static/index.js"></script>
	<script src="/static/nav.js"></script>
</head>
<body>
<!-- 顶部大图 -->
<header class="hidden-xs" class="container-fluid" id="header">
	<div class="col-md-6 col-md-offset-3">
		<a class="navbar-brand" href="#"><?php echo $infoArr['网站标题']['info_value'] ?></a>
		<p><?php echo $infoArr['每日一句']['info_value'] ?></p>
	</div>
	<div id="theme">
		<button class="fa fa-moon-o">
		</button>
		<a  href="https://github.com/webcyh" target="_blank">
			<button class="fa fa-github"></button>
		</a>
		<button class="fa fa-qq"></button>
		<a href="/xml/note.xml" target="_blank">
			<button class="	fa fa-rss"></button>
		</a>
	</div>
</header>
<div style="height: 80px;">
	<nav class="navbar navbar-default " id="nav" data-spy="affix" data-offset-top="200">
		<div class="container">
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu"> <span class="sr-only">展开导航</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span> 
						</button>
					</div>
					<div class="collapse navbar-collapse" id="menu">
						<ul class="nav navbar-nav">
							<li><a href="home" class="label-click">首页</a></li>
							<li> <a href="#" class="dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown">系列课程    <span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
									<li role="presentation"> <a role="menuitem" tabindex="-1" href="#">Java</a> </li>
									<li role="presentation" class="divider"></li>
									<li role="presentation"> <a role="menuitem" tabindex="-1" href="#">php基础到进阶</a></li>
								</ul>
							</li>
							<li> <a href="link" class="label-click">友链</a></li>
							<li> <a href="#" class="labdel-click">关于我</a></li>
						</ul>
						<div class="navbar-form navbar-right  hidden-sm">
							<input type="text" class="form-control" name="" placeholder="站内搜索">
							<button class="btn btn-success" style="margin-right: 30px;">搜索</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</nav>
</div>