<?php namespace nmvc;

class HubModel extends AppModel implements qmi\UserInterfaceProvider, AjaxListable, \nmvc\data_tables\DataTablesListable {
    /* Fields */
    public $city = array('core\TextType', 128);
    public $country = array('core\CountryType');

    public function  afterStore($was_linked) {
        parent::afterStore($was_linked);
        \nmvc\messenger\redirect_message(url("/"), _("The hub was added!"), "good");
    }

    public function uiValidate($interface_name) {
        $err = array();
        foreach (array(
        "city", "country"
        ) as $field) {
            $this->$field = trim($this->$field);
            if ($this->$field == "")
                $err[$field] = _("Field must be entered!");
        }
        return $err;
    }

        public function getAjaxListActions($interface_name) {
        $actions = array();
        $actions["@doRemove"] = array(_("Delete")
            , "confirm" => _("Do you really want to delete this hub?")
        );
        return $actions;
    }

    public function __toString() {
        return $this->view('city') . ", " . $this->view('country');
    }

    public function getAjaxListCells($interface_name) {
        return array(
            _("City") => '<strong>' . $this->view("city") . '</strong>',
            _("Country") => $this->view("country"),
        );
    }
    
    public static function uiGetInterface($interface_name, $field_set) {
  
        switch ($interface_name) {
        case "new_hub":
            return array(
                "city" => array(_("City"), "Enter name of hub"),
                "country" => array(_("Country"), ""),
            );

        }
    }

    public function doRemove() {
        $this->unlink();
        //\nmvc\request\send_json_data(true);
    }

    public static function getEnlistColumns() {
        return array(
            "city" => "City",
            "country" => "Country"
        );
    }

    public function getTableEnlistValues() {
        return array();
    }

}