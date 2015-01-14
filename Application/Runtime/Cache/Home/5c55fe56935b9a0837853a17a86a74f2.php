<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>角色管理|<<?php echo ($configcache['Title']); ?>></title>
<link rel="stylesheet" type="text/css" href="/route/Public/css/content.css"  />
<link rel="stylesheet" type="text/css" href="/route/Public/css/public.css"  />
<script type="text/javascript" src="/route/Public/js/jquery.js"></script>
<script type="text/javascript" src="/route/Public/js/Public.js"></script>
<script type="text/javascript" src="/route/Public/js/winpop.js"></script>
<script>
$(document).ready(function() {
    $('#content h2 .add').click(function() {
		popload('添加角色',700,500,"<?php echo U('Home/Rbac/addRole');?>");
		addDiv($('#iframe_pop'));
		popclose();
	});
	$('#content #table .tr .edit').click(function(event) {
		event.preventDefault();
		var id=$(this).attr('href');
		if (id=='' || isNaN(id)) {
			wintq('ID参数不正确',3,1000,1,'');
			return false;
		}else {
			popload('修改角色信息',740,410,"<?php echo U('Home/Rbac/editRole','','');?>/id/"+id);
			addDiv($('#iframe_pop'));
			popclose();
		}
	});
	$('#content #table .tr .del').click(function(event) {
		event.preventDefault();
		if (!confirm('确定要删除该数据吗？')) {
			return false;
		}
		var id=$(this).attr('href');
		if (id=='' || isNaN(id)) {
			wintq('ID参数不正确',3,1000,1,'');
			return false;
		}else {
			wintq('正在删除，请稍后...',4,20000,0,'');
			$.ajax({
				url:'/route/index.php/Role/roledel/',
				dataType:'json',
				type:'POST',
				data:'post=ok&id='+id,
				success: function(data) {
					if (data.s=='ok') {
						wintq('删除成功',1,1500,1,'?');
					}else {
						wintq(data.s,3,1500,1,'');
					}
				}
			});
		}
	});
});
</script>
</head>
<body>
<div id="content">
	<h1>首页 > 用户管理 > 角色管理</h1>
    <h2>
    	<div class="h2_left">
        	<a href="javascript:;" class="f5" onclick="f5();">刷新</a>
            <a href="javascript:;" class="add">新增</a>
            <a href="javascript:history.back();" class="Retreat">后退</a>
            <a href="javascript:history.go(1);" class="Advance">前进</a>
        </div>
    </h2>
    
    <table id="table" border="1" bordercolor="#CCCCCC" cellpadding="0" cellspacing="0">
    	<tr>
        	<th>编号</th>
            <th>角色名称</th>
            <th>角色说明</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        <?php if($role_list == 0): ?><tr class="tr"><td class="tc" colspan="7">暂无数据，等待添加～！</td></tr><?php endif; ?>
        <?php if(is_array($role_list)): $i = 0; $__LIST__ = $role_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><tr class="tr <?php if(($mod) == "1"): ?>tr2<?php endif; ?>">
            <td class="tc"><?php echo ($list["id"]); ?></td>
            <td class="tc"><?php echo ($list["name"]); ?></td>
            <td class="tc"><?php echo ($list["remark"]); ?></td>
            <td class="tc">
            <?php if($list["status"] == 1): ?><img src="/route/Public/image/home/yes.png" border="0" title="正常" />
            <?php else: ?>
            <img src="/route/Public/image/home/no.png" border="0" title="锁定" /><?php endif; ?>
            </td>
            <td class="tc fixed_w"><a href="<?php echo ($list["id"]); ?>" class="edit"><img src="/route/Public/image/home/edit.png" border="0" title="修改" /></a></td>
        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
    </table>
</div>
</body>
</html>