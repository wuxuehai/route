<?php
/**
 * Created by PhpStorm.
 * User: wuxuehai
 * Date: 15-1-7
 * Time: 下午6:03
 */


/*获取门店名称*/
function getStoreName($id){
    $store = D('store');
    return $store->where(array('id'=>$id))->getField('store_name');
}

/*获取管理分组名称*/
function getRoleName($id){
    $role = D('role');
    return $role->where(array('id'=>$id))->getField('name');
}