<?php

/**
 * Class Quas
 * PHP Text Template Engine
 *
 * Select single (|) or concatenate all (~) random choices, if limit (N) not specified.
 * [ ch1 | ch1 (1@,)]
 * [ ch1 ~ ch2 (N@,)]
 * If limit is set, this two rules behave the same.
 * N - number of choices in result string; @ - special symbol; all other symbols until ')' used as
 * separator to concatenated choices.
 * Negative numbers can be used. In that case LEN - N variants will be used (where LEN is length of choice list).
 *
 * <var> - Variable. Simply replaced with supplied value.
 *
 * {text <var>} - Out text only if variable set and not empty.
 * {text !<var>} - Out text only if variable not set or empty.
 * Multiple vars can be set in same rule; in that case they use and(&) relations.
 */
class Quas
{
    public function __construct() {

    }

    /**
     * Compile template
     *
     * @param string $template Source template
     * @param array $vars List of variables to be placed
     * @return string|bool
     */
    public function compile($template, $vars) {

    }

    /**
     * Check if supplied template is valid
     *
     * @param string $template
     * @return bool
     */
    public function valid($template) {

    }
}