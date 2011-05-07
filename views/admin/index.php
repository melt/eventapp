<?php namespace nmvc; ?>

<h1><?php echo _("Login"); ?></h1>
<?php $interface = new qmi\ModelInterface("login", "cell"); ?>
<?php echo $interface->startForm(); ?>
    <?php echo $interface->getInterface(new userx\UserModel(true)); ?>
<?php echo $interface->finalizeForm(true); ?>

<h1><?php echo _("Facebook Login"); ?></h1>
      <div id="fb-root"></div>
      <script src="http://connect.facebook.net/en_US/all.js">
      </script>
      <script>
         FB.init({
            appId:'211329565552399', cookie:true,
            status:true, xfbml:true
         });
      </script>
      <fb:login-button perms="email,user_hometown,user_location,user_about_me,user_work_history">
         Login with Facebook
      </fb:login-button>

      

<h1><?php echo _("Registration"); ?></h1>
<?php $interface = new qmi\ModelInterface("register", "cell"); ?>
<?php echo $interface->startForm(); ?>
    <?php echo $interface->getInterface(new userx\UserModel()); ?>
<?php echo $interface->finalizeForm(true); ?>

