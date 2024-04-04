<?php

namespace app\common\exception;

use think\Config;
use think\exception\Handle;
use think\Log;
use Exception;

class Z_Exception extends Handle
{
    private $code;
    private $msg;
    private $data;

    public function render(\Exception $e)
    {
        if ($e instanceof BaseException) {
            $this->code = $e->code;
            $this->msg = $e->msg;
            $this->data = $e->data;
        } else {
            if (Config::get('app_debug')) {
                return parent::render($e);
            }
            $this->code = 1;
            $this->msg = '系统错误';
            $this->data = null;
        }
        $result = [
            'code' => $this->code,
            'msg' => $this->msg,
            'data' => $this->data
        ];
        $this->recordErrorLog($e);
        return json($result);
    }

    /**
     * 将异常写入日志
     * @param Exception $e
     */
    private function recordErrorLog(Exception $e)
    {
        Log::record($e->getMessage(), 'error');
        Log::record($e->getTraceAsString(), 'error');
    }
}
