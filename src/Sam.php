<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/5/19
 * Time: 16:34
 */

namespace Lzq\Mqtt;

class Sam
{
    protected $eol;

    public function __construct()
    {
        $this->eol = "\n";
        if (isset($_SERVER['REQUEST_URI'])) {
            $this->eol = '<br>';
        }
    }

    protected function e($s)
    {
        echo '-->'.$s."$this->eol";
    }

    protected function t($s)
    {
        echo '   '.$s."$this->eol";
    }

    protected function x($s)
    {
        echo '<--'.$s."$this->eol";
    }
}