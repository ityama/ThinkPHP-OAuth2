<?php
return array(
	//'配置项'=>'配置值'

	'AUTOLOAD_NAMESPACE' => array(
    	'OAuth2' => THINK_PATH.'Library/Vendor/OAuth2',
	),

	//OAuth2数据库配置
	'OAUTH2_CONFIG' =>  array(
		'DSN' => 'mysql:dbname=oauth2db;host=localhost',	//数据库DSN
		'USERNAME' => 'root',								//数据库用户名
		'PASSWORD' => '12332168',							//数据库密码
	),

);