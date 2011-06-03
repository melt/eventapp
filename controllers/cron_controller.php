<?php namespace nmvc;

class CronController extends AppController {

    public function cron(){
      // Dates to select in between
      $today = date("Y-m-d");
      $one_day_from_now = date("Y-m-d", strtotime(date("Y-m-d", strtotime($today)) . " +1 day"));

        // Select events to send reminder email for
        $this->reminder_events = \nmvc\EventModel::select()->where(
        expr("event_date")->isntMoreThan($one_day_from_now)->and("event_date")->isntLessThan($today)
        )->and("reminder_email_sent")->is(0)->orderBy("event_date", "asc")->all();
        foreach($this->reminder_events as $event){
            $event->sendReminderEmail();
        }

    }
}