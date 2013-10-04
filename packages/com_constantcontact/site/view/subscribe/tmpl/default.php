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
<form action="" method="post" name="subscribeform" id="subscribeform">
<table width="100%">
  <tr>
    <td>
	 <h4><?php echo JText::_('COM_CONSTANTCONTACT_USER_UNSUBSCRIBED')?></h4>
	</td>
  </tr>  
   <tr>
    <td>
	 <?php echo JText::_('COM_CONSTANTCONTACT_USER_UNUB_RECEIVE_EMAILS')?>
	</td>
  </tr>  
   <tr>
    <td>
	<?php
		$options   = $this->getModel('contactslist')->getOptions();
		foreach ($options as $option) {  if ($option->value == 1) { $checked=' checked="checked"'; } else { $checked=''; }?>	
		   <input type="checkbox" name="lists[]" value="<?php echo $option->value;?>"  <?php echo $checked;?> /> <?php echo $option->text;?><br/>			
        <?php  }?>
	</td>
  </tr>
  <tr>
   <td>
	<input type="hidden" name="emailid" id="emailid" value="<?php echo $this->contactDetails->email_addresses[0]->email_address;?>" />
	<input type="hidden" name="contactid" id="contactid" value="<?php echo $this->contactDetails->id;?>" />
	<input type="hidden" name="task"  value="subscribe.subscribe" />
	<input class="button" type="submit" name="updatesub" id="updatesub" value="<?php echo JText::_('COM_CONSTANTCONTACT_BUTTON_UPDATE')?>" />
	</td>
   </tr>
</table>
<?php echo JHtml::_('form.token'); ?>
</form>