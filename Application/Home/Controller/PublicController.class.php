<?php
/**
 * Created by PhpStorm.
 * User: wuxuehai
 * Date: 15-1-7
 * Time: 上午10:06
 *
 * 公共控制器，不需要RBAC验证的方法！
 */
namespace Home\Controller;
use \Think\Controller;
use \Think\Verify;
use Org\Util\Rbac;

class PublicController extends Controller {

    /**
     * 用户登录
     */
    public function login(){
        if(!IS_POST){
            $this->display();
        }else{
            $admin = D('admin');
            if(!$admin->validate()){
                $this->error($this->getError());
            }
            if(!$this->checkVerify(I('post.verify'))){
                $this->error('验证码不正确','',0);
            }

            if(!$this->loginHandel(I('post.username'),I('post.password'))){
                $this->error('用户名或密码错误','',0);
            }

            $this->success('登录成功！',U('Home/Index/index'),1);

        }
    }

    public function loginOut(){
        session(null);
        $this->success('退出成功！');
    }

    /**
     * 生成验证码
     */
    public function verify(){
        $config = array(
            'fontSize'  =>  25,              // 验证码字体大小(px)
            'useCurve'  =>  true,            // 是否画混淆曲线
            'useNoise'  =>  true,            // 是否添加杂点
            'imageH'    =>  38,               // 验证码图片高度
            'imageW'    =>  100,               // 验证码图片宽度
            'length'    =>  2,               // 验证码位数
            'fontttf'   =>  '',              // 验证码字体，不设置随机获取
            'bg'        =>  array(243, 251, 254),  // 背景颜色
            'reset'     =>  true,
        );
        $verify = new Verify($config);
        $verify->entry();
    }

    /**
     * @param $code
     * @return bool
     * 验证验证码是否正确
     */
    public function checkVerify($code){
        $verify = new Verify();
        return $verify->check($code);
    }

    public function loginHandel($username,$password){
        $admin = D('admin');
        $userInfo = $admin->where(array('user_name'=>$username))->find();
        if(!$userInfo || md5($password)!=$userInfo['password']){
            return false;
        }
        session('id',$userInfo['id']);
        session('username',$userInfo['user_name']);
        session('nickname',$userInfo['nickname']);
        session('last_time',$userInfo['last_time']);
        session('last_ip',$userInfo['last_ip']);
        session('stores',unserialize($userInfo['stores']));
        session(C('ADMIN_AUTH_KEY'),session(id)==1?1:0);
        $rbac = new Rbac();

        $rbac::saveAccessList();

        /*更新登录数据*/
        $data=array(
            'id'=>$userInfo['id'],
            'last_time'=>NOW_TIME,
            'last_ip'=>get_client_ip()
        );
        $admin->save($data);

        return true;
    }
}
