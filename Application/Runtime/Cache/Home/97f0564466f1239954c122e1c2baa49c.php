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
	    var store_id = $('#store_id').val(),
            device_name = $('#device_name').val(),
            only_code = $('#only_code').val(),
            device_mac = $('#device_mac').val();
        if (!tcheck(store_id,'','ID参数有误，请刷新页面')) { return false; }
		if (!tcheck(device_name,'','设备名称不能为空')) { return false; }
        if (!tcheck(only_code,'','设备唯一标识不能为空')) { return false; }
        if (!tcheck(device_mac,'','设备mac地址不能为空')) { return false; }
		
		wintq('正在添加，请稍后...',4,20000,0,'');
		$.ajax({
			url:"<?php echo U('Home/Device/addDevice');?>",
			dataType:'json',
			type:'POST',
			data:{store_id:store_id,device_name:device_name,device_mac:device_mac,only_code:only_code},
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
    	<dt>添加设备</dt>
        <dd>
        	<span class="dd_left">所属门店：</span>
            <span class="dd_right">
            	<select name="store_id" id="store_id" class="select">
                    <?php if(is_array($store_list)): $i = 0; $__LIST__ = $store_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><option value="<?php echo ($list["id"]); ?>"><?php echo ($list["store_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select><font>* 请选择设备所属门店</font>
            </span>
        </dd>
        <dd>
        	<span class="dd_left">设备名称：</span>
        	<span class="dd_right"><input type="text" name="device_name" id="device_name" class="qtext"  /><font>* 请输入设备名称</font></span>
        </dd>
        <dd>
        	<span class="dd_left">设备唯一标识：</span>
        	<span class="dd_right"><input type="text" name="only_code" id="only_code" class="qtext"  /><font>* 请输入设备唯一标识</font></span>
        </dd>
        <dd>
        	<span class="dd_left">设备MAC地址：</span>
        	<span class="dd_right"><input type="text" name="device_mac" id="device_mac" class="qtext"  /><font>* 请输入设备MAC地址</font></span>
        </dd>
        <dd><input type="button" class="button" value="提 交" /></dd>
    </dl>
</div>
</body>
</html>