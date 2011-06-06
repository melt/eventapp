<?php namespace nmvc\qmi;
/* Auto generated empty class override. */


class InterfaceCallback extends InterfaceCallback_app_overrideable {

    public function ic_add_invitees() {
        $this->doValidate();
        $instances = $this->getInstances();
        $instance = $instances['nmvc\EventInviteeModel'][0];
        // Break up lists of emails into an array
        $invitees_previous = explode(",",$instance->list_of_members);
        $invitees_new = explode(",",$instance->list_of_emails);
        // Merge array to receive complete list of invitees
        $invitees = array_filter( array_map('trim', array_merge($invitees_previous,$invitees_new) ) );
        $include_members = $instance->include_members_in_hub;

        // If checkbox is true, add hub members as invitees
        if($include_members == true){
            $members = \nmvc\userx\UserModel::select()->where("hub")->is($instance->event->hub)->and("group->context")->isnt(\nmvc\userx\GroupModel::CONTEXT_GUEST);
            foreach($members as $member){
                 $invitee = new \nmvc\EventInviteeModel();
                 $invitee->event = $instance->event;
                 $invitee->invitee = $member;
                 $invitee->store();
            }
        }

        if(!empty($invitees)) {
            foreach($invitees as $email){
                $email = trim($email);
                // Special error handling in callback since standard error handling does not take care of this case
                if (!\nmvc\string\email_validate($email)){
                    \nmvc\messenger\push_message("One of your email addresses are incorrect, please recheck for typos!", "bad");
                    break;
                }

                // Create a new invitee to the event
                $invitee = new \nmvc\EventInviteeModel();
                $invitee->event = $instance->event;

                // Connect to existing user if he/she already exists
                $user = \nmvc\userx\UserModel::select()->where("username")->is($email)->first();
                // User does not exist
                if($user == null){
                    // Create a user to get the id
                    $user = new \nmvc\userx\UserModel();
                    $user->username = $email;
                }
                // Attach that id to the invitee before store
                $invitee->invitee = $user;
                // Store both
                $invitee->store();
                $user->store();
            }
        }
    }

    public function ic_new_event() {
        $this->doValidate();
        $this->doStore();
        $instances = $this->getInstances();
        $instance = $instances['nmvc\EventModel'][0];
        \nmvc\messenger\redirect_message(url("/event/add_invitees/".$instance->id), _("Event successfully added! Now add some invitees :-)"), "good");
    }

    public function ic_rvsp_page() {
        $this->doValidate();
        $this->doStore();
        $instances = $this->getInstances();
        $invitee = $instances['nmvc\EventInviteeModel'][0];
        // Redirect to thankyou page if save succeeds
        \nmvc\messenger\redirect_message(url("/outside/rvsp_thanks/", array( "rvsp" => $invitee->rvsp, "email" => $invitee->invitee->username) ), _("Thank you for your RVSP!"), "good");
    }

    public function ic_user_profile() {
        $this->doValidate();
        $this->doStore();
        \nmvc\messenger\redirect_message(url("/"), _("Your profile was updated!"), "good");
    }

}
