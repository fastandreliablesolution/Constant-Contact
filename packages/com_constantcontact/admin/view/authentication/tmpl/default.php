<?php
JHtml::_('behavior.modal');
?>
<h2><?php echo JText::_('COM_CONSTANTCONTACT_VIEW_AUTHENTICATION_WELCOME'); ?></h2>
<p><?php echo JText::_('COM_CONSTANTCONTACT_VIEW_AUTHENTICATION_DESCRIPTION'); ?></p>
<p>
    <a href="<?php echo ConstantcontactHelperAuthentication::getAuthenticationLink(); ?>" class="btn btn-primary btn-large">
        <?php echo JText::_('COM_CONSTANTCONTACT_VIEW_AUTHENTICATION_BUTTON_AUTHENTICATE'); ?>
    </a>
</p>
<p>
    <a href="<?php echo ConstantcontactHelperAuthentication::newaccountLink(); ?>" rel="{handler: 'iframe', size: {x: 800, y: 400}}" class="modal">
        <?php echo JText::_('COM_CONSTANTCONTACT_VIEW_AUTHENTICATION_NEW_ACCOUNT'); ?>
    </a>
</p>