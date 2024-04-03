<?php

namespace app\admin\controller;

use think\Db;

class User extends Controller
{
    public function getList()
    {

        $user = $this->getUser();

        $list = Db::name('user')
            ->field('password,token,create_time,update_time', true)
            ->order('id desc')
            ->select();
        foreach ($list as $key => $val) {
            $list[$key]['medical_history'] = Db::name('user_medical_history')
                ->where('user_id', $val['id'])
                ->find();
        }

        return message(0, '获取成功', $list);
    }
}
