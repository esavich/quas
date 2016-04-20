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
    protected $text = '';
    protected $vars = [];

    public function setData($data) {
        foreach ($data as $part) {
            if ($part['type'] == 'text' && $part['data'] != '' && $part['data'] != ' ') {
                $this->text .= $part['data'];
            }
            elseif ($part['type'] == 'variable') {
                $var = new Variable();
                $var->setData($part['data']);

                $this->vars[] = $var;

                $this->text .= $var->exists() ? $var->evaluate() : '';
            }
        }
    }

    public function evaluate() {
        foreach ($this->vars as $var) {
            if (!$var->is_set()) {
                return '';
            }
        }

        return $this->text;
    }
}