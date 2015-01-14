<?php
/**
 * Created by PhpStorm.
 * User: wuxuehai
 * Date: 15-1-7
 * Time: 下午5:03
 */

namespace Home\Model;

use \Think\Model;

class DeviceModel extends Model{
    protected $_validate = array(
        array('device_name','require','设备名称不能为空'),
        array('device_name','','该设备已存在！',0,'unique',1),
        array('only_code','require','设备唯一标识不能为空'),
        array('device_mac','require','设备mac不能为空'),
        array('store_id','require','请选择所属门店')
    );

    protected $_auto = array(
        array('create_time',NOW_TIME)
    );
}