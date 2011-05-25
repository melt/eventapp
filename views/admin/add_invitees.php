<?php namespace nmvc; ?>

<h2><?php echo _("Adding invitees to %s on %s",$this->event->view('title'),$this->event->view('event_date')); ?></h2>

    <?php $interface = new qmi\ModelInterface("add_invitee", "cell"); ?>
    <?php echo $interface->startForm(); ?>
    <?php echo $interface->getInterface($this->event_invitee); ?>
    <?php echo $interface->finalizeForm(true); ?>


<?php foreach($this->existing_invitees as $invitee): ?>
    <?php echo $invitee->getName(); ?>

<?php endforeach; ?>