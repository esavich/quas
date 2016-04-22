<?php

require __DIR__ . '/../Quas.php';

class CompileTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Quas
     */
    private $q;

    public function setUp() {
        $this->q = new Quas();
    }

    public function testPickSingle() {
        $tpl = '[test1|test2|test3]';

        $res = $this->q->compile($tpl);

        $this->assertTrue(in_array($res, ['test1', 'test2', 'test3']));
    }

    public function testPickMultiple() {
        $tpl = '[test1~test2~test3]';

        $res = $this->q->compile($tpl);

        $this->assertEquals(count(explode(',', $res)), 3);
    }

    public function testPickModifier() {
        $tpl = '[test1|test2|test3(2@:)]';

        $res = $this->q->compile($tpl);

        $this->assertEquals(count(explode(':', $res)), 2);
    }

    public function testPickNested() {
        $tpl = '[test1|test2|[test4|test5]|test3]';

        $res = $this->q->compile($tpl);

        $this->assertTrue(in_array($res, ['test1', 'test2', 'test3', 'test4', 'test5']));
    }

    public function testVariable() {
        $tpl = '<var>';

        $vars = [
            'var' => 'test'
        ];

        $res = $this->q->compile($tpl, $vars);

        $this->assertEquals($res, 'test');
    }

    public function testVariableUndefined() {
        $this->setExpectedException('\Quas\Expr\UndefinedVariable');

        $tpl = '<var>';

        $vars = [];

        $res = $this->q->compile($tpl, $vars);
    }

    public function testVariableNested() {
        $tpl = '<var<var1>>';

        $vars = [
            'var1' => '2',
            'var2' => 'test'
        ];

        $res = $this->q->compile($tpl, $vars);

        $this->assertEquals($res, 'test');
    }

    public function testConditionSingle() {
        $tpl = '{test <var>}';

        $vars = [
            'var' => 1
        ];

        $res = $this->q->compile($tpl, $vars);

        $this->assertEquals($res, 'test 1');
    }

    public function testConditionSingleNeg() {
        $tpl = '{test <!var>}';

        $vars = [
            'var' => 1
        ];

        $res = $this->q->compile($tpl, $vars);

        $this->assertEquals($res, '');
    }

    public function testConditionMultiple() {
        $tpl = '{test <var1> <var2>}';

        $vars = [
            'var1' => 1,
            'var2' => 2
        ];

        $res = $this->q->compile($tpl, $vars);

        $this->assertEquals($res, 'test 1 2');
    }

    public function testConditionMultipleNeg() {
        $tpl = '{test <var1> <!var2>}';

        $vars = [
            'var1' => 1
        ];

        $res = trim($this->q->compile($tpl, $vars));

        $this->assertEquals($res, 'test 1');
    }
}