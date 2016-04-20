<?php
/**
 * Created by PhpStorm.
 * User: lobster
 * Date: 4/19/16
 * Time: 11:13 AM
 */

namespace Quas;


class Parser
{
    private $root;

    private $opens = ['[', '<', '{'];
    private $closes = [']', '>', '}'];
    private $types = ['pick', 'variable', 'condition'];

    public function __construct() {
        $this->root = [];
    }

    public function parse($template) {
        $this->parse_partial($template, $this->root, 0, strlen($template));

        var_dump($this->root);
    }

    private function parse_partial($template, &$node, $start, $end) {
        $cc = 0;
        for ($i = $start; $i < $end; $i++) {
            if (!isset($node[$cc])) {
                $node[$cc] = [
                    'type' => 'text',
                    'data' => ''
                ];
            }

            if ($template[$i] == '\\') {
                if ($i < $end && (in_array($template[$i+1], $this->opens) || in_array($template[$i+1], $this->closes))) {
                    $i++;
                }

                $node[$cc]['data'] .= $template[$i];
            }
            elseif (in_array($template[$i], $this->opens)) {
                $tag_index = -1;

                foreach ($this->opens as $index => $tag) {
                    if ($template[$i] == $tag) {
                        $tag_index = $index;
                        break;
                    }
                }

                $node[++$cc] = [
                    'type' => $this->types[$tag_index],
                    'data' => []
                ];

                $i = $this->parse_partial($template, $node[$cc]['data'], $i+1, $end);

                $cc++;
            }
            elseif (in_array($template[$i], $this->closes)) {
                return $i;
            }
            else {
                $node[$cc]['data'] .= $template[$i];
            }
        }

        return True;
    }
}