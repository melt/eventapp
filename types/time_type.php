<?php namespace nmvc;


class TimeType extends \nmvc\AppType {
    private $varchar_size = null;

    public function __construct() {
        parent::__construct();
    }

    public function getSQLType() {
        return "TIME";
    }

    public function get() {
        return $this->value;
    }

    public function set($value) {
        $this->value = $value;
    }

    public function getSQLValue() {
        return \nmvc\db\strfy($this->value);
    }

    public function getInterface($name) {
        $value = escape($this->value);
        $maxlength = null;
        if ($this->varchar_size !== null)
            $maxlength = "maxlength=\"" . $this->varchar_size . "\"";
        return "<input type=\"text\" $maxlength name=\"$name\" id=\"$name\" value=\"$value\" />";
    }

    public function readInterface($name) {
        $this->set(@$_POST[$name]);
    }

    public function __toString() {
        return escape($this->value);
    }
}
