<?php namespace melt;

class EventModel extends AppModel implements qmi\UserInterfaceProvider, data_tables\DataTablesListable {
    
    /* Event Information */
    public $title = array('core\TextType', 128);
    public $description = array('core\TextAreaType');
    public $closed_event = array('core\SelectType','getClosedEventLabels');
    public $event_date = array('core\DateType');
    public $event_time = array('TimeType');
    public $location = array('core\TextType', 128);
    public $street = array('core\TextType', 128);
    /* A little bit special: we include city here in case event is outside hub city */
    public $city = array('core\TextType', 128);
    /* Every event is linked to a hub that sets the country and in normal cases also the city */
    public $hub_id = array(INDEXED,'core\SelectModelType', 'HubModel', 'CASCADE');
    /* Volatile fields in order to skip entering data for later */
    public $when_later = array(VOLATILE,'core\BooleanType');
    public $where_later = array(VOLATILE,'core\BooleanType');
    /* Closing the list will not allow further replies or attendees */
    public $rsvp_closed = array('core\BooleanType');
    
    
    const CLOSED_FOR_MEMBERS = 1;
    const CLOSED_FOR_INVITEES = 2;
    const CLOSED_FOR_EVERYONE = 3;
    public function getClosedEventLabels() {
        return array(
            0 => _("-- Please select --"),
            self::CLOSED_FOR_MEMBERS => _("Yes, just for members"),
            self::CLOSED_FOR_INVITEES => _("Yes, just for specific people I invite"),
            self::CLOSED_FOR_EVERYONE => _("No, members can bring friends")
        );
    }
    
    
    protected function beforeStore($is_linked) {
        parent::beforeStore($is_linked);
        if( $this->when_later == true ){
            $this->event_date = "1970-01-01";
        }
        if( $this->where_later == true ){
            $this->location = "";
            $this->street = "";
            $this->city = "";
        }
    }
    
    public static function uiGetInterface($interface_name, $field_set) {
            switch ($field_set) {
                case "hub":
                    return array(
                        "hub" => _("Hub"),
                    );
                case "what":
                    return array(
                        "title" => _("What To Do?"),
                        "description" => _("More Details.."),
                        "closed_event" => _("Is this a closed event  ?")
                    );
                case "when_later":
                    return array(
                        "when_later" => _("I'll enter WHEN later!"),
                    );
                case "when":
                    return array(
                        "event_date" => _("Event Date"),
                        "event_time" => _("Event Time (24 hr clock)")
                    );
                case "where_later":
                     return array(
                        "where_later" => _("I'll enter WHERE later!"),
                    );
                case "where":
                    return array(
                        "location" => _("Location/Venue"),
                        "street" => _("Street"),
                        "city" => _("City"),
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
        if($this->closed_event == 0)
        {
            $err["closed_event"] = _("You must select an option!");
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
        
    public static function dtGetSearchCondition($interface_name, $search_term) {
    }
    
    public static function dtGetColumns($interface_name) {
        switch ($interface_name) {
            case "overview":
            default:
                return array(
                    "title" => _("Title"),
                    "hub" => _("Hub"),
                    //"description" => _("Description"),
                    "event_date" => _("Event Date"),
                    "_attendees" => _("Attendees"),
                    "_actions" => _("Actions")
                    );
        }
    }
    
    public function dtGetValues($interface_name) {
        $attendees_count = EventInviteeModel::select()->where('event')->is($this)->count();
        return array(
             "_attendees"=>$attendees_count . " <a href=\"". url("/events/attendees/" . $this->getID()) . "\">See List</a>",
             "_actions" => "<a href=\"". url("/events/details/" . $this->hub->getID()) ."/". $this->getID() . "\">Edit/Invite</a>",
        );
    }
    
    public static function dtBatchAction($interface_name, $batch_action, \melt\db\SelectQuery $selected_instances) {
        switch ($batch_action) {
            default:
                break;
        }
    }
    
    public static function dtSelect($interface_name) {
        return EventModel::select();
    }
    

    
}