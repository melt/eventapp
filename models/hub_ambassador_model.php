<?php namespace nmvc;

class HubAmbassadorModel extends AppModel implements qmi\UserInterfaceProvider {
    /* Fields */
    public $hub_id = array('core\SelectModelType', 'HubModel');
    public $ambassador_id = array('core\SelectModelType', 'userx\UserModel');

    public function uiValidate($interface_name) {
        $err = array();
        if($this->ambassador == null || $this->ambassador == 0)
               $err[$this->ambassador] = _("Field must be entered!");
        return $err;
    }

    public static function uiGetInterface($interface_name, $field_set) {

        switch ($interface_name) {
        case "new_hub":
            return array(
                "ambassador" => array(_("Ambassador"), "Select from list"),
            );

        }
    }
}