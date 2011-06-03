<?php namespace nmvc; ?>
<?php echo $this->content; ?>
\n\n
&copy; <?php echo date("Y"); ?> Sandbox Network. <?php if(isset($this->unsubscribe_link)): ?><a target="_blank" href="<?php echo $this->unsubscribe_link; ?>"><?php echo _("Click on this link"); ?></a> to unsubscribe from all these emails.<?php endif; ?>