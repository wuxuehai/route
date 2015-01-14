<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo C('SITE_NAME');?></title>
<link rel="stylesheet" type="text/css" href="/route/Public/css/main.css"  />
<link rel="stylesheet" type="text/css" href="/route/Public/css/public.css"  />
<script type="text/javascript" src="/route/Public/js/jquery.js"></script>
<script type="text/javascript" src="/route/Public/js/winpop.js"></script>
<script type="text/javascript" src="/route/Public/js/Public.js"></script>
<script>
window.onload=function() {
	//退出登录
	function quit() {
		$('body #quit').click(function(event) {
			event.preventDefault();
			if (confirm('确定要退出吗？')) {
				window.top.location.href="<?php echo U('Home/Public/loginOut');?>";
			}
		});
	}
	quit();
	$('#home').click(function() {
		window.top.location.href="<?php echo U('Home/Index/index');?>";
	});
    $('#main #user_save').click(function() {
		popload('修改密码',620,300,"<?php echo U('Home/Admin/editPassword');?>");
		addDiv($('#iframe_pop'));
	});
	//一键清空缓存
	$('#main #cache').click(function() {
		if (confirm('确定要清空所有缓存吗？')) {
			wintq('正在清除缓存，请稍后...',4,60000,0,'');
			$.ajax({
				url:"<?php echo U('Home/Index/clearCache');?>",
				dataType:'JSON',
				type:'POST',
				data:'clear=ok',
				success: function(data) {
					if (data.status==1) {
						wintq(data.info,1,1000,1,'');
					}else {
						wintq(data.info,3,1000,1,'');
					}
				}
			});
		}
	});

}
$(function() {
	for (i=0; i<$('#left dl').size(); i++) {
		$dldd=$('#left dl').eq(i);
		if ($dldd.find('dd').size() < 1) {
			$dldd.remove();
		}
	}
	$('#ul li .a').click(function() {
		$('#ul li .a').removeClass('lia');
		$(this).addClass('lia');
		$('#ul li dl').stop().slideUp('fast');
		var $dl = $(this).parents('li').find('dl');
		$dl.stop().slideToggle('fast');
		$dl.find('a').click(function() {
			$('#ul li dl dd a').removeClass('dla');
			$(this).addClass('dla');
		});
	});
});
</script>
</head>
<body>
<div id="main">
	<div id="header">
    	<div id="logo"><?php echo C('SITE_NAME');?></div>
        <div id="cache" title="清空缓存"></div>
        <div id="home" title="首页"></div>
        <div id="all" title="全局导航"></div>
        <div id="quit" title="退出登录"></div>
    </div>
    <div id="top">
    	<div class="top_left">
        	<div id="jnkc"></div><script>setInterval("jnkc.innerHTML=new Date().toLocaleString()+' 星期'+'日一二三四五六'.charAt(new Date().getDay());",1000);</script>
        	<div class="top_left1">
            欢迎您：<font><?php if($_SESSION['nickname']): echo ($_SESSION["nickname"]); else: echo ($_SESSION['username']); endif; ?></font>
             上次登录IP：<?php echo ($_SESSION["last_ip"]); ?>
             上次登录时间：<?php echo (date('Y-m-d H:i:s',$_SESSION["last_time"])); ?>
            <span id="user_save"><img src="/route/Public/image/home/user4.png" border="0" height="16" />修改密码</span>&nbsp;&nbsp;&nbsp;&nbsp;
            <span id="cache"><img src="/route/Public/image/home/cache.png" border="0" height="16" />清空缓存</span>&nbsp;&nbsp;&nbsp;&nbsp;
            <span id="quit"><img src="/route/Public/image/home/exit.png" border="0" height="16" />退出登录</span>
            </div>
        </div>
        <div class="top_right">
        	<a href="javascript:;" onclick="f5();"><img src="/route/Public/image/home/arrow_refresh.png" border="0" title="刷新" /></a>
        </div>
    </div>
    <div id="left">
    	<ul id="ul">

            <?php if(array_key_exists('STORE',$_SESSION[_ACCESS_LIST]['HOME']) or $_SESSION[C('ADMIN_AUTH_KEY')] == 1): ?><li><a class="a" href="javascript:;" target="c"><img src="/route/Public/image/home/img/1029.png" height="26" />门店管理</a>
            	<dl>
                	<dd><a href="<?php echo U('Home/Store/index');?>" target="c"><img src="/route/Public/image/home/img/975.png" />门店列表</a></dd>
                </dl>
            </li><?php endif; ?>
            <?php if(array_key_exists('DEVICE',$_SESSION[_ACCESS_LIST]['HOME']) or $_SESSION[C('ADMIN_AUTH_KEY')] == 1): ?><li><a class="a" href="javascript:;" target="c"><img src="/route/Public/image/home/img/659.png" height="26" />设备管理</a>
                <dl>
                    <dd><a href="<?php echo U('Home/Device/index');?>" target="c"><img src="/route/Public/image/home/img/662.png" />设备列表</a></dd>
                </dl>
            </li><?php endif; ?>
            <?php if(array_key_exists('AD',$_SESSION[_ACCESS_LIST]['HOME']) or $_SESSION[C('ADMIN_AUTH_KEY')] == 1): ?><li><a class="a" href="javascript:;" target="c"><img src="/route/Public/image/home/img/659.png" height="26" />广告管理</a>
                    <dl>
                        <dd><a href="<?php echo U('Home/Ad/index');?>" target="c"><img src="/route/Public/image/home/img/662.png" />广告列表</a></dd>
                    </dl>
                </li><?php endif; ?>
            <?php if(array_key_exists('ADMIN',$_SESSION[_ACCESS_LIST]['HOME']) or $_SESSION[C('ADMIN_AUTH_KEY')] == 1 ): ?><li id="Admin"><a class="a" href="javascript:;" target="c"><img src="/route/Public/image/home/img/54.png" height="26" />管理员管理</a>
                <dl>
                    <dd><a href="<?php echo U('Home/Admin/index');?>" target="c"><img src="/route/Public/image/home/img/21.png" />管理员列表</a></dd>
                    <dd><a href="<?php echo U('Home/Rbac/roleIndex');?>" target="c"><img src="/route/Public/image/home/img/51.png" />管理员组</a></dd>
                </dl>
            </li><?php endif; ?>
            <?php if(array_key_exists('RBAC',$_SESSION[_ACCESS_LIST]['HOME']) or $_SESSION[C('ADMIN_AUTH_KEY')] == 1 ): ?><li><a class="a" href="javascript:;" target="c"><img src="/route/Public/image/home/img/577.png" height="26" />权限管理</a>
                <dl>
                    <dd><a href="<?php echo U('Home/Rbac/nodeIndex');?>" target="c"><img src="/route/Public/image/home/img/576.png" />节点列表</a></dd>
                </dl>
            </li><?php endif; ?>
            <?php if(array_key_exists('SYSTEM',$_SESSION[_ACCESS_LIST]['HOME']) or $_SESSION[C('ADMIN_AUTH_KEY')] == 1 ): ?><li><a class="a" href="javascript:;" target="c"><img src="/route/Public/image/home/img/675.png" height="26" />系统设置</a>
                <dl>
                    <dd><a href="<?php echo U('Home/System/index');?>" target="c"><img src="/route/Public/image/home/img/884.png" />系统配置</a></dd>
                </dl>
            </li><?php endif; ?>
        </ul>
    </div>
    <div class="left" title="收缩"></div>
    <div id="right">
    	<iframe id="ifdd" name="c" height="100%" width="100%" border="0" frameborder="0" src="<?php echo U('Home/Index/systemInfo');?>">浏览器不支持嵌入式框架，或被配置为不显示嵌入式框架。</iframe>
    </div>
</div>
</body>
</html>