<?php

require_once __DIR__.'/../src/Expr/IExpression.php';
require_once __DIR__.'/../src/Expr/Expression.php';
require_once __DIR__.'/../src/Expr/Variable.php';

class VariableTest extends PHPUnit_Framework_TestCase
{
    public function testEvaluate() {
        $data = ['test'];

        \Quas\Expr\Variable::$VAR_LIST = [
            'test' => '123'
        ];

        $var = new \Quas\Expr\Variable($data);

        $this->assertEquals($var->evaluate(), '123');
    }

    public function testNegative() {
        $data = ['!test'];

        \Quas\Expr\Variable::$VAR_LIST = [
            'test' => '123'
        ];

        $var = new \Quas\Expr\Variable($data);

        $this->assertTrue($var->is_neg());
    }

    public function testIsSet() {
        $data = ['!test'];

        \Quas\Expr\Variable::$VAR_LIST = [
            'test' => '123'
        ];

        $var = new \Quas\Expr\Variable($data);

        $this->assertTrue(!$var->is_set());
    }

    public function testExists() {
        $data = ['test'];

        \Quas\Expr\Variable::$VAR_LIST = [
            'test' => '123'
        ];

        $var = new \Quas\Expr\Variable($data);

        $this->assertTrue($var->exists());
    }

    public function testNested() {
        \Quas\Expr\Variable::$VAR_LIST = [
            'st' => 'st',
            'test' => '123'
        ];

        $data = ['te', new \Quas\Expr\Variable(['st'])];

        $var = new \Quas\Expr\Variable($data);

        $this->assertEquals($var->evaluate(), '123');
    }
}