<?php namespace melt\userx;
/* Auto generated empty class override. */


class UserModel extends UserModel_app_overrideable implements \melt\data_tables\DataTablesListable {
    
    /* Facebook User ID */
    public $facebook_user = array(INDEXED,'core\IntegerType');
    /* User Details */
    public $first_name = array('core\TextType',128);
    public $last_name = array('core\TextType',128);
    public $phone = array('core\TextType', 128);
    public $street = array('core\TextType', 128);
    public $city = array('core\TextType', 128);
    public $country = array('CountryType');
    public $birthday = array('core\DateType');
    public $timezone_utc_offset = array('core\IntegerType');
    public $facebook_profile_link = array('core\TextType', 128);
    public $company = array('core\TextType', 128);
    public $website = array('core\TextType', 128);
    public $photo_id = array('core\PictureType');
    /* Type of User */
    public $user_type = array('core\SelectType', 'getUserTypeLabels');
    
    public function getUserTypeLabels() {
        return array(
            0 => _("-- Please select --"),
            1 => _("Contact"),
            2 => _("Outer Circle"),
            3 => _("Inner Circle"),
            //4 => _("Ingen"),
            //5 => _("Ingen"),
            //6 => _("Ingen"),
            7 => _("Member"),
            8 => _("Ambassador"),
            9 => _("Alumni")
        );
    }
    
    public function getName() {
        return $this->view('first_name')." ".$this->view('last_name');
    }
    
    protected function beforeStore($is_linked) {
        parent::beforeStore($is_linked);
        if(!$is_linked){
            $this->password = \melt\string\random_hex_str(32);
            $this->group = GroupModel::getStandardGroup(GroupModel::CONTEXT_GUEST);
        }
    }
    
    /*
     * Add a completely new user to the database
     */
    public static function addNewUser($fb_user_data) {
        // Create new user
        $user = new UserModel();
        // Only set this information the first time the user logs in
        $user->facebook_user = $fb_user_data["id"];
        $user->username = (isset($fb_user_data["email"])) ? $fb_user_data["email"]: null;
        $user->first_name = (isset($fb_user_data["first_name"])) ? $fb_user_data["first_name"]: null;
        $user->last_name = (isset($fb_user_data["last_name"])) ? $fb_user_data["last_name"]: null;
        // Phone cannot be retrieved
        // Street cannot be retrieved
        $location_array = (isset($fb_user_data["location"]["name"])) ? explode( "," ,$fb_user_data["location"]["name"] ): null;
        $user->city = (isset($location_array[0])) ? trim( $location_array[0] ) : null;
        $user->country = (isset($location_array[1])) ? \melt\CountryType::getAlpha2FromName( trim($location_array[1]) ) : null;
        $user->birthday = (isset($fb_user_data["birthday"])) ? date("Y-m-d", strtotime($fb_user_data["birthday"])): "1970-01-01"; 
        $user->timezone_utc_offset = (isset($fb_user_data["timezone"])) ? $fb_user_data["timezone"]: null;
        $user->facebook_profile_link = (isset($fb_user_data["link"])) ? $fb_user_data["link"]: null;
        $user->company = (isset($fb_user_data["work"][0]["employer"]["name"])) ? $fb_user_data["work"][0]["employer"]["name"]: null;
        $user->website = (isset($fb_user_data["website"])) ? "http://".$fb_user_data["website"]: null;
        // Add user photo
        $photo_link = "http://graph.facebook.com/".$fb_user_data['username']."/picture?type=large";
        $photo = file_get_contents( $photo_link );
        $user->type('photo')->setBinaryData( $photo, ".jpg" );
        // Update last loggedin
        $user->updateUserLastLogin();
        // Store user
        $user->store();
        return $user;
    }
    
    /*
     * Update last login of existing user
     */
    public function updateUserLastLogin() {
        $user = $this;
        $user->last_login_time = time();
        $user->last_login_ip = $_SERVER['REMOTE_ADDR'];      
        // Store user
        $user->store();
    }
    
    
    public static function uiGetInterface($interface_name, $field_set) {
        switch ($interface_name) {
            case "my_profile":
                return array(
                    "first_name" => _("First Name"),
                    "last_name" => _("Last Name"),
                    "phone" => _("Phone"),
                    "username" => _("Email"),
                    "street" => _("Street Address"),
                    "city" => _("City"),
                    "country" => _("Country"),
                    "birthday" => _("Birthday"),
                    "company" => _("Company/Project"),
                    "website" => _("Website"),
                    "photo" => _("Photo"),
                    
                );
             case "user_type":
                 return array(
                     "user_type" => _(""),
                 );
             case "user_details":
                 return array(
                    "first_name" => _("First Name"),
                    "last_name" => _("Last Name"),
                    "phone" => _("Phone"),
                    "username" => _("Email"),
                    "street" => _("Street Address"),
                    "city" => _("City"),
                    "country" => _("Country"),
                    "birthday" => _("Birthday"),
                    "company" => _("Company/Project"),
                    "website" => _("Website"),
                    "photo" => _("Photo"),
                    "user_type" => _("Type of Person"),
                    "group" => _("System Permissions (WARNING: THIS WILL GRANT USER ADDITIONAL SYSTEM RIGHTS)"),
                 );
        }
    }
    
    public function uiValidate($interface_name) {
        $err = array();
        foreach (array(
        "first_name", "last_name"
        ) as $field) {
            $this->$field = trim($this->$field);
            if ($this->$field == "")
                $err[$field] = _("Field must be entered!");
        }
        if (!\melt\string\email_validate($this->username)){
            $err["username"] = "Incorrect email address!";
        }
        if (!\melt\string\http_url_validate($this->website)){
            $err["website"] = "Incorrect url format!";
        }
        return $err;
    }
    
    
    public static function dtGetSearchCondition($interface_name, $search_term) {
    }
    
    public static function dtGetColumns($interface_name) {
        switch ($interface_name) {
            case "queue":
            default:
                return array(
                    "first_name" => _("First Name"),
                    "last_name" => _("Last Name"),
                    "username" => _("Email Address"),
                    //"description" => _("Description"),
                    "user_type" => _("Type of Person")
                    );
            case "people":
            default:
                return array(
                    "first_name" => _("First Name"),
                    "last_name" => _("Last Name"),
                    "country" => _("Country"),
                    //"description" => _("Description"),
                    "user_type" => _("Type of Person"),
                    "username" => _("Email Address"),
                    "_actions" => _("Actions")
                    );
        }
    }
    
    public function dtGetValues($interface_name) {
        switch ($interface_name) {
            case "queue":
                $interface = new \melt\qmi\ModelInterface("user_type");
                return array(
                    "country" => $this->view('country')." (".($this->country).")",
                    "user_type" => $interface->startForm(array("class"=>"table_form")).
                                   $interface->getInterface($this).
                                    '<input type="submit" value="Save">'.
                                   $interface->finalizeForm(false),
                );                
            case "people":
                return array(
                    "country" => $this->view('country')." (".($this->country).")",
                     "user_type" => $this->view('user_type')." (".$this->user_type.")",
                    
                    "_actions" => "<a href=\"". url("/people/details/" . $this->getID()) . "\">View/Edit</a>"
                );
        }

    }
    
    public static function dtBatchAction($interface_name, $batch_action, \melt\db\SelectQuery $selected_instances) {
        switch ($batch_action) {
            default:
                break;
        }
    }
    
    public static function dtSelect($interface_name) {
        return UserModel::select();
    }
    	
}
