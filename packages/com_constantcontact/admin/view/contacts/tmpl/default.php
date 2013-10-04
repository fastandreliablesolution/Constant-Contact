<?php
// no direct access
defined('_JEXEC') or die;
JHtml::_('behavior.keepalive');
$document =JFactory::getDocument();
$document->addScript("http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js");
?>
<style>
form { display: block; margin: 20px auto; background: #eee; border-radius: 10px; padding: 15px }
#progress { position:relative; width:400px; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }
#bar { background-color: #B4F5B4; width:0%; height:20px; border-radius: 3px; }
#percent { position:absolute; display:inline-block; top:3px; left:48%; }
</style>
<script type="text/javascript">
    jQuery.noConflict();   
      function batchCopyMove() {	
	    var actionval = '';	  
		var checkeditems = jQuery('input:checkbox[name="cid[]"]:checked').map(function() { return jQuery(this).val() }).get().join(",");	
		
		if(checkeditems == '') {
			alert("Select Contacts from list");
			return false;
		}
		
		if(jQuery('#filter_move_list_id').val() == '') {
			alert("Select Contactlist where contacts has to be Moved/Copied");
			return false;
		}	
       
		for( i = 0; i < document.adminForm.action.length; i++ )
		{
			if( document.adminForm.action[i].checked == true ) { 
			actionval = document.adminForm.action[i].value; 
			break; // stop searching as soon as one is found
			} 
		}
		
		var response = jQuery.ajax({
			    url: 'index.php?option=com_constantcontact&task=contacts.batch&format=json',
				data: { contacts: checkeditems, action: actionval, listid: jQuery('#filter_move_list_id').val() },
                dataType: 'text',
                type: 'POST',
				beforeSend: function()
					{
						jQuery("#progress").show();
						jQuery("#bar").width('0%');
						jQuery("#batch_process").hide();
						jQuery("#percent").html("0%");
					},				
                success: function(data) {
                   jQuery("#batch_process").show();
				   jQuery("#bar").width('100%');
		           jQuery("#percent").html('100%');
				   jQuery('#progress').delay(3000).fadeOut(400);				  
			    },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    alert("Error: " + errorThrown); 
                }  
            });
		  
	}  
</script>	

<form action="<?php echo JRoute::_(JUri::getInstance()); ?>" method="post" name="adminForm" id="adminForm">

<?php echo $this->loadTemplate('filter'); ?>
<?php echo $this->loadTemplate('table'); ?>
<?php echo $this->loadTemplate('batch'); ?>
<div>
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0" />
    <input type="hidden" name="next" id="next" value="<?php echo $this->state->get('list.next'); ?>" />
    <?php echo JHtml::_('form.token'); ?>
</div>
</form>
 