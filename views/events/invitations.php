<?php namespace melt; ?>
<?php $this->layout->enterSection('head'); ?>
<script type="text/javascript">
    $(document).ready(function() {
	$('.invitations input').click(function() {
                window.location.href = $(this).attr("href");
	});
	$('.navigation input').click(function() {
                window.location.href = $(this).attr("href");
	});
  });
</script>
<?php $this->layout->exitSection(); ?>
<h2>Invitations to <?php echo $this->event->title; ?></h2>


<?php // Enter custom fields here ?>

<div class="invitations">

<h3>Send Invitation</h3>
<p>This email will be sent to people that have not yet received an invitation.</p>
<input id="invitation" href="/events/invitations_send/<?php echo $this->event->id; ?>/invitation" type="submit" value="Send To <?php echo $this->event->getInvitations()->count(); ?> People Now" /> 

<h3>Send Invitation Reminder</h3>
<p>This email will be sent to people that have not yet RSVPed to the event.</p>
<input id="invitation_reminder" href="/events/invitations_send/<?php echo $this->event->id; ?>/invitation_reminder" type="submit" value="Send To <?php echo $this->event->getInvitationReminders()->count(); ?> People Now" /> 

<h3>Force Send Attendees Reminder</h3>
<p>This email is automatically sent one day prior to the event to people that have RSVPed attending.</p>
<input id="reminder" href="/events/invitations_send/<?php echo $this->event->id; ?>/reminder" type="submit" value="Force Send To <?php echo $this->event->getAttending()->count(); ?> People Now" /> 


<h3>Force Send Thankyou</h3>
<p>This email is automatically sent one day after the event to people that have RSVPed attending.</p>
<input id="thankyou" href="/events/invitations_send/<?php echo $this->event->id; ?>/thankyou" type="submit" value="Force Send To <?php echo $this->event->getAttending()->count(); ?> People Now" /> 

</div>

<br/><br/><br/>
<div class="navigation">


<input id="previous_step" href="/events/invitees/<?php echo $this->event->id; ?>/<?php echo $this->event->id; ?>" type="submit" value="Previous Step" /> or <input id="send_later" href="/events/" type="submit" value="Send Later" /> 

</div>