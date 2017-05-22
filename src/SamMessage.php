<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/5/19
 * Time: 16:57
 */

namespace Lzq\Mqtt;

class SamMessage
{
    public $body;

    public function __construct($body = '')
    {
        if ($body != '') {
            $this->body = $body;
        }
    }
}