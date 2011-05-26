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
        } else if(selected.val() == 2){
            $('.fc_why_not_attend').show();
            $('.fc_most_exciting_project').hide();
            $('.fc_biggest_challenge').hide();
            $('.fc_generally_help').hide();
            $('.fc_wants_to_skype').hide();
            $('.user_update_form').hide();
        }
  }

</script>

<h2>RVSP to <?php echo $this->rvsp->event->view("title"); ?></h2>
    <?php $interface = new qmi\ModelInterface("rvsp_page", "cell"); ?>
    <?php echo $interface->startForm(); ?>
    <?php echo $interface->getInterface($this->rvsp); ?>

<?php if($this->user != null): ?>

<div class="user_update_form">
<h2>Is this still you?</h2>
    <?php $interface = new qmi\ModelInterface("rvsp_page", "cell"); ?>
    <?php //echo $interface->startForm(); ?>
    <?php echo $interface->getInterface($this->user); ?>
    <?php //echo $interface->finalizeForm(false); ?>
</div>

<?php endif; ?>

    <?php echo $interface->finalizeForm(true); ?>


<?php else: ?>

<h2>Invalid invitee link: did you already RVSP to this event?</h2>

<h2>If not, please recheck your invitation email and contact your local ambassador.</h2>
<?php endif; ?>