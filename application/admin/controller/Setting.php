<?php
/**
 * Created by PhpStorm.
 * User: nobita
 * Date: 8/18
 * Time: 11:02
 */

namespace app\admin\controller;


use think\Db;

class Setting extends Base
{
    public function index(){
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
//        $result = Db::name('setting')
//            ->where('type','admin')
//            ->update([
//                'content' => json_encode($data)
//            ]);
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