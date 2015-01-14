<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>添加用户|<<?php echo ($configcache['Title']); ?>></title>
<link rel="stylesheet" type="text/css" href="/route/Public/css/content.css"  />
<link rel="stylesheet" type="text/css" href="/route/Public/css/public.css"  />
<script type="text/javascript" src="/route/Public/js/jquery.js"></script>
<script type="text/javascript" src="/route/Public/js/Public.js"></script>
<script type="text/javascript" src="/route/Public/js/winpop.js"></script>
<script type="text/javascript" src="/route/Public/js/check.js"></script>
<script>
$(document).ready(function() {
	$('.button').click(function() {
		var roleid = $('#roleid').val(),
            user_name = $('#user_name').val(),
            password = $('#password').val(),
            repassword = $('#repassword').val(),
            stores = '',
            status = $('#status').val();
        $('.stores').each(function(){
            if($(this).attr('checked')){
                    stores +=','+$(this).val();
               }
        });
		if (!tcheck(roleid,'','用户角色ID获取失败')) { return false; }
		if (!tcheck(roleid,'number','用户角色ID获取失败')) { return false; }
		if (!tcheck(user_name,'','请输入正确的用户名')) { return false; }
		if (!tcheck(password,'6,18','请输入6~18位数的密码','length')) { return false; }
        if (!tcheck(repassword,password,'两次密码不一致','equal')) { return false; }
		wintq('正在添加，请稍后...',4,20000,0,'');
		$.ajax({
			url:"<?php echo U('Home/Admin/addUser');?>",
			dataType:'json',
			type:'POST',
			data:{roleid:roleid,user_name:user_name,password:password,repassword:repassword,status:status,stores:stores},
			success: function(data) {
				if (data.status==1) {
					wintq(data.info,1,1500,0,'parent');
				}else {
					wintq(data.info,3,1000,1,'');
				}
			}
		});
	});
});
</script>
</head>
<body>
<div id="content">
	<dl id="dl">
    	<dt>添加用户</dt>
        <dd>
        	<span class="dd_left">用户角色：</span>
            <span class="dd_right">
            	<select name="roleid" id="roleid" class="select">
                    <?php if(is_array($role_list)): $i = 0; $__LIST__ = $role_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><option value="<?php echo ($list["id"]); ?>"><?php echo ($list["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select><font>* 选择用户角色，分配权限</font>
            </span>
        </dd>
        <dd>
        	<span class="dd_left">用户名：</span>
        	<span class="dd_right"><input type="text" name="user_name" id="user_name" class="qtext"  /><font>* 2～12位英文数字组合</font></span>
        </dd>
        <dd>
        	<span class="dd_left">密码：</span>
        	<span class="dd_right"><input type="password" name="password" id="password" class="qtext" maxlength="18" /><font>* 6~18位密码组合</font></span>
        </dd>
        <dd>
            <span class="dd_left">确认密码：</span>
            <span class="dd_right"><input type="password" name="repassword" id="repassword" class="qtext" maxlength="18" /><font>* 6~18位密码组合</font></span>
        </dd>
        <dd>
            <span class="dd_left">门店列表：</span>
            <span class="dd_right">
                <?php if(is_array($store_list)): foreach($store_list as $key=>$s_list): ?><input type="checkbox" name="stores" class="stores"  value="<?php echo ($s_list["id"]); ?>" /><?php echo ($s_list["store_name"]); ?>   &nbsp;&nbsp;<?php endforeach; endif; ?>
                <font>* 能够管理哪些门店的广告</font>

            </span>
        </dd>
        <dd>
        	<span class="dd_left">状态：</span>
            <span class="dd_right"><label><input type="radio" name="status" id="status" value="0" checked /> 正常</label><label><input type="radio" name="status" value="1" /> 锁定</label></span>
        </dd>
        <dd><input type="button" class="button" value="提 交" /></dd>
    </dl>
</div>
</body>
</html>