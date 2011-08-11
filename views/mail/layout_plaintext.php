<?php namespace melt; ?>
<?php echo $this->content; ?>
¬© <?php echo date("Y"); ?> Sandbox Network. <?php if(isset($this->unsubscribe_link)): ?><a target="_blank" href="<?php echo $this->unsubscribe_link; ?>"><?php echo _("Click on this link"); ?></a> to unsubscribe from all future emails.<?php endif; ?>