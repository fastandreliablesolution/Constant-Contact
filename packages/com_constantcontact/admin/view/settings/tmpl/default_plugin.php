<?php if (JPluginHelper::isEnabled('user','profile') == False && JPluginHelper::isEnabled('user','constantcontact') == False): ?>
    <?php echo JText::_('COM_CONSTANTCONTACT_VIEW_SETTINGS_TAB_PLUGIN_TEXT_NO_PLUGIN_AVAILABLE'); ?>
<?php else: ?>
    <?php if (JPluginHelper::isEnabled('user','profile')): ?>
        <?php foreach ($this->forms['plg_user_profile']->getFieldset('basic') as $field): ?>
            <?php echo $field->label; ?>
            <?php echo $field->input; ?>
        <?php endforeach; ?>
    <?php endif; ?>
    <?php if (JPluginHelper::isEnabled('user','constantcontact')): ?>
    <?php foreach ($this->forms['plg_user_constantcontact']->getFieldset('basic') as $field): ?>
        <?php echo $field->label; ?>
        <?php echo $field->input; ?>
    <?php endforeach; ?>
    <?php endif; ?>
<?php endif; ?>
<div class="clr"></div>