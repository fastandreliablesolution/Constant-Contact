<?php
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
if (intval(JVERSION) > 2) {
    JHtml::_('formbehavior.chosen', 'select');
}
?>
<script>
    Joomla.submitbutton = function(task)
    {
        if (task == 'contact.cancel' || document.formvalidator.isValid(document.id('adminForm'))) {
            Joomla.submitform(task, document.getElementById('adminForm'));
        }
    }
</script>
<form method="post" action="<?php echo JUri::getInstance(); ?>" name="adminForm" id="adminForm" class="form-validate">
<div class="adminformlist">
    <div class="form-horizontal">
        <?php if (intval(JVERSION) > 2): ?><fieldset><?php endif; ?>
            <?php echo ConstantcontactHelperTab::startTabs('contact-tabs','tab-personal'); ?>
            <?php echo ConstantcontactHelperTab::addTab(JText::_('COM_CONSTANTCONTACT_VIEW_CONTACT_TAB_PERSONAL_TITLE'), 'tab-personal'); ?>
            <ul class="adminformlist unstyled">
              <?php foreach($this->form['basic']->getFieldset('basic') as $field): ?>
                  <li>
                      <div class="control-group">
                          <div class="control-label"><?php echo $field->label; ?></div>
                          <div class="controls"><?php echo $field->input; ?></div>
                      </div>
                  </li>
              <?php endforeach; ?>
            </ul>
            <br clear="all">
            <?php echo ConstantcontactHelperTab::closeTab(); ?>
            <?php echo ConstantcontactHelperTab::addTab(JText::_('COM_CONSTANTCONTACT_VIEW_CONTACT_TAB_ADDRESS_TITLE'), 'tab-address'); ?>
            <ul class="adminformlist unstyled">
                <?php foreach($this->form['address'] as $formAddress): foreach($formAddress->getFieldset('addresses') as $field): ?>
                    <li>
                        <div class="control-group">
                            <div class="control-label"><?php echo $field->label; ?></div>
                            <div class="controls"><?php echo $field->input; ?></div>
                        </div>
                    </li>
                <?php endforeach; endforeach; ?>
            </ul>
            <br clear="all">
            <?php echo ConstantcontactHelperTab::closeTab(); ?>
            <?php echo ConstantcontactHelperTab::addTab(JText::_('COM_CONSTANTCONTACT_VIEW_CONTACT_TAB_EMAIL_ADDRESS_TITLE'), 'tab-email-address'); ?>
            <ul class="adminformlist unstyled">
                <?php foreach($this->form['email_addresses'] as $formEmailAddress): foreach ($formEmailAddress->getFieldset('email_addresses') as $field): ?>
                    <li>
                        <div class="control-group">
                            <div class="control-label"><?php echo $field->label; ?></div>
                            <div class="controls"><?php echo $field->input; ?></div>
                        </div>
                    </li>
                <?php endforeach; endforeach; ?>
            </ul>
            <br clear="all">
            <?php echo ConstantcontactHelperTab::closeTab(); ?>
            <?php echo ConstantcontactHelperTab::endTabs(); ?>
            <?php if (intval(JVERSION) > 2): ?></fieldset><?php endif; ?>
    </div>
</div>
<input type="hidden" name="task" value="" />
<?php echo JHtml::_('form.token'); ?>
</form>