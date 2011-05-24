<?php namespace nmvc;

class EventModel extends AppModel implements qmi\UserInterfaceProvider, AjaxListable {
    /* Fields */
    public $title = array('core\TextType', 128);
    public $venue = array('core\TextType', 128);
    public $event_date = array('core\DateType');
    public $event_time = array('core\TimestampType');
    public $address = array('core\TextType', 128);
    public $zip_code = array('core\TextType', 16);
    public $city = array('core\TextType', 128);
    public $country = array('core\CountryType');
    /* Object Relations */
    public $hub_id = array('core\PointerType', 'HubModel', 'CASCADE');

    public $invite_email_sent = array('core\BooleanType');
    public $reminder_email_sent = array('core\BooleanType');
    public $thankyou_email_sent = array('core\BooleanType');
    
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

    public static function uiGetInterface($interface_name, $field_set) {

        switch ($interface_name) {
        case "new_event":
            return array(
                "title" => array(_("Title"), ""),
                "venue" => array(_("Venue"), ""),
                "event_date" => array(_("Date"), ""),
                "event_time" => array(_("Time"), ""),
                "address" => array(_("Street"), ""),
                "zip_code" => array(_("Zip"), ""),
                "city" => array(_("City"), ""),
                "country" => array(_("Country"), ""),
            );

        }
    }

    public function doRemove() {
        $this->unlink();
        \nmvc\request\send_json_data(true);
    }
}