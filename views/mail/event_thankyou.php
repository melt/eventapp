<?php namespace nmvc; ?>

<h2 class="primary-heading no-margin-top"><?php echo _("Hi,"); ?></h2>
<p>
<?php echo _("Thank's for attending the below event!"); ?><br/><br/>
<?php echo _("Attached you will find the list of attendees for your convenience. Feel free to contact the ambassadors with your feedback."); ?>
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



            <p> <?php echo _("Cheers,"); ?><br/>
<?php echo _("Sandbox %s Ambassadors", $this->hub_name); ?></p>

        <p>
<?php if($this->ambassadors != null): ?>
<?php foreach ($this->ambassadors as $ambassador): ?>
<?php echo $ambassador->getName() . ", " . $ambassador->phone . ", " . $ambassador->username; ?>
<?php endforeach; ?>
<?php endif; ?>
</p>