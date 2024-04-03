<?php

namespace app\admin\controller;

use think\Db;

class Data extends Controller
{
    public function getData()
    {
        $user = $this->getUser();
        $data = $this->param;

        $filter = [
            'user_id' => $data['user_id'],
            'is_delete' => 0
        ];

        isset($data['upload_date']) && $data['upload_date'] && $filter['upload_date'] = $data['upload_date'];

        $list = Db::name('data')
            ->where($filter)
            ->field('id,upload_date,time,path')
            ->order('create_time desc')
            ->select();

        foreach ($list as $key => $val) {
            $time = explode('-', $val['time']);

            $list[$key]['upload_date'] = date('Y-m-d', $val['upload_date']);

            $list[$key]['min_date_time'] =  date('Y-m-d', $val['upload_date']) . ' ' . $time[0] . ':000';
            $list[$key]['max_date_time'] =  date('Y-m-d', $val['upload_date']) . ' ' . $time[1] . ':000';
        }

        return message(0, '获取成功', $list);
    }

    public function delete()
    {
        $user = $this->getUser();
        $data = $this->param;

        $dbData = Db::name('data')
            ->where('id', $data['id'])
            ->where('user_id', $data['user_id'])
            ->where('is_delete', 0)
            ->find();
        if (!$dbData) {
            return message(1, '删除失败');
        }

        Db::name('data')
            ->where('id', $dbData['id'])
            ->where('is_delete', 0)
            ->update([
                'is_delete' => 1,
                'update_time' => time()
            ]);

        return message(0, '删除成功');
    }

    public function getGPSData()
    {
        $user = $this->getUser();
        $data = $this->param;

        $dbData = Db::name('data')
            ->where('id', $data['id'])
            ->where('user_id', $data['user_id'])
            ->where('is_delete', 0)
            ->find();
        if (!$dbData) {
            return message(1, '数据不存在');
        }

        $list = Db::name('data_gps')
            ->where('data_id', $data['id'])
            ->field('latitude,longitude,create_time')
            ->order('create_time desc')
            ->select();
        foreach ($list as $key => $val) {
            $list[$key]['create_time'] = date('Y-m-d H:i', $val['create_time']);
        }


        return message(0, '添加成功', $list);
    }

    public function download()
    {
        $user = $this->getUser();


        $json = [
            'users' => []
        ];


        $users = Db::name('user')
            ->field('password,token,create_time,update_time', true)
            ->order('id desc')
            ->select();
        foreach ($users as $user) {
            $medical_history = Db::name('user_medical_history')
                ->where('user_id', $user['id'])
                ->find();
            $static_data = [
                'id' => $user['id'],
                'name' => $user['name'],
                'surname' => $user['surname'],
                'age' => $user['age'],
                'gender' => $user['gender'],
                'date_of_birth' => date('Y-m-d', $user['date_of_birth']),
                'fiscal_code' => $user['fiscal_code'],
                'address' => $user['address'],
                'phone' => $user['phone'],
                'email' => $user['email'],
                'medical_history' => [
                    'visual_disability' => $medical_history['visual_disability'],
                    'mobility_disability' => $medical_history['mobility_disability'],
                    'wheelchair_user' => $medical_history['wheelchair_user'],
                    'hypertension' => $medical_history['hypertension'],
                    'diabetes' => $medical_history['diabetes'],
                    'asthma' => $medical_history['asthma'],
                    'arthritis' => $medical_history['arthritis']
                ]
            ];

            $dynamic_data = [];

            $datas = Db::name('data')
                ->where([
                    'user_id' => $user['id'],
                    'is_delete' => 0
                ])
                ->order('create_time desc')
                ->select();
            foreach ($datas as $data) {
                $localPath = ROOT_PATH . 'public' . DS . $data['path'];
                $eda = file_get_contents($localPath . '/EDA.json');
                $bvp = file_get_contents($localPath . '/BVP.json');
                $acc = file_get_contents($localPath . '/ACC.json');
                $hr = file_get_contents($localPath . '/HR.json');
                $temp = file_get_contents($localPath . '/TEMP.json');

                $upload_date = date('Y-m-d', $data['upload_date']);

                $dynamic_data[] = [
                    'date_time' => $upload_date . ' ' . $data['time'],
                    'eda' => $eda,
                    'bvp' => $bvp,
                    'acc' => $acc,
                    'hr' => $hr,
                    'temp' => $temp
                ];
            }


            $json['users'][] = [
                'static_data' => $static_data,
                'dynamic_data' => $dynamic_data
            ];
        }

        return message(0, '生成json文件成功', $json);
    }
}
