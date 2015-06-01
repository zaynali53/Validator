<?php

    require_once 'class.Helper.php';
/**
 * Simple Input Validator
 * @author Zayn Ali https://www.facebook.com/zaynali53
 * @link   https://github.com/zaynali53/Validator
 */
abstract class Rule extends Helper {

    /**
     * Required field rule
     * @param  string $value
     * @param  string $field_name
     * @return bool
     */
    protected function required($value, $field_name) {
        $valid = ! empty($value);
        if ($valid === FALSE)
            $this->errors[] = $field_name . " is required.";
        return $valid;
    }

    /**
     * Email filter rule
     * @param  string $value
     * @param  string $field_name
     * @param  string $domain
     * @return bool
     */
    protected function email($value, $field_name, $domain = NULL) {
        if (empty($value)) return;
        $valid = filter_var($value, FILTER_VALIDATE_EMAIL);
        if ( ! $valid) {
            $this->errors[] = $field_name . " needs to be a valid E-Mail.";
            return $valid;
        }
        if ( ! is_null($domain)) {
            $value_domain = explode('@', $value)[1];
            if ($domain !== $value_domain) {
                $this->errors[] = "Invalid Email! Only '$domain' associated email are accepted.";
                return;
            }
        }
    }

    /**
     * Minimum Length of the string rule
     * @param  string $value
     * @param  string $field_name
     * @param  int    $length
     * @return bool
     */
    protected function min_length($value, $field_name, $length) {
        $valid = TRUE;
        if ( ! is_numeric($length)) {
            trigger_error('min_length Param: $length must be a number');
            return;
        }

        if ( !empty($value) && trim(strlen($value)) < (int) $length) {
            $valid = FALSE;
            $this->errors[] = $field_name . " Minimum Length must be " . $length;
        }
        return $valid;
    }

    /**
     * Maximum Length of the string rule
     * @param  string $value
     * @param  string $field_name
     * @param  int    $length
     * @return bool
     */
    protected function max_length($value, $field_name, $length) {
        $valid = TRUE;
        if ( ! is_numeric($length)) {
            trigger_error('max_length Param: $length must be a number');
            return;
        }

        if ( ! empty($value) && trim(strlen($value)) > (int) $length) {
            $valid = FALSE;
            $this->errors[] = $field_name . " Maximum Length must be " . $length;
        }
        return $valid;
    }

    /**
     * White list filter rule
     * @param  string $value
     * @param  string $field_name
     * @param  string $white_list_string [comma separated]
     * @return bool
     */
    protected function white_list($value, $field_name, $white_list_string) {
        if (empty($value)) return;
        $white_list = explode(',', $white_list_string);
        $valid = in_array($value, $white_list);
        if ($valid === FALSE)
            $this->errors[] = $field_name . " is invalid";
        return $valid;
    }

    /**
     * Required file rule
     * @param  NULL   $value
     * @param  string $field_name
     * @return bool
     */
    protected function f_required($value, $field_name) {
        if ($_FILES[$field_name]['error'] == 4) {
            $this->errors[] = $field_name . " is required.";
            return FALSE;
        }
    }

    /**
     * Validate and Restrict File Types
     * @param  NULL   $value
     * @param  string $field_name
     * @param  string $white_list_string [comma separated]
     * @return bool
     */
    protected function f_types($value, $field_name, $white_list_string) {
        if ($_FILES[$field_name]['error'] != 4) {
            $given_types = explode(',', $white_list_string);

            $defined_types = $this->get_mime_types();

            $valid_types = array();

            foreach ($given_types as $given_type) {
                foreach ($defined_types as $def_type => $key) {
                    if ($given_type == $def_type) {
                        $valid_types[] = $key;
                    }
                }
            }

            $error = "Only ";

            if ( ! in_array($_FILES[$field_name]['type'], $valid_types)) {
                $index = 1;
                foreach ($given_types as $type) {
                    $error .= strtolower($type);
                    if ($index != count($given_types)) {
                        $error .= ", ";
                    }
                    $index++;
                }

                if (count($given_types) === 1) {
                    $error .= ' file is allowed.';
                } else {
                    $error .= ' files are allowed.';
                }

                $this->errors[] = $error;
                return FALSE;
            }
        }
    }
}

?>
