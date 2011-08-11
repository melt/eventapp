<?php namespace melt; ?>
<?php /* For Visitors */ ?>
<?php if( $this->user == null ): ?>

<h3>What is <?php echo APP_NAME; ?>?</h3>
<p>
    <?php echo APP_NAME; ?> is the web based app to manage Sandbox events.
    If you came here a good chance is you have been invited to an event in our of our hubs.
</p>
<p>
    Should you have questions about this application, please email Nico on <strong>nico.luchsinger@sandbox-network.com</strong>.
</p>

<?php else: ?>
<?php /* For Logged In Users */ ?>


<h2>Sidebar</h2>
<p> PUT USEFUL INFO HERE </p>

<?php endif;?>