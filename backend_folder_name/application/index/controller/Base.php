<?php

namespace app\index\controller;

use think\Controller;
use app\common\exception\BaseException;

class Base extends Controller
{
    protected $param;

    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        $this->param = $this->request->param();
    }

    protected function token($id)
    {
        $guid = getGuidV4();
        $timeStamp = microtime(true);
        return md5("{$timeStamp}_{$id}_{$guid}_user");
    }

    protected function throwError($msg)
    {
        throw new BaseException(['code' => -1, 'msg' => $msg]);
    }
}
