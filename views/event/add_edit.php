<?php namespace nmvc; ?>
<?php if($this->event->id == 0): // If new event, set default textarea description ?>
<script type="text/javascript">
    $(document).ready(function() {
        var default_text = "<Add a teaser (one sentence of the overall topic of the evening, for example “April’s Fools”, “Summer dinner”; exciting special guests; etc.)>";

        /*
         * Shows a default text for the description textarea that is removed on focus and not submitted with form if left intact
         **/
        $(".fc_description textarea").val( default_text );
        $(".fc_description textarea").focus(function() {
            if($(this).val() == default_text)
                $(this).val("");
        });
        $(".fc_description textarea").blur(function() {
            if($(this).val()=="")
                $(this).val( default_text );
        });
        $("#new_event_form").submit(function() {
            if($(".fc_description textarea").val()==default_text)
                $(".fc_description textarea").val("");
        });

        /*
        $(".fc_street input").keypress(function() {
            if($(this).val().length > 3 && $(".fc_city input").val().length > 3) {
                   showMap($(".fc_street input").val(),$(".fc_city input").val());
            }
        });
        $(".fc_city input").keypress(function() {
            if($(this).val().length > 3 && $(".fc_street input").val().length > 3) {
                   showMap($(".fc_street input").val(),$(".fc_city input").val());
            }
        });
        $("#google_maps").hide();
        */
        
  });
  
</script>
<?php endif; ?>

<div id="stylized" class="myform">
<h1><?php echo ($this->event->id != 0)? _("Edit"): _("Add new"); ?> <?php echo _("event"); ?></h1>
<p><?php echo _("Use this form to"); ?> <?php echo ($this->event->id != 0)? _("edit the event <b>%s</b>.",$this->event->title): _("add a new event to %s.",APP_NAME); ?></p>
<?php $interface = new qmi\ModelInterface("new_event", "cell"); ?>
<?php echo $interface->startForm(array("id"=>"new_event_form")); ?>
<?php echo $interface->getInterface($this->event); ?>
<button type="submit "role="button" aria-disabled="false"><?php echo _("Next Step"); ?></button> or <a href="<?php echo url("/"); ?>">Cancel</a>
<div class="spacer"></div>
<?php echo $interface->finalizeForm(false); ?>
</div>