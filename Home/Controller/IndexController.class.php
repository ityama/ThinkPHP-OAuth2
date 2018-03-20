<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {

	protected $storage = null;	//OAuth2 数据连接对象
	protected $server = null;	//OAuth2 Server对象

	function __construct(){
		$dsn = C('OAUTH2_CONFIG')['DSN'];
		$username = C('OAUTH2_CONFIG')['USERNAME'];
		$password = C('OAUTH2_CONFIG')['PASSWORD'];

		//\OAuth2\Autoloader::register();
 
		// $dsn is the Data Source Name for your database, for exmaple "mysql:dbname=my_oauth2_db;host=localhost"
		$this->storage = new \OAuth2\Storage\Pdo(array('dsn' => $dsn, 'username' => $username, 'password' => $password));
 
		// Pass a storage object or array of storage objects to the OAuth2 server class
		$this->server = new \OAuth2\Server($this->storage);
 
		// Add the "Client Credentials" grant type (it is the simplest of the grant types)
		$this->server->addGrantType(new \OAuth2\GrantType\ClientCredentials($this->storage));
 
		// Add the "Authorization Code" grant type (this is where the oauth magic happens)
		$this->server->addGrantType(new \OAuth2\GrantType\AuthorizationCode($this->storage));
	}

	public function index(){

	}

    public function authorize(){
        $request = \OAuth2\Request::createFromGlobals();
		$response = new \OAuth2\Response();
 
		// validate the authorize request
		if (!$this->server->validateAuthorizeRequest($request, $response)) {
    		$response->send();
    		die;
		}

		$is_authorized = true;
    	$userid = 1; // A value on your server that identifies the user
    	$this->server->handleAuthorizeRequest($request, $response, $is_authorized, $userid);
    	if ($is_authorized) {
    	  	// this is only here so that you get to see your code in the cURL request. Otherwise, we'd redirect back to the client
    	  	$code = substr($response->getHttpHeader('Location'), strpos($response->getHttpHeader('Location'), 'code=')+5, 40);
    	  	echo '授权码为'.$code;
    	}

    }


    public function token(){
    	$this->server->handleTokenRequest(\OAuth2\Request::createFromGlobals())->send();
    }


    public function resource(){
    	if (!$this->server->verifyResourceRequest(\OAuth2\Request::createFromGlobals())) {
    		$this->server->getResponse()->send();
    		die;
		}

		$token = $this->server->getAccessTokenData(\OAuth2\Request::createFromGlobals());
		//这里使用MD5(用户ID+ClientID)生成用户openid
		$openid = hash('MD5',$token['user_id'].$token['client_id']);
		$this->ajaxReturn(array('success' => true, 'openId' => $openid));
    }

}