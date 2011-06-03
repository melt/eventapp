<?php namespace nmvc;

class CronController extends AppController {

    /*
     * Automatically sends event emails depending on date
     */
    public function cron(){
        // Dates to select in between
        $today = date("Y-m-d");
        $one_day_from_now = date("Y-m-d", strtotime(date("Y-m-d", strtotime($today)) . " +1 day"));
        $one_day_ago = date("Y-m-d", strtotime(date("Y-m-d", strtotime($today)) . " -1 day"));

        // Select events to send reminder email for
        $this->reminder_events = \nmvc\EventModel::select()->where(
        expr("event_date")->isntMoreThan($one_day_from_now)->and("event_date")->isntLessThan($today)
        )->and("invite_email_sent")->is(1)->and("reminder_email_sent")->is(0)->orderBy("event_date", "asc")->all();
        foreach($this->reminder_events as $event){
            $event->sendReminderEmail();
        }

        // Select events to send thankyou email for
        $this->thankyou_events = \nmvc\EventModel::select()->where(
        expr("event_date")->isLessThan($one_day_ago)
        )->and("invite_email_sent")->is(1)->and("thankyou_email_sent")->is(0)->orderBy("event_date", "asc")->all();
        foreach($this->thankyou_events as $event){
            $event->sendThankyouEmail();
        }

    }

    /*
     * Run this once to setup user groups
     */
    public function setup_groups(){
        $group_array(
            array("name"=>"Superadmin","context"=>4,"root"=>1),
            array("name"=>"Administrator","context"=>3,"root"=>0),
            array("name"=>"Ambassador","context"=>2,"root"=>0),
            array("name"=>"Guest","context"=>1,"root"=>0)

        );

        foreach($group_array as $group){
            $this->group = new \nmvc\userx\GroupModel();
        $this->group->name = $group->name;
        $this->group->context = $group->context;
        $this->group->root = $group->root;
        }
        
    }

}