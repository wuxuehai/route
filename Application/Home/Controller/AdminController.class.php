<?php
/**
 * Created by PhpStorm.
 * User: wuxuehai
 * Date: 15-1-7
 * Time: 下午1:24
 */

namespace Home\Controller;
use Home\Controller;

class AdminController extends CommonController {
    protected $table='admin';

    public function editPassword(){
        if(!IS_POST){
            $this->display();
        }else{
            $admin = D('admin');

            //验证表单规则
            $validate = array(
                array('nickname','require','昵称不能为空'),
                array('password','require','密码不能为空'),
                array('repassword','require','确认密码不能为空'),
                array('repassword','password','两次密码不正确',2,'confirm')
            );
            if(!$admin->validate($validate)){
                $this->error($this->getError(),'',0);
            }

            //修改数据
            $data = array(
                'id'=>$_SESSION['id'],
                'nickname'=>I('post.nickname'),
                'password'=>I('post.password','','md5')
            );

            $admin->save($data);

            session('nickname',I('post.nickname'));

            $this->success('修改成功','',1);

        }

    }

    /*用户列表*/
    public function index(){
        $admin = D('admin');
        $this->admin_list = $admin->select();
        $this->display();
    }

    /*添加用户*/
    public function addUser(){
        $role = D('role');
        $admin = D('admin');
        $sotre = D('store');
        $role_user = D('role_user');
        if(!IS_POST){
            $this->role_list = $role->select();
            $this->store_list = $sotre->field('id,store_name')->select();
            $this->display();
        }else{
            $_POST['pid']=$_POST['roleid'];
            $_POST['password']=md5($_POST['password']);
            $_POST['repassword']=md5($_POST['repassword']);
            if(!$admin->create()){
                $this->error($admin->getError(),'',0);
            }
            if(!$uid = $admin->add()){
                $this->error('添加失败','',0);
            }

            $role_user->add(array('role_id'=>I('post.roleid'),'user_id'=>$uid));

            $this->success('添加成功','',1);


        }

    }

    /*编辑用户*/
    public function editUser(){
        $id = I('get.id');
        $admin = D('admin');
        $sotre = D('store');
        $role = D('role');
        if(!IS_POST){
            $user_info = $admin->where(array('id'=>$id))->find();
            $user_info['stores'] = unserialize($user_info['stores']);
            $this->user_info = $user_info;
            $this->store_list = $sotre->field('id,store_name')->select();
            $this->role_list = $role->select();
            $this->display();
        }else{
            $role_user = D('role_user');

            $password = I('password',0);
            $data=array(
                'id'=>I('post.id'),
                'user_name'=>I('post.user_name'),
                'pid'=>I('post.roleid'),
                'stores'=>I('post.stores'),
                'status'=>I('post.status')
            );

            if(!empty($password)){
                $data['password']=md5($password);
                $data['repassword']=md5(I('repassword',0));
            }
            $_POST=$data;

            if(!$admin->create()){
                $this->error($admin->getError(),'',0);
            }

            $admin->save();

            $role_user->where(array('user_id'=>I('post.id')))->save(array('role_id'=>I('post.pid')));

            $this->success('修改成功','',1);

        }

    }
}