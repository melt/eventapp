<?php namespace nmvc; ?>





<?php if ($this->fb_user && $this->user): ?>


>




    <script>
        $(function() {
            $( "#tabs" ).tabs({cookie: {path: '/', domain: <?php echo string\quote(APP_ROOT_HOST); ?>}});
        });
    </script>



    <div class="demo">

        <div id="tabs">
            <ul>
                <li><a href="#tabs-1"><?php echo _("My Profile"); ?></a></li>
                <li><a href="#tabs-2"><?php echo _("Hubs"); ?></a></li>
                <li><a href="#tabs-3"><?php echo _("Events"); ?></a></li>
                <li><a href="#tabs-4"><?php echo _("Users"); ?></a></li>


            </ul>
            <div id="tabs-1">
                <h3><a href="<?php echo $this->logout_url; ?>">Logout</a></h3>

                <img src="https://graph.facebook.com/<?php echo $this->fb_user; ?>/picture?type=small">


            <?php $interface = new qmi\ModelInterface("user_profile", "cell"); ?>
            <?php echo $interface->startForm(); ?>
<?php echo $interface->getInterface($this->user); ?>
<?php echo $interface->finalizeForm(true); ?>

        </div>
        <div id="tabs-2">
            <?php
            AjaxController::invoke("_print_instances_list", array(
                        HubModel::select()->orderBy("city", "asc"),
                        _("Hubs"),
                        "/static/img/home.png",
                            ), true);
            ?>

            <h2><?php echo _("New Hub"); ?></h2>

<?php $interface = new qmi\ModelInterface("new_hub", "cell"); ?>
<?php echo $interface->startForm(); ?>
<?php echo $interface->getInterface($this->new_hub); ?>
<?php echo $interface->finalizeForm(true); ?>



        </div>
        <div id="tabs-3">

            <?php
            AjaxController::invoke("_print_instances_list", array(
                        EventModel::select()->orderBy("event_date", "asc"),
                        _("Events"),
                        "/static/img/calendar-blue.png",
                            ), true);
            ?>
<?php $interface = new qmi\ModelInterface("new_event", "cell"); ?>
<?php echo $interface->startForm(); ?>
<?php echo $interface->getInterface($this->new_event); ?>
<?php echo $interface->finalizeForm(true); ?>


        </div>

        <div id="tabs-4">

<?php
            AjaxController::invoke("_print_instances_list", array(
                        userx\UserModel::select(),
                        _("Users"),
                        "/static/img/user.png",
                        "user_list"), true);
?>

        </div>
    </div>

</div><!-- End demo -->






<?php else: ?>

                <div class="center_content">
                    <a id="fb_button" href="<?php echo $this->login_url; ?>">
                        <img id="fb_login_image" src="http://static.ak.fbcdn.net/images/fbconnect/login-buttons/connect_light_large_long.gif" alt="Connect to Facebook"/>
                    </a>

                    <h3><a href="<?php echo url("/admin/spec"); ?>">High Level Specification</a></h3>
                    <h3><a href="<?php echo url("/reports/r20110507"); ?>">Status Check 2011-05-07</a></h3>
                </div>

<?php endif; ?>