<?php
/**
 * Created by PhpStorm.
 * User: lobster
 * Date: 4/21/16
 * Time: 2:32 PM
 */

namespace Quas;


class Engine
{
    private $vars;

    public function __construct() {

    }

    public function process($root, $vars) {
        Expr\Variable::$VAR_LIST = $vars;

        $this->vars = $vars;

        $tree = $this->prepare($root);

        $text = '';

        foreach ($tree as $node) {
            if (!is_string($node)) {
                $text .= $node->evaluate();
            }
            else {
                $text .= $node;
            }
        }

        return $text;
    }

    private function prepare($root) {
        foreach ($root as $key => $node) {
            if (is_array($node['data'])) {
                $node['data'] = $this->prepare($node['data']);
            }

            if ($node['type'] == 'text') {
                $root[$key] = $node['data'];
            }

            if ($node['type'] == 'variable') {
                $root[$key] = new Expr\Variable($node['data']);
            }

            if ($node['type'] == 'condition') {
                $root[$key] = new Expr\Condition($node['data']);
            }

            if ($node['type'] == 'pick') {
                $root[$key] = new Expr\Pick($node['data']);
            }
        }

        return $root;
    }
}