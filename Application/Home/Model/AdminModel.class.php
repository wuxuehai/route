<?php
/**
 * Created by PhpStorm.
 * User: wuxuehai
 * Date: 15-1-7
 * Time: 上午10:29
 */

namespace Home\Model;
use \Think\Model;

class AdminModel extends Model{
    protected $_validate=array(
        array('user_name','require','用户名不能为空'),
        array('user_name','','帐号名称已经存在！',0,'unique',1),
        array('password','require','密码不能为空'),
        array('repassword','require','确认密码不能为空'),
        array('repassword','password','两次密码不正确',2,'confirm')
    );

    protected $_auto = array(
        array('create_time',NOW_TIME),
        array('stores','get_stores',3,'callback')
    );

    /*处理门店信息*/
    public function get_stores(){
        if($_POST['stores']){
            return serialize(explode(',',trim($_POST['stores'],',')));
        }
    }

}