<?php
/**
 * Created by PhpStorm.
 * User: wuxuehai
 * Date: 15-1-8
 * Time: 上午10:11
 */

namespace Home\Model;
use \Think\Model;

class NodeModel extends Model{
    protected $_validate  = array(
        array('pid','require','ID参数错误，请刷新页面'),
        array('name','require','名称不能为空'),
        array('title','require','标题不能为空'),
        array('status','require','ID参数错误，请刷新页面'),
        array('level','require','ID参数错误，请刷新页面')
    );
}