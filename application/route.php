<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;
Route::rule('openlinks/[:code]','index/openlinks/index');
//Route::rule('openlinks/show/[:code]','index/openlinks/show');
Route::rule('admin/bookmark','admin/index/bookmark');
Route::rule('admin/links','admin/index/links');
Route::rule('admin/center/[:page]','admin/center/index');
//Route::rule('admin/category','admin/index/category');
//Route::rule('admin/category/update','admin/category/update');
//Route::rule('admin/category/edit/[:id]','admin/category/edit');