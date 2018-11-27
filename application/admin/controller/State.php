<?php
/**
 * Created by PhpStorm.
 * User: nobita
 * Date: 10/11
 * Time: 10:29
 */

namespace app\admin\controller;


use think\Controller;

class State extends Controller
{
    public function index(){
        $data = input('get.');
        $token = $data['token'];
        if ($token == 'snafleerror'){
            $sendMail = new Mailhelper();
            $sendMail->sendMail('4020426@qq.com','信息流推广页面出错啦!',date('Y-m-d H:i:s',time()).'微信号显示文件不正常，请尽快修复!');
        }
    }
}