<div class="btn-toolbar">
    <fieldset id="filter-bar">
        <div class="filter-search fltlft btn-group pull-left">
            <input type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_BANNERS_SEARCH_IN_TITLE'); ?>" />
        </div>
        <div class=" btn-group">
            <button type="submit" class="btn"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
            <button type="button" onclick="document.getElementById('filter_search').value='';document.getElementById('next').value='';this.form.submit();" class="btn"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
        </div>
        <div class="filter-select fltrt pull-right">
            <select name="filter_contactlist_id" id="contactlist_id" class="inputbox" onchange="this.form.submit()">
                <option value=""><?php echo JText::_('COM_CONSTANTCONTACT_VIEW_CONTACTS_SELECT_CONTACT_LIST'); ?></option>
                <?php echo JHtml::_('select.options', $this->getModel('contactslist')->getOptions(), 'value', 'text', $this->state->get('filter.contactlist_id')); ?>
            </select>
        </div>
    </fieldset>
</div>