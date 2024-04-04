<?php

namespace app\index\controller;

use think\Db;

class User extends Controller
{
    public function login()
    {
        $data = $this->param;

        $user = Db::name('user')
            ->where('email', $data['email'])
            ->find();
        if (!$user) {
            return message(1, '用户不存在');
        }
        if (md5('0314_medical_' . $data['password']) != $user['password']) {
            return message(1, '密码错误');
        }

        $token = $this->token($user['id']);

        Db::name('user')
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

        $user = Db::name('user')
            ->where('email', $data['email'])
            ->find();
        if ($user) {
            return message(1, '用户已存在');
        }

        $firstToken = $this->token($data['email']);

        $res = Db::transaction(function () use ($data, $firstToken) {
            $userId = Db::name('user')->insertGetId([
                // 'username' => $data['username'],
                'password' => md5('0314_medical_' . $data['password']),
                'name' => $data['name'],
                'surname' => $data['surname'],


                'age' => birthday($data['date_of_birth']),


                'gender' => $data['gender'],
                'date_of_birth' => strtotime($data['date_of_birth']),
                'fiscal_code' => $data['fiscal_code'],
                'address' => $data['address'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'token' => $firstToken,
                'create_time' => time(),
                'update_time' => time()
            ]);

            Db::name('user_medical_history')->insert([
                'visual_disability' => $data['medical_history']['visual_disability'],
                'mobility_disability' => $data['medical_history']['mobility_disability'],
                'wheelchair_user' => $data['medical_history']['wheelchair_user'],
                'hypertension' => $data['medical_history']['hypertension'],
                'diabetes' => $data['medical_history']['diabetes'],
                'asthma' => $data['medical_history']['asthma'],
                'arthritis' => $data['medical_history']['arthritis'],
                'user_id' => $userId,
                'create_time' => time(),
                'update_time' => time()
            ]);

            return true;
        });
        if (!$res) {
            return message(1, '注册失败');
        }


        return message(0, '注册成功');
    }

    public function detail()
    {
        $user = $this->getUser();
        unset($user['password']);

        $user['date_of_birth'] = date('Y-m-d', $user['date_of_birth']);

        $user['medical_history'] = Db::name('user_medical_history')
            ->where('user_id', $user['id'])
            ->find();
        return message(0, '获取成功', $user);
    }
}
