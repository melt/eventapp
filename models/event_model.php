<?php namespace nmvc;

class EventModel extends AppModel implements qmi\UserInterfaceProvider, AjaxListable {
    /* Fields */
    public $title = array('core\TextType', 128);
    public $description = array('core\TextAreaType');
    public $event_date = array('core\DateType');
    public $event_time = array('TimeType');
    public $street = array('core\TextType', 128);
    public $zip = array('core\TextType', 16);
    public $city = array('core\TextType', 128);
    /* Object Relations */
    public $hub_id = array('core\SelectModelType', 'HubModel', 'CASCADE');
    public $invite_email_sent = array('core\BooleanType');
    public $reminder_email_sent = array('core\BooleanType');
    public $thankyou_email_sent = array('core\BooleanType');

    public function  beforeStore($is_linked) {
        parent::beforeStore($is_linked);
        // If event takes place today we simulate that reminder email already has been sent
        if($this->event_date == date('Y-m-d')){
            $this->reminder_email_sent = true;
        }
    }

    public function sendReminderEmail(){
        self::sendInviteEmail("reminder");
    }

    public function sendThankyouEmail(){
        self::sendInviteEmail("thankyou");
    }

    public function sendInviteEmail($type = "invite"){
        switch($type){
            case "invite":
                $invitees = EventInviteeModel::select()->where("event")->is($this)->and("invitee->is_unsubscribed")->is(false);
                $subject = _("Invitation to %s",$this->view('title'));
                $mail_view = "event_invite";
                $this->invite_email_sent = true;
                break;
            case "reminder":
                // Only send reminder email to people that RVSP attending to avoid angry faces
                $invitees = EventInviteeModel::select()->where("event")->is($this)->and("rvsp")->is(\nmvc\EventInviteeModel::ATTENDING)->and("invitee->is_unsubscribed")->is(false);
                $subject = _("Reminder for %s",$this->view('title'));
                $mail_view = "event_reminder";
                $this->reminder_email_sent = true;
                break;
            case "thankyou":
                // Only send thankyou email to people that RVSP attending to avoid angry faces
                $invitees = EventInviteeModel::select()->where("event")->is($this)->and("rvsp")->is(\nmvc\EventInviteeModel::ATTENDING)->and("invitee->is_unsubscribed")->is(false);
                $subject = _("Thank you for attending %s",$this->view('title'));
                $mail_view = "event_thankyou";
                $this->thankyou_email_sent = true;
                break;
        }

        // Select ambassadors of current hub
        $ambassadors = userx\UserModel::select()->where("\nmvc\HubAmbassadorModel->hub")->is($this);


        foreach($invitees as $invitee){
            \nmvc\MailHelper::sendMail($mail_view,
                    array(
                        "event_name"=>$this->view('title'),
                        "event_description"=>$this->description,
                        "event_date"=>$this->view('event_date'),
                        "event_time"=>$this->view('event_time'),
                        "street"=>$this->view('street'),
                        "zip"=>$this->view('zip'),
                        "city"=>$this->view('city'),
                        "rvsp_link"=>"http://".\APP_ROOT_HOST . "/admin/rvsp/" . $invitee->view('rvsp_page_hash'),
                        "hub_name"=>$this->hub->view('city'),
                        "ambassadors"=>$ambassadors,
                        "map_image"=>$this->generateStaticGoogleMapsImage(),
                        "google_maps_link"=>$this->generateGoogleMapsLink($invitee->invitee)
                    ),
                    $subject,
                    $invitee->view('email'),
                    false,
                    array()
                    );
        }
        $this->store();
    }

    public function getAjaxListActions($interface_name) {
        $actions = array();
        $has_invitees = EventInviteeModel::select("invitee")->where("event")->is($this)->count();
        if($this->invite_email_sent==false)
            $actions["@addInvitees"] = array(_("Add Invitees"));
        /*if($has_invitees > 0 && $this->invite_email_sent==true && $this->reminder_email_sent == true && $this->thankyou_email_sent == false)
            $actions["@sendThankyouEmail"] = array(_("Send Thankyou Email"));*/
        if($has_invitees <= 0)
            $actions["@doRemove"] = array(_("Delete")
                , "confirm" => _("Do you really want to delete the event %s?",$this->view('title'))
            );
        return $actions;
    }

    public function generateStaticGoogleMapsImage(){
        // If there is a complete address we will generate a map
        if ( $this->street != "" && $this->city != "" && $this->hub_id != null ){
            $url_friendly_address = \rawurlencode( $this->view('street') ." ". $this->view('city') . " ". $this->hub->view('country') );
            return "http://maps.google.com/maps/api/staticmap?center=$url_friendly_address&zoom=14&size=512x300&maptype=roadmap&markers=color:red|label:Here|$url_friendly_address&sensor=false";
        } else {
            return null;
        }
    }

    public function generateGoogleMapsLink($user = null){
        // If there is a complete address we will generate a map
        if ( $this->street != "" && $this->city != "" && $this->hub_id != null ){
            $destination_address = \rawurlencode( $this->view('street') ." ". $this->view('city') ." ". $this->view('zip') . " ". $this->hub->view('country') );
        if ( $user != null )
            $source_address = \rawurlencode( $user->view('street') ." ". $user->view('city') . " ". $user->view('country') );
        else
            $source_address = "";
            return "http://maps.google.com/?saddr=$source_address&daddr=$destination_address";
        } else {
            return null;
        }
    }

    public function getAjaxListCells($interface_name) {
        return array(
            _("Title") => '<strong>' . $this->view("title") . '</strong>',
            _("Hub") => $this->view('hub'),
            _("Date") => $this->view('event_date'),
        );
    }
    
    public function uiValidate($interface_name) {
        $err = array();
        foreach (array(
        "title", "street",
        "city"
        ) as $field) {
            $this->$field = trim($this->$field);
            if ($this->$field == "")
                $err[$field] = _("Field must be entered!");
        }
        /*if (!\nmvc\string\email_validate($this->username))
            $err["username"] = _("Email address is incorrect.");
        foreach (array(
        "first_name", "last_name", "company",
        "phone", "user_type", "hub_id"
        ) as $field) {
            $this->$field = trim($this->$field);
            if ($this->$field == "")
                $err[$field] = _("Field must be entered!");
        }*/
        return $err;
    }

    public static function uiGetInterface($interface_name, $field_set) {

        switch ($interface_name) {
        case "new_event":
            return array(
                "hub" => array(_("Hub"), "Select from list"),
                "title" => array(_("Title"), "Eg. Dinner @ My Place"),
                "description" => array(_("Description"), "A short and sweet tagline to make people excited to attend"),
                "event_date" => array(_("Date"), "Select from datepicker"),
                "event_time" => array(_("Time"), "HH:mm:ss"),
                "street" => array(_("Street"), "Shows Google Maps"),
                "zip" => array(_("Zip"), ""),
                "city" => array(_("City"), ""),
            );

        }
    }

    public function addEventAndContinue(){
        // Validate and store
        $this->validate();
        $this->store();
        // Go to add invitees page
        $this->addInvitees();
    }

    public function addInvitees() {
        \nmvc\request\redirect("/event/add_invitees/".$this->id);
    }

    public function doRemove() {
        $this->unlink();
        //\nmvc\request\send_json_data(true);
    }
}