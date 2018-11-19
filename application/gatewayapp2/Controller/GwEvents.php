<?php
namespace app\gatewayapp\controller;
 
use GatewayWorker\Lib\Gateway;

use think\Session;
 
/**
 * 主逻辑
 * 主要是处理 onConnect onMessage onClose 三个方法
 * onConnect 和 onClose 如果不需要可以不用实现并删除
 */
class GwEvents {
 
    /**
     * 当客户端连接时触发
     * 如果业务不需此回调可以删除onConnect     *
     * @param int $client_id 连接id
     */
    public static function onConnect($client_id) {
        // Gateway::binduid($client_id,$req_data['user']);
        // 向当前client_id发送数据
        Gateway::sendToClient($client_id,'连接成功');
        // 向所有人发送
        // $arr = array('marry','feng','peng','wary','link');
        // Gateway::sendToAll(sprintf('用户 %s 已登录！',$client_id));

    }
 
    /**
     * 当客户端发来消息时触发
     * @param int $client_id 连接id
     * @param mixed $message 具体消息
     */
    public static function onMessage($client_id, $message) {

        $req_data = json_decode($message, true);
        //绑定

        if($req_data['type'] == 'login'){
            Gateway::binduid($client_id,$req_data['user']);
            Gateway::sendToAll(sprintf('用户 %s 已登录！',$req_data['user']));
        }else{
            // 向所有人发送
            Gateway::sendToAll(sprintf('用户 %s 说：%s',$req_data['user'],$req_data['message']));
        }
       
       
    }
 
    /**
     * 当用户断开连接时触发
     * @param int $client_id 连接id
     */
    public static function onClose($client_id) {
        // 向所有人发送
        GateWay::sendToAll(sprintf('用户 %s 已退出！',$client_id));
    }
 
}