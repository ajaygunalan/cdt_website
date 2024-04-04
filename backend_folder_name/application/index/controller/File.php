<?php

namespace app\index\controller;

use think\Db;
use app\common\library\FileLock;
use Exception;

class File extends Controller
{
    public function upload()
    {
        $user = $this->getUser();

        $lockKey = 'upload_lock_' . $user['id'];

        FileLock::lockUp($lockKey);

        try {
            $file = request()->file('file');
            $info = $file->validate(['size' => 1048576 * 10, 'ext' => 'json'])
                ->move(ROOT_PATH . 'public' . DS . 'resource' . DS . 'json');
            if ($info) {
                // $path = request()->domain() . '/resource/json/' . str_replace(DS, '/', $info->getSaveName());
                $json = json_decode(file_get_contents(ROOT_PATH . 'public' . DS . 'resource' . DS . 'json' . DS . str_replace(DS, '/', $info->getSaveName())), true)['users'][0];

                $static_data = $json['static_data'];
                Db::name('user')
                    ->where('id', $user['id'])
                    ->update([
                        // 'username' => $static_data['username'],
                        'name' => $static_data['name'],
                        'surname' => $static_data['surname'],
                        'age' => birthday($static_data['date_of_birth']),
                        'gender' => $static_data['gender'],
                        'date_of_birth' => strtotime($static_data['date_of_birth']),
                        'fiscal_code' => $static_data['fiscal_code'],
                        'address' => $static_data['address'],
                        'phone' => $static_data['phone'],
                        'update_time' => time()
                    ]);
                Db::name('user_medical_history')
                    ->where('user_id', $user['id'])
                    ->update([
                        'hypertension' => $static_data['medical_history']['hypertension'] ? 1 : 0,
                        'diabetes' => $static_data['medical_history']['diabetes'] ? 1 : 0,
                        'asthma' => $static_data['medical_history']['asthma'] ? 1 : 0,
                        'arthritis' => $static_data['medical_history']['arthritis'] ? 1 : 0,
                        'update_time' => time()
                    ]);


                $dynamic_data = $json['dynamic_data'];

                $time_duration = explode('-', $dynamic_data['time_duration']);
                $viewToken = md5('0314_' . $user['id'] . $user['email']);
                $date = date('Ymd');

                $path = 'resource' . DS . 'json' . DS . 'chart' . DS  . $viewToken . DS . $date . DS . str_replace(':', '', $time_duration[0]) . str_replace(':', '', $time_duration[1]);
                $localPath = ROOT_PATH . 'public' . DS . $path;
                if (!file_exists($localPath)) {
                    mkdir($localPath, 0755, true);
                }

                $this->reFile($localPath, 'EDA.json');
                $this->reFile($localPath, 'BVP.json');
                $this->reFile($localPath, 'ACC.json');
                $this->reFile($localPath, 'HR.json');
                $this->reFile($localPath, 'TEMP.json');

                file_put_contents($localPath . DS . 'EDA.json', json_encode($dynamic_data['EDA']['values']));
                file_put_contents($localPath . DS . 'BVP.json', json_encode($dynamic_data['BVP']['values']));
                file_put_contents($localPath . DS . 'ACC.json', json_encode($dynamic_data['ACC']['values']));
                file_put_contents($localPath . DS . 'HR.json', json_encode($dynamic_data['HR']['values']));
                file_put_contents($localPath . DS . 'TEMP.json', json_encode($dynamic_data['TEMP']['values']));


                $isExistDb = Db::name('data')
                    ->where('user_id', $user['id'])
                    ->where('upload_date', strtotime($date))
                    ->where('time', $dynamic_data['time_duration'])
                    ->where('is_delete', 0)
                    ->find();
                if (!$isExistDb) {
                    Db::name('data')->insert([
                        'upload_date' => strtotime($date),
                        'time' => $dynamic_data['time_duration'],
                        'path' => $path,
                        'user_id' => $user['id'],
                        'create_time' => time(),
                        'update_time' => time()
                    ]);
                }


                FileLock::unLock($lockKey);

                return message(0, '上传成功');

                $memoryUsage = memory_get_usage();
                $memoryUsageMB = round($memoryUsage / 1024 / 1024, 2);
                // return message(0, '上传成功', $memoryUsageMB . "MB");
            } else {
                FileLock::unLock($lockKey);
                return message(1, '上传失败1');
            }
        } catch (Exception $e) {
            FileLock::unLock($lockKey);
            return message(1, '上传失败2');
        }
    }

    private function reFile($path, $fileName)
    {
        if (file_exists($path . DS . $fileName)) {
            if (rename($path . DS . $fileName, $path . DS . 'back_' . microtime_float() . '_' . $fileName)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
