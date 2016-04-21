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
    static public $VAR_LIST = [];

    private $name = [];
    private $neg = false;
    private $fetched = false;

    public function __construct($data) {
        $this->name = $data;
    }

    public function prefetch() {
        if (!$this->fetched) {
            $tmp = [];
            foreach ($this->name as $n) {
                if (is_string($n)) {
                    $tmp[] = $n;
                } else {
                    $tmp[] = $n->evaluate();
                }
            }

            $this->name = join('', $tmp);

            if ($this->name[0] == '!') {
                $this->neg = true;
                $this->name = substr($this->name, 1);
            }

            $this->fetched = true;
        }
    }

    public function is_neg() {
        return $this->neg;
    }

    public function is_set() {
        $this->prefetch();
        $exists = array_key_exists($this->name, static::$VAR_LIST);

        return $this->neg ? !$exists : $exists;
    }

    public function exists() {
        $this->prefetch();
        return isset(static::$VAR_LIST[$this->name]);
    }

    public function evaluate() {
        $this->prefetch();
        return static::$VAR_LIST[$this->name];
    }
}