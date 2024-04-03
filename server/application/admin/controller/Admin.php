<?php

namespace app\admin\controller;

use think\Db;

class Admin extends Controller
{
    public function login()
    {
        $data = $this->param;

        $user = Db::name('admin_user')
            ->where('email', $data['email'])
            ->find();
        if (!$user) {
            return message(1, '用户不存在');
        }
        if (md5('0314_medical_' . $data['password']) != $user['password']) {
            return message(1, '密码错误');
        }

        $token = $this->token($user['id']);

        Db::name('admin_user')
            ->where('id', $user['id'])
            ->update([
                'token' => $token,
                'update_time' => time()
            ]);

        return message(0, '登录成功', [
            'user_id' => $user['id'],
            'token' => $token
        ]);
    }

    public function register()
    {
        $data = $this->param;

        $user = Db::name('admin_user')
            ->where('email', $data['email'])
            ->find();
        if ($user) {
            return message(1, '用户已存在');
        }

        $firstToken = $this->token($data['email']);

        Db::name('admin_user')->insertGetId([
            'password' => md5('0314_medical_' . $data['password']),
            'name' => $data['name'],
            'surname' => $data['surname'],


            'age' => birthday($data['date_of_birth']),


            'gender' => $data['gender'],
            'date_of_birth' => strtotime($data['date_of_birth']),
            'employ_id' => $data['employ_id'],
            'organization_address' => $data['organization_address'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'token' => $firstToken,
            'create_time' => time(),
            'update_time' => time()
        ]);


        return message(0, '注册成功');
    }

    public function detail()
    {
        $user = $this->getUser();
        unset($user['password']);
        return message(0, '获取成功', $user);
    }
}
