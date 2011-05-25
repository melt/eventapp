<?php namespace nmvc; ?>

<?php if($this->rvsp != null): ?>

<h2>RVSP to Event</h2>
    <?php $interface = new qmi\ModelInterface("rvsp_page", "cell"); ?>
    <?php echo $interface->startForm(); ?>
    <?php echo $interface->getInterface($this->rvsp); ?>
    <?php echo $interface->finalizeForm(true); ?>

<?php if($this->user != null): ?>
<h2>Is this still you?</h2>
    <?php $interface = new qmi\ModelInterface("user_profile", "cell"); ?>
    <?php echo $interface->startForm(); ?>
    <?php echo $interface->getInterface($this->user); ?>
    <?php echo $interface->finalizeForm(true); ?>
<?php endif; ?>


<?php else: ?>

<h2>Invalid invitee link, please recheck your invitation email.</h2>

<?php endif; ?>