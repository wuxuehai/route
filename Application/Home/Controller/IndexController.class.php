<?php
namespace Home\Controller;
use Home\Controller;
class IndexController extends CommonController {

    //后台管理界面首页
    public function index(){
        $this->display();
    }

    public function systeminfo(){
        //获取系统信息
        $info['THINK_VERSION'] = THINK_VERSION;
        $info['SERVER_SOFTWARE'] = $_SERVER["SERVER_SOFTWARE"];
        $info['PHP_OS'] = PHP_OS;
        $info['mysql'] = mysql_get_server_info();
        $this->assign('info',$info);
        $this->display();
    }

    //清除缓存
    public function clearCache() {
            if (I('post.clear','')=='ok') {
                $fileDel = RUNTIME_PATH;
                if (file_exists($fileDel)) {
                    $this->delDir($fileDel);
                    $this->success('清楚缓存成功');
                }else {
                    $this->error('暂无缓存','',0);
                }
            }else {
                $this->error('参数错误','',0);
            }
    }

    //删除缓存文件
    public function delDir($dirName) {
        $dh = opendir($dirName);
        //循环读取文件
        while ($file = readdir($dh)) {
            if($file != '.' && $file != '..') {
                $fullpath = $dirName . '/' . $file;
                //判断是否为目录
                if(!is_dir($fullpath)) {
                    //如果不是,删除该文件
                    if(!unlink($fullpath)) {
                        echo $fullpath . '无法删除,可能是没有权限!<br>';
                    }
                } else {
                    //如果是目录,递归本身删除下级目录
                    $this->delDir($fullpath);
                }
            }
        }
        //关闭目录
        closedir($dh);
        //删除目录
        if(!rmdir($dirName)) {
            R('Public/errjson',array($dirName.'__目录删除失败'));
        }
    }


}
