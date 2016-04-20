<?php
/**
 * Created by PhpStorm.
 * User: lobster
 * Date: 4/20/16
 * Time: 2:51 PM
 */

namespace Quas\Expr;


class Variable extends Expression
{
    public static $VAR_LIST = [];

    protected $name;

    protected $negative = false;

    public function setData($data) {
        $this->name = $data[0]['data'];

        if ($this->name[0] == '!') {
            $this->name = substr($this->name, 1);
            $this->negative = true;
        }
    }

    public function evaluate() {
        return static::$VAR_LIST[$this->name];
    }

    public function exists() {
        return isset(static::$VAR_LIST[$this->name]);
    }

    public function is_set() {
        return $this->negative ? !isset(static::$VAR_LIST[$this->name]) : isset(static::$VAR_LIST[$this->name]);
    }
}