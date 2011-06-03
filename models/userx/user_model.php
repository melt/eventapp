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

    public function  afterStore($was_linked) {
        parent::afterStore($was_linked);
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
        //$user->sendModerateUserEmail(); Activate to send moderation email to admins
        // Store user
        $user->store();
        return $user;
    }
    
    public function updateUser($fb_user_data) {
        $user = $this;
        $user->last_login_time = time();
        $user->last_login_ip = $_SERVER['REMOTE_ADDR'];      
        // Store user
        $user->store();
    }

    public function sendModerateUserEmail(){
        $admin_context = GroupModel::select()->where("context")->is(GroupModel::CONTEXT_ADMIN)->first();
        $admins = UserModel::select()->where("group")->is($admin_context);
        foreach($admins as $admin){
            \nmvc\MailHelper::sendMail("user_approval", array("email"=>$this->view('username'),"name"=>$this->getName()), _("%s has registered on %s",$this->getName(),\nmvc\APP_NAME), $admin->username, true);
        }
    }

    public function getName() {
        return $this->view('first_name') . " " . $this->view('last_name');
    }

    public function __toString() {
        return $this->getName() . " (" . $this->username . ")";
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
                "phone" => array(_("Phone"), "Where we can reach you"),
                "company" => array(_("Company/Project"), "Primary project right now"),
                "street" => array(_("Street"), "Where you live right now"),
                "city" => array(_("City"), "Where you live right now"),
                "country" => array(_("Country"), "Where you live right now"),
                //"user_type" => array(_("Type of User"), ""),
                "username" => array(_("Email"), "Where to send invitations"),
                "hub"=> array(_("Hub"), "Primary hub of interest"),
                "is_unsubscribed" => array(_("Unsubscribe to Invites"), "Do not receive any emails"),
                //"password" => array(_("Password"), ""),
                //"_password_2" => array(_("Repeat Password"), ""),
                //"remember_login" => array(_("Remember Login", "")),
            );
            break;
        case "rvsp_page":
            return array(
                "phone" => array(_("Phone"), "Where we can reach you"),
                "company" => array(_("Company/Project"), "Primary project right now"),
                "street" => array(_("Street"), "Where you live right now"),
                "city" => array(_("City"), "Where you live right now"),
                "country" => array(_("Country"), "Where you live right now"),
                //"user_type" => array(_("Type of User"), ""),
                "username" => array(_("Email"), "Where to send invitations"),
                //"password" => array(_("Password"), ""),
                //"_password_2" => array(_("Repeat Password"), ""),
                //"remember_login" => array(_("Remember Login", "")),
            );
            break;
        case "user_edit":
            return array(
                "hub"=> array(_("Belongs to Hub"), "User will receive information from this hub per default"),
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
                //"Permissions"=>$this->view('group'),
                "Name"=>$this->getName(),
                "Email"=>$this->view('username'),
                "Company/Project"=>$this->view('company')
            );
            break;
        case "guest_list":
            $rvsp_count = \nmvc\EventInviteeModel::select()->where("invitee")->is($this)->and("rvsp")->is(true)->count();
            $cells = array(
                "Name"=>$this->getName(),
                "Email"=>$this->view('username'),
                "Attended Events"=>$rvsp_count
            );
            break;
        case "moderation_list":
            $cells = array(
                "Name"=>$this->getName(),
                "Email"=>$this->view('username')
            );
            break;
        }
        return $cells;
        
    }

    public function getAjaxListActions($interface_name) {
        $actions = array();
        switch ($interface_name) {
        case "user_list":
            $actions["@doRemove"] = array(_("Delete")
                , "confirm" => _("This will PERMANENTLY remove the user including all data. This action cannot be undone. Are you sure?")
            );
            break;
        case "guest_list":
            $actions["@doPromoteToMember"] = array(_("Promote to Member"));
            $actions["@doRemove"] = array(_("Delete")
                , "confirm" => _("This will PERMANENTLY remove the user including all data. This action cannot be undone. Are you sure?")
            );
            break;
        case "moderation_list":
            $actions[ \nmvc\qmi\get_action_link($this,"setRole",null,array("type"=>"guest"))] = array(_("Guest"));
            $actions[ \nmvc\qmi\get_action_link($this,"setRole",null,array("type"=>"member")) ] = array(_("Member"));
            $actions[ \nmvc\qmi\get_action_link($this,"setRole",null,array("type"=>"ambassador")) ] = array(_("Ambassador"));
            $actions[ \nmvc\qmi\get_action_link($this,"setRole",null,array("type"=>"admin")) ] = array(_("Administrator"));
            break;
        }
        return $actions;
    }

    public function setRole($type = "guest"){
        switch($type){
            case "guest":
                $this->group = GroupModel::getStandardGroup(GroupModel::CONTEXT_GUEST);
                break;
            case "member":
                $this->group = GroupModel::getStandardGroup(GroupModel::CONTEXT_GUEST);
                break;
            case "ambassador":
                $this->group = GroupModel::getStandardGroup(GroupModel::CONTEXT_GUEST);
                break;
            case "admin":
                $this->group = GroupModel::getStandardGroup(GroupModel::CONTEXT_GUEST);
                break;
        }
        $this->is_moderated = true;
        $this->store();
    }

    public function doPromoteToMember(){
        $this->group = \nmvc\userx\GroupModel::select("id")->where("context")->is( \nmvc\userx\GroupModel::CONTEXT_MEMBER )->first();
        $this->store();
    }

    public function doRemove() {
        $this->unlink();
        //\nmvc\request\send_json_data(true);
    }



}
