<?php
/**
 * Created by PhpStorm.
 * User: nobita
 * Date: 8/17
 * Time: 14:27
 */

namespace app\admin\controller;
use think\Db;

class Search extends Base
{
    public function index(){
        $data = input('get.');
        $keyword = $data['keyword'];
        $result = Db::name('content')
            ->where('user_id',$this->userId())
            ->where('title|content','like','%'.$keyword.'%')
            ->where('del',0)
            ->select();
        $category = $this->getCategory();
        $this->assign([
            'title' => $keyword.'的搜索结果',
            'result' => $result,
            'category' => $category
        ]);
        return $this->fetch('./index');
    }
}