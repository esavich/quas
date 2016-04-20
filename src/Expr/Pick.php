<?php
/**
 * Created by PhpStorm.
 * User: lobster
 * Date: 4/20/16
 * Time: 2:51 PM
 */

namespace Quas\Expr;


class Pick extends Expression
{
    protected $choices = [];
    protected $meta = [];
    protected $delimeter = null;

    public function setData($data) {
        foreach ($data as $opt) {
            if ($opt['type'] == 'text') {
                if (strpos($opt['data'], '|') !== false) {
                    if (!$this->delimeter) {
                        $this->delimeter = '|';

                        $this->meta = [
                            'N' => 1,
                            'C' => ','
                        ];
                    }
                    elseif ($this->delimeter != '|') {
                        // error in syntax (conflicted delimiters)
                    }

                    $this->choices = array_merge($this->choices, explode('|', $opt['data']));
                }
                elseif (strpos($opt['data'], '~') !== false) {
                    if (!$this->delimeter) {
                        $this->delimeter = '~';

                        $this->meta = [
                            'N' => 'all',
                            'C' => ','
                        ];
                    }
                    elseif ($this->delimeter != '~') {
                        // error in syntax (conflicted delimiters)
                    }

                    $this->choices = array_merge($this->choices, explode('~', $opt['data']));
                }
                elseif ($opt['data'] != '|' && $opt['data'] != '~' && !empty(trim($opt['data']))) {
                    $this->choices[] = $opt['data'];
                }
            }
            elseif ($opt['type'] == 'variable') {

            }
            elseif ($opt['type'] == 'condition') {
                
            }
        }
    }

    public function evaluate() {

    }
}