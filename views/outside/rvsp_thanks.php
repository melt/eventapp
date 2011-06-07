<?php namespace nmvc; ?>
<div id="stylized" class="myform">
    <h1><?php echo _("Thanks for responding!"); ?></h1>
    <?php if($this->rvsp==2): ?>
        <p><?php echo _("We will miss you! See you at the next event."); ?></p>
    <?php else: ?>
        <p><?php echo _("You will receive a reminder one day before the event."); ?></p>
    <?php endif; ?>
</div>