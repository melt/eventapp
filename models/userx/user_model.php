<?php namespace nmvc\userx;

class UserModel extends UserModel_app_overrideable implements \nmvc\data_tables\DataTablesListable {
    /* Facebook User ID */
    public $facebook_user = array('core\IntegerType');
    /* Fields */
    public $first_name = array('core\TextType', 128);
    public $last_name = array('core\TextType', 128);
    public $phone = array('core\TextType', 128);
    public $company = array('core\TextType', 128);
    public $street = array('core\TextType', 128);
    public $city = array('core\TextType', 128);
    public $country = array('core\CountryType');
    public $photo_id = array('core\PictureType'); // Not used as of now
    public $is_unsubscribed = array('core\BooleanType');
    public $is_moderated = array('core\BooleanType');
    /* Object Relations */
    public $hub_id = array('core\SelectModelType', 'HubModel');


    public function  beforeStore($is_linked) {
        parent::beforeStore($is_linked);
        //$this->password = \nmvc\string\random_hex_str(16);
        // If no group exists, assume guest
        if($this->group == null)
            $this->group = GroupModel::getStandardGroup(GroupModel::CONTEXT_GUEST);
    }

    public static function addNewUser($fb_user_data) {
        // Create new user
        $user = new UserModel();
        $user->last_login_time = time();
        $user->last_login_ip = $_SERVER['REMOTE_ADDR'];
        // Only set this information the first time the user logs in
        $user->facebook_user = $fb_user_data["id"];
        $user->first_name = (isset($fb_user_data["first_name"])) ? $fb_user_data["first_name"]: null;
        $user->last_name = (isset($fb_user_data["last_name"])) ? $fb_user_data["last_name"]: null;
        $location_array = (isset($fb_user_data["location"]["name"])) ? explode(",",$fb_user_data["location"]["name"]): null;
        $user->city = (isset($location_array[0])) ? $location_array[0]: null;
        $user->country = (isset($location_array[1])) ? $location_array[1]: null;
        $user->username = (isset($fb_user_data["email"])) ? $fb_user_data["email"]: null;
        // Store user
        $user->store();
        return $user;
    }
    
    public function updateUser() {
        $user = $this;
        $user->last_login_time = time();
        $user->last_login_ip = $_SERVER['REMOTE_ADDR'];      
        // Store user
        $user->store();
    }

    public function getName() {
        return $this->view('first_name') . " " . $this->view('last_name');
    }

    public function getGroupName(){
        if($this->isAdmin()) return _("Sandbox Team");
        elseif($this->isSuperAdmin() || $this->isAmbassador()) return _("Sandbox Ambassador");
        elseif($this->isMember()) return _("Sandbox Member");
        else return _("Guest");
    }

    public function __toString() {
        return $this->getName() . " (" . $this->view('username') . ")";
    }

    public function isSuperAdmin() {
        return ($this->group->context === GroupModel::CONTEXT_SUPERADMIN);
    }

    public function isAdmin() {
        return ($this->group->context === GroupModel::CONTEXT_ADMIN);
    }

    public function isAmbassador() {
        return ($this->group->context === GroupModel::CONTEXT_AMBASSADOR);
    }

    public function isMember() {
        return ($this->group->context === GroupModel::CONTEXT_MEMBER);
    }

    public function uiValidate($interface_name) {
        $err = array();
        if (!\nmvc\string\email_validate($this->username))
            $err["username"] = _("Email address is incorrect.");
        foreach (array(
        "first_name", "last_name",
        "phone", "city", "country"
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
                "username" => array(_("Email"), "Where to send invitations"),
                "phone" => array(_("Phone"), "Where we can reach you"),
                "company" => array(_("Company/Project"), "What keeps you busy"),
                "street" => array(_("Street"), "Where you live right now"),
                "city" => array(_("City"), "Where you live right now"),
                "country" => array(_("Country"), "Where you live right now"),                
                "hub"=> array(_("Hub"), "Primary hub of interest"),
                "is_unsubscribed" => array(_("Unsubscribe to Invites"), "Do not receive any emails"),
            );
            break;
        case "rvsp_page":
            return array(
                "username" => array(_("Email"), "Where to send invitations"),
                "phone" => array(_("Phone"), "Where we can reach you"),
                "company" => array(_("Company/Project"), "What keeps you busy"),
                "street" => array(_("Street"), "Where you live right now"),
                "city" => array(_("City"), "Where you live right now"),
                "country" => array(_("Country"), "Where you live right now")
            );
            break;
        case "user_edit":
            return array(
                "group" => array(_("Role"), "Select the role that best corresponds with this person"),
                "first_name" => array(_("First Name"), ""),
                "last_name" => array(_("Last Name"), ""),
                "username" => array(_("Email"), "Where to send invitations"),
                "phone" => array(_("Phone"), "Where we can reach you"),
                "company" => array(_("Company/Project"), "What keeps you busy"),
                "street" => array(_("Street"), "Where you live right now"),
                "city" => array(_("City"), "Where you live right now"),
                "country" => array(_("Country"), "Where you live right now"),
                "hub"=> array(_("Hub"), "Primary hub of interest"),
                "is_unsubscribed" => array(_("Unsubscribe to Invites"), "Do not receive any emails"),
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

    public function setRole($type = "guest"){
        switch($type){
            case "guest":
                $this->group = GroupModel::getStandardGroup(GroupModel::CONTEXT_GUEST);
                break;
            case "member":
                $this->group = GroupModel::getStandardGroup(GroupModel::CONTEXT_MEMBER);
                break;
            case "ambassador":
                $this->group = GroupModel::getStandardGroup(GroupModel::CONTEXT_AMBASSADOR);
                break;
            case "admin":
                $this->group = GroupModel::getStandardGroup(GroupModel::CONTEXT_ADMIN);
                break;
        }
        $this->is_moderated = true;
        $this->store();
    }

    public static function getEnlistColumns() {
        return array(
            "first_name" => "First Name",
            "last_name" => "Last Name",
            "username" => "Email",
            "hub" => "Hub",
            "attended_events" => "Attended"
        );
    }

    public function getTableEnlistValues() {
        $attended_events = \nmvc\EventInviteeModel::select()->where("invitee")->is($this)->and("rvsp")->is( \nmvc\EventInviteeModel::ATTENDING )->count();
        $set_ambassador = \nmvc\qmi\get_action_link($this, "setRole",null,array("type"=>"ambassador"));
        $set_member = \nmvc\qmi\get_action_link($this, "setRole",null,array("type"=>"member"));
        $set_guest = \nmvc\qmi\get_action_link($this, "setRole",null,array("type"=>"guest"));
        $delete = \nmvc\qmi\get_action_link($this, "doRemove");

        return array(
            "attended_events" => "<b>".$attended_events ."</b> events",
            "set_permissions" => "<a href=\"$set_guest\">Guest</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"$set_member\">Member</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"$set_ambassador\">Ambassador</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"$delete\">DELETE</a>"
        );
    }


}
