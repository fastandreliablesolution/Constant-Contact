<?php
// no direct access
defined('_JEXEC') or die;
?>	  
<fieldset class="batch">
    <legend><?php echo JText::_('COM_CONSTANTCONTACT_BATCH_CONTACTLIST_OPTIONS');?></legend>
    <p><?php echo JText::_('COM_CONTENT_BATCH_TIP'); ?></p>

    <br />
    <label><?php echo JText::_('COM_CONSTANTCONTACT_CC_SELECT_CONTACT_LIST_MOVE')?>:</label>

    <select id="filter_move_list_id" name="batch[list_id]" class="inputbox" style="overflow: hidden;">
        <option value=""><?php echo JText::_('COM_CONSTANTCONTACT_VIEW_CONTACTS_SELECT_CONTACT_LIST'); ?></option>
        <?php echo JHtml::_('select.options', $this->getModel('contactslist')->getOptions(), 'value', 'text'); ?>
    </select>
	
	<?php // Create the copy/move options.
		$options = array(JHtml::_('select.option', 'copy', JText::_('JLIB_HTML_BATCH_COPY')),
			JHtml::_('select.option', 'move', JText::_('JLIB_HTML_BATCH_MOVE')));
		echo JHtml::_('select.radiolist', $options, 'action', '', 'value', 'text', 'move')
	?>		

    <br />
    <div class="clr"></div>
    <div id="progress" style="display:none">
		<div id="bar"></div>
		<div id="percent">0%</div >
    </div>
    <div id="batch_process">
        <button type="button" onclick="batchCopyMove();">
            <?php echo JText::_('JGLOBAL_BATCH_PROCESS'); ?>
        </button>
        <button type="button" onclick="document.id('filter_move_list_id').value='';">
            <?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>
        </button>
    </div>
    
   
</fieldset>

