<?php namespace melt\qmi;
/* Auto generated empty class override. */


class InterfaceCallback extends InterfaceCallback_app_overrideable {
	
    /* Custom interface callback for contact form - instead of saving instance to database */
    public function ic_events_details() {
        // Validate the form
        $this->doValidate();
        // Store the results
        $this->doStore();
        $instances = $this->getInstances();
        $event = $instances['melt\EventModel'][0];
        \melt\request\redirect( url("/events_invitees/". $event->id ) );  
    }
}
