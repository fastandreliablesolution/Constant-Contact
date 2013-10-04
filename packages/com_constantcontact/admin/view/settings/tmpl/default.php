<?php
JHtml::_('behavior.framework');
$prefix = '';
$sufix = '';
if (intval(JVERSION) > 2) {
    $prefix = '<h3>';
    $sufix = '</h3>';
}

?>
<form method="post" action="<?php echo JUri::getInstance(); ?>" name="adminForm" id="adminForm">
    <?php if($this->tmpl != '') { ?>
    <fieldset>
        <div class="fltrt pull-right">
            <button onclick="Joomla.submitform('settings.apply', this.form);" type="button" class="btn btn-success"><?php echo JText::_('JTOOLBAR_APPLY'); ?></button>
            <?php if (intval(JVERSION) == 2): ?>
            <button onclick="window.parent.SqueezeBox.close();" type="button"><?php echo JText::_('JTOOLBAR_CANCEL'); ?></button>
            <?php endif; ?>
        </div>
        <div class="configuration page-header">
            <?php echo sprintf('%s%s%s',$prefix, JText::_('COM_CONSTANTCONTACT_VIEW_SETTINGS_TITLE'),$sufix); ?>
        </div>
    </fieldset>
   <?php }?>
<?php
echo ConstantcontactHelperTab::startTabs('panel-tabs','tabs-sync');
echo ConstantcontactHelperTab::addTab(JText::_('COM_CONSTANTCONTACT_VIEW_SETTINGS_TAB_SYNC_TITLE'), 'tabs-sync');
echo $this->loadtemplate('sync');
echo ConstantcontactHelperTab::closeTab();
echo ConstantcontactHelperTab::addTab(JText::_('COM_CONSTANTCONTACT_VIEW_SETTINGS_TAB_MODULE_TITLE'), 'tabs-mod');
echo $this->loadtemplate('module');
echo ConstantcontactHelperTab::closeTab();
echo ConstantcontactHelperTab::addTab(JText::_('COM_CONSTANTCONTACT_VIEW_SETTINGS_TAB_PLUGIN_TITLE'), 'tabs-plg');
echo $this->loadTemplate('plugin');
echo ConstantcontactHelperTab::closeTab();
echo ConstantcontactHelperTab::endTabs();
?>
<input type="hidden" name="task" value="" />
<?php echo JHtml::_('form.token'); ?>
</form>