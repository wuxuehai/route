<?php
/**
 * Created by PhpStorm.
 * User: wuxuehai
 * Date: 15-1-7
 * Time: 下午1:02
 */

namespace Home\Controller;
use \Think\Controller;
use Org\Util\Rbac;

class CommonController extends Controller{

    public function _initialize(){

        /*重建session*/
        $token = I('post.token',0);
        if($token){
            session_id($token) && session_start();
        }

        /*实例化RBAC*/
        $rbac = new Rbac();

        /*检测登录*/
        $rbac::checkLogin();

        /*权限检测*/
        if(!$rbac::AccessDecision()){
            $this->error('没有权限');
        }

    }

    //获取sessionId
    public function getSessionId(){
        $this->token = session_id();
    }


    public function del(){
        if(I('get.all')){
            $id =I('post.id');
            $id = explode(',',$id);
            $where = array('id'=>array('in',$id));
        }else{
            $id = I('post.id');
            $where = array('id'=>$id);
        }

        if($this->table=='admin' && $id==1){
            $this->error('系统默认管理员不能删除','',0);
        }


        $model = D($this->table);
        if($model->where($where)->delete()){
            $this->success('删除成功','',1);
        }else{
            $this->error('删除失败','',0);
        }
    }
}
