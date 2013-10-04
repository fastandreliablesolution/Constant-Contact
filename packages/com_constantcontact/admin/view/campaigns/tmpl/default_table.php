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
            <?php echo JHtml::_('grid.sort', 'COM_CONSTANTCONTACT_VIEW_CAMPAIGN_HEADER_ID', 'a.title', $listDirn, $listOrder); ?>
        </th>
        <th>
            <?php echo JHtml::_('grid.sort', 'COM_CONSTANTCONTACT_VIEW_CAMPAIGN_HEADER__NAME', 'a.title', $listDirn, $listOrder); ?>
        </th>
		<th>
            <?php echo JHtml::_('grid.sort', 'COM_CONSTANTCONTACT_VIEW_CAMPAIGN_HEADER_MODIFIED_DATE', 'a.title', $listDirn, $listOrder); ?>
        </th>
		<th>
            <?php echo JHtml::_('grid.sort', 'COM_CONSTANTCONTACT_VIEW_HEADER_CAMPAIGN_STATUS', 'a.title', $listDirn, $listOrder); ?>
        </th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <td colspan="15">
		   
           <?php  if (count($this->items) > 20 )  echo ConstantcontactHelperPagination::buildPagination($this->pagination); ?>
        </td>
    </tr>
    </tfoot>
    <tbody>
    <?php if (count($this->items)==0): ?>
        <tr>
            <td colspan="100%" align="center" style="color:red"> <?php echo JText::_('COM_CONSTANTCONTACT_VIEW_CONTACTS_TEXT_NO_CAMPAIGNS'); ?></td>
        </tr>
    <?php else: ?>
        <?php foreach ($this->items as $i => $item): ?>
        <tr class="row<?php echo $i % 2; ?>">
            <td class="center">
                <?php echo JHtml::_('grid.id', $i, $item->id); ?>
            </td>
            <td>
                <?php echo $item->id; ?>
            </td>
            <td>
               <a href="index.php?option=com_constantcontact&view=campaign&id=<?php echo $item->id; ?>"> <?php echo $item->name; ?></a>
            </td>
			<td>
                <?php echo $item->modified_date; ?>
            </td>
			<td>
                <?php echo $item->status; ?>
            </td>
		  </tr>
        <?php endforeach; ?>
    <?php endif;?>
    </tbody>
</table>