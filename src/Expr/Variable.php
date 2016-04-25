<?php
namespace Quas\Expr;

/**
 * Class UndefinedVariable
 * @package Quas\Expr
 */
class UndefinedVariable extends \Exception {}

/**
 * Class Variable
 * @package Quas\Expr
 */
class Variable extends Expression
{
    static public $VAR_LIST = [];

    private $name = [];
    private $neg = false;
    private $fetched = false;

    public function __construct($data) {
        $this->name = $data;
    }

    /**
     * Precompile nested variable to get final name
     */
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

    /**
     * Return true if this is negative expression
     *
     * @return bool
     */
    public function is_neg() {
        $this->prefetch();
        return $this->neg;
    }

    /**
     * Checks if variable match condition
     *
     * @return bool
     */
    public function is_set() {
        $this->prefetch();
        $exists = array_key_exists($this->name, static::$VAR_LIST);

        return $this->neg ? !$exists : $exists;
    }

    /**
     * Checks if variable exists in source list
     *
     * @return bool
     */
    public function exists() {
        $this->prefetch();
        return isset(static::$VAR_LIST[$this->name]);
    }

    /**
     * Evaluate variable expression
     *
     * @return mixed
     * @throws UndefinedVariable
     */
    public function evaluate() {
        $this->prefetch();

        if (!isset(static::$VAR_LIST[$this->name])) {
            throw new UndefinedVariable($this->name);
        }

        return static::$VAR_LIST[$this->name];
    }
}