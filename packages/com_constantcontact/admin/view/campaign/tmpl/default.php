<form action="<?php echo JRoute::_(JUri::getInstance()); ?>" method="post" name="adminForm" id="adminForm">
<fieldset>	
  <legend><?php echo JText::_('COM_CONSTANTCONTACT_CAMPAIGN_DETAILS')?>:</legend>
     <table class="adminlist  table table-striped">
	  <tr>
	  	<td><?php echo JText::_('COM_CONSTANTCONTACT_VIEW_CAMPAIGN_HEADER_ID')?>:</td><td><?php echo $this->campaignDetails->id;?></td>
	  </tr>
	  <tr>
		<td><?php echo JText::_('COM_CONSTANTCONTACT_VIEW_CAMPAIGN_HEADER__NAME')?>:</td><td><?php echo $this->campaignDetails->name;?></td>
	  </tr>
	  <tr>
		<td><?php echo JText::_('COM_CONSTANTCONTACT_LABEL_CAMPAIGN_SUBJECT')?>:</td><td><?php echo $this->campaignDetails->subject;?></td>
	  </tr>
	  <tr>
		<td><?php echo JText::_('COM_CONSTANTCONTACT_LABEL_CAMPAIGN_EMAIL_CONTENT')?>:</td><td><?php echo $this->campaignDetails->email_content;?></td>
	  </tr>
	  <tr>
		<td><?php echo JText::_('COM_CONSTANTCONTACT_LABEL_CAMPAIGN_FROM_NAME')?></td><td><?php echo $this->campaignDetails->from_email;?></td>
	  </tr>
	  <tr>
		<td><?php echo JText::_('COM_CONSTANTCONTACT_LABEL_CAMPAIGN_TYPE')?></td><td><?php echo $this->campaignDetails->template_type;?></td>
	  </tr>
	  <tr>
	    <td><?php echo JText::_('COM_CONSTANTCONTACT_LABEL_CAMPAIGN_VIEW_WEBPAGE')?></td><td><?php echo $this->campaignDetails->is_view_as_webpage_enabled;?></td>
	  </tr>
	  <tr>
	    <td><?php echo JText::_('COM_CONSTANTCONTACT_LABEL_CAMPAIGN_VIEW_WEBPAGE_LINK_TEXT')?></td><td><?php echo $this->campaignDetails->view_as_web_page_link_text;?></td>
	  </tr>
	  <tr>
		<td><?php echo JText::_('COM_CONSTANTCONTACT_LABEL_CAMPAIGN_VIEW_WEBPAGE_TEXT')?></td><td><?php echo $this->campaignDetails->view_as_web_page_text;?></td>
	  </tr>
	  <tr>
		<td><?php echo JText::_('COM_CONSTANTCONTACT_LABEL_CAMPAIGN_PERMISSION_REMINDER')?></td><td><?php echo $this->campaignDetails->is_permission_reminder_enabled;?></td>
	  </tr>
	  <tr>
		<td><?php echo JText::_('COM_CONSTANTCONTACT_LABEL_CAMPAIGN_PERMISSION_REMINDER_TEXT')?></td><td><?php echo $this->campaignDetails->permission_reminder_text;?></td>
	  </tr>
	  <tr>
		<td><?php echo JText::_('COM_CONSTANTCONTACT_LABEL_CAMPAIGN_STATUS')?></td><td><?php echo $this->campaignDetails->status;?></td>
	  </tr>
	  <tr>
		<td><?php echo JText::_('COM_CONSTANTCONTACT_LABEL_CAMPAIGN_CREATED_DATE')?></td><td><?php echo $this->campaignDetails->created_date;?></td>
	  </tr>
	  <tr>
		<td><?php echo JText::_('COM_CONSTANTCONTACT_LABEL_CAMPAIGN_MODIFIED_DATE')?></td><td><?php echo $this->campaignDetails->modified_date;?></td>
	  </tr>
	  <tr>
		<td><?php echo JText::_('COM_CONSTANTCONTACT_LABEL_CAMPAIGN_SENT')?></td><td><?php echo $this->campaignDetails->tracking_summary->sends;?></td>
	  </tr>
	  <tr>
		<td><?php echo JText::_('COM_CONSTANTCONTACT_LABEL_CAMPAIGN_OPENS')?></td><td><?php echo $this->campaignDetails->tracking_summary->opens;?></td>
	  </tr>
	  <tr>
	    <td><?php echo JText::_('COM_CONSTANTCONTACT_LABEL_CAMPAIGN_CLICKS')?></td><td><?php echo $this->campaignDetails->tracking_summary->clicks;?></td>
	  </tr>
	  <tr>
	    <td><?php echo JText::_('COM_CONSTANTCONTACT_LABEL_CAMPAIGN_BOUNCES')?></td><td><?php echo $this->campaignDetails->tracking_summary->bounces;?></td>
	  </tr>
	  <tr>
		<td><?php echo JText::_('COM_CONSTANTCONTACT_LABEL_CAMPAIGN_FORWARDS')?></td><td><?php echo $this->campaignDetails->tracking_summary->forwards;?></td>
	  </tr>			
	</table>
</fieldset>
<input type="hidden" name="task">
</form>