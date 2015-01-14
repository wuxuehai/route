<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改权限|<<?php echo ($configcache['Title']); ?>></title>
<link rel="stylesheet" type="text/css" href="/route/Public/css/content.css"  />
<link rel="stylesheet" type="text/css" href="/route/Public/css/public.css"  />
<script type="text/javascript" src="/route/Public/js/jquery.js"></script>
<script type="text/javascript" src="/route/Public/js/Public.js"></script>
<script type="text/javascript" src="/route/Public/js/winpop.js"></script>
<script type="text/javascript" src="/route/Public/js/check.js"></script>
<script>
$(document).ready(function() {
	$('.button').click(function() {
        var pid = $('#pid').val(),
            name = $('#name').val(),
            title = $('#title').val(),
            remark = $('#remark').val(),
            status = $('#status').val(),
            level = $('#level').val();
		
		if (!tcheck(pid,'number','ID获取失败，请刷新页面')) { return false; }
		if (!tcheck(name,'','请输入<?php echo ($type); ?>名称')) { return false; }
		if (!tcheck(title,'','请输入<?php echo ($type); ?>标题')) { return false; }
		if (!tcheck(remark,'','请输入<?php echo ($type); ?>描述')) { return false; }
		if (!tcheck(status,'number','ID获取失败，请刷新页面')) { return false; }
		if (!tcheck(level,'number','ID获取失败，请刷新页面')) { return false; }
		
		wintq('正在添加，请稍后...',4,20000,0,'');
		$.ajax({
			url:"<?php echo U('Home/Rbac/addNode');?>",
			dataType:'json',
			type:'POST',
			data:{pid:pid,name:name,title:title,remark:remark,status:status,level:level},
			success: function(data) {
				if (data.status==1) {
					wintq(data.info,1,1500,0,'parent');
				}else {
					wintq(data.info,3,1500,1,'');
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
    	<dt>添加权限信息</dt>
        <dd>
        	<span class="dd_left">权限分类：</span>
            <span class="dd_right">
            	<select name="pid" id="pid" class="select">
                	<option value="0">顶级目录</option>
                    <?php if(is_array($node_list)): foreach($node_list as $key=>$list): ?><option  value="<?php echo ($list["id"]); ?>" <?php if($list['id'] == $pid): ?>selected<?php endif; ?> ><?php echo ($list["title"]); ?></option>
                    <?php if(is_array($list['_child'])): foreach($list['_child'] as $key=>$child_list): ?><option  value="<?php echo ($child_list["id"]); ?>" <?php if($child_list['id'] == $pid): ?>selected<?php endif; ?> >&nbsp;&nbsp;<?php echo ($child_list["title"]); ?></option><?php endforeach; endif; endforeach; endif; ?>
                </select><font>* 选择所属目录</font>
            </span>
        </dd>
        <dd>
        	<span class="dd_left"><?php echo ($type); ?>名称：</span>
        	<span class="dd_right"><input type="text" name="name" id="name" class="qtext" /><font>* 请输入程序实际名称[不能为中文]</font></span>
        </dd>
        <dd>
            <span class="dd_left"><?php echo ($type); ?>标题：</span>
            <span class="dd_right"><input type="text" name="title" id="title" class="qtext" /><font>* 请输入程序中文名称</font></span>
        </dd>
        <dd>
        	<span class="dd_left"><?php echo ($type); ?>描述：</span>
            <span class="dd_right"><textarea name="remark" id="remark"  class="textarea"></textarea></span>
        </dd>
        <dd>
        	<span class="dd_left">状态：</span>
            <span class="dd_right"><label><input type="radio" name="status" id="status" value="1" <?php if($result['Status'] == 0): ?>checked<?php endif; ?> /> 正常</label><label><input type="radio" name="status" value="0" <?php if($result['Status'] == 1): ?>checked<?php endif; ?> /> 锁定</label><font>* 提示：如果没有修改任何信息，则会提示“数据修改失败”</font></span>
        </dd>
        <input type="hidden" name="level" id="level" value="<?php echo ($level); ?>" />
        <dd><input type="button" class="button" value="提 交" /></dd>
    </dl>
</div>
</body>
</html>