<?php namespace nmvc; ?>
<div id="stylized" class="myform">
    <h1><?php echo _("Thanks for responding!"); ?></h1>
    <?php if($this->rvsp==1): ?>
    <p><?php echo _("You will receive a reminder to <b>%s</b> one day before the event.",$this->email); ?></p>
    <?php else: ?>
    <p><?php echo _("We will miss you this time! See you at the next event."); ?></p>
    <?php endif; ?>
</div>