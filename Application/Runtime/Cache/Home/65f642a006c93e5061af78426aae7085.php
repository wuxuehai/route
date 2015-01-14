<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>权限管理|<<?php echo ($configcache['Title']); ?>></title>
<link rel="stylesheet" type="text/css" href="/route/Public/css/content.css"  />
<link rel="stylesheet" type="text/css" href="/route/Public/css/public.css"  />
<script type="text/javascript" src="/route/Public/js/jquery.js"></script>
<script type="text/javascript" src="/route/Public/js/Public.js"></script>
<script type="text/javascript" src="/route/Public/js/winpop.js"></script>
<script type="text/javascript" src="/route/Public/js/check.js"></script>
<script>
$(document).ready(function() {
    $('#content h2 .add').click(function() {
		popload('添加权限',700,400,"<?php echo U('Home/Rbac/addNode');?>");
		addDiv($('#iframe_pop'));
		popclose();
	});

    $('.addChild').click(function(){
        event.preventDefault();
        var url = "<?php echo U('Home/Rbac/addNode','','');?>",
            title = $(this).attr('title'),
            pid = $(this).attr('href'),
            level = $(this).attr('level');
        if (!tcheck(level,'number','ID获取失败，请刷新页面')) { return false; }
        if (!tcheck(pid,'number','ID获取失败，请刷新页面')) { return false; }
        url+='/pid/'+pid+'/level/'+level;
        popload('添加权限-['+title+']',700,400,url);
        addDiv($('#iframe_pop'));
        popclose();
    })

	$('#content #table .tr .edit').click(function(event) {
		event.preventDefault();
		var id=$(this).attr('href');		
		if (id=='' || isNaN(id)) {
			wintq('ID参数不正确',3,1000,1,'');
			return false;
		}else {
			popload('修改权限信息',600,300,'/route/index.php/Competence/cedit/id/'+id);
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
				url:'/route/index.php/Competence/cdel/',
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
	<h1>首页 > 用户管理 > 权限管理</h1>
    <h2>
    	<div class="h2_left">
        	<a href="/route/index.php/Home/Rbac/nodeIndex" class="whole">全部</a>
        	<a href="javascript:;" class="f5" onclick="f5();">刷新</a>
            <a href="javascript:;" class="add">新增</a>
            <a href="javascript:history.back();" class="Retreat">后退</a>
            <a href="javascript:history.go(1);" class="Advance">前进</a>
        </div>
    </h2>
    <table id="table" border="1" bordercolor="#CCCCCC" cellpadding="0" cellspacing="0">
    	<tr>
        	<th>编号</th>
            <th>权限分类</th>
            <th>权限名称</th>
            <th>权限说明</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        <?php if($node_list == 0): ?><tr class="tr"><td class="tc" colspan="7">暂无数据，等待添加～！</td></tr><?php endif; ?>
        <!--顶级数据-->
        <?php if(is_array($node_list)): $i = 0; $__LIST__ = $node_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><tr class="tr tr2">
            <td class="tc"><?php echo ($list["id"]); ?></td>
            <td class="tc"><?php echo ($list["title"]); ?></td>
            <td class="tc"><?php echo ($list["name"]); ?></td>
            <td class="tc"><?php echo ($list["remark"]); ?></td>
            <td class="tc">
            <?php if($list["status"] == 1): ?><img src="/route/Public/image/home/yes.png" border="0" title="正常" />
            <?php else: ?>
            <img src="/route/Public/image/home/no.png" border="0" title="锁定" /><?php endif; ?>
            </td>
            <td class="tc fixed_w">
                <a href="<?php echo ($list["id"]); ?>" class="addChild" level="<?php echo ($list["level"]); ?>" title="添加<?php echo ($list["title"]); ?>下级"><img src="/route/Public/image/home/add.png" border="0" title="添加<?php echo ($list["title"]); ?>下级" /></a>

            </td>
        </tr>
        <!--二级数据-->
        <?php if(is_array($list['_child'])): $i = 0; $__LIST__ = $list['_child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$child_list): $mod = ($i % 2 );++$i;?><tr class="tr">
            <td class="tc"><?php echo ($child_list["id"]); ?></td>
            <td class="l2"><?php echo ($child_list["title"]); ?></td>
            <td class="l2"><?php echo ($child_list["name"]); ?></td>
            <td class="l2"><?php echo ($child_list["remark"]); ?></td>
            <td class="tc">
            <?php if($child_list["status"] == 1): ?><img src="/route/Public/image/home/yes.png" border="0" title="正常" />
            <?php else: ?>
            <img src="/route/Public/image/home/no.png" border="0" title="锁定" /><?php endif; ?>
            </td>
            <td class="tc fixed_w">
                <a href="<?php echo ($child_list["id"]); ?>" class="addChild" level="<?php echo ($child_list["level"]); ?>" title="添加<?php echo ($child_list["title"]); ?>下级"><img src="/route/Public/image/home/add.png" border="0" title="添加<?php echo ($child_list["title"]); ?>下级" /></a>

            </td>
        </tr>

            <!--三级数据-->
            <?php if(is_array($child_list['_child'])): $i = 0; $__LIST__ = $child_list['_child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$children_list): $mod = ($i % 2 );++$i;?><tr class="tr">
                    <td class="tc"><?php echo ($children_list["id"]); ?></td>
                    <td></td>
                    <td class="l3"><?php echo ($children_list["name"]); ?></td>
                    <td class="l3"><?php echo ($children_list["remark"]); ?></td>
                    <td class="tc">
                        <?php if($children_list["status"] == 1): ?><img src="/route/Public/image/home/yes.png" border="0" title="正常" />
                            <?php else: ?>
                            <img src="/route/Public/image/home/no.png" border="0" title="锁定" /><?php endif; ?>
                    </td>
                    <td class="tc fixed_w">

                    </td>
                </tr><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
    </table>
    <div id="page"><?php echo ($page); ?></div>
</div>
</body>
</html>