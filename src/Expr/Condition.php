<?php
namespace Quas\Expr;

/**
 * Class Condition
 * @package Quas\Expr
 */
class Condition extends Expression
{
    private $text = [];
    private $vars = [];

    public function __construct($src) {
        parent::__construct($src);

        foreach ($this->data as $d) {
            if ($d instanceof Variable) {
                $this->vars[] = count($this->text);
                $this->text[] = $d;
            }
            else {
                $this->text[] = $d;
            }
        }
    }

    /**
     * Evaluate conditional expression
     *
     * @return string
     */
    public function evaluate() {
        foreach ($this->vars as $var) {
            if (!$this->text[$var]->is_set()) {
                return '';
            }
        }

        foreach ($this->text as $key => $value) {
            if (!is_string($value)) {
                if ($value instanceof Variable) {
                    if (!$value->is_neg()) {
                        $this->text[$key] = $value->evaluate();
                    } else {
                        $this->text[$key] = '';
                    }
                }
                else {
                    $this->text[$key] = $value->evaluate();
                }
            }
        }

        return $this->modify_result(preg_replace('/\s{2,}/', ' ', join('', $this->text)));
    }
}