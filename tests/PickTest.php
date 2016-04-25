<?php

require_once __DIR__.'/../src/Expr/IExpression.php';
require_once __DIR__.'/../src/Expr/Expression.php';
require_once __DIR__.'/../src/Expr/Pick.php';


class PickTest extends PHPUnit_Framework_TestCase
{
    public function testEvaluateT() {
        $data = [
            'test1~test2~test3'
        ];

        $pick = new \Quas\Expr\Pick($data);

        $this->assertEquals(count(explode(',', $pick->evaluate())), 3);
        $this->assertEquals(substr_count($pick->evaluate(), ','), 2);
    }

    public function testEvaluateTMod() {
        $data = [
            'test1~test2~test3(1@,)'
        ];

        $pick = new \Quas\Expr\Pick($data);

        $this->assertTrue(in_array($pick->evaluate(), ['test1', 'test2', 'test3']));
    }

    public function testEvaluateP() {
        $data = [
            'test1|test2|test3'
        ];

        $pick = new \Quas\Expr\Pick($data);

        $this->assertTrue(in_array($pick->evaluate(), ['test1', 'test2', 'test3']));
    }

    public function testEvaluatePMod() {
        $data = [
            'test1|test2|test3(2@:)'
        ];

        $pick = new \Quas\Expr\Pick($data);

        $this->assertEquals(count(explode(':', $pick->evaluate())), 2);
        $this->assertTrue(strpos($pick->evaluate(), ':') > 0);
    }
}