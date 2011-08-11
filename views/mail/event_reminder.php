<?php namespace melt; ?>

<h2 class="primary-heading no-margin-top"><?php echo _("Hi,"); ?></h2>
<p>
<?php echo _("Your event is almost here! Check out the details below."); ?>
</p>

<h1 class="secondary-heading"><?php echo $this->event_name; ?></h1>
<p>
<b><?php echo _("%s at %s (GMT+0100)", $this->event_date, $this->event_time); ?></b><br/>
<?php echo $this->street; ?><br/>
<?php echo $this->city; ?> <?php echo $this->zip; ?><br/>
<?php if ($this->google_maps_link != null): ?>
        <a href="<?php echo $this->google_maps_link; ?>"><?php echo _("View Map / Get Directions"); ?></a>
<?php endif; ?>
    </p>

<?php if ($this->map_image != null): ?>
            <img src="<?php echo $this->map_image; ?>" alt="<?php echo $this->event_name; ?>"/>
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