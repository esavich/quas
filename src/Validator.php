<?php
namespace Quas;

/**
 * Class Validator
 * @package Quas
 */
class Validator
{
    public $errors = [];

    protected $err_trace = '';

    /**
     * Perform template validation
     *
     * @param string $template Source template
     *
     * @return bool
     */
    public function valid($template) {
        $is_err = false;

        if (!$this->validate_tag_count($template)) {
            $is_err = true;
            $this->errors[] = 'Mismatched number of open and close tags';
        }

        if (!$this->validate_condition_modifiers($template)) {
            $is_err = true;
            $this->errors[] = 'Unrecognized condition modifier in '.$this->err_trace;
        }

        if (!$this->validate_empty_expressions($template)) {
            $is_err = true;
            $this->errors[] = 'Empty expression in '.$this->err_trace;
        }

        if (!$this->validate_pick_delimiters($template)) {
            $is_err = true;
            $this->errors[] = 'Invalid pick delimiter in '.$this->err_trace;
        }

        return !$is_err;
    }

    /**
     * Count unescaped open and close tags
     *
     * @param $template
     * @return bool
     */
    public function validate_tag_count($template) {
        $res = [
            'opens' => 0,
            'closes' => 0
        ];

        $max = strlen($template);
        for ($i = 0; $i < $max; $i++) {
            if (in_array($template[$i], ['[', '{', '<'])) {
                if ($i > 0 && $template[$i - 1] == '\\') {
                    continue;
                }

                $res['opens']++;
            }

            if (in_array($template[$i], [']', '}', '>'])) {
                if ($template[$i - 1] != '\\') {
                    $res['closes']++;
                }
            }
        }

        return $res['opens'] == $res['closes'];
    }

    /**
     * Valid syntax is (N@C)]
     *
     * @param $template
     * @return bool
     */
    public function validate_condition_modifiers($template) {
        return true;
    }

    /**
     * Recognized delimiters is | and ~
     *
     * @param $template
     * @return bool
     */
    public function validate_pick_delimiters($template) {
        return true;
    }

    /**
     * Any unescaped expression (<>, {}, [])
     *
     * @param $template
     * @return bool
     */
    public function validate_empty_expressions($template) {
        return true;
    }
}