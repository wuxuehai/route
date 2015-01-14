<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>登录 - <?php echo C('SITE_NAME');?></title>
<link rel="stylesheet" type="text/css" href="/route/Public/css/login.css"  />
<link rel="stylesheet" type="text/css" href="/route/Public/css/public.css"  />
<script type="text/javascript" src="/route/Public/js/jquery.js"></script>
<script type="text/javascript" src="/route/Public/js/Public.js"></script>
<script type="text/javascript" src="/route/Public/js/winpop.js"></script>
<script>
$(function() {
	$('#content input').eq(0).focus();
    $('body input:text, input:password, textarea').focus(function() {
		$(this).css({'border':'solid 1px #398700','boxShadow':'0px 0px 8px #398700'});
	});
    $('body input:text, input:password, textarea').blur(function() {
		$(this).css({'border':'solid 1px #ccc','boxShadow':'none'});
	});
	$('.button').click(function(event) {
		event.preventDefault();
		var username=$('#content .utext').val();
		var password=$('#content .ptext').val();
		var code=$('#content .code').val();
		if (!/^[a-zA-Z0-9_-]|[\u4e00-\u9fa5]{2,16}$/.test(username)) {
			wintq('请输入正确的用户名',2,2000,1,'');
			$('#content .utext').focus();
			return;
		}
		if (password.length<5) {
			wintq('请输入6位数以上的密码',2,2000,1,'');
			$('#content .ptext').focus();
			return;
		}
		if (!/^[a-zA-Z0-9]{2}$/.test(code)) {
			wintq('请输入正确的验证码',2,2000,1,'');
			$('#content .code').focus();
			return;
		}
		wintq('正在登录，请稍后...',4,20000,0,'');
		$.ajax({
			url:"<?php echo U('Home/Public/login','','');?>",
			dataType:"json",
			type:'POST',
			cache:false,
			data:'username='+username+'&password='+password+'&verify='+code,
			success: function(data) {
				if (data.status=='1') {
					wintq(data.info,1,2000,0,data.url);
				}else {
					rcode($('#verify'));
					wintq(data.info,3,2000,1,'');
				}
			}
		});
	});
	//更换验证码
	function rcode(obj) {
		obj.attr('src',"<?php echo U('Home/Public/verify','','');?>/"+Math.random());
	}
	$('#verify').click(function() {
		rcode($(this));
	});
});
</script>
</head>
<body>
<div id="content">
	<form action="/route/index.php/Index/login" method="post">
	<dl>
    	<dt>客户管理系统</dt>
    	<dd><input type="text" name="username" class="utext" maxlength="12" value="" /></dd>
        <dd><input type="password" name="password" class="ptext" maxlength="18" value="" /></dd>
        <dd><input type="text" name="verify" class="code" maxlength="4" /> <img src="<?php echo U('Home/Public/verify','','');?>" border="0" id="verify"/><input type="submit" name="login" value="登 录" class="button" /></dd>
        <dd><label>版本：V 1.0　　设计和维护：<a href="#" target="_blank">##</a></label></dd>
    </dl>
    </form>
</div>
</body>
</html>