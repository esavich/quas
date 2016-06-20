<?php
namespace Quas\Expr;


trait Modifiers
{
    protected $modifiers = [];

    public function modify_result($data = '')
    {
        foreach ($this->modifiers as $mod) {
            if ($mod == '@') {
                $data = '';
            } elseif ($mod == '^') {
                $data = ucfirst($data);
            } elseif ($mod == '*') {
                $data = lcfirst($data);
            }
        }

        return $data;
    }
}