<?php
namespace Quas\Expr;

/**
 * Class Expression
 * @package Quas\Expr
 */
abstract class Expression implements IExpression, IModifiable
{
    use Modifiers;

    protected $data = null;

    public function __construct($data)
    {
        $this->modifiers = isset($data['modifiers']) ? $data['modifiers'] : [];
        $this->data = $data['data'];
    }
}