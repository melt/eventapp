<?php namespace nmvc; ?>

<?php _("Hi,"); ?>

<?php _("You have been invited to the below event. Please RVSP as soon as you can!"); ?>

<?php echo $this->title; ?>
<?php echo _("%s at %s (GMT+0100)", $this->date, $this->time); ?>
<?php echo $this->venue; ?>, <?php echo $this->street; ?>
<?php echo $this->city; ?> <?php echo $this->zip; ?>
RVSP Now: <?php echo $this->rvsp_link ?>


Looking forward to meeting you!


<?php _("Cheers,"); ?>
<?php _("Sandbox %s Ambassadors",$this->hub_name); ?>

Per Jonsson, +46 70 299 97 97, per.d.jonsson@gmail.com