<?php namespace nmvc; ?>


<div id="stylized" class="myform">
<h1><?php echo _("Add invitees to %s",$this->event->view('title')); ?></h1>
<p><?php echo _("Use this form to add invitees to the event %s on %s.",$this->event->view('title'),$this->event->view('event_date')); ?></p>
<?php $interface = new qmi\ModelInterface("add_invitees_by_email", "cell"); ?>
<?php echo $interface->startForm(); ?>
<?php echo $interface->getInterface($this->new_event_invitee); ?>
<button type="submit"><?php echo _("Add Invitees to List"); ?></button> or <a href="<?php echo url("/"); ?>">Do this later</a>

<?php if($this->existing_invitees->count() > 0): ?>
<h1>Existing Invitees</h1>
<p><?php echo _("These people will receive the invitation to %s.",$this->event->view('title')); ?></p>
<div class="fc_list_of_invitees">
<label>&nbsp;</label>
<div class="field-group list_of_invitees">
<?php foreach($this->existing_invitees as $invitee): ?>
    <?php echo ($invitee->first_name=!"")? $invitee->getName().", ": ""; ?><?php echo $invitee->invitee->view('username'); ?>
    <a href="<?php echo qmi\get_action_link($invitee, "delete"); ?>"><?php echo _("Remove"); ?></a><br/>
<?php endforeach; ?>
</div>
</div>
<button href="<?php echo qmi\get_action_link($this->event, "sendInviteEmail", url("/")); ?>" role="button" aria-disabled="false"><?php echo _("Send Invitation Now"); ?></button> or <a href="<?php echo url("/"); ?>">Send it later</a>
<?php endif; ?>

<div class="spacer"></div>
<?php echo $interface->finalizeForm(false); ?>
</div>