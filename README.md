# ThinkPHP-OAuth2
本套程序基于ThinkPHP3.2.3开发，其他版本做些小修改也能使用。

使用方法：
（1）导入数据库文件oauth2db.sql到数据库

（2）把OAuth2文件夹放到ThinkPHP/Library/Vendor目录下

（3）在需要使用到OAuth2的应用的配置或全局配置加上以下内容

    //自定义命名空间
    'AUTOLOAD_NAMESPACE' => array(
    	'OAuth2' => THINK_PATH.'Library/Vendor/OAuth2',
    ),

    //OAuth2数据库配置
    'OAUTH2_CONFIG' =>  array(
	'DSN' => 'mysql:dbname=oauth2db;host=localhost',	//数据库DSN
	'USERNAME' => 'root',					//数据库用户名
	'PASSWORD' => '123456',					//数据库密码
    ),

（4）把Home目录放到Application应用目录下


第三方授权测试

第一步
浏览器打开URL
http://localhost/index.php/Home/Index/authorize?response_type=code&client_id=testclient&state=xyz

返回结果实例
授权码为035a11e40a0adab678e8be6f03781f9e7318e667


第二步
curl -u testclient:testpass http://localhost/index.php/Home/Index/token -d 'grant_type=authorization_code&code=xxxx'
其中xxxx为刚才获取到的code码

返回结果实例
{
  "access_token": "c59ae24ab36a0dc73b1b5f3344c2e68a0dbea328",
  "expires_in": 3600,
  "token_type": "Bearer",
  "scope": null,
  "refresh_token": "b515fa502546e8afc8094b3a6850d62e453d2f9a"
}


第三步
curl http://localhost/index.php/Home/Index/resource -d 'access_token=YOUR_TOKEN'
YOUR_TOKEN为token接口返回的access_token参数

返回结果实例
{
  "success": true,
  "openId": "6297218d3cf1f6f9fcb5cdf09287a4c2"
}

