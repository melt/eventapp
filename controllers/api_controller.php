<?php namespace nmvc;

class ApiController extends userx\RestrictedController {


    /*
     * Public API call to get events in certain hub.
     */
    public function get_events( $hub_name, $scope = "all" ) {
        $scope = @$_GET["scope"];
        switch($scope){
            case "all":
                $results = \nmvc\EventModel::select()->where("hub->city")->isLike("%".$hub_name."%")->orderBy("event_date","ASC");
                break;
            case "upcoming":
                $results = \nmvc\EventModel::select()->where("hub->city")->isLike("%".$hub_name."%")->and("event_date")->isntLessThan(date('Y-m-d'))->orderBy("event_date","ASC");
                break;
            case "past":
                $results = \nmvc\EventModel::select()->where("hub->city")->isLike("%".$hub_name."%")->and("event_date")->isLessThan(date('Y-m-d'))->orderBy("event_date","ASC");
                break;
        }
        

        $response = array();
        foreach($results as $result):
           $response[] = array(
                "title"=>$result->view('title'),
                "description"=>strip_tags($result->description),
                "event_date"=>$result->view('event_date'),
                "event_time"=>$result->view('event_time'),
                "city"=>$result->view('city')
                );
        endforeach;

        if( count($results) == 0 )
            \nmvc\request\send_json_data( false );
        else
            \nmvc\request\send_json_data( $response );
    }


    public static function getDefaultPermission(userx\GroupModel $group = null) {
        if ($group === null)
            return "Allow";
        else if ($group->context == userx\GroupModel::CONTEXT_GUEST)
            return "Allow";
        else if ($group->context == userx\GroupModel::CONTEXT_MEMBER)
            return "Allow";
        else if ($group->context == userx\GroupModel::CONTEXT_AMBASSADOR)
            return "Allow";
        else if ($group->context == userx\GroupModel::CONTEXT_ADMIN)
            return "Allow";
        else if ($group->context == userx\GroupModel::CONTEXT_SUPERADMIN)
            return "Allow";
        else
            return false;
    }
}