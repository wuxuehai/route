<?php
/**
 * Created by PhpStorm.
 * User: wuxuehai
 * Date: 15-1-12
 * Time: 上午10:38
 */

namespace Home\Controller;
use Home\Controller;

class Adcontroller extends CommonController{
    public $table = 'ad';

    public function index(){
        $ad = D('ad');
        $where = session(C('ADMIN_AUTH_KEY'))?'':array('create_user'=>session('username'));
        $this->ad_list = $ad->where($where)->select();

        $this->display();
    }

    public function addAd(){

        if(!IS_POST){
            /*获取session_id*/
            $this->getSessionId();

            $store = D('store');

            if(!session(C('ADMIN_AUTH_KEY'))){
                $this->stores = $store->where(array('id'=>array('in',session('stores'))))->field('id,store_name')->relation(true)->select();
            }else{
                $this->stores = $store->field('id,store_name')->relation(true)->select();
            }

            if(empty($this->stores)){
                $this->error('你管理的门店为空！请联系管理员');
            }



            $this->display();
        }else{

           $data =  array(
                'devices' => array(array('devices' =>'设备唯一标识'), array('devices' => '门店4')),
                'link' =>'',
                'image' =>'',
                'global' => 1,
                'content' => '<p>这里写你的初始化内容</p>'
           );

           //print_r($_POST);die;

            $ad = D('ad');
            if(!$ad->create()){
                $this->error($ad->getError(),'',0);
            }
            if(!$ad->relation(true)->add($data)){
                $this->error('添加失败','',0);
            }

            $this->success('添加成功','',1);
        }

    }

    public function editAd(){
        if(!IS_POST){
            /*获取session_id*/
            $this->getSessionId();

            $store = D('store');
            $ad = D('ad');

            if(!session(C('ADMIN_AUTH_KEY'))){
                $this->stores = $store->where(array('id'=>array('in',session('stores'))))->field('id,store_name')->select();
            }else{
                $this->stores = $store->field('id,store_name')->select();
            }

            if(empty($this->stores)){
                $this->error('你管理的门店为空！请联系管理员');
            }
            $this->ad_info = $ad->where(array('id'=>I('get.id')))->find();
            //$this->ad_info['content']=html_entity_decode($this->ad_info['content']);

            if(!$this->ad_info){
                $this->error('参数错误！');
            }
            $this->display();
        }else{

            /*判断该门店--判断ad_id*/
            if(!$this->checkStoreId(I('post.sid',0)) || !I('post.id',0)){
                $this->error('参数错误,请刷新页面');
            }



            $data = array(
                'id'=>I('post.id',0),
                'sid'=>I('post.sid',0),
                'title'=>I('post.title',''),
                'link'=>I('post.link',''),
                'image'=>I('post.logo',''),
                'content'=>I('post.content','',false),
                'global'=>C('ADMIN_AUTH_KEY')?I('post.global'):0
            );

            /*未传Logo就不做修改*/
            if(empty($data['image'])){
                unset($data['image']);
            }

            $_POST=$data;

            $ad = D('ad');
            if(!$ad->create()){
                $this->error($ad->getError(),'',0);
            }
            if(!$ad->save()){
                $this->error('编辑失败','',0);
            }

            $this->success('编辑成功','',1);
        }
    }

    /*删除*/
    public function del(){

        if(!$this->checkStoreId(I('post.id',true))){
            $this->error('参数错误');
        }

        if(I('get.all')){
            $id =I('post.id');
            $id = explode(',',$id);
            $where = array('id'=>array('in',$id));
        }else{
            $id = I('post.id');
            $where = array('id'=>$id);
        }

        $model = D($this->table);
        if($model->where($where)->delete()){
            $this->success('删除成功','',1);
        }else{
            $this->error('删除失败','',0);
        }
    }


    /**
     * 检查是否是自己管理的门店
     * @param string $id  字符串单个ID或,链接长字符串
     * @param bool $ex   为真则用,号分割成数组
     * @return bool
     */
    public function checkStoreId($id='',$ex=false){

        /*如果是超级管理员*/
        if(C('ADMIN_AUTH_KEY')){
            return true;
        }

        if(!(session('stores'))){
            return false;
        }
        if(!$ex){
            if(!in_array($id,session('stores'))){
                return false;
            }
        }else{
            $id=explode(',',trim($id,','));

            foreach ($id as $v){
                if(!in_array($v,session('stores'))){
                    return false;
                }
            }

        }


        return true;
    }


}