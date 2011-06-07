<?php namespace nmvc;

class EventModel extends AppModel implements qmi\UserInterfaceProvider, \nmvc\data_tables\DataTablesListable {
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
    //public $invite_email_sent = array('core\BooleanType');
    //public $reminder_email_sent = array('core\BooleanType');
    //public $thankyou_email_sent = array('core\BooleanType');

    public function  beforeStore($is_linked) {
        parent::beforeStore($is_linked);
        // If event takes place today we simulate that reminder email already has been sent
        /*if($this->event_date == date('Y-m-d')){
            $this->reminder_email_sent = true;
        }*/
    }

    public function  afterStore($was_linked) {
        parent::afterStore($was_linked);
    }

    public function sendReminderEmail(){
        self::sendEmail("reminder");
    }

    public function sendThankyouEmail(){
        self::sendEmail("thankyou");
    }

    public function sendInviteEmail(){
        self::sendEmail("invite");
        \nmvc\messenger\redirect_message(url("/"), _("Your invites have been sent!"), "good");
    }

    private function sendEmail($type = "invite"){
        switch($type){
            case "invite":
                $invitees = EventInviteeModel::select()->where("event")->is($this)->
                    and("invitee->is_unsubscribed")->is(false)->
                    and("invite_email_sent")->is(false);
                $subject = _("Personal invitation to %s",$this->view('title'));
                $mail_view = "event_invite";
                //$this->invite_email_sent = true;
                break;
            case "reminder":
                // Only send reminder email to people that RVSP attending to avoid angry faces
                $invitees = EventInviteeModel::select()->
                    where("event")->is($this)->
                    and("rvsp")->is(\nmvc\EventInviteeModel::ATTENDING)->
                    and("invitee->is_unsubscribed")->is(false)->
                    and("reminder_email_sent")->is(false);
                $subject = _("Reminder for %s",$this->view('title'));
                $mail_view = "event_reminder";
                //$this->reminder_email_sent = true;
                break;
            case "thankyou":
                // Only send thankyou email to people that RVSP attending to avoid angry faces
                $invitees = EventInviteeModel::select()->
                    where("event")->is($this)->
                    and("rvsp")->is(\nmvc\EventInviteeModel::ATTENDING)->
                    and("invitee->is_unsubscribed")->is(false)->
                    and("reminder_email_sent")->is(true)->
                    and("thankyou_email_sent")->is(false);
                $subject = _("Thank you for attending %s",$this->view('title'));
                $mail_view = "event_thankyou";
                //$this->thankyou_email_sent = true;
                break;
        }

        foreach($invitees as $invitee):
            \nmvc\MailHelper::sendMail($mail_view,
                    array(
                        "event_name"=>$this->view('title'),
                        "event_description"=>$this->description,
                        "event_date"=>$this->view('event_date'),
                        "event_time"=>$this->view('event_time'),
                        "street"=>$this->view('street'),
                        "zip"=>$this->view('zip'),
                        "city"=>$this->view('city'),
                        "rvsp_link"=>$invitee->generateRvspLink(),
                        "hub_name"=>$this->hub->view('city'),
                        "ambassadors"=>$this->getAmbassadors(),
                        "map_image"=>$this->generateStaticGoogleMapsImage(),
                        "google_maps_link"=>$this->generateGoogleMapsLink($invitee->invitee),
                        "attendees"=>$this->getAttendees(),
                        "unsubscribe_link"=>$invitee->generateUnsubscribeLink(),
                        "invitee_type"=>$invitee->invitee->group->view('context')
                    ),
                    $subject,
                    $invitee->invitee->view('username'),
                    false,
                    array()
                    );

            switch($type){
                case "invite":
                    $invitee->invite_email_sent = true;
                    break;
                case "reminder":
                    $invitee->reminder_email_sent = true;
                    break;
                case "thankyou":
                    $invitee->thankyou_email_sent = true;
                    break;
            }

            $invitee->store();
        endforeach;
        // Store that email is sent
        $this->store();
    }


    private function getAttendees(){
        return userx\UserModel::select()->where("id")->isIn(
            EventInviteeModel::select("invitee")->where("event")->is($this)->and("rvsp")->is( \nmvc\EventInviteeModel::ATTENDING )
         );
    }

    private function getAmbassadors(){
        return userx\UserModel::select()->where("id")->isIn(
            HubAmbassadorModel::select("ambassador")->where("hub")->is($this->hub)
         );
    }

    /*
     *  Generates a static map using the Google Maps static API
     *  @params size Size of map in widthxheight format
     *  @params zoom Zoom factor
     */
    public function generateStaticGoogleMapsImage( $size = "512x300", $zoom = "14" ){
        // If there is a complete address we will generate a map
        if ( $this->street != "" && $this->city != "" && $this->hub_id != null ){
            $url_friendly_address = \rawurlencode( $this->view('street') ." ". $this->view('city') . " ". $this->hub->view('country') );
            return "http://maps.google.com/maps/api/staticmap?center=$url_friendly_address&zoom=$zoom&size=$size&maptype=roadmap&markers=color:red|label:Here|$url_friendly_address&sensor=false";
        } else {
            return null;
        }
    }

    private function generateGoogleMapsLink($user = null){
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




    
    public function uiValidate($interface_name) {
        $err = array();
        if($this->hub == null)
               $err[$this->hub] = _("Field must be entered!");
        foreach (array(
        "title", "street",
        "city", "event_time"
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
                "street" => array(_("Street"), "For Google Maps"),
                "zip" => array(_("Zip"), ""),
                "city" => array(_("City"), "For Google Maps"),
            );

        }
    }

    public static function getEnlistColumns() {
        return array(
            "title" => "Title",
            "hub" => "Hub",
            "event_date" => "Date",
            "attendees" => "Attendees"
        );
    }

    public function getTableEnlistValues() {
        $rvsp_yes = \nmvc\EventInviteeModel::select()->where("event")->is($this)->and("rvsp")->is( \nmvc\EventInviteeModel::ATTENDING )->count();
        $invitees = \nmvc\EventInviteeModel::select()->where("event")->is($this)->and("invite_email_sent")->is(true)->count();
        $have_not_replied = \nmvc\EventInviteeModel::select()->where("event")->is($this)->and("rvsp")->is( \nmvc\EventInviteeModel::NO_RVSP )->count();
        return array(
            "attendees" => "<b>$rvsp_yes</b> ($invitees invites, $have_not_replied unreplied)"
        );
    }
}