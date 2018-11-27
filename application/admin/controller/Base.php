<?php
/**
 * Created by PhpStorm.
 * User: nobita
 * Date: 2018/8/7
 * Time: 17:37
 */

namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\View;
use think\Db;
use think\Session;

class Base extends Controller
{
    public $_N;
    protected $userResult;
    public function _initialize()
    {
        parent::_initialize();
        $setting = Session::get('setting');
        //read userinfo
        $this->userResult = Session::get('user');
        $flag = $this->userResult['id'];
        if (!$flag) {
            $this->redirect('/admin/login');
            return false;
        }
        //定义公共目录和主题目录
        $this->_N['public']     = '/';
        $this->_N['theme_path'] = './theme/admin/';
        //主图视图实例化
        $this->view = new View([
            'type'          => 'php',
            'view_path'     => $this->_N['theme_path'],
            'view_suffix'   => 'php',
            'view_depr'     => '/',
        ]);
        if(!defined('__THEME__')){
            define('__THEME__','./theme/admin');
            define('__PUBLIC__','/theme/admin');
        }
        $this->assign(
            [
                'title' => $setting['site_name'],
                'description' => $setting['description'],
                'setting' => $setting,
                'userInfo' => $this->userResult,
                'navBar' => $this->navBar(),
                '_n' => $this->_N
            ]
        );
    }
    public function userId(){
        $userId = $this->userResult['id'];
        return $userId;
    }

    public function userCategory(){
        $GetCategoryAll = Db::name('category')
        ->where('user_id',$this->userId())
        ->where('del',0)
        ->select();
        return $GetCategoryAll;
    }

    public function navBar() {
        return [
            [
                ['article', '/admin/center', '<i class="czs-pen-write"></i> 创作中心']
            ],
            [
                ['bookmark', '/admin/bookmark', '<i class="czs-book-l"></i> 收藏中心']
            ],
            [
                ['links', '/admin/links', '<i class="czs-share"></i> 外链中心']
            ],
            [
                ['category', '/admin/category', '<i class="czs-newspaper-l"></i> 创作分类']
            ],
            [
                ['trash', '/admin/trash/', '<i class="czs-trash-l"></i> 回收的箱']
            ],
            [
                ['setting', '/admin/setting/', '<i class="czs-setting-l"></i> 网站设置']
            ]
        ];
    }

    public function getCategory(){
        $result = Db::name('category')
            ->where('user_id',$this->userId())
            ->where('del' , 0)
            ->select();
        $category = [];
        foreach($result as $v){
            $category[$v['id']] = $v['name'];
            $category[$v['slug']] = $v['name'];
        }
        return $category;
    }

    public function state($result){
        if ($result){
            echo 1;
        }else{
            echo 2;
        }
    }

    public function upload(Request $request){
        // 获取表单上传文件
        //$file = $request->file('file');
        $file = \think\Image::open(request()->file('editormd-image-file'));
        $dirTime = iconv("UTF-8", "GBK", ROOT_PATH . 'public' . DS . 'upload/'.$this->userId().'/images/'.date('Ym',time()));
        if (file_exists($dirTime));
        else
            mkdir ($dirTime,0777,true);
        $fileUrl = $dirTime. DS .md5(time()).'.jpg';
        $width = $file->width();
        if ($width >= 2048){
            $info = $file->thumb(1440,900)->save($fileUrl);
        }else{
            $info = $file->save($fileUrl);
        }
        if ($info) {
            $faceurl = strstr($fileUrl,"/upload");
            $result = array(
                'success'=>1,
                'message'=>'上传成功啦!',
                'url'=>$faceurl
            );
            return json_encode($result);
        } else {
            // 上传失败获取错误信息
            $this->error($file->getError());
        }
    }

    public function findResult($dbname,$id){
        $result = Db::name($dbname)
            ->where('user_id',$this->userId())
            ->where('id',$id)
            ->find();
        return $result;
    }

    public function selectResult($dbname,$param){
        $result = Db::name($dbname)
            ->where($param)
            ->find();
        return $result;
    }

    public function deleteResult($dbname,$id){
        $result = Db::name($dbname)
            ->where('id',$id)
            ->where('user_id',$this->userId())
            ->delete();
        return $result;
    }

    public function updateResult($dbname,$id,$param){
        $result = Db::name($dbname)
            ->where('id',$id)
            ->where('user_id',$this->userId())
            ->update($param);
        return $result;
    }

    protected function randNum($id){
        $str = 'abcdefghijklnmopqrstuvwxyz';
        $links = substr(str_shuffle($str),0,2).$id;
        return $links;
    }

    public function action($id){
        $data = input('post.');
        $type = $data['type'];
        $dbname = $data['dbname'];
        if ($type == 'del'){
            $param = ['del' => 1];
            $result = $this->updateResult($dbname,$id,$param);
            return $this->state($result);
        }
        if ($type == 'unTrash'){
            $param = ['del' => 0];
            $result = $this->updateResult($dbname,$id,$param);
            return $this->state($result);
        }
        if ($type == 'destroy'){
            $result = $this->deleteResult($dbname,$id);
            return $this->state($result);
        }
        if ($type == 'notice'){
            $result = $this->deleteResult($dbname,$id);
            return $this->state($result);
        }
        if ($type == 'star'){
            $article = $this->findResult($dbname,$id);
            $star = $article['star'];
            if ($star == 0){
                $param = ['star' => 1];
                $this->updateResult($dbname,$id,$param);
                return 1;
            }else{
                $param = ['star' => 0];
                $this->updateResult($dbname,$id,$param);
                return 2;
            }
        }
        if ($type == 'link'){
            $article = $this->findResult($dbname,$id);
            $link = intval($article['links']);
            $links = $this->randNum($id);
            if ($link == 1){
                $param = ['links' => $links];
                $this->updateResult($dbname,$id,$param);
                return 1;
            }else{
                $param = ['links' => 1];
                $this->updateResult($dbname,$id,$param);
                return 2;
            }
        }
        if ($type == 'linkel'){
            $param = ['links' => 1];
            $result = $this->updateResult($dbname,$id,$param);
            return $this->state($result);
        }
        if ($type == 'star'){
            $result = $this->findResult($dbname,$id);
            $star = $result['star'];
            if ($star == 0){
                $param = ['star' => 1];
                $this->updateResult($dbname,$id,$param);
                return 1;
            }else{
                $param = ['star' => 0];
                $this->updateResult($dbname,$id,$param);
                return 2;
            }
        }
    }
}