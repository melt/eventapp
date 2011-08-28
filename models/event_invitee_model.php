<?php namespace melt;

class EventInviteeModel extends AppModel implements qmi\UserInterfaceProvider, data_tables\DataTablesListable {
     /* N-N Relations */
    public $event_id = array('core\PointerType', 'EventModel','CASCADE');
    public $invitee_id = array('core\SelectModelType', 'userx\UserModel','CASCADE');
    public $rsvp = array('core\SelectType','getRsvpLabels');
    public $rsvp_page_hash = array('core\TextType',16);
    /* Tracks the different emails that the invitee can receive */
    public $invite_email_sent = array('core\BooleanType');
    public $reminder_email_sent = array('core\BooleanType'); // Only if RVSP ATTENDING
    public $thankyou_email_sent = array('core\BooleanType'); // Only if RVSP ATTENDING
    /* Invitee Meta Information */
    //public $most_exciting_project = array('core\TextAreaType');
    //public $biggest_challenge = array('core\TextAreaType');
    //public $generally_help = array('core\TextAreaType');
    //public $wants_to_skype = array('core\BooleanType');
    public $why_not_attend = array('core\TextAreaType');
    // Volatile fields for callback operations and actions
    public $email_addresses = array(VOLATILE, 'core\TextAreaType');  
     /* RVSP */
    const NO_RSVP = 0;
    const ATTENDING = 1;
    const NOT_ATTENDING = 2;
    public function getRsvpLabels(){
        return array(
            self::NO_RSVP => "Not yet",
            self::ATTENDING => "Attending",
            self::NOT_ATTENDING => "Not Attending"
        );
    }
   
    
    protected function beforeStore($is_linked) {
        parent::beforeStore($is_linked);
        if($this->inviteeExists()) {
            $this->unlink();
        }
    }
    
   private function inviteeExists(){
        if($this->select()->where("event")->is($this->event)->and("invitee")->is($this->invitee)->count() > 0)
            return true;
        else
            return false;
    }
    
    public static function uiGetInterface($interface_name, $field_set) {

            switch ($field_set) {
                case "list":
                    return array(
                        "email_addresses" => _("Enter Email Address(es) Separated by Comma"),
                    );
            }
        
    }
    
    public function uiValidate($interface_name) {
        $err = array();
        return $err;
    }
    
    public static function dtGetSearchCondition($interface_name, $search_term) {

    }
    
    public static function dtGetColumns($interface_name) {
        switch ($interface_name) {
            case "attendees":
            case "not_yet":
                return array(
                    "_name" => _("Name"),
                    "_email" => _("Email"),
                    "invite_email_sent" => _("Invited"),
                    "reminder_email_sent" => _("Reminded")
                    );                
            case "invitees":
            default:
                return array(
                    "_name" => _("Name"),
                    "_email" => _("Email"),
                    "invite_email_sent" => _("Invited"),
                    "reminder_email_sent" => _("Reminded"),
                    "rsvp" => _("RSVP"),
                    "_actions" => _("Actions"),
                    );
        }
    }
    
    public function dtGetValues($interface_name) {
        return array(
            "_name" => $this->invitee->getName(),
            "_email" => $this->invitee->username,
            "_actions" => "<a href=\"". url("/events/invitees_remove/" . $this->getID()) . "\">Remove</a>"
        );
    }
    
    public static function dtBatchAction($interface_name, $batch_action, \melt\db\SelectQuery $selected_instances) {
        switch ($batch_action) {
            default:
                break;
        }
    }
    
    public static function dtSelect($interface_name) {
        return EventInviteeModel::select();
    }
        
}