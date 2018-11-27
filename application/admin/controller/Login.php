<?php
/**
 * Created by PhpStorm.
 * User: nobita
 * Date: 2018/8/7
 * Time: 17:37
 */

namespace app\admin\controller;
use think\Controller;
use think\Session;
use think\View;
use think\Db;

class Login extends Controller
{
    public $_N;
    public function index(){
        $flag = Session::get('user.id');
        if($flag){
            $this->redirect('/admin/center');
            return false;
        }
        //获取form提交数据
        $data   = input('post.');
        $result = $this->validate($data,'Login');
        if($result === true){
            $password = htmlspecialchars($data['password']);
            $validate = htmlspecialchars($data['username']);
            $user = $user = Db::name('user')->where('username',$validate)->whereOr('email',$validate)->find();
            if (!empty($user)){
                if ($user['username'] === $validate || $user['email'] === $validate ){
                    if ($user['password'] == md5(sha1($password))){
                        $siteSetting = Db::name('setting')
                            ->where('type','admin')
                            ->value('content');
                        $setting = json_decode($siteSetting,true);
                        $settingArray = [
                            'site_name' => $setting['site_name'],
                            'admin_email' => $setting['admin_email'],
                            'web_url' => $setting['web_url'],
                            'keyword' => $setting['keyword'],
                            'description' => $setting['description']
                        ];
                        Session::set('setting',$settingArray);
                        $userArray = [
                            'id' => $user['id'],
                            'username' => $user['username'],
                            'nickname' => $user['nickname'],
                            'email' => $user['email'],
                            'face_url' => $user['face_url'],
                            'description' => $user['description'],
                            'user_group' => $user['user_group']
                        ];
                        Session::set('user',$userArray);
                        //$sendMail = new Mailhelper();
                        //$sendMail->sendMail('4020426@qq.com','账号登录提醒!',date('Y-m-d H:i:s',time()).'登录成功!IP地址为:'.$this->getIp());
                        return $this->redirect('/admin/center');
                    }
                }
            }
        }
        $this->assign(
            [
                'title' => '开始登陆'
            ]
        );
        return view();
    }
    public function Logout(){
        Session::clear();
        $this->redirect('/admin');
    }

    //获取用户IP地址
    public function getIp()
    {
        if(!empty($_SERVER["HTTP_CLIENT_IP"])) {
            $cip = $_SERVER["HTTP_CLIENT_IP"];
        }
        else if(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        }
        else if(!empty($_SERVER["REMOTE_ADDR"])) {
            $cip = $_SERVER["REMOTE_ADDR"];
        }
        else {
            $cip = '';
        }
        preg_match("/[\d\.]{7,15}/", $cip, $cips);
        $cip = isset($cips[0]) ? $cips[0] : 'unknown';
        unset($cips);
        return $cip;
    }
}