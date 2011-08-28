<?php namespace melt;

class ApiController extends AppController {


    /*
     * Public API call to get events in certain hub.
     */
    public function get_events( $hub_name, $scope = "all" ) {
        $scope = @$_GET["scope"];
        switch($scope){
            case "all":
                $results = \melt\EventModel::select()->where("hub->city")->isLike("%".$hub_name."%")->orderBy("event_date","ASC");
                break;
            case "upcoming":
                $results = \melt\EventModel::select()->where("hub->city")->isLike("%".$hub_name."%")->and("event_date")->isntLessThan(date('Y-m-d'))->orderBy("event_date","ASC");
                break;
            case "past":
                $results = \melt\EventModel::select()->where("hub->city")->isLike("%".$hub_name."%")->and("event_date")->isLessThan(date('Y-m-d'))->orderBy("event_date","ASC");
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
            \melt\request\send_json_data( false );
        else
            \melt\request\send_json_data( $response );
    }
}