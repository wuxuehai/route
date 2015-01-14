<?php
/**
 * Created by PhpStorm.
 * User: wuxuehai
 * Date: 15-1-12
 * Time: 下午12:42
 */

namespace Home\Controller;
use Home\Controller;
use Think\Upload;

class UploadController extends CommonController{
    /*上传文件*/
    public function upload(){
        $upload = new Upload();
        if(!$info = $upload->upload()){
            $this->error($upload->getError());
        }

        /*保存文件*/
        $files = D('files');

        $_POST = array(
            'path'=>$info['savepath'].$info['savename'],
        );

        if(!$files->create()){
            $this->error('上传失败');
        }
        $files->add();
        $this->ajaxReturn(array('info'=>$info['Filedata']['savepath'].$info['Filedata']['savename'],status=>1));

    }
}