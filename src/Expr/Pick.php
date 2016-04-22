<?php
namespace Quas\Expr;

/**
 * Class Pick
 * @package Quas\Expr
 */
class Pick extends Expression
{
    private $opts = [];
    private $meta = [];
    private $delimiter = null;

    public function __construct($data) {
        foreach ($data as $d) {
            if (is_string($d)) {
                // regex for matching (N@C)
                if (preg_match('/[^\\\]?\((\d+)@(.*)[^\\\]?\)/', $d, $matches) > 0) {
                    $d = preg_replace('/\((\d+)@(.*)\)/', '', $d);

                    $this->meta = [
                        'N' => $matches[1],
                        'C' => $matches[2]
                    ];
                }

                $this->opts = array_merge($this->opts, array_filter($this->split_opts($d), function($x) {
                    return !empty(trim($x));
                }));
            }
            else {
                $this->opts[] = $d;
            }
        }
    }

    /**
     * Evaluate expression
     *
     * @return string
     */
    public function evaluate() {
        foreach ($this->opts as $key => $value) {
            if (!is_string($value)) {
                $this->opts[$key] = $value->evaluate();
            }
        }

        if ($this->meta['N'] == 'N') {
            $this->meta['N'] = count($this->opts);
        }

        shuffle($this->opts);

        return join($this->meta['C'], array_slice($this->opts, 0, $this->meta['N']));
    }

    /**
     * Split options from string using delimiter
     *
     * @param $text
     * @return array
     */
    private function split_opts($text) {
        if (!$this->delimiter) {
            if (strpos($text, '~') !== false) {
                $this->delimiter = '~';

                if (empty($this->meta)) {
                    $this->meta = [
                        'N' => 'N',
                        'C' => ','
                    ];
                }
            }
            else {
                $this->delimiter = '|';

                if (empty($this->meta)) {
                    $this->meta = [
                        'N' => 1,
                        'C' => ','
                    ];
                }
            }
        }

        return explode($this->delimiter, $text);
    }
}