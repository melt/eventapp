<?php namespace nmvc;

class EventInviteeModel extends AppModel implements qmi\UserInterfaceProvider {
    /* N-N Relations */
    public $event_id = array('core\PointerType', 'EventModel','CASCADE');
    public $invitee_id = array('core\SelectModelType', 'userx\UserModel');
    public $rvsp_page_hash = array('core\TextType',16);
    /* If invitee is not a user in the system */
    public $email = array('core\TextType', 128);
    /* Invitee Meta Information */
    public $most_exciting_project = array('core\TextAreaType');
    public $biggest_challenge = array('core\TextAreaType');
    public $generally_help = array('core\TextAreaType');
    public $wants_to_skype = array('core\BooleanType');
    public $why_not_attend = array('core\TextAreaType');
    /* RVSP */
    const NO_RVSP = 0;
    const ATTENDING = 1;
    const NOT_ATTENDING = 2;
    public $rvsp = array('core\SelectType', array(self::NO_RVSP => "––", self::ATTENDING => "Attending", self::NOT_ATTENDING => "Not Attending"));

    public function  beforeStore($is_linked) {
        parent::beforeStore($is_linked);
        $this->rvsp_page_hash = \nmvc\string\random_hex_str(16);
        // If we add a database user, copy the email to the invitee list
        if($this->invitee!=null)
            $this->email = $this->invitee->username;
    }

    public function uiValidate($interface_name) {
        $err = array();
        if (!\nmvc\string\email_validate($this->email))
            $err["email"] = _("Email address is incorrect.");
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
                "rvsp" => array(_("RVSP"), "Select whether or not to attend this event"),
                "most_exciting_project" => array(_("What is your most exciting project right now?"), "Helps seating arrangements"),
                "biggest_challenge" => array(_("What is your biggest challenge right now?"), "Helps seating arrangements"),
                "generally_help" => array(_("How can we generally help?"), "Helps seating arrangements"),
                "wants_to_skype" => array(_("Do you want to Skype with the ambassador before the event?"), "A short Skype call can help the ambassador understand current challenges and projects of each guest and how it may overlap with other guests."),
                "why_not_attend" => array(_("Why do you not wish to attend this event?"), "This helps us make future events better for you"),
            );
            break;
        case "new_event":
            return array(
                // Include user fields here if user
                "email" => array(_("Invitee from Email Addresss"), "OR enter an email address"),
                 // Include user fields here if user
                "invitee" => array(_("Invitee from Users"), "Select from users in list.."),
            );
            break;


        }
    }

}