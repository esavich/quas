<?php
/**
 * Created by PhpStorm.
 * User: lobster
 * Date: 4/20/16
 * Time: 3:01 PM
 */

namespace Quas\Expr;


interface IExpression
{
    /**
     * Evaluate expression
     *
     * @return mixed
     */
    public function evaluate();
}