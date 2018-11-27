<?php
/**
 * Created by PhpStorm.
 * User: nobita
 * Date: 8/18
 * Time: 11:02
 */

namespace app\admin\controller;
use think\Session;
use think\Db;

class Setting extends Base
{
    public function index(){
        $isAdmin = $this->userResult['user_group'];
        if ($isAdmin !== 1){
            return $this->redirect('/admin/center');
        }
        $result = Db::name('setting')
            ->where('type','admin')
            ->value('content');
        $data = json_decode($result,true);
        $this->assign([
            'title' => '网站设置',
            'nav_cur' => 'setting',
            'data' => $data
        ]);
        return $this->fetch('/setting');
    }
    public function update(){
        $data = input('post.');
        $result = Db::name('setting')
            ->where('type','admin')
            ->update([
                'content' => json_encode($data)
            ]);
        if ($result){
            return $this->redirect('/admin/setting');
        }else{
            return $this->redirect('/admin/setting');
        }
    }
}