<?php namespace melt; ?>
<?php $this->layout->enterSection('head'); ?>
<script type="text/javascript">
    $(document).ready(function() {


	$('#invitation,#invitation_reminder,#reminder,#thankyou').click(function() {
                window.location.href = $("#invitation,#invitation_reminder,#reminder,#thankyou").attr("href");
	});

  });
</script>
<?php $this->layout->exitSection(); ?>
<h2>Invitations to <?php echo $this->event->title; ?></h2>


<?php // Enter custom fields here ?>


<h3>Send Invitation</h3>
<p>This email will be sent to the <strong><?php echo $this->invitees->count(); ?></strong> people that have not yet received an invitation.</p>
<input id="invitation" href="/events/invitations_send/<?php echo $this->event->id; ?>/invitation" type="submit" value="Send Now" /> 

<h3>Send Invitation Reminder</h3>
<p>This email will be sent to the <strong><?php echo $this->invitees_no_rsvp; ?></strong> people that have not yet RSVPed to the event.</p>
<input id="invitation_reminder" href="/events/invitations_send/<?php echo $this->event->id; ?>/invitation" type="submit" value="Send Now" /> 

<h3>Force Send Attendees Reminder</h3>
<p>This email is automatically sent one day prior to the event to the <strong><?php echo $this->invitees_attending; ?></strong> people that have RSVPed attending.</p>
<input id="reminder" href="/events/invitations_send/<?php echo $this->event->id; ?>/invitation" type="submit" value="Force Send Now" /> 


<h3>Force Send Thankyou</h3>
<p>This email is automatically sent one day after the event to the <strong><?php echo $this->invitees_attending; ?></strong> people that have RSVPed attending.</p>
<input id="thankyou" href="/events/invitations_send/<?php echo $this->event->id; ?>/invitation" type="submit" value="Force Send Now" /> 