<?php namespace melt; ?>
<h2>Hubs</h2>
<?php if($this->email->members_only == true): ?>
Use this form to email all <strong><?php echo $this->hub->getMemberCount(); ?> members</strong> of the <strong><?php echo $this->hub->view('city'); ?> hub</strong>.
<?php else: ?>
Use this form to email the entire community of <strong><?php echo $this->hub->getCommunityCount(); ?> people</strong> in the <strong><?php echo $this->hub->view('city'); ?> hub</strong>.
<?php endif; ?>
<?php $interface = new qmi\ModelInterface("send_email"); ?>
<?php echo $interface->startForm(); ?>
<?php echo $interface->getInterface($this->email); ?>
<input type="submit" value="Send Email" />
<?php echo $interface->finalizeForm(false); ?>