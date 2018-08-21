<?php
/**
 * Created by PhpStorm.
 * User: nobita
 * Date: 8/17
 * Time: 14:52
 */

namespace app\admin\controller;
use think\Db;

class Trash extends Base
{
    public function index(){
        $data = Db::name('content')
            ->where('user_id',$this->userId())
            ->where('del',1)
            ->select();
        $category = $this->getCategory();
        $this->assign([
            'title' => '回收站',
            'nav_cur' => 'trash',
            'result' => $data,
            'category' => $category
        ]);
        return $this->fetch('/trash');
    }
}