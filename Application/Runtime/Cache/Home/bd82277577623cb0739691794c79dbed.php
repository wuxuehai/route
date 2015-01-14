<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo ($configcache['Title']); ?></title>
<link rel="stylesheet" type="text/css" href="/route/Public/css/public.css"  />
<link rel="stylesheet" type="text/css" href="/route/Public/css/content.css"  />
<script type="text/javascript" src="/route/Public/js/jquery.js"></script>
<script type="text/javascript" src="/route/Public/js/winpop.js"></script>
</head>
<body>
<div id="content">
	<div id="con1">
    	<h6>系统信息</h6>
        <ul>
        	<li><span>ThinkPHP框架版本：</span><?php echo ($info['THINK_VERSION']); ?></li>
            <li><span>服务器操作系统：</span><?php echo ($info['PHP_OS']); ?></li>
            <li><span>运行环境：</span><?php echo ($info['SERVER_SOFTWARE']); ?></li>
            <li><span>Mysql版本：</span><?php echo ($info['mysql']); ?></li>
        </ul>
    </div>
    <div id="con1">
        <h6>开发维护团队</h6>
        <ul>
            <li><span>程序：</span>XXX</li>
            <li><span>界面：</span>XXX</li>
            <li><span>公司：</span>XXX</li>
            <li><span>联系方式：</span>XXX</li>
        </ul>
    </div>

</div>
</body>
</html>