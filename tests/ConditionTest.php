<?php

require_once __DIR__.'/../src/Expr/IExpression.php';
require_once __DIR__.'/../src/Expr/Expression.php';
require_once __DIR__.'/../src/Expr/Variable.php';
require_once __DIR__.'/../src/Expr/Condition.php';


class ConditionTest extends PHPUnit_Framework_TestCase
{
    public function testEvaluate() {
        \Quas\Expr\Variable::$VAR_LIST = [
            'test' => '123'
        ];

        $data = [
            'test ',
            new \Quas\Expr\Variable(['test'])
        ];

        $cond = new \Quas\Expr\Condition($data);

        $this->assertEquals($cond->evaluate(), 'test 123');
    }
    public function testEvaluateNeg() {
        \Quas\Expr\Variable::$VAR_LIST = [
            'test' => '123'
        ];

        $data = [
            'test ',
            new \Quas\Expr\Variable(['!test'])
        ];

        $cond = new \Quas\Expr\Condition($data);

        $this->assertEquals($cond->evaluate(), '');
    }
}