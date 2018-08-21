<?php
/**
 * Created by PhpStorm.
 * User: nobita
 * Date: 8/17
 * Time: 17:12
 */

namespace app\index\controller;
use think\Controller;
use think\Db;

class Openlinks extends Controller
{
    public function index($code){
//        $result = $this->queryDate($code);
//        if ($result['links'] == 1){
//            return false;
//        }else{
//            $this->assign([
//                'title' => $result['title'],
//                'data' => $result
//            ]);
//        }
        $this->assign([
            'code' => $code
        ]);
        return view();
    }
    public function show(){
        $data = input('get.');
        $code = $data['code'];
        $result = Db::name('content')
            ->where('links',$code)
            ->find();
        return json_encode($result);
    }
}