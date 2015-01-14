<?php
/**
 * Created by PhpStorm.
 * User: wuxuehai
 * Date: 15-1-8
 * Time: 上午9:36
 */
namespace Home\Controller;
use Home\Controller;

class RbacController extends CommonController{

    /*角色列表*/
    public function roleIndex(){
        $role = D('role');
        $this->role_list = $role->select();
        $this->display();
    }

    /*添加角色*/
    public function addRole(){
        $node = D('node');
        $role = D('role');
        if(!IS_POST){
            $this->node_list = list_to_tree($node->select());
            $this->display();
        }else{
            if(!$role->create()){
                $this->error($role->getError(),'',0);
            }
            if(!$role_id = $role->add()){
                $this->error('添加失败','',0);
            }

            /*把角色的权限添加到权限表*/
            if($comp = I('post.comp',0)){
                $access = D('access');
                /*清空权限*/
                $access->where(array('role_id'=>$role_id))->delete();
                $comp = explode(',',trim($comp,','));
                foreach ($comp as $v){
                    $temp = explode('-',$v);
                    $data = array(
                        'role_id'=>$role_id,
                        'node_id'=>$temp[0],
                        'level'=>$temp[1]
                    );

                    $access->add($data);
                }
            }

            $this->success('添加成功','',1);

        }

    }

    /*编辑角色*/

    public function editRole(){
        $role = D('role');
        $node = D('node');
        $access = D('access');
        if(!IS_POST){
            $id = I('get.id');
            $this->role_info = $role->where(array('id'=>$id))->find();
            $this->node_list = list_to_tree($node->select());
            $this->access_list = $access->where(array('role_id'=>$this->role_info['id']))->getField('node_id',true);

            $this->display();
        }else{
            if(!$role->create()){
                $this->error($role->getError(),'',0);
            }
            $role->save();
            $role_id=I('post.id');


            /*把角色的权限添加到权限表*/
            if($comp = I('post.comp',0)){
                $access = D('access');
                /*清空权限*/
                $access->where(array('role_id'=>$role_id))->delete();
                $comp = explode(',',trim($comp,','));
                foreach ($comp as $v){
                    $temp = explode('-',$v);
                    $data = array(
                        'role_id'=>$role_id,
                        'node_id'=>$temp[0],
                        'level'=>$temp[1]
                    );

                    $access->add($data);
                }
            }

            $this->success('修改成功','',1);
        }

    }

    /*节点列表*/
    public function nodeIndex(){
        $node = D('node');
        $this->node_list = list_to_tree($node->select());
        //print_r($this->node_list);die;
        $this->display();
    }

    /*添加节点*/
    public function addNode(){
        $node = D('node');
        if(!IS_POST){
            $this->type="模块";
            $this->node_list = list_to_tree($node->select());
            $this->pid = I('get.pid',0)?I('get.pid'):0;
            $this->level = I('get.level',0)?I('get.level')+1:1;
            switch ($this->level){
                case 1:
                    $this->type="模块";
                    break;
                case 2:
                    $this->type="控制器";
                    break;
                case 3:
                    $this->type="方法";
                    break;
            }

            $this->display();


        }else{
            if(!$node->create()){
                $this->error($node->getError(),'',0);
            }
            if(!$node->add()){
                $this->error('添加失败','',0);
            }

            $this->success('添加成功','',1);
        }

    }
}
