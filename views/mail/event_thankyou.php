<?php namespace nmvc; ?>

<h2 class="primary-heading no-margin-top"><?php echo _("Hi,"); ?></h2>
<p>
<?php echo _("Thank you for attending the %s yesterday! We hope you enjoyed it and are already looking forward to seeing you at our next event.",$this->event_name); ?>
</p>

<?php if($this->invitee_type == 0): // User is a guest ?>
<p>
<?php echo _("Those of you who are not yet admitted to our selective community, please apply <a %s>on the Sandbox website</a>",'href="http://www.sandbox-network.com/join/"'); ?>
</p>
<?php endif; ?>

<p>
<b><?php echo _("Attached you will find the list of attendees for your convenience. Please let us know how you felt about the event so that we can improve them in the future."); ?></b>
</p>

<h1 class="secondary-heading"><?php echo $this->event_name; ?></h1>
<p>
<b><?php echo _("%s at %s (GMT+0100)", $this->event_date, $this->event_time); ?></b><br/>
<?php echo $this->street; ?><br/>
<?php echo $this->city; ?> <?php echo $this->zip; ?><br/>


<h1 class="secondary-heading"><?php echo _("Attendees"); ?></h1>
<p>
<?php echo _("The following people attended this event."); ?></p>
<p>
<?php if($this->attendees != null): ?>
<?php foreach($this->attendees as $attendee): ?>
    <?php echo ($attendee->first_name=!"")? $attendee->getName().", ": ""; ?><?php echo $attendee->username; ?><br/>
<?php endforeach; ?>
<?php endif; ?>
</p><br/><br/>


<p><?php echo _("Cheers,"); ?><br/>
<?php echo _("Sandbox %s Ambassadors", $this->hub_name); ?></p>

        <p>
<?php if($this->ambassadors != null): ?>
<?php foreach ($this->ambassadors as $ambassador): ?>
<?php echo $ambassador->getName() . ", " . $ambassador->phone . ", " . $ambassador->username; ?>
<?php endforeach; ?>
<?php endif; ?>
</p>