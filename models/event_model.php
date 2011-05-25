<?php namespace nmvc;

class EventModel extends AppModel implements qmi\UserInterfaceProvider, AjaxListable {
    /* Fields */
    public $title = array('core\TextType', 128);
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
    


    public function sendInviteEmail(){
        $invitees = EventInviteeModel::select()->where("event")->is($this);
        $hub = HubModel::select("city")->where("id")->is($this->hub_id)->first();
        foreach($invitees as $invitee){
            \nmvc\MailHelper::sendMail("event_invite",
                    array(
                        "title"=>$this->view('title'),
                        "event_date"=>$this->view('event_date'),
                        "event_time"=>$this->view('event_time'),
                        "street"=>$this->view('street'),
                        "zip"=>$this->view('zip'),
                        "city"=>$this->view('city'),
                        "rvsp_link"=>$invitee->view('rvsp_page_hash'),
                        "hub_name"=>$hub
                    ),
                    _("Invitation to %s",$this->view('title')),
                    $invitee->view('email'),
                    false);
        }
        $this->invite_email_sent = true;
        $this->store();
    }

    public function getAjaxListActions($interface_name) {
        $actions = array();

        $has_invitees = EventInviteeModel::select("invitee")->where("event")->is($this)->count();
        if($has_invitees <= 0)
            $actions["@addInvitees"] = array(_("Add Invitees"));
        if($has_invitees > 0 && $this->invite_email_sent==false)
            $actions["@sendInviteEmail"] = array(_("Send Invite Email"));
        if($this->invite_email_sent==true && $this->reminder_email_sent == false)
            $actions["@sendReminderEmail"] = array(_("Send Reminder Email"));
        if($this->invite_email_sent==true && $this->reminder_email_sent == true && $this->thankyou_email_sent == false)
            $actions["@sendThankyouEmail"] = array(_("Send Thankyou Email"));
        $actions["@doEdit"] = array(_("Edit "));
        $actions["@doRemove"] = array(_("Delete")
            , "confirm" => _("Do you really want to delete this hub?")
        );
        return $actions;
    }

    public function getAjaxListCells($interface_name) {
        return array(
            _("Hub") => '<strong>' . $this->view("hub") . '</strong>',
            _("Title") => $this->view('title'),
            _("Date") => $this->view('event_date'),
            _("Time") => $this->view('event_time'),
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
        case "event_edit":
            return array(
                "hub" => array(_("Hub"), ""),
                "title" => array(_("Title"), "Eg. Dinner @ My Place"),
                "event_date" => array(_("Date"), ""),
                "event_time" => array(_("Time"), "HH:mm:ss"),
                "street" => array(_("Street"), "Full address shows Google Maps"),
                "zip" => array(_("Zip"), ""),
                "city" => array(_("City"), ""),
            );

        }
    }

    public function doRemove() {
        $this->unlink();
        //\nmvc\request\send_json_data(true);
    }

    public function doEdit(){
        \nmvc\request\redirect("/admin/event_edit/".$this->id);
    }

    public function addInvitees(){
        \nmvc\request\redirect("/admin/add_invitees/".$this->id);
    }
}