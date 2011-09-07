<?php namespace melt;

 class RsvpController extends AppController {

     public function index($rsvp_page_hash){
        $this->invitee = EventInviteeModel::select()->where("rsvp_page_hash")->is($rsvp_page_hash)->first();
        if($this->invitee === null)
            show_404();
    }
     
 }