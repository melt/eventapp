<?php namespace nmvc\userx;

class UserModel extends UserModel_app_overrideable implements \nmvc\AjaxListable {
    /* Facebook User ID */
    public $facebook_user = array('core\IntegerType');
    /* Fields */
    public $first_name = array('core\TextType', 128);
    public $last_name = array('core\TextType', 128);
    public $phone = array('core\TextType', 128);
    public $company = array('core\TextType', 128);
    public $street = array('core\TextType', 128);
    public $city = array('core\TextType', 128);
    public $country = array('core\TextType', 128);
    public $photo_id = array('core\PictureType');
    /* User Type - Mainly for visual purposes, not directly related to permissions */
    const GUEST = 0;
    const APPLICANT = 1;
    const MEMBER = 2;
    public $user_type = array('core\SelectType', array(self::GUEST => "Guest", self::APPLICANT => "Sandbox Applicant", self::MEMBER => "Sandbox Member"));
    /* Object Relations */
    public $hub_id = array('core\SelectModelType', 'HubModel');
        /* Object Relations */
    public $hub_ambassador_id = array('core\SelectModelType', 'HubModel');
    public $is_unsubscribed = array('core\BooleanType');

    public function  beforeStore($is_linked) {
        parent::beforeStore($is_linked);
        $this->password = \nmvc\string\random_hex_str(16);
    }
    
    public static function updateOrCreateNewUser($fb_user_data) {
        // Check if user exists in database
        $user_exists = UserModel::select()->where("facebook_user")->is($fb_user_data["id"])->first();
        // Create new user if not existing
        $user = (!$user_exists) ? new UserModel() : $user_exists;
        // Only set FB user and password if not existing
        if (!$user_exists)
            $user->facebook_user = $fb_user_data["id"];
        // Update other details since last login
        $location_array = (isset($fb_user_data["location"]["name"])) ? explode(",",$fb_user_data["location"]["name"]): null;
        $user->company = (isset($fb_user_data["work"]["employer"])) ? $fb_user_data["work"]["employer"]: null;
        $user->first_name = (isset($fb_user_data["first_name"])) ? $fb_user_data["first_name"]: null;
        $user->last_name = (isset($fb_user_data["last_name"])) ? $fb_user_data["last_name"]: null;
        $user->city = (isset($location_array[0])) ? $location_array[0]: null;
        $user->country = (isset($location_array[1])) ? $location_array[1]: null;
        $user->username = (isset($fb_user_data["email"])) ? $fb_user_data["email"]: null;
        $user->last_login_time = time();
        $user->last_login_ip = $_SERVER['REMOTE_ADDR'];
        //$user->photo = \file_get_contents();
        // Store user
        $user->store();
        //\nmvc\MailHelper::sendMail("new_user", array("first_name"=>$user->first_name), _("Your Facebook account has been connected to %s",\nmvc\APP_NAME), \nmvc\APP_EMAIL, true);
        return $user;
    }

    public function getName() {
        return $this->view('first_name') . " " . $this->view('last_name');
    }

    public function __toString() {
        return $this->getName() . " (" . $this->username . ")";
    }

    public function uiValidate($interface_name) {
        $err = array();
        if (!\nmvc\string\email_validate($this->username))
            $err["username"] = _("Email address is incorrect.");
        foreach (array(
        "first_name", "last_name",
        "phone"
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
        case "user_profile":
            return array(
                "first_name" => array(_("First Name"), ""),
                "last_name" => array(_("Last Name"), ""),
                "phone" => array(_("Phone"), ""),
                "company" => array(_("Primary Company/Project"), "The project you feel mostly affiliated with"),
                "street" => array(_("Street"), "Where you live right now, to get map directions to events"),
                "city" => array(_("City"), "Where you live right now"),
                "country" => array(_("Country"), "Where you live right now"),
                //"user_type" => array(_("Type of User"), ""),
                "username" => array(_("Email"), ""),
                "hub"=> array(_("Primary Hub"), ""),
                "is_unsubscribed" => array(_("Unsubscribed to Email Updates"), ""),
                //"password" => array(_("Password"), ""),
                //"_password_2" => array(_("Repeat Password"), ""),
                //"remember_login" => array(_("Remember Login", "")),
            );
            break;
        case "rvsp_page":
            return array(
                "phone" => array(_("Phone"), ""),
                "company" => array(_("Primary Company/Project"), "The project you feel mostly affiliated with"),
                "city" => array(_("City"), "Where you live right now"),
                "country" => array(_("Country"), "Where you live right now"),
                //"user_type" => array(_("Type of User"), ""),
                "username" => array(_("Email"), ""),
                //"password" => array(_("Password"), ""),
                //"_password_2" => array(_("Repeat Password"), ""),
                //"remember_login" => array(_("Remember Login", "")),
            );
            break;
        case "user_edit":
            return array(
                "hub"=> array(_("Belongs to Hub"), "User will receive information from this hub per default"),
                "hub_ambassador"=> array(_("Ambassador for Hub"), "This grants the user special privileges"),
            );
            break;
        /* Deprecated: Using strictly only Facebook login
         * case "login":
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
            );*/
        }
    }

     public function getAjaxListCells($interface_name) {
        switch ($interface_name) {
        case "user_list":
            $cells = array(
                "Name"=>$this->getName(),
                "Email"=>$this->view('username'),
                $this->view('company'),
                "Hub"=>$this->view('hub'),
                "Ambassador for"=>$this->view('hub_ambassador')
            );
        return $cells;
        }
    }

    public function getAjaxListActions($interface_name) {
        $actions = array();
        switch ($interface_name) {
        case "user_list":
            $actions["@doEdit"] = array(_("Edit"));
            $actions["@doRemove"] = array(_("Delete")
                , "confirm" => _("This will PERMANENTLY remove the user including all data. This action cannot be undone. Are you sure?")
            );
            break;
        }
        return $actions;
    }

    public function doRemove() {
        $this->unlink();
        //\nmvc\request\send_json_data(true);
    }

    public function doEdit(){
        \nmvc\request\redirect("/admin/user_edit/".$this->id);
    }



}
