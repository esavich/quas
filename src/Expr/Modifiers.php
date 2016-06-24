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
                $data = mb_strtoupper(mb_substr($data, 0, 1)) . mb_substr($data, 1);
            } elseif ($mod == '*') {
                $data = mb_strtolower(mb_substr($data, 0, 1)) . mb_substr($data, 1);
            }
        }

        return $data;
    }
}