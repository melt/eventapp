<?php namespace nmvc;

class CronController extends userx\RestrictedController {

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
        )->orderBy("event_date", "asc")->all();
        foreach($this->reminder_events as $event){
            $event->sendReminderEmail();
        }

        // Select events to send thankyou email for
        $this->thankyou_events = \nmvc\EventModel::select()->where(
        expr("event_date")->isLessThan($one_day_ago)
        )->orderBy("event_date", "asc")->all();
        foreach($this->thankyou_events as $event){
            $event->sendThankyouEmail();
        }
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