<?php namespace nmvc; ?>

<h2><?php echo _("Adding invitees to %s on %s",$this->event->view('title'),$this->event->view('event_date')); ?></h2>

    <?php $interface = new qmi\ModelInterface("add_invitee_user", "cell"); ?>
    <?php echo $interface->startForm(); ?>
    <?php echo $interface->getInterface($this->event_invitee); ?>
    <?php echo $interface->finalizeForm(true); ?>
<p>&nbsp;</p>

    <?php $interface = new qmi\ModelInterface("add_invitee_email", "cell"); ?>
    <?php echo $interface->startForm(); ?>
    <?php echo $interface->getInterface($this->event_invitee); ?>
    <?php echo $interface->finalizeForm(true); ?>


<p>&nbsp;</p>
<h2>Existing Invitees</h2>
<?php foreach($this->existing_invitees as $invitee): ?>

<?php if(isset($invitee->invitee)): ?>
    <?php echo $invitee->invitee->getName() . ", " . $invitee->invitee->view('username'); ?><br/>
<?php else: ?>
    <?php echo $invitee->email; ?><br/>
<?php endif; ?>

<?php endforeach; ?>