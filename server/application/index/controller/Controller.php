<?php

namespace app\index\controller;

use think\Db;

class Controller extends Base
{
    protected function getUser($is_force = true)
    {
        if (!$token = $this->request->header('token')) {
            $is_force && $this->throwError('用户未登录');
            return false;
        }
        $detail = Db::name('user')
            ->where('token', $token)
            ->field('password,create_time,update_time', true)
            ->find();
        if (!$detail) {
            $is_force && $this->throwError('登录失效');
            return false;
        }
        return $detail;
    }
}
