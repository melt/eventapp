<?php namespace nmvc; ?>

<?php $interface = new qmi\ModelInterface("userx\\login", "cell"); ?>
<?php echo $interface->startForm(); ?>
    <?php echo $interface->getInterface(new userx\UserModel(true)); ?>
<?php echo $interface->finalizeForm(true); ?>