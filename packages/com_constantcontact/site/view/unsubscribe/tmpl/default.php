<?php
/**
 * @version 1.1
 * @package com_constantcontact
 * @copyright Copyright (C) 2013. All rights reserved.
 * @license GNU General Public License version 2 or later; see LICENSE.txt
 * @author Cloud Access <constantcontact@cloudaccess.net> - http://cloudaccess.net
 */

// no direct access
defined('_JEXEC') or die;
$document =JFactory::getDocument();
$document->addStyleSheet(JURI::root()."media/com_constantcontact/assets/css/constantcontact.css");

?>
<script>
function checkLists(obj) {
	var style = obj.checked;
	var cont = document.getElementById('checkboxLists');
	inputs = cont.getElementsByTagName('input');
    for (i=0;i<inputs.length;i++) {
        if (inputs[i]!=obj) {
            inputs[i].disabled = style;
        }
    }
	document.getElementById('get_emails').disabled=style;
} 
</script>

<form action="<?php echo JRoute::_(JUri::getInstance()); ?>" method="post" name="unsubscribeform" id="unsubscribeform">
<table width="100%">
    <tr>
        <td><?php echo JText::_('COM_CONSTANTCONTACT_EMAIL_PREFERENCE'); ?></td>
    </tr>   
    <tr>
        <td><?php echo JText::_('COM_CONSTANTCONTACT_EMAIL_REMOVE_ALL'); ?>&nbsp; <input type="checkbox" class="checkbox"  name="removeall" id="removeall" value="1" onclick="checkLists(this);" /></td>
    </tr>   
    <tr>
        <td><?php echo JText::_('COM_CONSTANTCONTACT_USER_TAILOR_EMAILS'); ?></td>
    </tr>   
    <tr>
        <td>
            <span id="checkboxLists">
	<?php 
	    foreach ($this->contactDetails->lists as $i => $item) {
			 $listidArray[] = $item->id;
		}
		
		foreach ($this->options as $option) { 
			$listStatus = $this->getModel('unsubscribe')->getListStatus($option->value);
			
		 if (in_array($option->value,$listidArray) && $listStatus == "ACTIVE") { 		          
		        $checked=' checked="checked"';
			  } else { 
			    $checked=''; 
			  } ?>
		   <input type="checkbox" name="lists[]" value="<?php echo $option->value;?>"  <?php echo $checked;?> /> <?php echo $option->text;?><br/>			
        <?php  } ?>
            </span>
        </td>
    </tr>   
    <tr>
        <td>
            <input type="hidden" name="contactid" id="contactid" value="<?php echo $this->contactDetails->id;?>" />
            <input type="hidden" name="task"  value="unsubscribe.unsubscribe" />
            <input class="button" type="submit" name="updatesub" id="updatesub" value="<?php echo JText::_('COM_CONSTANTCONTACT_BUTTON_UPDATE')?>" />
        </td>
    </tr>
</table>
<?php echo JHtml::_('form.token'); ?>
</form>