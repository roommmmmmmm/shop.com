<?php
return array(
	/* 数据库设置 */
	'DB_TYPE'               =>  'mysql',     // 数据库类型
	'DB_HOST'               =>  '127.0.0.1', // 服务器地址
	'DB_NAME'               =>  'tpshop',          // 数据库名
	'DB_USER'               =>  'root',      // 用户名
	'DB_PWD'                =>  '123123',          // 密码
	'DB_PORT'               =>  '3306',        // 端口
	'DB_PREFIX'             =>  'xz_',    // 数据库表前缀
	'DB_DEBUG'  			=>  TRUE, // 数据库调试模式 开启后可以记录SQL日志
	'DB_FIELDS_CACHE'       =>  true,        // 启用字段缓存
	'DB_CHARSET'            =>  'utf8',      // 数据库编码默认采用utf8

	/*图片上传配置*/
	'IMAGE_CONFIG'=>array(
		'maxSize' => 1024*1024,
		'exts' => array('jpg','gif','png','jpeg'),
		'rootPath' => './Public/Uploads/', //上传保存路径（硬盘路径）
		'savePath' => 'Goods/',
		'viewPath' => '/Public/Uploads' //显示图片路径（前端使用）
	),
);
