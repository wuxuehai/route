<?php
/**
 * Created by PhpStorm.
 * User: wuxuehai
 * Date: 15-1-7
 * Time: 下午3:12
 */

namespace Home\Model;
use \Think\Model\RelationModel;

class StoreModel extends RelationModel{

    protected $_link = array(
        'device'=>array(
            'mapping_type' => self::HAS_MANY,
            'foreign_key'  => 'store_id',
            'mapping_fields' =>'id,device_name,only_code',
        ),
    );

    protected $_validate = array(
        array('store_name','require','门店名称不能为空'),
        array('store_name','','门店名称已存在！',0,'unique',1),
        array('store_phone','require','门店联系电话不能为空'),
        array('store_address','require','门店联系地址不能为空')
    );

    protected $_auto = array(
        array('create_time',NOW_TIME)
    );
}