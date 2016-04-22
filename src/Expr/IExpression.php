<?php
namespace Quas\Expr;

/**
 * Interface IExpression
 * @package Quas\Expr
 */
interface IExpression
{
    /**
     * Evaluate expression
     *
     * @return mixed
     */
    public function evaluate();
}