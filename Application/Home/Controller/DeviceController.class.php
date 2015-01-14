<?php
/**
 * Created by PhpStorm.
 * User: wuxuehai
 * Date: 15-1-7
 * Time: 下午4:53
 */
namespace Home\Controller;

use Home\Controller;
use Think\Page;
class DeviceController extends CommonController{
    protected $table = 'device';

    public function index(){
        $device = D($this->table);
        $count = $device->count();
        $page = new Page($count,C('PAGE_LIMIT'));
        $device_list = $device->limit($page->firstRow.','.$page->listRows)->select();
        $show = $page->show();
        $this->assign('page',$show);
        $this->assign('device_list',$device_list);
        $this->display();
    }

    public function addDevice(){
        if(!IS_POST){
            $store = D('store');
            $store_list = $store->select();
            $this->assign('store_list',$store_list);
            $this->display();
        }else{
            $device = D($this->table);
            if(!$device->create()){
                $this->error($device->getError(),'',0);
            }
            if(!$device->add()){
                $this->error('添加失败','',0);
            }

            $this->success('添加成功',U('Home/Device/addDevice'),1);
        }

    }

    public function editDevice(){
        $device = D($this->table);
        if(!IS_POST){
            $store = D('store');
            $store_list = $store->select();
            $this->assign('store_list',$store_list);

            $device = $device->where(array('id'=>I('get.id')))->find();
            $this->assign('device',$device);
            $this->display();
        }else{
            $validate = array(
                array('id','require','ID参数错误'),
                array('store_id','require','ID参数错误'),
                array('device_name','require','设备名称不能为空'),
                array('only_code','require','设备唯一标识不能为空'),
                array('device_mac','require','设备MAC地址不能为空')
            );
            if(!$device->validate($validate)){
                $this->error($device->getError(),'',0);
            }

            if(!$device->save($_POST)){
                $this->error('修改失败','',0);
            }

            $this->success('修改成功',U('Home/Store/editStore',array('id'=>I('post.id')),''),1);
        }
    }
}
