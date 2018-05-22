<?php
/**
 * Created by IntelliJ IDEA.
 * User: xrain
 * Date: 2018/5/23
 * Time: 00:24
 */

namespace App\Helpsers;


class Conf
{
    private $_string = '';

    public function __construct($str = null)
    {
        if ($str) {
            $this->_string = $str;
        }
    }

    public function clear()
    {
        $this->_string = '';
    }

    public function add($str)
    {
        $this->_string .= $str;
    }

    public function addLine($str = "")
    {
        $this->_string .= $str . PHP_EOL;
    }

    public function get()
    {
        return $this->_string;
    }
}