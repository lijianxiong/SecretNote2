<?php
/**
 * Created by PhpStorm.
 * User: nobita
 * Date: 8/10
 * Time: 15:51
 */

namespace app\admin\controller;
use think\Db;

class Article extends Base
{
    public function show($id){
        $data = input('post.');
        $id = $data['id'];
        $result = Db::name('content')
            ->where('id', $id)
            ->where('user_id', $this->userId())
            ->find();
        return json_encode($result);
    }

    public function write($id=0){
        $id     = $id > 0 ? intval($id) : 0;
        $title = $id == 0 ? '开始创作' : '编辑创作';
        if ($id > 0){
            $result = Db::name('content')
                ->where('id',$id)
                ->where('user_id',$this->userId())
                ->find();
        }
        $result = [
            'id' => $id > 0 ? $result['id'] : '',
            'title' => $id > 0 ? $result['title'] : '',
            'category_id' => $id > 0 ? $result['category_id'] : '',
            'create_time' => $id > 0 ? date('Y-m-d H:i:s',$result['create_time']) : date("Y-m-d H:i:s",time()),
            'description' => $id > 0 ? $result['description'] : '',
            'content' => $id > 0 ? $result['content'] : '',
            'update_time' => $id > 0 ? $result['update_time'] : date("Y-m-d H:i:s",time())
        ];
        $userCategory = $this->userCategory();
        $this->assign([
            'title' => $title,
            'nav_cur' => 'write',
            'userCategory' => $userCategory,
            'data' => $result
        ]);
        return $this->fetch('write');
    }

    public function update(){
        $data  = input('post.');
        if (empty($data['title'])){
            return $this->redirect('/admin/article/write');
        }
        $time = strtotime($data['create_time']);
        $insertData = [
            'title' => htmlspecialchars(@$data['title']),
            'category_id' => @$data['category_id'],
            'create_time' => $time,
            'description' => @$data['description'],
            'content' => @$data['content'],
            'update_time' => htmlspecialchars($time),
            'user_id' => $this->userId()
        ];
        $id    = intval($data['id']);
        if ($id == 0){
            $result = Db::name('content')
                ->data($insertData)
                ->insert();
        }else{
            $result = Db::name('content')
                ->where('id',$id)
                ->update($insertData);
            if ($result) {
                return $this->redirect('/admin');
            }
        }
        if ($result) {
            return $this->redirect('/admin');
        } else {
            return $this->Tips('/admin/article/write','发布失败，请重新编辑',1);
        }
    }
}