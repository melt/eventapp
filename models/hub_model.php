<?php namespace melt;

class HubModel extends AppModel implements qmi\UserInterfaceProvider, data_tables\DataTablesListable {
    /* Hub Information */
    public $city = array('core\TextType', 128);
    public $country = array('core\CountryType');
    
    public function __toString() {
        return $this->view('city') . " (" . $this->country . ")";
    }
    
    public static function uiGetInterface($interface_name, $field_set) {
            switch ($interface_name) {
                case "hub_details":
                    return array(
                        "city" => _("City"),
                        "country" => _("Country")
                    );
            }  
    }
    
    public function uiValidate($interface_name) {
        $err = array();
        foreach (array(
        "city", "country"
        ) as $field) {
            $this->$field = trim($this->$field);
            if ($this->$field == "")
                $err[$field] = _("Field must be entered!");
        }
        return $err;
    }
    
    
    public static function dtGetSearchCondition($interface_name, $search_term) {
    }
    
    public static function dtGetColumns($interface_name) {
        switch ($interface_name) {
            case "hubs":
            default:
                return array(
                    "city" => _("City"),
                    "country" => _("Country"),
                    "_members" => _("Members"),
                    "_total_community" => _("Total Community"),
                    "_total_events" => _("Number of Events"),
                    "_actions" => _("Actions")
                    );
        }
    }
    
    public function getEventCount(){
        return EventModel::select()->where('hub')->is($this)->count();
    }
    
    public function getCommunity(){
        return userx\UserModel::select()->where('country')->is($this->country);
    }
    
    public function getCommunityCount() {
        return userx\UserModel::select()->where('country')->is($this->country)->count();
    }
    
    public function getMembers(){
        return userx\UserModel::select()->where('country')->is($this->country)->and("user_type")->isntLessThan(7);
    }
    
    public function getMemberCount() {
        return userx\UserModel::select()->where('country')->is($this->country)->and("user_type")->isntLessThan(7)->count();
    }
    
    public function dtGetValues($interface_name) {
        $member_count = $this->getMemberCount();
        $community_count = $this->getCommunityCount();
        $event_count = $this->getEventCount();
        return array(
            "country" => $this->view('country')." (".$this->country.")",
            "_members" => $member_count . " <a href=\"". url("/hubs/email/" . $this->getID()."/1") . "\">Email</a>",
            "_total_community" => $community_count . " <a href=\"". url("/hubs/email/" . $this->getID()."/0") . "\">Email</a>",
            "_total_events" => $event_count,
            "_actions" => "<a href=\"". url("/hubs/add_edit/" . $this->getID()) . "\">Edit</a>"
        );

    }
    
    public static function dtBatchAction($interface_name, $batch_action, \melt\db\SelectQuery $selected_instances) {
        switch ($batch_action) {
            default:
                break;
        }
    }
    
    public static function dtSelect($interface_name) {
        return HubModel::select();
    }    
}