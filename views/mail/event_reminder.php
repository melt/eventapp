<?php namespace nmvc; ?>
<?php namespace nmvc; ?>
<?php

 namespace nmvc; ?>
<h2 class="primary-heading no-margin-top"><?php echo _("Hi,"); ?></h2>
<p>
<?php echo _("Your event is almost here! Check out the details below."); ?>
</p>

<h1 class="secondary-heading"><?php echo $this->event_name; ?></h1>
<p>
<?php echo _("%s at %s (GMT+0100)", $this->event_date, $this->event_time); ?><br/>
<?php echo $this->street; ?><br/>
<?php echo $this->city; ?> <?php echo $this->zip; ?><br/>
    <a href="<?php echo $this->rvsp_link ?>"><?php echo _("View Map / Get Directions / See Attendees"); ?></a>
</p>


<h1 class="secondary-heading"><?php echo _(""); ?></h1>

<p> <?php echo _("Cheers,"); ?><br/>
<?php echo _("Sandbox %s Ambassadors", $this->hub_name); ?></p>

<p>
    <?php foreach($this->ambassadors as $ambassador): ?>
        <?php echo $ambassador->getName() . ", " . $ambassador->phone . ", " . $ambassador->username; ?>
    <?php endforeach; ?>
</p>