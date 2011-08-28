<?php namespace melt; ?>
<h2>Attendees of the event <?php echo $this->event->view('title'); ?></h2>
<p>The following people have confirmed that they will attend.</p>
<?php echo data_tables\render_table(
        "attendees", 
        'melt\EventInviteeModel', 
        array(),
        array("bPaginate"=>false,"bSearch"=>false,"bFilter"=>false,"bJQueryUI"=>false,"bInfo"=>true),
        expr("event")->is($this->event)->and("rvsp")->is(EventInviteeModel::ATTENDING)
        ); ?>

<p>
<?php if($this->event->rsvp_closed == false): ?>
    <strong>The RSVP list is still open</strong>. 
    To avoid receiving further replies
    you can <a href="<?php echo url("/events/rsvp_list_toggle/").$this->event->id; ?>">close the RSVP list</a>
    <br/><br/>
    
    <h2>Not yet RSVPed</h2>
<p>The following people have not yet RSVPed to the event.</p>

<?php echo data_tables\render_table(
        "not_yet", 
        'melt\EventInviteeModel', 
        array(),
        array("bPaginate"=>false,"bSearch"=>false,"bFilter"=>false,"bJQueryUI"=>false,"bInfo"=>true),
        expr("event")->is($this->event)->and("rvsp")->is(EventInviteeModel::NO_RSVP)
        ); ?>
    
    
<?php else: ?>
    <strong>The RSVP list is closed</strong>.
    To receive more replies, you can <a href="<?php echo url("/events/rsvp_list_toggle/").$this->event->id; ?>">open the RSVP list</a>
<?php endif; ?></p>


