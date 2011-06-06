<?php namespace nmvc;

class EventInviteeModel extends AppModel implements qmi\UserInterfaceProvider {
    /* N-N Relations */
    public $event_id = array('core\PointerType', 'EventModel','CASCADE');
    public $invitee_id = array('core\SelectModelType', 'userx\UserModel','CASCADE');
    public $rvsp_page_hash = array('core\TextType',16);
    /* Invitee Meta Information */
    public $most_exciting_project = array('core\TextAreaType');
    public $biggest_challenge = array('core\TextAreaType');
    public $generally_help = array('core\TextAreaType');
    public $wants_to_skype = array('core\BooleanType');
    public $why_not_attend = array('core\TextAreaType');
    // Volatile fields for callback operations and actions
    public $include_members_in_hub = array(VOLATILE, 'core\BooleanType');
    public $list_of_emails = array(VOLATILE, 'core\TextAreaType');
    public $list_of_members = array(VOLATILE, 'core\TextAreaType');

    /* RVSP */
    const NO_RVSP = 0;
    const ATTENDING = 1;
    const NOT_ATTENDING = 2;
    public $rvsp = array('core\SelectType', array(self::NO_RVSP => "––", self::ATTENDING => "Attending", self::NOT_ATTENDING => "Not Attending"));

    public function  beforeStore($is_linked) {
        parent::beforeStore($is_linked);            
        $this->rvsp_page_hash = \nmvc\string\random_hex_str(16);        
    }

    public function generateRvspLink(){
        return \APP_ROOT_URL . "outside/rvsp/" . $this->view('rvsp_page_hash');
    }

    public function generateUnsubscribeLink(){
        return \APP_ROOT_URL . "outside/unsubscribe/" . $this->invitee->id;
    }

    private function inviteeExists(){
        if($this->select()->where("event")->is($this->event)->and("invitee->username")->is($this->invitee->username)->count() > 0)
            return true;
        else
            return false;
    }

    public function uiValidate($interface_name) {
        $err = array();
        foreach (array(
        "rvsp"
        ) as $field) {
            $this->$field = trim($this->$field);
            if ($this->$field == "")
                $err[$field] = _("Field must be entered!");
        }
        return $err;
    }

    public static function uiGetInterface($interface_name, $field_set) {
        switch ($interface_name) {
        case "rvsp_page":
            return array(
                // Include user fields here if user
                "rvsp" => array(_("RVSP"), "Select whether or not you wish to attend this event"),
                "most_exciting_project" => array(_("What's currently your most exciting project?"), "Helps seating arrangements"),
                "biggest_challenge" => array(_("What's your biggest challenge right now?"), "Helps seating arrangements"),
                "generally_help" => array(_("How can we help you in general?"), "Helps seating arrangements"),
                "wants_to_skype" => array(_("Schedule a Skype call?"), "A short Skype call helps the Sandbox ambassador understand your current challenges and projects"),
                "why_not_attend" => array(_("Why do you not wish to attend this event?"), "This helps us make future events better for you"),
            );
            break;
        case "add_invitees":
            return array(
                // Invitees email addresses separated by comma
                "include_members_in_hub" => array(_("Include hub members"), "Add all members to list"),
                "list_of_members" => array(_("Invite members and previous guests"), "Search and add Sandbox members, applicants and previous guests at Sandbox events"),
                "list_of_emails" => array(_("Invite new guests"), "Enter email addresses of people to invite separated by comma (,)"),
            );
            break;


        }
    }

}