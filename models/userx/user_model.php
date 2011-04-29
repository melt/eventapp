<?php namespace nmvc\userx;

class UserModel extends UserModel_app_overrideable implements \nmvc\AjaxListable {
    /* Fields */
    public $first_name = array('core\TextType', 128);
    public $last_name = array('core\TextType', 128);
    public $phone = array('core\TextType', 128);
    public $company = array('core\TextType', 128);
    public $city = array('core\TextType', 128);
    public $country = array('core\CountryType');
    /* User Type - Mainly for visual purposes, not directly related to permissions */
    const GUEST = 0;
    const APPLICANT = 1;
    const MEMBER = 2;
    public $user_type = array('core\SelectType', array(self::GUEST => "Guest", self::APPLICANT => "Sandbox Applicant", self::MEMBER => "Sandbox Member"));
    /* Object Relations */
    public $hub_id = array('core\PointerType', 'HubModel', 'CASCADE');
    public $is_unsubscribed = array('core\BooleanType');

    

    public function uiValidate($interface_name) {
        $err = array();
        if (!\nmvc\string\email_validate($this->username))
            $err["username"] = _("Email address is incorrect.");
        foreach (array(
        "first_name", "last_name", "company",
        "phone", "user_type", "hub_id"
        ) as $field) {
            $this->$field = trim($this->$field);
            if ($this->$field == "")
                $err[$field] = _("Field must be entered!");
        }
        return $err;
    }

    public static function uiGetInterface($interface_name, $field_set) {
        $name_desc = "";
        switch ($interface_name) {
        case "userx\\login":
            return array(
                "username" => array(_("Email"), ""),
                "password" => array(_("Password"), ""),
                "remember_login" => array(_("Remember Login", "")),
            );
        case "recover_password":
            return array(
                "username" => array(_("Email Address")),
            );
        case "new_password":
            return array(
                "password" => array(_("New Password"), \nmvc\AppHelper::getPasswordInfo()),
                "_password_2" => array(_("Repeat password"), ""),
            );
        }
    }

     public function getAjaxListCells($interface_name) {
        switch($interface_name) {
        case "user_list":
            $cells = array(
                $this->company
            );
            break;       
        }
        return $cells;
    }

    public function getAjaxListActions($interface_name) {
        $actions = array();
        switch ($interface_name) {
        case "user_list":
            $actions["@doRemove"] = array(_("Ta bort")
                , "confirm" => _("This will PERMANENTLY remove the user and all related databases and domains. This action cannot be undone. Are you sure?")
            );
        }
        return $actions;
    }

}
