<?php namespace melt; ?>
<?php $this->layout->enterSection('head'); ?>
<script type="text/javascript">
    $(document).ready(function() {
       /* Custom JQuery to allow entering later */     
       $(".c_when_later input").click(function(){            
            $("#when")//find(":input[type=text]")
            .attr("hidden", $(this).is(":checked"));
       });
       
       $(".c_where_later input").click(function(){            
            $("#where")//find(":input[type=text]")
            .attr("hidden", $(this).is(":checked"));
       });
       
       if($(".c_where_later input").is(":checked")){
           $("#where").attr("hidden",true);
       }
       
       if($(".c_when_later input").is(":checked")){
           $("#when").attr("hidden",true);
       }
       
       
       $(".c_street input,.c_city input").keyup(function() {
            clearTimeout($.data(this, 'timer'));
            var wait = setTimeout(search, 1000);
            $(this).data('timer', wait);   

       });
  });
  
  
  function search() {
    $('#map_canvas').googleMaps({
        geocode: $('.c_location input').val() + " " + $('.c_street input').val() + " " + $('.c_city input').val()
    });
    }

  
</script>
<?php $this->layout->exitSection(); ?>
<h2><?php echo ($this->event->id==0)? "Add New": "Edit"; ?> Event</h2>


<?php echo $this->display("events_breadcrumb",array("events_breadcrumb"=>$this->events_breadcrumb)); ?>

<?php $interface = new qmi\ModelInterface("event_details"); ?>
<?php echo $interface->startForm(); ?>

<?php if($this->event->hub == null): ?>
<h3>HUB</h3>
<p>Enter the hub that this event belongs to. If this is a global event, select "Global".</p>
<?php echo $interface->getInterface($this->event,"hub"); ?>
<?php endif; ?>


<h3>WHAT</h3>
<p>Enter the subject, topic or title of this event.</p>

<?php echo $interface->getInterface($this->event,"what"); ?>

<h3>WHEN</h3>

<?php echo $interface->getInterface($this->event,"when_later"); ?>
<div id="when">
<p>Enter the date and time of the event.</p>
<?php echo $interface->getInterface($this->event,"when"); ?>
</div>
    
<h3>WHERE</h3>
<?php echo $interface->getInterface($this->event,"where_later"); ?>
<div id="where">
<p>Enter the location of the event. The address will be retrieved via Google Maps and attached to the invitation - so make sure you get it right.</p>
<?php echo $interface->getInterface($this->event,"where"); ?>
<p><label>Map</label></p>
<div id="map_canvas" style="width: 500px; height: 300px; position: relative; background-color: rgb(229, 227, 223);"></div>
</div>
<input type="submit" value="Next Step" /> or <a href="<?php echo url("/events"); ?>" title="Go Back to Events">Cancel</a>
<?php echo $interface->finalizeForm(false); ?>