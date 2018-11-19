<?php
namespace app\gatewayapp\controller;
 
use GatewayWorker\Lib\Gateway;

use think\Session;
use app\gatewayapp\controller\Base;
 
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
            //模拟数据库
            // $data = array('feng', 'ma','wang','li');
            Gateway::setSession($client_id, array('user_name'=>$req_data['user']));
            Gateway::sendToAll(sprintf('%s 用户 %s 已登录！',$client_id,$req_data['user']));
        //单独聊天
        }elseif(!empty($req_data['to_client'])){
            $Session = Gateway::getSession($client_id);
            Gateway::sendToUid($req_data['to_client'], $req_data['message']);
            Gateway::sendToClient($client_id,$req_data['message']);
        }elseif(!empty($req_data['group'])){
            $Session = Gateway::getSession($client_id);
            Gateway::joinGroup($client_id, $req_data['group']);
            Gateway::sendToClient($client_id,sprintf('%s 用户 %s 建组成功！',$client_id,$Session['user_name']));
        }elseif(!empty($req_data['join'])){
            $Session = Gateway::getSession($client_id);
           
            Gateway::sendToGroup($req_data['join'], sprintf('%s 用户 %s 说:%s',$client_id,$Session['user_name'],$req_data['message']));
            // Gateway::sendToClient($client_id,sprintf('%s 用户 %s 说:%s',$client_id,$Session['user_name'],$req_data['message']));
            $group = Gateway::getClientSessionsByGroup($req_data['join']);
            // if(isset($group[$client_id]))
             var_export($group[$client_id]);
             
        }else{
            $Session = Gateway::getSession($client_id);
            // 向所有人发送
            Gateway::sendToAll(sprintf('%s 用户 %s 说：%s',$client_id,$Session['user_name'],$req_data['message']));
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