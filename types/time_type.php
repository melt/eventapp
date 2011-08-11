<?php namespace melt;

/**
 * A date selector which uses jquery-ui to display a date picker.
 * It stores/gets/sets dates in ISO-8601 format (YYYY-mm-dd).
 */
class TimeType extends core\TimeType {
    
    public function getInterface($name) {
        $value = escape($this->value->format("H:i"));
        return "<input type=\"text\" name=\"$name\" id=\"$name\" value=\"$value\" />";
    }
}