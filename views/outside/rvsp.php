<?php namespace nmvc; ?>

<?php if($this->rvsp != null): ?>


<script type="text/javascript">
$(document).ready(function() {
  
        $('.rvsp').change(onRVSPSelectChange);
        $('.fc_why_not_attend').hide();
        $('.fc_most_exciting_project').hide();
        $('.fc_biggest_challenge').hide();
        $('.fc_generally_help').hide();
        $('.fc_wants_to_skype').hide();
        $('.user_update_form').hide();
        $('#user_details').hide();
        $('#submit_button').hide();
  });

  function onRVSPSelectChange(){

        var selected = $(".rvsp option:selected");
        if(selected.val() == 1){
            $('.fc_most_exciting_project').show();
            $('.fc_biggest_challenge').show();
            $('.fc_generally_help').show();
            $('.fc_wants_to_skype').show();
            $('.user_update_form').show();
            $('.fc_why_not_attend').hide();
            $('#user_details').show();
            $('#submit_button').show();
        } else if(selected.val() == 2){
            $('.fc_why_not_attend').show();
            $('.fc_most_exciting_project').hide();
            $('.fc_biggest_challenge').hide();
            $('.fc_generally_help').hide();
            $('.fc_wants_to_skype').hide();
            $('.user_update_form').hide();
            $('#user_details').hide();
            $('#submit_button').show();
        }
  }

</script>




<div id="stylized" class="myform">
<h1>RVSP to <?php echo $this->rvsp->event->view("title"); ?></h1>
<p><?php echo _("You have been invited to %s on %s at %s.", $this->rvsp->event->view("title"), $this->rvsp->event->view('event_date'), $this->rvsp->event->view('event_time')); ?></p>

    <?php $interface = new qmi\ModelInterface("rvsp_page", "cell"); ?>
    <?php echo $interface->startForm(); ?>
    <?php echo $interface->getInterface($this->rvsp); ?>
    <div class="spacer"></div>



<div id="user_details"><br/><br/>
<h1>Is this (still) you?</h1>
<p><?php echo _("Please verify your contact details below."); ?></p>
    <?php echo $interface->getInterface($this->rvsp->invitee); ?>
<div class="spacer"></div>
</div>

<button id="submit_button" type="submit"><?php echo _("Send RVSP"); ?></button>
<div class="spacer"></div>
<?php echo $interface->finalizeForm(false); ?>
</div>


<?php else: ?>

<div id="stylized" class="fullwidth">
<h1><?php echo _("Invalid invitee link: did you already RVSP to this event?"); ?></h1>

<p><?php echo _("If you selected to attend the event, you will receive a reminder with directions to the venue one day before the event"); ?></p>

<p><?php echo _("If you did not yet RVSP, please check that the URL matches the link you received in your email.<br/>If you believe there is an error, please contact your local ambassador via email."); ?></p>
</div>


<?php endif; ?>




