<?php
return array(

    //'配置项'=>'配置值'
    'DB_TYPE'      =>  'mysql',     // 数据库类型
    'DB_HOST'      =>  '127.0.0.1',     // 服务器地址
//    'DB_NAME'      =>  'bak',     // 数据库名
//    'DB_USER'      =>  'bak',     // 用户名
//    'DB_PWD'       =>  'Ta121212',     // 输入安装MySQL时设置的密码
    'DB_NAME'      =>  'route',     // 数据库名
    'DB_USER'      =>  'root',     // 用户名
    'DB_PWD'       =>  'root',     // 输入安装MySQL时设置的密码
    'DB_PORT'      =>  '3306',     // 端口
    'DB_PREFIX'    =>  'tp_',     // 数据库表前缀
    'DB_DSN'       =>  '',     // 数据库连接DSN 用于PDO方式


	//'URL_CASE_INSENSITIVE' =>true,
	//'URL_MODEL'=>2,   //URL模式

    /*RBAC认证配置*/
    'USER_AUTH_ON'              =>true,
    'USER_AUTH_TYPE'            =>1,        // 默认认证类型 1 登录认证 2 实时认证
    'USER_AUTH_KEY'             =>'id',    // 用户认证SESSION标记
    'ADMIN_AUTH_KEY'            =>'admin',
    'USER_AUTH_MODEL'           =>'admin',    // 默认验证数据表模型
    'AUTH_PWD_ENCODER'          =>'md5',    // 用户认证密码加密方式
    'USER_AUTH_GATEWAY'         =>'/Home/Public/login',// 默认认证网关
    'NOT_AUTH_MODULE'           =>'Public',    // 默认无需认证模块
    'REQUIRE_AUTH_MODULE'       =>'',        // 默认需要认证模块
    'NOT_AUTH_ACTION'           =>'systemInfo,editPassword',        // 默认无需认证操作
    'REQUIRE_AUTH_ACTION'       =>'',        // 默认需要认证操作
    'GUEST_AUTH_ON'             =>false,    // 是否开启游客授权访问
    'GUEST_AUTH_ID'             =>0,        // 游客的用户ID
    'RBAC_ROLE_TABLE'           =>'tp_role',
    'RBAC_USER_TABLE'           =>'tp_role_user',
    'RBAC_ACCESS_TABLE'         =>'tp_access',
    'RBAC_NODE_TABLE'           =>'tp_node',

    /*加载扩展配置*/
    'LOAD_EXT_CONFIG'=>'setting'


);
