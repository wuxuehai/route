<?php
/**
 * Created by PhpStorm.
 * User: wuxuehai
 * Date: 15-1-12
 * Time: 下午2:52
 */

namespace Home\Model;
use Think\Model\RelationModel;

class AdModel extends RelationModel{

    protected $_validate = array(
        array('device','require','参数错误请刷新页面'),
    );
    protected $_auto = array(
        array('create_time',NOW_TIME),
        array('create_user','get_user',3,'callback')
    );

    protected $_link = array(
        'devices'=>array(
            'mapping_type' => self::HAS_MANY,
            'mapping_name' => 'devices',
            'class_name'   => 'AdDevice',
            'foreign_key'  => 'ad_id',
            'mapping_key'  => 'id',
        ),
    );

    public function get_user(){
        return session('username');
    }
}

