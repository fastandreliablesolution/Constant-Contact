<?php
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
?>
<script>
    Joomla.submitbutton = function(task)
    {
		
		if (task == 'contactlist.apply' || task == 'contactlist.save') {
		    if((document.getElementById('jform_name').value == '')) {
			   alert('Contactlist name cannot be empty.');
			   return false;
			 }
			
			if(document.getElementById('jform_name').value != '' ) {
                var regx = /^[A-Za-z0-9_ ]+$/;
				if (!regx.test(document.getElementById('jform_name').value)) {           			   
				   alert('Contactlist name can only be alpha numeric.');
				   return false;
			  }
		   } 
			Joomla.submitform(task, document.getElementById('adminForm'));		
		}
		else {
          
			Joomla.submitform(task, document.getElementById('adminForm'));
			
		} 
    }
</script>
<form method="post" action="<?php echo JUri::getInstance(); ?>" name="adminForm" id="adminForm">
<div class="adminformlist">
  <div> 
	<ul class="adminformlist  unstyled">
		<li>
			<?php echo $this->form->getLabel('id'); ?>
			<?php echo $this->form->getInput('id'); ?>
		</li>
		<li>
			<?php echo $this->form->getLabel('status'); ?>
			<?php echo $this->form->getInput('status'); ?>
		</li>
		<li>
			<?php echo $this->form->getLabel('name'); ?>
			<?php echo $this->form->getInput('name'); ?>
		</li>
		<li>
			<?php echo $this->form->getLabel('contact_count'); ?>
			<?php echo $this->form->getInput('contact_count'); ?>
	   </li>		
	</ul>
  </div>
</div>

<input type="hidden" name="task" value="" />
<?php echo JHtml::_('form.token'); ?>
</form>