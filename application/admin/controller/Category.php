<?php
/**
 * Created by PhpStorm.
 * User: nobita
 * Date: 8/16
 * Time: 17:41
 */

namespace app\admin\controller;
use think\Db;

class Category extends Base
{
    public function index(){
        $data = Db::name('category')
            ->where('user_id',$this->userId())
            ->order('id','desc')
            ->where('del',0)
            ->select();
        $this->assign([
            'title' => '创作分类',
            'nav_cur' => 'category',
            'data' => $data
        ]);
        return $this->fetch('/category');
    }
    public function update($id=0){
        $data = input('post.');
        if (empty($data['name'])){
            return $this->redirect('/admin/category');
        }
        $insertData = [
            'name' => $data['name'],
            'slug' => $data['slug'],
            'user_id' => $this->userId()
        ];
        if ($id == 0){
            $result = Db::name('category')
                ->data($insertData)
                ->insert();
        }else{
            $result = Db::name('category')
                ->where('id',$id)
                ->update($insertData);
            if ($result) {
                return $this->redirect('/admin/category');
            }
        }
        if ($result) {
            return $this->redirect('/admin/category');
        } else {
            return $this->redirect('/admin/category');
        }
    }
    public function edit($id){
        $getCategory = Db::name('category')
            ->where('user_id',$this->userId())
        ->where('id',$id)
        ->find();
        return $getCategory;
    }

    public function show($id){
        $data = Db::name('content')
            ->where('user_id',$this->userId())
            ->where('category_id',$id)
            ->where('del',0)
            ->select();
        $category = Db::name('category')
            ->where('user_id',$this->userId())
            ->where('id',$id)
            ->find();
        $categoryName = $category['name'];
        $result = $this->getCategory();
        $this->assign([
            'title' => $categoryName.'的所有文章',
            'result' => $data,
            'category' => $result
        ]);
        return $this->fetch('./index');
    }
}