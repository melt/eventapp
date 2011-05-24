<?php namespace nmvc;

class HubModel extends AppModel implements qmi\UserInterfaceProvider, AjaxListable {
    /* Fields */
    public $city = array('core\TextType', 128);
    /* Object Relations */
    public $ambassador_id = array('core\PointerType', 'userx\UserModel');

    public function uiValidate($interface_name) {
        $err = array();
        /*if (!\nmvc\string\email_validate($this->username))
            $err["username"] = _("Email address is incorrect.");
        foreach (array(
        "first_name", "last_name", "company",
        "phone", "user_type", "hub_id"
        ) as $field) {
            $this->$field = trim($this->$field);
            if ($this->$field == "")
                $err[$field] = _("Field must be entered!");
        }*/
        return $err;
    }

        public function getAjaxListActions($interface_name) {
        $actions = array();
        $actions["@doRemove"] = array(_("Delete")
            , "confirm" => _("Do you really want to delete this hub?")
        );
        return $actions;
    }

    public function getAjaxListCells($interface_name) {
        return array(
            _("City") => '<strong>' . $this->view("city") . '</strong>',
            _("Ambassador") => $this->view("ambassador"),
        );
    }
    
    public static function uiGetInterface($interface_name, $field_set) {
  
        switch ($interface_name) {
        case "new_hub":
            return array(
                "city" => array(_("City"), ""),
                "ambassador" => array(_("Ambassador"), ""),
            );

        }
    }
}