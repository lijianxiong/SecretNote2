<?php
/**
 * Created by PhpStorm.
 * User: nobita
 * Date: 8/10
 * Time: 14:28
 */

namespace app\admin\validate;
use think\Validate;

class Login extends Validate
{
    protected $rule = [
        ['username','require|min:4|max:20'],
        ['password','require']
    ];
}