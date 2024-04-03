<?php

namespace app\index\controller;

use think\Db;

class Data extends Controller
{
    public function getData()
    {
        $user = $this->getUser();
        $data = $this->param;

        $filter = [
            'user_id' => $user['id'],
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
            ->where('user_id', $user['id'])
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
            ->where('user_id', $user['id'])
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

    public function addGPSData()
    {
        $user = $this->getUser();
        $data = $this->param;

        $dbData = Db::name('data')
            ->where('user_id', $user['id'])
            ->where('is_delete', 0)
            ->where('upload_date', strtotime(date("Y-m-d")))
            ->where("CURTIME() BETWEEN TIME_FORMAT(SUBSTRING_INDEX(time, '-', 1), '%H:%i:%s') AND TIME_FORMAT(SUBSTRING_INDEX(time, '-', -1), '%H:%i:%s')")
            ->order('create_time desc')
            ->find();

        if ($dbData) {
            Db::name('data_gps')->insert([
                'data_id' => $dbData['id'],
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
                'create_time' => time()
            ]);
        }

        return message(0, '添加成功');
    }
}
