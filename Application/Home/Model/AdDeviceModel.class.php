<?php
/**
 * Created by PhpStorm.
 * User: wuxuehai
 * Date: 15-1-14
 * Time: 上午11:36
 */

namespace Home\Model;

use \Think\Model\RelationModel;


class AdDeviceModel extends RelationModel{
    protected $tableName = 'ad_device';

    protected $_link = array(
        'ad'=>array(
            'mapping_type' => self::BELONGS_TO,
            'foreign_key' => 'id',
        ),
    );
}