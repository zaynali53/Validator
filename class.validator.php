<?php

    require_once 'class.Rule.php';

/**
 * Simple Input Validator
 * @author Zayn Ali https://www.facebook.com/zaynali53
 * @link   https://github.com/zaynali53/Validator
 */
class Validator extends Rule {

    /**
     * Error messages for user feedback
     */
    protected $errors = array();

    /**
     * Validity Check member
     */
    public $is_valid = FALSE;

    /**
     * Get validation errors for custom display
     * @return array
     */
    public function get_errors() {
        return $this->errors;
    }

    /**
     * Show Ordered/Un-ordered list of Generated Errors
     * @param  array   $attributes
     * @param  boolean $ordered_list
     * @return void
     */
    public function show_errors($attributes = array(), $ordered_list = FALSE) {
        if ( ! is_array($attributes)) {
            trigger_error('show_errors expects $attributes to be an array.');
            return;
        }

        if ( ! is_bool($ordered_list)) {
            trigger_error('show_errors expects $ordered_list to be a boolean.');
            return;
        }

        $tag = ($ordered_list == TRUE) ? "ol" : "ul";
        $output = "<$tag";
        foreach ($attributes as $key => $value) {
            $output .= " $key=\"$value\"";
        }
        $output .= ">";

        foreach ($this->errors as $error) {
            $output .= "<li>" . $error . "</li>";
        }
        $output .= "</$tag>";

        echo $output;
    }

    /**
     * Validates the data with the given set of rules
     * @param  array $data
     * @param  array $rules
     * @return bool
     */
    public function validate($data, $rules) {
        if ( ! is_array($data)) {
            trigger_error('validate expects $data to be an array.');
            return;
        }

        if ( ! is_array($rules)) {
            trigger_error('validate expects $rules to be an array.');
            return;
        }

        $valid = TRUE;

        foreach ($rules as $field_name => $rules_str) {
            $rules_arr = explode('|', $rules_str);

            foreach ($rules_arr as $rule) {
                $value = isset($data[$field_name]) ? $data[$field_name] : NULL;

                if (preg_match('/:/', $rule)) {
                    $sub_rule = explode(':', $rule);
                    if ($this->$sub_rule[0]($value, $field_name, $sub_rule[1]) === FALSE) $valid = FALSE;
                }
                else {
                    if ($this->$rule($value, $field_name) === FALSE) $valid = FALSE;
                }
            }
        }

        $this->is_valid = $valid;
    }

}

?>
