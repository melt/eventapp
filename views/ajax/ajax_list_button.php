<?php namespace nmvc; ?>
<a class="button <?php echo $this->class; ?>" href="<?php echo $this->url ?>" <?php if ($this->onclick != ""): ?>onclick="<?php echo $this->onclick; ?>"<?php endif; ?>>
    <?php if ($this->icon): ?>
        <img src="<?php echo $this->icon; ?>" alt="icon" />
    <?php endif; ?>
    <?php if ($this->confirm_msg): ?>
        <span class="confirm_msg">
            <?php echo escape($this->confirm_msg); ?>
        </span>
    <?php endif; ?>
    <?php echo escape($this->title); ?>
</a>