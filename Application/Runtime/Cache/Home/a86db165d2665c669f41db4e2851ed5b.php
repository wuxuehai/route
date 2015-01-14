<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>添加角色|<<?php echo ($configcache['Title']); ?>></title>
<link rel="stylesheet" type="text/css" href="/route/Public/css/content.css"  />
<link rel="stylesheet" type="text/css" href="/route/Public/css/public.css"  />
<script type="text/javascript" src="/route/Public/js/jquery.js"></script>
<script type="text/javascript" src="/route/Public/js/Public.js"></script>
<script type="text/javascript" src="/route/Public/js/winpop.js"></script>
<script type="text/javascript" src="/route/Public/js/check.js"></script>
<script>
$(document).ready(function() {
	$('.button').click(function() {
		var name = $('#name').val(),
            remark = $('#remark').val(),
            status = $('#status').val(),
            comp='';
        $('.comp').each(function(){
            if($(this).attr('checked')){
                var id = $(this).val(),
                    level = $(this).attr('level');
                comp+=','+id+'-'+level;
            }

        })
		if (!tcheck(name,'','请填写角色名称')) { return false; }
		if (!tcheck(name,'2,20','角色名称请在20个字符以内','length')) { return false; }
		if (!tcheck(remark,'0,254','描述请在254个字符以内','length')) { return false; }
		
		wintq('正在添加，请稍后...',4,20000,0,'');
		$.ajax({
			url:"<?php echo U('Home/Rbac/addRole');?>",
			dataType:'json',
			type:'POST',
			data:{name:name,remark:remark,status:status,comp:comp},
			success: function(data) {
				if (data.status==1) {
					wintq(data.info,1,1500,0,'parent');
				}else {
					wintq(data.info,3,1500,10,'');
				}
			}
		});
	});

    /*全选/反选自元素*/
    $('.controller').click(function(){
        var id = $(this).attr('value');
        if($(this).attr('checked')){
            $('.action'+id).each(function(){
                $(this).attr('checked',true);
            })
        }else{
            $('.action'+id).each(function(){
                $(this).attr('checked',false);
            })
        }
    })
});
</script>
</head>
<body>
<div id="content">
	<dl id="dl">
    	<dt>添加控制角色</dt>
        <dd>
        	<span class="dd_left">角色名称：</span>
        	<span class="dd_right"><input type="text" name="name" id="name" class="qtext" maxlength="20" /><font>* 输入如：来宾用户</font></span>
        </dd>
        <dd>
        	<span class="dd_left">角色说明：</span>
            <span class="dd_right"><textarea name="remark" id="remark" id="remark" class="textarea"></textarea></span>
        </dd>
        <dt>权限分配</dt>
        <?php if(is_array($node_list)): $i = 0; $__LIST__ = $node_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$model_list): $mod = ($i % 2 );++$i;?><dt><input type="checkbox" class="comp controller" checked value="<?php echo ($model_list["id"]); ?>" level="<?php echo ($model_list["level"]); ?>" /> <?php echo ($model_list["title"]); ?>：</dt>
            <dd>
                <?php if(is_array($model_list['_child'])): $i = 0; $__LIST__ = $model_list['_child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$controller_list): $mod = ($i % 2 );++$i;?><span class="dd_left"><input type="checkbox" class="comp controller" value="<?php echo ($controller_list["id"]); ?>" level="<?php echo ($controller_list["level"]); ?>" /> <?php echo ($controller_list["title"]); ?>：</span>
                    <span class="dd_right" style="width:100%;padding-left:100px;">
                        <?php if(is_array($controller_list['_child'])): $i = 0; $__LIST__ = $controller_list['_child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$action_list): $mod = ($i % 2 );++$i;?><label><input type="checkbox" class="comp action<?php echo ($controller_list["id"]); ?>" level="<?php echo ($action_list["level"]); ?>" value="<?php echo ($action_list["id"]); ?>" /> <?php echo ($action_list["title"]); ?></label><?php endforeach; endif; else: echo "" ;endif; ?>
                    </span><?php endforeach; endif; else: echo "" ;endif; ?>
            </dd><?php endforeach; endif; else: echo "" ;endif; ?>
        <dd>
        	<span class="dd_left">状态：</span>
            <span class="dd_right"><label><input type="radio" name="status"id="status" class="status" value="1" checked /> 正常</label><label><input type="radio" name="status" class="status" value="0" /> 锁定</label></span>
        </dd>
        <dd><input type="button" class="button" value="提 交" /></dd>
    </dl>
</div>
</body>
</html>