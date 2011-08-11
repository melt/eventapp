<?php namespace melt;

class EventModel extends AppModel implements qmi\UserInterfaceProvider, data_tables\DataTablesListable {
    
    /* Event Information */
    public $title = array('core\TextType', 128);
    public $description = array('core\TextAreaType');
    public $event_date = array('core\DateType');
    //public $event_time = array('TimeType');
    public $location = array('core\TextType', 128);
    public $street = array('core\TextType', 128);
    /* A little bit special: we include city here in case event is outside hub city */
    public $city = array('core\TextType', 128);
    /* Every event is linked to a hub that sets the country and in normal cases also the city */
    public $hub_id = array(INDEXED,'core\SelectModelType', 'HubModel', 'CASCADE');
    /* Volatile fields in order to skip entering data for later */
    public $when_later = array(VOLATILE,'core\BooleanType');
    public $where_later = array(VOLATILE,'core\BooleanType');
    
    
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
                    );
                case "when_later":
                    return array(
                        "when_later" => _("I'll enter WHEN later!"),
                    );
                case "when":
                    return array(
                        "event_date" => _("Event Date"),
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
                    "description" => _("Description"),
                    "event_date" => _("Event Date"),
                    );
        }
    }
    
    public function dtGetValues($interface_name) {
        return array(
             "title" => "<a href=\"". url("/events_details/" . $this->hub->getID()) ."/". $this->getID() . "\">" . $this->view("title") . "</a>",
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