<?php namespace nmvc; ?>
<script type="text/javascript">
    $(document).ready(function() {

        /*
         * Requires autocomplete and does not accept other input
         **/
        $('.fc_list_of_members textarea').autocomplete("<?php echo url("/event/search_invitee"); ?>", {
		delay: 50,
                selectFirst: true,
                multiple: true,
		mustMatch: true,
		autoFill: true,
                matchContains: true,
		formatItem: formatItem,
		formatResult: formatResult

	});
        /*
         * Does not require autocomplete but gives hints if user can be found in database
         **/
        $('.fc_list_of_emails textarea').autocomplete("<?php echo url("/event/search_invitee"); ?>", {
                delay: 50,
                multiple: true,
		mustMatch: false,
		autoFill: true,
                matchContains: true,
		formatItem: formatItem,
		formatResult: formatResult

	});
	function formatItem(row) {
		return row[0] + " (<strong>" + row[1] + "</strong>)";
	}
	function formatResult(row) {
                return row[1];
		//return row[0].replace(/(<.+?>)/gi, '');
	}
	$('.fc_list_of_members textarea').result(function(event, data, formatted) {
		var hidden = $(this).parent().next().find(">:input");
		hidden.val( (hidden.val() ? hidden.val() + ";" : hidden.val()) + data[1]);
	});
	$('#sendInvites').click(function() {
                window.location.href = $("#sendInvites").attr("href");
	});

  });
</script>

<div id="stylized" class="myform">
<a title="<?php echo _("Click on map to return and edit address"); ?>" href="<?php echo url("/event/add_edit/".$this->event->id); ?>"><img id="google_maps" src="<?php echo $this->event->generateStaticGoogleMapsImage("200x120","13"); ?>"/></a>

<h1><?php echo _("Add invitees to %s",$this->event->view('title')); ?></h1>
<p><?php echo _("Use this form to add invitees to the event <b>%s</b> in the <b>%s</b> hub.",$this->event->view('title'),$this->event->hub->view('city')); ?></p>
<?php $interface = new qmi\ModelInterface("add_invitees", "cell"); ?>
<?php echo $interface->startForm(); ?>
<?php echo $interface->getInterface($this->new_event_invitee); ?>
<button type="submit"><?php echo _("Add Invitees to List"); ?></button> or <a href="<?php echo url("/"); ?>">Do this later</a>
<?php echo $interface->finalizeForm(false); ?>

<?php if($this->existing_invitees->count() > 0): ?>
<h1>Existing Invitees</h1>
<p><?php echo _("These people will receive the invitation to <b>%s</b>.",$this->event->view('title')); ?></p>

<div class="fc_list_of_invitees">
<label>&nbsp;</label>
<div class="field-group list_of_invitees">
<?php foreach($this->existing_invitees as $invitee): ?>
    <?php echo ($invitee->invitee->first_name != "") ? $invitee->invitee->getName() . ", ": ""; ?><?php echo $invitee->invitee->view('username'); ?>
    <a href="<?php echo qmi\get_action_link($invitee, "delete"); ?>"><?php echo _("Remove"); ?></a><br/>
<?php endforeach; ?>
</div>
</div>
<button id="sendInvites" href="<?php echo qmi\get_action_link($this->event, "sendInviteEmail"); ?>" role="button" aria-disabled="false"><?php echo _("Send Invitation Now"); ?></button> or <a href="<?php echo url("/"); ?>">Send it later</a>
<?php endif; ?>


<div class="spacer"></div>
</div>
<br/>