<?php
namespace app\gatewayapp\controller;
 
use think\Controller;
use GatewayWorker\Lib\Gateway;
// use app\gatewayapp\controller\Base;
 
class Index extends Controller
{
 
    public function index() {
        return $this->fetch();
    }

    /*用户登录方法*/
    public function login(){
            // $user = model('User')->where(['user_phone'=>$this->params['user_phone']])->find();
            //将客户端ID与用户名绑定成UID
            // Gateway::bindUid($this->client_id,$user['user_phone']);
            // //保存客户端在socket服务端的session
            // wmsession($this->client_id,['user_id'=>$user['user_id'],'uid'=>$user['user_phone'],'role_id'=>$user['user_role_id'],'token'=>$token]);
            //         //构建并返回信息给客户端
            // Gateway::sendToClient($this->client_id, wmjson(['status'=>0,'message'=>'登录成功','controller'=>'index','action'=>'login']));
        // echo $this->client_id;
    }
}