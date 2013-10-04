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
            <?php echo JHtml::_('grid.sort', 'COM_CONSTANTCONTACT_VIEW_CONTACTS_HEADER_EMAIL', 'a.title', $listDirn, $listOrder); ?>
        </th>
        <th>
            <?php echo JHtml::_('grid.sort', 'COM_CONSTANTCONTACT_VIEW_CONTACTS_HEADER_NAME', 'a.title', $listDirn, $listOrder); ?>
        </th>
        <th>
            <?php echo JHtml::_('grid.sort', 'COM_CONSTANTCONTACT_VIEW_CONTACTS_HEADER_CONTACT_STATUS', 'a.title', $listDirn, $listOrder); ?>
        </th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <td colspan="15">
            <?php
                if (count((array)$this->pagination) == 0 && $this->state->get('list.next') != '') {
                    echo ConstantcontactHelperPagination::startPage();
                } else {
                    echo ConstantcontactHelperPagination::buildPagination($this->pagination);
                }
            ?>
        </td>
    </tr>
    </tfoot>
    <tbody>
    <?php if (count($this->items)==0): ?>
        <tr>
            <td colspan="100%" align="center" style="color:red"> <?php echo JText::_('COM_CONSTANTCONTACT_VIEW_CONTACTS_TEXT_NO_CONTACTS'); ?></td>
        </tr>
    <?php else: ?>
        <?php foreach ($this->items as $i => $item): ?>
        <tr class="row<?php echo $i % 2; ?>">
            <td class="center">
                <?php echo JHtml::_('grid.id', $i, $item->id); ?>
            </td>
            <td>
                <a href="index.php?option=com_constantcontact&task=contact.edit&cid[]=<?php echo $item->id; ?>"><?php echo $item->email_addresses[0]->email_address; ?></a>
            </td>
            <td>
                <?php echo $item->first_name; ?>
                <?php echo $item->middle_name; ?>
                <?php echo $item->last_name; ?>
            </td>
            <td>
                <?php echo $item->email_addresses[0]->status; ?>
            </td>
		  </tr>
        <?php endforeach; ?>
    <?php endif;?>
    </tbody>
</table>