<?php
/**
 * Created by PhpStorm.
 * User: wuxuehai
 * Date: 15-1-8
 * Time: 上午10:10
 */

namespace Home\Model;

use \Think\Model;

class RoleModel extends Model{
    protected $_validate=array(
        array('name','require','组名不能为空'),
        array('name','','组名已存在！',0,'unique',1),
        array('remark','require','描述不能为空')
    );
}