<?php namespace melt;

class EventInviteeModel extends AppModel implements qmi\UserInterfaceProvider {
     /* N-N Relations */
    public $event_id = array('core\PointerType', 'EventModel','CASCADE');
    public $invitee_id = array('core\SelectModelType', 'userx\UserModel','CASCADE');
    public $rvsp_page_hash = array('core\TextType',16);
    /* Tracks the different emails that the invitee can receive */
    public $invite_email_sent = array('core\BooleanType');
    public $reminder_email_sent = array('core\BooleanType'); // Only if RVSP ATTENDING
    public $thankyou_email_sent = array('core\BooleanType'); // Only if RVSP ATTENDING
    /* Invitee Meta Information */
    public $most_exciting_project = array('core\TextAreaType');
    public $biggest_challenge = array('core\TextAreaType');
    public $generally_help = array('core\TextAreaType');
    public $wants_to_skype = array('core\BooleanType');
    public $why_not_attend = array('core\TextAreaType');
    // Volatile fields for callback operations and actions
    public $include_members_in_hub = array(VOLATILE, 'core\BooleanType');
    public $search_invitee = array(VOLATILE, 'core\TextAreaType');
    public $list_of_members = array(VOLATILE, 'core\TextAreaType');   
    
    
    
      public static function uiGetInterface($interface_name, $field_set) {

            switch ($field_set) {
                case "list":
                    return array(
                        "search_invitee" => _("Search Invitee / Enter New"),
                    );
            }

        
        
    }
    
    public function uiValidate($interface_name) {
        $err = array();
        foreach (array(
        "title", "description"
        ) as $field) {
            $this->$field = trim($this->$field);
            if ($this->$field == "")
                $err[$field] = _("Field must be entered!");
        }
        if($this->when_later == false){
        // Validate when part
        }
        if($this->where_later == false){
        // Validate where part
            foreach (array(
            "location", "street", "city"
            ) as $field) {
                $this->$field = trim($this->$field);
                if ($this->$field == "")
                    $err[$field] = _("Field must be entered!");
            }
        }
        return $err;
    }
    
}