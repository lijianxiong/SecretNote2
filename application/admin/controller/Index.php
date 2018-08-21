<?php
/**
 * Created by PhpStorm.
 * User: nobita
 * Date: 2018/8/7
 * Time: 17:51
 */

namespace app\admin\controller;


use think\Db;

class Index extends Base
{
    public function index(){
        return $this->redirect('/admin/center');
//        $path = url('admin/index/index/');
//        $result = Db::name('content')
//            ->where('user_id',$this->userId())
//            ->where('del',0)
//            ->order('create_time','desc')
//            ->paginate(3,true, [
//                'page'     => $pg,
//                'path'     => $path.'[PAGE]'
//            ]);
//        $page = $result->render();
//        $userCategory = $this->getCategory();
//        $this->assign([
//            'title' => '创作中心',
//            'result' => $result,
//            'category' =>$userCategory,
//            'page' => $page
//        ]);
//        return $this->fetch('/index');
    }

    public function bookmark(){
        $result = Db::name('content')
            ->where('user_id',$this->userId())
            ->where('del',0)
            ->where('star',1)
            ->order('create_time','desc')
            ->select();
        $userCategory = $this->getCategory();
        $this->assign([
            'title' => '收藏中心',
            'nav_cur' => 'bookmark',
            'result' => $result,
            'category' =>$userCategory
        ]);
        return $this->fetch('/index');
    }
}