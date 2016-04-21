<?php
/**
 * Created by PhpStorm.
 * User: lobster
 * Date: 4/20/16
 * Time: 2:51 PM
 */

namespace Quas\Expr;


class Condition extends Expression
{
    private $text = [];
    private $vars = [];

    public function __construct($data) {
        foreach ($data as $d) {
            if (is_string($d)) {
                $this->text[] = $d;
            }
            else {
                $this->vars[] = count($this->text);
                $this->text[] = $d;
            }
        }
    }

    public function evaluate() {
        foreach ($this->vars as $var) {
            if (!$this->text[$var]->is_set()) {
                return '';
            }
        }

        foreach ($this->text as $key => $value) {
            if (!is_string($value)) {
                if (!$value->is_neg()) {
                    $this->text[$key] = $value->evaluate();
                }
                else {
                    $this->text[$key] = '';
                }
            }
        }

        return str_replace('  ', ' ', join('', $this->text));
    }
}