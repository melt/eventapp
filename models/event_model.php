<?php namespace nmvc;

class EventModel extends AppModel implements qmi\UserInterfaceProvider, AjaxListable {
    /* Fields */
    public $title = array('core\TextType', 128);
    public $venue = array('core\TextType', 128);
    public $event_date = array('core\DateType');
    public $event_time = array('core\TimestampType');
    public $street = array('core\TextType', 128);
    public $zip = array('core\TextType', 16);
    public $city = array('core\TextType', 128);
    public $country = array('core\CountryType');
    /* Object Relations */
    public $hub_id = array('core\SelectModelType', 'HubModel', 'CASCADE');

    public $invite_email_sent = array('core\BooleanType');
    public $reminder_email_sent = array('core\BooleanType');
    public $thankyou_email_sent = array('core\BooleanType');
    


    public function sendInviteEmail(){
        $invitees = EventInviteeModel::select()->where("event")->is($this);
        $hub = HubModel::select("city")->where("id")->is($this->hub_id)->first();
        foreach($invitees as $invitee){
            \nmvc\MailHelper::sendMail("event_invite",
                    array(
                        "title"=>$this->view('title'),
                        "venue"=>$this->view('venue'),
                        "event_date"=>$this->view('event_date'),
                        "event_time"=>$this->view('event_time'),
                        "street"=>$this->view('street'),
                        "zip"=>$this->view('zip'),
                        "city"=>$this->view('city'),
                        "rvsp_link"=>$invitee->view('rvsp_page_hash'),
                        "hub_name"=>$hub
                    ),
                    _("Invitation to %s @ %s",$this->view('title'),$this->view('venue')),
                    $invitee->view('email'),
                    false);
        }
    }

    public function getAjaxListActions($interface_name) {
        $actions = array();
        $actions["@doRemove"] = array(_("Delete")
            , "confirm" => _("Do you really want to delete this hub?")
        );
        return $actions;
    }

    public function getAjaxListCells($interface_name) {
        return array(
            _("Title") => '<strong>' . $this->view("title") . '</strong>',
            _("Venue") => $this->view("venue"),
        );
    }
    
    public function uiValidate($interface_name) {
        $err = array();
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
                "hub" => array(_("Hub"), ""),
                "title" => array(_("Title"), ""),
                "venue" => array(_("Venue"), ""),
                "event_date" => array(_("Date"), ""),
                "event_time" => array(_("Time"), ""),
                "street" => array(_("Street"), ""),
                "zip" => array(_("Zip"), ""),
                "city" => array(_("City"), ""),
                "country" => array(_("Country"), ""),
            );

        }
    }

    public function doRemove() {
        $this->unlink();
        //\nmvc\request\send_json_data(true);
    }
}