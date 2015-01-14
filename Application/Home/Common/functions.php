<?php
/**
 * Created by PhpStorm.
 * User: wuxuehai
 * Date: 15-1-7
 * Time: 下午6:03
 */

function getStoreName($id){
    $store = D('store');
    return $store->where(array('id'=>$id))->getField('store_name');
}