<?php
/**
 * Created by PhpStorm.
 * User: wuxuehai
 * Date: 15-1-9
 * Time: 上午9:37
 */
namespace Home\Controller;

use Home\Controller\CommonController;

class SystemController extends CommonController{

    //设置视图
    public function index(){
        $this->display();
    }

    //处理设置
    public function setting(){
        if(!IS_POST){
            $this->error('非法访问');
        }else{
            if(is_array($_POST)){
                foreach ($_POST as $k=>$v){
                   C($k,$k);
                }
            }

            $this->success('设置成功');
        }
    }
}