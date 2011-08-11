<?php namespace melt; ?>
<h2>Contact the team</h2>
<p>
    This is a sample contact form. It is equipped with the following:</p>
<ul>
    <li>VOLATILE data types set in <strong>contact_form_model.php</strong> that are used to generate form fields on-the-fly without saving them to the database</li>
    <li>An interface callback set in <strong>/classes/qmi/interface_callback.php</strong> that overrides the default callback and sends an email instead of saving the instance to the database</li>
    <li>An input form structure set in <strong>contact_form_model.php</strong> by uiGetInterface()</li>
    <li>An input form validation set in <strong>contact_form_model.php</strong> by uiValidate()</li>
</ul>
<p>
    You must have your SMTP settings properly configured to submit the form.</p>
    <?php $interface = new qmi\ModelInterface("contact_form"); ?>
    <?php echo $interface->startForm(); ?>
        <?php echo $interface->getInterface($this->contact_form); ?>
    <?php echo $interface->finalizeForm(true); ?>

