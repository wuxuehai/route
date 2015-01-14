<?php
/**
 * Created by PhpStorm.
 * User: wuxuehai
 * Date: 15-1-12
 * Time: 下午1:54
 */

namespace Home\Model;
use Think\Model;

class FilesModel extends Model{
    protected $_auto = array(
        array('create_time',NOW_TIME),
        array('create_user','get_user',3,'callback'),
    );

    public function get_user(){
        return $_SESSION['username'];
    }
}