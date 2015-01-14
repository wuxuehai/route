<?php
/**
 * Created by PhpStorm.
 * User: wuxuehai
 * Date: 15-1-7
 * Time: 下午2:59
 */


namespace Home\Controller;
use Home\Controller;
use Think\Page;
class StoreController extends CommonController {

    protected $table = 'store';
    public function index(){
        $store = D($this->table);
        $count = $store->count();
        $page = new Page($count,C('PAGE_LIMIT'));
        $store_list = $store->limit($page->firstRow.','.$page->listRows)->select();
        $show = $page->show();
        $this->assign('page',$show);
        $this->assign('store_list',$store_list);
        $this->display();
    }

    /**
     *
     * 添加门店
     */
    public function addStore(){
        if(!IS_POST){
            $this->display();
        }else{
            $store = D($this->table);
            if(!$store->create()){
                $this->error($store->getError(),'',0);
            }

            if($store->add()){
                $this->success('添加成功！','',1);
            }
        }

    }

    public function editStore(){
        $store = D($this->table);
        if(!IS_POST){
            $store = $store->where(array('id'=>I('get.id')))->find();
            $this->assign('store',$store);
            $this->display();
        }else{
            $validate = array(
                array('id','require','ID参数错误'),
                array('store_name','require','门店名称不能为空'),
                array('store_phone','require','门店联系电话不能为空'),
                array('store_address','require','门店联系地址不能为空')
            );
            if(!$store->validate($validate)){
                $this->error($store->getError(),'',0);
            }

            if(!$store->save($_POST)){
                $this->error('修改失败','',0);
            }

            $this->success('修改成功',U('Home/Store/editStore',array('id'=>I('post.id')),''),1);
        }
    }
}