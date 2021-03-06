<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>系统用户管理|管理员列表</title>
<link rel="stylesheet" type="text/css" href="/route/Public/css/content.css"  />
<link rel="stylesheet" type="text/css" href="/route/Public/css/public.css"  />
<script type="text/javascript" src="/route/Public/js/jquery.js"></script>
<script type="text/javascript" src="/route/Public/js/Public.js"></script>
<script type="text/javascript" src="/route/Public/js/winpop.js"></script>
<script>
$(document).ready(function() {
    $('#content h2 .add').click(function() {
		popload('添加管理用户',600,380,"<?php echo U('Home/Admin/addUser');?>");
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
			popload('修改用户信息',740,420,"<?php echo U('Home/Admin/editUser','','');?>/id/"+id);
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
				url:"<?php echo U('Home/Admin/del');?>",
				dataType:'json',
				type:'POST',
				data:{id:id},
				success: function(data) {
					if (data.status==1) {
						wintq(data.info,1,1500,0,'?');
					}else {
						wintq(data.info,3,1500,1,'');
					}
				}
			});
		}
	});
	$('#dely').click(function(event) {
		event.preventDefault();
		if (!confirm('确定要删除选择项吗？')) {
			return false;
		}
		var delid='';
		for (i=0; i<$('#table .delid').size(); i++) {
			if (!$('#table .delid').eq(i).attr('checked')==false) {
				delid=delid+$('#table .delid').eq(i).val()+',';
			}
		}
		if (delid=='') {
			wintq('请选中后再操作',2,1500,1,'');
		}else {
			wintq('正在删除，请稍后...',4,20000,0,'');
			$.ajax({
				url:"<?php echo U('Home/Admin/del','','');?>/all/1",
				dataType:'JSON',
				type:'POST',
				data:{id:delid},
				success: function(data) {
					if (data.status==1) {
						wintq(data.info,1,1500,0,'?');
					}else {
						wintq(data.info,3,1500,1,'');
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
	<h1>首页 > 用户管理 > 管理员列表</h1>
    <h2>
    	<div class="h2_left">
        	<a href="/route/index.php/Home/Admin/index" class="whole">全部</a>
        	<a href="javascript:;" class="f5" onclick="f5();">刷新</a>
            <a href="javascript:;" class="add">新增</a>
            <a href="javascript:history.back();" class="Retreat">后退</a>
            <a href="javascript:history.go(1);" class="Advance">前进</a>
        </div>
    </h2>
    <table id="table" border="1" bordercolor="#CCCCCC" cellpadding="0" cellspacing="0">
    	<tr>
        	<th><input type="checkbox" class="indel" value="del" /></th>
        	<th>编号</th>
            <th>所属分组</th>
            <th>用户名</th>
            <th>昵称</th>
            <th>最后登录时间</th>
            <th>最后登录IP</th>
            <th>添加时间</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        <?php if($admin_list == 0): ?><tr class="tr"><td class="tc" colspan="11">暂无数据，等待添加～！</td></tr><?php endif; ?>
        <!--顶级数据-->
        <?php if(is_array($admin_list)): $i = 0; $__LIST__ = $admin_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><tr class="tr <?php if(($mod) == "1"): ?>tr2<?php endif; ?>">
        	<td class="tc"><?php if($list['id'] != 1): ?><input type="checkbox" class="delid" value="<?php echo ($list["id"]); ?>" /><?php endif; ?></td>
            <td class="tc"><?php echo ($list["id"]); ?></td>
            <td class="tc"><?php echo (getRoleName($list["pid"])); ?></td>
            <td class="tc"><?php echo ($list["user_name"]); ?></td>
            <td class="tc"><?php echo ($list["nickname"]); ?></td>
            <td class="tc"><?php if($list["last_time"] == true): echo (date('Y-m-d H:i:s',$list["last_time"])); else: ?>未登录<?php endif; ?></td>
            <td class="tc"><?php echo ($list["last_ip"]); ?></td>
            <td class="tc"><?php if($list["create_time"] == true): echo (date('Y-m-d H:i:s',$list["create_time"])); else: ?>无<?php endif; ?></td>
            <td class="tc">
            <?php if($list["status"] == 0): ?><img src="/route/Public/image/home/yes.png" border="0" title="正常" />
            <?php else: ?>
            <img src="/route/Public/image/home/no.png" border="0" title="锁定" /><?php endif; ?>
            </td>
            <td class="tc fixed_w">
                <?php if($list[id] != 1): ?><a href="<?php echo ($list["id"]); ?>" class="edit"><img src="/route/Public/image/home/edit.png" border="0" title="修改" /></a>
                <a href="<?php echo ($list["id"]); ?>" class="del"><img src="/route/Public/image/home/delete.png" border="0" title="删除" /></a><?php endif; ?>
            </td>
        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
    </table>
    <div id="page"><a href="javascript:;" class="selbox">全选</a><a href="javascript:;" class="anti">反选</a><a href="javascript:;" class="unselbox">全不选</a>&nbsp;&nbsp;对选中项进行&nbsp;&nbsp;<a href="javascript:;" id="dely">删除</a>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo ($page); ?></div>
</div>
</body>
</html>