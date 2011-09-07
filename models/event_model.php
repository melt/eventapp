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
    public $when_later = array('core\BooleanType');
    public $where_later = array('core\BooleanType');
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
    
    protected function initialize() {
        parent::initialize();
        //$this->event_date = date("Y-m-d");
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
        if( $this->view('event_date') == "1970-01-01" )
            $event_date = "TBD";
        else
            $event_date = $this->view('event_date');
        if( $this->rsvp_closed == true )
            $actions = "<em>RSVP List Closed</em>";
        else
            $actions = "<a href=\"". url("/events/details/" . $this->hub->getID()) ."/". $this->getID() . "\">Edit/Invite</a>";
        return array(
             "event_date" => $event_date,
             "_attendees"=>$attendees_count . " <a href=\"". url("/events/attendees/" . $this->getID()) . "\">See List</a>",
             "_actions" => $actions,
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
    
    public function sendInvitations(){
         $invitees = EventInviteeModel::select()->where("rsvp")->is( EventInviteeModel::NO_RSVP )->and("invitation_sent")->is(false);
         $user = userx\get_user();
         foreach($invitees as $invitee):
            \melt\MailHelper::sendMail("event_invitation",
                    array(
                        "event_name"=>$this->view('title'),
                        "event_description"=>$this->description,
                        "event_date"=>$this->view('event_date'),
                        "event_time"=>$this->view('event_time'),
                        "street"=>$this->view('street'),
                        "city"=>$this->view('city'),
                        "rvsp_link"=>$invitee->generateRsvpLink(),
                        "hub_name"=>$this->hub->view('city'),
                        "map_image"=>$this->generateStaticGoogleMapsImage(),
                        "google_maps_link"=>$this->generateGoogleMapsLink($invitee->invitee),
                        "attendees"=>$this->getAttendees(),
                        "closed_event"=>$this->getClosedEventText(),
                        "organizer"=>$user
                    ),
                    _("Invitation to %s",$this->view('title')),
                    $invitee->invitee->view('username'),
                    false,
                    array(),
                    $user->username,
                    $user->getName()
                    );
            $invitee->invitation_sent = true;
            $invitee->store();
         endforeach;
    }
    
    public function sendInvitationReminders(){
        
    }
    
    public function forceSendReminders(){
        
    }
    
    public function forceSendThankyous(){
        
    }
    
    public static function getAttendees(){
        return EventInviteeModel::select()->where("rsvp")->is(EventInviteeModel::ATTENDING);
    }
    
    public function getClosedEventText(){
        switch($this->closed_event){
            case 2:
                return "This event is closed and just for people with an invitation.";
            case 3:
                return "This event is for the Sandbox community, you may bring a friend.";
            default:
            case 1:
                return "This event is just for Sandbox members.";  
        }
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
            $destination_address = \rawurlencode( $this->view('street') ." ". $this->view('city') . " ". $this->hub->view('country') );
        if ( $user != null )
            $source_address = \rawurlencode( $user->view('street') ." ". $user->view('city') . " ". $user->view('country') );
        else
            $source_address = "";
            return "http://maps.google.com/?saddr=$source_address&daddr=$destination_address";
        } else {
            return null;
        }
    }

    
}