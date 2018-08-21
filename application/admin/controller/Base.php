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
    public function _initialize()
    {
        parent::_initialize();
        $flag = Session::get('user.id');
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
        $resultSetting = Db::name('setting')
            ->where('type','admin')
            ->value('content');
        $setting = json_decode($resultSetting,true);
        //read userinfo
        $userResult = Db::name('user')
        ->where('id',$this->userId())
        ->find();
        $this->assign(
            [
                'title' => $setting['site_name'],
                'description' => $setting['description'],
                'setting' => $setting,
                'userInfo' => $userResult,
                'navBar' => $this->navBar(),
                '_n' => $this->_N
            ]
        );
    }
    public function userId(){
        $userId = Session::get('user.id');
        return $userId;
    }

    public function userCategory(){
        $GetCategoryAll = Db::name('category')
            ->where('user_id', $this->userId())
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
        $dirTime = iconv("UTF-8", "GBK", ROOT_PATH . 'public' . DS . 'upload/images/'.date('Ym',time()));
        if (file_exists($dirTime));
        else
            mkdir ($dirTime,0777,true);
        $fileUrl = $dirTime. DS .md5(time()).'.jpg';
        $width = $file->width();
        if ($width >= 1280){
            $info = $file->thumb(1280,720)->save($fileUrl);
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

    public function action($id){
        $data = input('post.');
        $type = $data['type'];
        $dbname = $data['dbname'];
        if ($type == 'del'){
            $result = Db::name($dbname)
                ->where('id',$id)
                ->where('user_id',$this->userId())
                ->update([
                    'del' => 1
                ]);
            return $this->state($result);
        }
        if ($type == 'untrash'){
            $result = Db::name($dbname)
                ->where('id',$id)
                ->where('user_id',$this->userId())
                ->update(
                    [
                        'del' => 0
                    ]
                );
            return $this->state($result);
        }
        if ($type == 'destroy'){
            $result = Db::name($dbname)
                ->where('id',$id)
                ->where('user_id',$this->userId())
                ->delete();
            return $this->state($result);
        }
        if ($type == 'notice'){
            $result = Db::name($dbname)
                ->where('id',$id)
                ->delete();
            return $this->state($result);
        }
        if ($type == 'star'){
            $article = Db::name($dbname)
                ->where('user_id',$this->userId())
                ->where('id',$id)
                ->find();
            $star = $article['star'];
            if ($star == 0){
                Db::name($dbname)
                    ->where('user_id',$this->userId())
                    ->where('id',$id)
                    ->update([
                        'star' => 1
                    ]);
                return 1;
            }else{
                Db::name($dbname)
                    ->where('user_id',$this->userId())
                    ->where('id',$id)
                    ->update([
                        'star' => 0
                    ]);
                return 2;
            }
        }
        if ($type == 'share'){
            $result = Db::name($dbname)
                ->where('id',$id)
                ->where('user_id',$this->userId())
                ->find();
            $array = [];
            for ($i = 1; $i <= 2; $i++) {
                $array[$i] = chr(rand(97, 122));
            }
            $random = implode('',$array);
            $links = $random.$id;
            if ($result['links'] == 1){
                $res = Db::name($dbname)
                    ->where('id',$id)
                    ->where('user_id',$this->userId())
                    ->update([
                        'links' => $links,
                        'status' => 1
                    ]);
                return $this->state($res);
            }else{
                Db::name($dbname)
                    ->where('id',$id)
                    ->where('user_id',$this->userId())
                    ->update([
                        'links' => 1,
                        'status' => 1
                    ]);
                return 2;
            }
        }
        if ($type == 'link'){
            $article = Db::name($dbname)
                ->where('user_id',$this->userId())
                ->where('id',$id)
                ->find();
            $link = intval($article['links']);
            $array = [];
            for ($i = 1; $i <= 2; $i++) {
                $array[$i] = chr(rand(97, 122));
            }
            $random = implode('',$array);
            $links = $random.$id;
            if ($link == 1){
                Db::name($dbname)
                    ->where('user_id',$this->userId())
                    ->where('id',$id)
                    ->update(
                        [
                            'links' => $links
                        ]
                    );
                return 1;
            }else{
                Db::name($dbname)
                    ->where('user_id',$this->userId())
                    ->where('id',$id)
                    ->update(
                        [
                            'links' => 1
                        ]
                    );
                return 2;
            }
        }
        if ($type == 'linkdel'){
            $result = Db::name($dbname)
                ->where('user_id',$this->userId())
                ->where('id',$id)
                ->update(
                    [
                        'links' => 1
                    ]
                );
            return $this->state($result);
        }
        if ($type == 'star'){
            $result = Db::name($dbname)
                ->where('user_id',$this->userId())
                ->where('id',$id)
                ->find();
            $star = $result['star'];
            if ($star == 0){
                Db::name($dbname)
                    ->where('user_id',$this->userId())
                    ->where('id',$id)
                    ->update(
                        [
                            'star' => 1
                        ]
                    );
                return 1;
            }else{
                Db::name($dbname)
                    ->where('user_id',$this->userId())
                    ->where('id',$id)
                    ->update(
                        [
                            'star' => 0
                        ]
                    );
                return 2;
            }
        }
    }
}