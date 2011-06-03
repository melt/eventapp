<?php namespace nmvc\qmi;
/* Auto generated empty class override. */


class InterfaceCallback extends InterfaceCallback_app_overrideable {

    public function ic_rvsp_page() {
        $this->doValidate();
        $this->doStore();
        //$instances = $this->getInstances();
        //$sr = $instances['nmvc\EventInviteeModel'][0];
        \nmvc\request\redirect(url("/admin/thanks", array("rvsp" => null)));
    }

    public function ic_new_event() {
        $this->doValidate();
        $this->doStore();
        $instances = $this->getInstances();
        $event = $instances['nmvc\EventModel'][0];
        \nmvc\request\redirect("/admin/new_event_invitees/" . $event->id);
    }

    public function ic_add_invitees_by_email() {
        $instances = $this->getInstances();
        $instance = $instances['nmvc\EventInviteeModel'][0];
        // Break up list of emails into an array
        $email_array = explode(",",$instance->list_of_emails);

        foreach($email_array as $email){
            $email = trim($email);
            if (!\nmvc\string\email_validate($email))
                break;
            $invitee = new \nmvc\EventInviteeModel();
            // Every invitee belongs to this event
            $invitee->event = $instance->event;
            // Take the current email address
            $invitee->email = $email;  
            $invitee->store();
        }
    }



    public function ic_user_profile() {
        \nmvc\request\redirect("/");
    }

}
