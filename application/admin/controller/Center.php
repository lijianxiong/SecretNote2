<?php
/**
 * Created by PhpStorm.
 * User: nobita
 * Date: 8/18
 * Time: 9:49
 */

namespace app\admin\controller;
use think\Db;

class Center extends Base
{
    public function index($page=1){
        $path = url('/admin/center/');
        $result = Db::name('content')
            ->where('user_id',$this->userId())
            ->where('del',0)
            ->order('create_time','desc')
            ->paginate(5,true, [
                'page'     => $page,
                'path'     => $path.'[PAGE]'
            ]);
        $page = $result->render();
        $userCategory = $this->getCategory();
        $this->assign([
            'title' => '创作中心',
            'result' => $result,
            'category' =>$userCategory,
            'page' => $page
        ]);
        return $this->fetch('/index');
    }
}