<?php namespace nmvc;

class ApiController extends userx\RestrictedController {


    /*
     * Public API call to get events in certain hub.
     */
    public function get_events($hub_name) {
        $results = \nmvc\EventModel::select()->where("hub->city")->isLike($hub_name);
        $response = array();
        foreach($results as $result):
           $response[] = array(
                "title"=>$result->view('title'),
                "description"=>strip_tags($result->description),
                "event_date"=>$result->view('event_date'),
                "event_time"=>$result->view('event_time'),
                "street"=>$result->view('street'),
                "zip"=>$result->view('zip'),
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