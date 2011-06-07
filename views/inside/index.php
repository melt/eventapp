<?php namespace nmvc; ?>

<div id="stylized" class="fullwidth">
    <h1><?php echo _("Welcome to %s!",APP_NAME); ?></h1>
    <p><?php echo _("Select the action you wish to perform."); ?></p>

    <a class="navigation_button" href="<?php echo $this->logout_url; ?>"><?php echo _("Logout"); ?></a>
    
    <a class="navigation_button" href="<?php echo url("/inside/my_profile"); ?>"><?php echo _("Edit my profile"); ?></a>

    <?php if( $this->user->isAmbassador() || $this->user->isAdmin() || $this->user->isSuperAdmin() ): ?>
    <a class="navigation_button" href="<?php echo url("/event/add_edit"); ?>"><?php echo _("Add new event"); ?></a>
    <?php endif; ?>

    <?php if( $this->user->isAdmin() || $this->user->isSuperAdmin() ): ?>
    <a class="navigation_button" href="<?php echo url("/hub/add_edit"); ?>"><?php echo _("Add new hub"); ?></a>
    <?php endif; ?>
    <br/><br/>
</div>

<?php if( $this->user->isAdmin() || $this->user->isSuperAdmin() ): ?>
<br/><br/>

 <script>
        $(function() {
            $( "#tabs" ).tabs({cookie: {path: '/', domain: <?php echo string\quote(APP_ROOT_HOST); ?>}});
        });
    </script>

    <div class="demo">

        <div id="tabs">
            <ul>
                <li><a href="#tabs-2"><?php echo _("Events"); ?></a></li>
                <li><a href="#tabs-3"><?php echo _("Hubs"); ?></a></li>
                <li><a href="#tabs-4"><?php echo _("Members"); ?></a></li>
                <li><a href="#tabs-5"><?php echo _("Guests"); ?></a></li>


            </ul>

        <div id="tabs-2">


        <?php data_tables\list_model("nmvc\EventModel", "/event/add_invitees", "event/add_edit", "", null, null, false, array()); ?>


        </div>
        <div id="tabs-3">

        <?php data_tables\list_model("nmvc\HubModel", null, "hub/add_edit"); ?>




        </div>

        <div id="tabs-4">

        <?php data_tables\list_model("nmvc\userx\UserModel", null, null, null, db\expr("group->context")->isnt( userx\GroupModel::CONTEXT_GUEST ) ); ?>


        </div>


        <div id="tabs-5">

        <?php data_tables\list_model("nmvc\userx\UserModel", null, null, null, db\expr("group->context")->is( userx\GroupModel::CONTEXT_GUEST ) ); ?>


        </div>
    </div>

</div><!-- End demo -->


<?php endif; ?>
