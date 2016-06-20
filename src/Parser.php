<?php
/**
 * Created by PhpStorm.
 * User: lobster
 * Date: 4/19/16
 * Time: 11:13 AM
 */

namespace Quas;

/**
 * Class Parser
 * @package Quas
 */
class Parser
{
    private $root;

    /**
     * @var array List of open tags
     */
    private $opens = ['[', '<', '{'];

    /**
     * @var array List of close tags
     */
    private $closes = [']', '>', '}'];

    /**
     * @var array List types relative to tags
     */
    private $types = ['pick', 'variable', 'condition'];

    /**
     * @var array List of available modifiers
     */
    private $modifiers = ['@', '^', '*'];

    public function __construct() {
        $this->root = [];
    }

    /**
     * @getter $root
     *
     * @return array
     */
    public function getRoot() {
        return $this->root;
    }

    /**
     * Parse supplied template to tree
     *
     * @param $template
     */
    public function parse($template) {
        $this->root = [];

        // Replace all spaces after } to space before }. Necessary for preventing double space in compiled string
        $template = preg_replace('/(.*)([^\\\])(\}\s)(.*)/', '$1$2 }$4', $template);

        $this->parse_partial($template, $this->root, 0, strlen($template));
    }

    /**
     * Perform expression-by-expression parsing
     *
     * @param string $template Supplied template
     * @param array $node Current tree node
     * @param int $start Start index
     * @param int $end End index
     * @return bool|int
     */
    private function parse_partial($template, &$node, $start, $end) {
        $cc = 0;
        $applied_modifiers = [];
        
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
            elseif (in_array($template[$i], $this->modifiers)) {
                $applied_modifiers[] = $template[$i];
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
                
                if (!empty($applied_modifiers)) {
                    $node[$cc]['modifiers'] = $applied_modifiers;
                    $applied_modifiers = [];
                }

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