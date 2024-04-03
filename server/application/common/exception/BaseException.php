<?php

namespace app\common\exception;

use \Exception;

class BaseException extends Exception
{
    public $code = 1;
    public $msg = 'ERROR';
    public $data = null;

    public function __construct($params = [])
    {
        if (!is_array($params)) {
            return;
        }
        if (array_key_exists('code', $params)) {
            $this->code = $params['code'];
        }
        if (array_key_exists('msg', $params)) {
            $this->msg = $params['msg'];
        }
        if (array_key_exists('data', $params)) {
            $this->data = $params['data'];
        }
    }
}
