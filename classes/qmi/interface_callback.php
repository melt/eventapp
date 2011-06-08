<?php namespace nmvc\qmi;
/* Auto generated empty class override. */


class InterfaceCallback extends InterfaceCallback_app_overrideable {

    public function ic_add_invitees() {
        $this->doValidate();
        $instances = $this->getInstances();
        $instance = $instances['nmvc\EventInviteeModel'][0];
        // Break up lists of emails into an array
        $invitees = explode(",",$instance->list_of_emails);
        $invitees = array_filter( array_map('trim', $invitees ) );
        $include_members = $instance->include_members_in_hub;

        // If checkbox is true, add hub members as invitees
        if($include_members == true){
            $members = \nmvc\userx\UserModel::select()->where("hub")->is($instance->event->hub)->and("group->context")->isnt(\nmvc\userx\GroupModel::CONTEXT_GUEST);
            foreach($members as $member){
                 $invitee = new \nmvc\EventInviteeModel();
                 $invitee->event = $instance->event;
                 $invitee->invitee = $member;
                 $invitee->rvsp_page_hash = \nmvc\string\random_hex_str(16);
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
                $invitee->rvsp_page_hash = \nmvc\string\random_hex_str(16);
                // Connect to existing user if he/she already exists
                $user = \nmvc\userx\UserModel::select()->where("username")->is($email)->first();
                // User does not exist
                if($user == null){
                    // Create a user to get the id
                    $user = new \nmvc\userx\UserModel();
                    $user->username = $email;
                    $user->hub = $invitee->event->hub;
                }
                // Attach that id to the invitee before store
                $invitee->invitee = $user;
                // Store both
                $invitee->store();
                $user->store();
            }
        }
    }

    public function ic_new_hub() {
        $this->doValidate();
        $this->doStore();
        \nmvc\messenger\redirect_message(url("/"), _("Hub was added/updated!"), "good");
    }

    public function ic_new_event() {
        $this->doValidate();
        $this->doStore();
        $instances = $this->getInstances();
        $instance = $instances['nmvc\EventModel'][0];
        \nmvc\request\redirect(url("/event/add_invitees/".$instance->id));
    }

    public function ic_rvsp_page() {
        $this->doValidate();
        $this->doStore();
        $instances = $this->getInstances();
        $instance = $instances['nmvc\EventInviteeModel'][0];
        $invitee = \nmvc\EventInviteeModel::select()->where("invitee")->is($instance->invitee_id)->first();
        if($instance->rvsp == 1){
            $invitee->sendRVSPToAmbassadors();
            \nmvc\request\redirect(url("/outside/rvsp_accept/"));
        } elseif($instance->rvsp == 2){
            \nmvc\request\redirect(url("/outside/rvsp_decline/"));
        }
    }

    public function ic_user_profile() {
        $this->doValidate();
        $this->doStore();
        \nmvc\messenger\redirect_message(url("/"), _("Your profile was updated!"), "good");
    }

    public function ic_user_edit() {
        $this->doValidate();
        $this->doStore();
        \nmvc\messenger\redirect_message(url("/"), _("User was updated!"), "good");
    }

}
