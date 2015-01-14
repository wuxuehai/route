<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>添加广告|<<?php echo ($configcache['Title']); ?>></title>
<link rel="stylesheet" type="text/css" href="/route/Public/css/content.css"  />
<link rel="stylesheet" type="text/css" href="/route/Public/css/public.css"  />
<link rel="stylesheet" type="text/css" href="/route/Public/uploadify/uploadify.css"  />
    <link rel="stylesheet" type="text/css" href="/route/Public/My97DatePicker/skin/WdatePicker.css"  />
<script type="text/javascript" src="/route/Public/js/jquery.js"></script>
<script type="text/javascript" src="/route/Public/js/Public.js"></script>
<script type="text/javascript" src="/route/Public/js/winpop.js"></script>
<script type="text/javascript" src="/route/Public/js/check.js"></script>
<script type="text/javascript" src="/route/Public/ueditor1_4_3-utf8-php/ueditor.config.js"></script>
<script type="text/javascript" src="/route/Public/ueditor1_4_3-utf8-php/ueditor.all.min.js"></script>
<script type="text/javascript" src="/route/Public/uploadify/jquery.uploadify.min.js"></script>
<script type="text/javascript" src="/route/Public/My97DatePicker/WdatePicker.js"></script>
<script>
$(document).ready(function() {
    /*uplodify上传插件*/
    $("#file").uploadify({
        /*注意前面需要书写path的代码*/
        'formData'     : {
            'token'     : '<?php echo ($token); ?>'
        },
        'uploader'       : "<?php echo U('Home/Upload/upLoad','','');?>",
        'swf'            : '/route/Public/uploadify/uploadify.swf',
        'script'         : "<?php echo U('Home/Public/upLoad','','');?>",
        'cancelImg'      : '/route/Public/uploadify/cancel.png',
        'auto'           : true, //是否自动开始
        'multi'          : false, //是否支持多文件上传
        'buttonText'     : '上传图片', //按钮上的文字
        'simUploadLimit' : 1, //一次同步上传的文件数目
        'sizeLimit'      : 19871202, //设置单个文件大小限制
        'queueSizeLimit' : 1, //队列中同时存在的文件个数限制
        'fileDesc'       : '支持格式:jpg/gif/jpeg/png/bmp.', //如果配置了以下的'fileExt'属性，那么这个属性是必须的
        'fileExt'        : '*.jpg;*.gif;*.jpeg;*.png;*.bmp',//允许的格式
        onUploadSuccess :function(file,data,response){
            data = eval('('+data+')');
            if(data.status){
                var html = '<img src="/route/Uploads/'+data.info+'" />';
                $('#images').append(html);
                $('#logo').val(data.info);
            }
         },
        onError: function(event, queueID, fileObj) {
            alert("文件:" + fileObj.name + "上传失败");
        },
        onCancel: function(event, queueID, fileObj){
            alert("取消了" + fileObj.name);
        }
    });


/*编辑器配置*/
    window.UEDITOR_CONFIG.toolbars= [[
            'fullscreen', 'source', '|', 'undo', 'redo', '|',
            'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|',
            'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
            'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',
            'directionalityltr', 'directionalityrtl', 'indent', '|',
            'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|',
            'link', 'unlink', 'anchor', '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
            'simpleupload', 'insertimage', 'emotion', 'scrawl', 'insertvideo', 'music', 'attachment', 'map', 'gmap', 'insertframe', 'insertcode', 'webapp', 'pagebreak', 'template', 'background', '|',

        ]]
    /*实例化编辑器*/
    var ue = UE.getEditor('container');

	$('.button').click(function() {

		var devices = new Array(),
            link = $('#link').val(),
            logo = $('#logo').val(),
            global = 0,
            content = ue.getContent();

        $(".global").each(function(){
            if($(this).attr('checked')){
                global =  $(this).val();
            }
        });

        $('.devices').each(function(){
            if($(this).attr('checked')){
                devices.push($(this).val());
            }
        })


		wintq('正在添加，请稍后...',4,20000,0,'');
		$.ajax({
			url:"<?php echo U('Home/Ad/addAd');?>",
			dataType:'json',
			type:'POST',
			data:{devices:devices,link:link,image:logo,global:global,content:content},
			success: function(data) {
				if (data.status==1) {
					wintq(data.info,1,1500,0,'parent');
				}else {
					wintq(data.info,3,1000,1,'');
				}
			}
		});
	});

    /*全选反选*/
    $('.stores').click(function(){
        var id = $(this).attr('id');
        if($(this).attr('checked')){
            $('.'+id).attr('checked',true);
        }else{
            $('.'+id).attr('checked',false);
        }
    })
});
</script>
</head>
<body>
<div id="content">
	<dl id="dl">
    	<dt>添加广告</dt>
        <dd>
        	<span class="dd_left">所属门店：</span>
            <span class="dd_right" >
                   <?php if(is_array($stores)): $i = 0; $__LIST__ = $stores;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$store_list): $mod = ($i % 2 );++$i;?><dd>
                               <span class="dd_left" style="margin-left:30px;"><input type="checkbox" class="stores" id="store<?php echo ($store_list["id"]); ?>" value="<?php echo ($store_list["id"]); ?>"  /> <?php echo ($store_list["store_name"]); ?>：</span>

                        <?php if(is_array($store_list['device'])): $i = 0; $__LIST__ = $store_list['device'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$device_list): $mod = ($i % 2 );++$i;?><label><input type="checkbox" class="devices store<?php echo ($store_list["id"]); ?>"  value="<?php echo ($device_list["only_code"]); ?>" /> <?php echo ($device_list["device_name"]); ?> &nbsp;
                            </label><?php endforeach; endif; else: echo "" ;endif; ?>

                       </dd><?php endforeach; endif; else: echo "" ;endif; ?>
            </span>
        </dd>
        <!--<dd>-->
        	<!--<span class="dd_left">广告标题：</span>-->
        	<!--<span class="dd_right"><input type="text"  name="title" id="title" class="qtext"  /><font>*请输入广告标题</font></span>-->
        <!--</dd>-->
        <dd>
            <span class="dd_left">广告类型：</span>
            <span class="dd_right">
                <input type="radio"  name="type" checked value="1" />普通广告
                <input type="radio"  name="type"  value="2" />优惠券广告
            </span>
        </dd>
        <dd>
        	<span class="dd_left">广告链接：</span>
        	<span class="dd_right"><input type="text"  name="link" id="link" class="qtext" maxlength="18" /><font>* 请输入一个完整的链接如：http://www.baidu.com</font></span>
        </dd>
        <dd>
            <span class="dd_left">广告图片：</span>
            <span class="dd_right"><input type="file" name="file" id="file" class="qtext"  />
            </span>
            <span id="images" style="margin-left:10px;"></span>
        </dd>
        <?php if(C('ADMIN_AUTH_KEY')): ?><dd>
            <span class="dd_left">是否全局：</span>
            <span class="dd_right">
                <input type="radio" name="global" class="global" checked value="1"   />是
                <input type="radio" name="global" class="global" value="0"  />否
            </span>
            <span id="images" style="margin-left:10px;"></span>
        </dd><?php endif; ?>
        <dd>
            <span class="dd_left">优惠券数量：</span>
            <span class="dd_right">
                <input type="text" name="start_time time" class="qtext w150"  />
            </span>
        </dd>
        <dd>
            <span class="dd_left">开始-结束时间：</span>
            <span class="dd_right">
                <input type="text" name="start_time " id="start_time" class="Wdate" onfocus="WdatePicker({startDate:'%y-%M-01 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true})" />-
                <input type="text" class="Wdate" name="end_time" id="end_time" onfocus="WdatePicker({startDate:'%y-%M-01 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true})" />
            </span>
        </dd>

        <dd>
            <span class="dd_left">广告内容：</span>
            <span class="dd_right">
                 <!-- 加载编辑器的容器 -->
                <script id="container" name="content" type="text/plain">这里写你的初始化内容</script>

            </span>
        </dd>
        <input type="hidden" id="logo" value="" />
        <dd><input type="button" class="button" value="提 交" /></dd>
    </dl>
</div>
</body>
</html>