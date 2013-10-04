<?php
$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
?>
<div class="clearfix"></div>
<table class="adminlist table table-striped">
    <thead>
    <tr>
        <th width="1%">
            <input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
        </th>
        <th>
            <?php echo JHtml::_('grid.sort', 'COM_CONSTANTCONTACT_VIEW_CONTACTS_HEADER_ID', 'a.title', $listDirn, $listOrder); ?>
        </th>
        <th>
            <?php echo JHtml::_('grid.sort', 'COM_CONSTANTCONTACT_VIEW_CONTACTS_HEADER__LISTNAME', 'a.title', $listDirn, $listOrder); ?>
        </th>
		<th>
            <?php echo JHtml::_('grid.sort', 'COM_CONSTANTCONTACT_VIEW_CONTACTS_HEADER_CONTACT_COUNT', 'a.title', $listDirn, $listOrder); ?>
        </th>
        <th>
            <?php echo JHtml::_('grid.sort', 'COM_CONSTANTCONTACT_VIEW_CONTACTS_HEADER_CONTACTLIST_STATUS', 'a.title', $listDirn, $listOrder); ?>
        </th>
    </tr>
    </thead>
    <tfoot>
    </tfoot>
    <tbody>
    <?php if (count($this->items)==0): ?>
        <tr>
            <td colspan="100%" align="center" style="color:red"> <?php echo JText::_('COM_CONSTANTCONTACT_VIEW_CONTACTS_TEXT_NO_CONTACTSLIST'); ?></td>
        </tr>
    <?php else: ?>
        <?php foreach ($this->items as $i => $item): ?>
        <tr class="row<?php echo $i % 2; ?>">
            <td class="center">
                <?php echo JHtml::_('grid.id', $i, $item['id']); ?>
            </td>
            <td>
                <?php echo $item['id']; ?>
            </td>
            <td>
               <a href="index.php?option=com_constantcontact&view=contactlist&layout=edit&id=<?php echo $item['id']; ?>"> <?php echo $item['name']; ?></a>
            </td>
			 <td>
                <?php echo $item['contact_count']; ?>
            </td>
            <td>
                <?php echo $item['status']; ?>
            </td>
		  </tr>
        <?php endforeach; ?>
    <?php endif;?>
    </tbody>
</table>