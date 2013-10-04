<?php
JHtml::_('behavior.framework');
?>
<form method="post" action="<?php echo JUri::getInstance(); ?>" name="adminForm" id="adminForm">
    <fieldset>
        <div class="fltrt">
            <button onclick="Joomla.submitform('authentication.create', this.form);" type="button"><?php echo JText::_('COM_CONSTANTCONTACT_BUTTON_CREATE_ACCOUNT'); ?></button>
            <button onclick="  window.parent.SqueezeBox.close();" type="button"><?php echo JText::_('COM_CONSTANTCONTACT_BUTTON_CANCEL'); ?></button>
        </div>
        <div class="configuration"><?php echo JText::_('COM_CONSTANTCONTACT_VIEW_SIGNUP_FILDSET_LEGEND_TITLE'); ?></div>
    </fieldset>
    <div class="adminformlist">
        <div class="current">
            <dd class="tabs">
                <p class="tab-description"><?php echo JText::_('COM_CONSTANTCONTACT_VIEW_SIGNUP_DESCRIPTION'); ?></p>
                <ul class="config-option-list">
                    <?php foreach(array('email', 'username', 'password', 'firstname', 'lastname', 'phone', 'country', 'state') as $field): ?>
                    <li>
                        <?php echo $this->form->getLabel($field); ?>
                        <?php echo $this->form->getInput($field); ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <div class="clr"></div>
            </dd>
        </div>
    </div>
    <input name="task" type="hidden" value="">
    <?php echo JHtml::_('form.token'); ?>
</form>
