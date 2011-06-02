<?php namespace nmvc; ?>
<div class="cell_interface">
    <?php $print_label = function($component) { ?>
        <label for="<?php echo $component->id; ?>"><?php echo @$component->label[0]; ?>
            <?php if(@$component->label[1]): ?><span class="small"><?php echo @$component->label[1]; ?></span><?php endif; ?>
        </label>
    <?php }; ?>
    <?php foreach ($this->components as $name => $component): ?>
        <div class="fc_<?php echo $name; ?>">
            <?php if (isset($component->type->checkbox_render) && $component->type->checkbox_render): ?>
                <div class="checkbox_render">
                    <?php echo $component->html_interface; ?>
                    <?php $print_label($component); ?>
                    <?php if (@$component->label[1]): ?>
                        <span class="helptext">
                            <?php echo @$component->label[1]; ?>
                        </span>
                    <?php endif; ?>
                    <?php if (isset($component->html_error)): ?>
                        <div class="qmi_error">
                            <span><?php echo $component->html_error; ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <?php $print_label($component); ?>
                <div class="field-group <?php echo $name; ?>">
                    <?php echo $component->html_interface; ?>
                    <?php if (isset($component->html_error)): ?>
                        <div class="qmi_error">
                            <span><?php echo $component->html_error; ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>
