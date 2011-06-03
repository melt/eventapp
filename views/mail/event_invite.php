<?php namespace nmvc; ?>

<h2 class="primary-heading no-margin-top"><?php echo _("Hi,"); ?></h2>
<p>
<?php echo _("You have been invited to the below event. Please RVSP as soon as you can!"); ?>
</p>

<h1 class="secondary-heading"><?php echo $this->event_name; ?></h1>
<p>
<b><?php echo _("%s at %s (GMT+0100)", $this->event_date, $this->event_time); ?></b><br/>
<?php echo $this->street; ?><br/>
<?php echo $this->city; ?> <?php echo $this->zip; ?><br/>
        <a href="<?php echo $this->rvsp_link ?>"><?php echo _("RVSP / Give Us Your Response"); ?></a>
    </p>
    <p>
    <?php if ($this->event_description != ""): ?><em><?php echo $this->event_description; ?></em><?php endif; ?>
    </p>

<?php if ($this->map_image != null): ?>
            <img src="<?php echo $this->map_image; ?>" alt=""/>
<?php endif; ?>

            <h1 class="secondary-heading"><?php echo _(""); ?></h1>

            <p> <?php echo _("Cheers,"); ?><br/>
<?php echo _("Sandbox %s Ambassadors", $this->hub_name); ?></p>

        <p>
<?php if($this->ambassadors != null): ?>
<?php foreach ($this->ambassadors as $ambassador): ?>
<?php echo $ambassador->getName() . ", " . $ambassador->phone . ", " . $ambassador->username; ?>
<?php endforeach; ?>
<?php endif; ?>
</p>









