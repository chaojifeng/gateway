<?php
namespace app\gatewayapp\controller;
use think\Controller;
/**
* 公共文件
*/
class Base extends Controller
{
	public $client_id;
	// public function __construct()
	// {
	
	// }

	public function client($client){
		echo $this->client_id = $client;
	}
	

	public function index(){
		echo $this->client_id;
	}
}