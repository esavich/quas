<?php
/**
 * Created by PhpStorm.
 * User: lobster
 * Date: 4/20/16
 * Time: 2:51 PM
 */

namespace Quas\Expr;


abstract class Expression implements IExpression
{
    protected $data;

    public function setData($data) {
        $this->data = $data;
    }
}