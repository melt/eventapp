<?php namespace melt; ?>

<h2 class="primary-heading no-margin-top"><?php echo _("Hi,"); ?></h2>
<p>
<?php if($this->is_reminder == true): ?>    
    <strong><?php echo _("--- This is a reminder. We need your RSVP asap. ---"); ?></strong>  
<?php endif; ?>
<?php echo _("You have been invited to the below event. Please RVSP as soon as you can!"); ?>
</p>

<h1 class="secondary-heading"><?php echo $this->event_name; ?></h1>
<p>

<?php if($this->when_later == false): ?>
    <b><?php echo _("%s at %s", $this->event_date, $this->event_time); ?></b><br/>
<?php endif; ?>

<?php if($this->where_later == false): ?>
    <?php echo $this->street; ?><br/>
    <?php echo $this->city; ?> <?php echo $this->zip; ?><br/>
<?php endif; ?>

        <a href="<?php echo $this->rvsp_link ?>"><?php echo _("RVSP / Give Us Your Response"); ?></a>
    </p>
    <p>
    <?php if ($this->event_description != ""): ?><em><?php echo $this->event_description; ?></em><?php endif; ?></p>
    <p>
    <strong><?php echo $this->closed_event; ?></strong>
    </p>
    
    <p>
  

<?php if ($this->map_image != null): ?>
            <img src="<?php echo $this->map_image; ?>" alt=""/>
<?php endif; ?>

            <h1 class="secondary-heading"><?php echo _(""); ?></h1>

            <p> <?php echo _("Best Wishes,"); ?><br/>
<?php echo $this->organizer->getName(); ?><br/>
<?php echo _("Sandbox %s", $this->hub_name); ?></p>
            <p>__</p>
            <p><strong>Questions?</strong></p>
            <p>Reply to this email or contact <strong><?php echo $this->organizer->getName(); ?></strong>.<br/>
                Phone: <?php echo $this->organizer->phone; ?></strong> / Email: <strong><?php echo $this->organizer->username; ?></strong>
</p>









