<?php
/**
 * @version 1.1
 * @package com_constantcontact
 * @copyright Copyright (C) 2013. All rights reserved.
 * @license GNU General Public License version 2 or later; see LICENSE.txt
 * @author Cloud Access <constantcontact@cloudaccess.net> - http://cloudaccess.net
 */

// no direct access
defined('_JEXEC') or die;
$document =JFactory::getDocument();
if ($params->get('load_jquery',1)) {
    $document->addScript("http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js");

}
$document->addStyleSheet(JURI::root()."media/com_constantcontact/assets/css/constantcontact.css");

JHTML::_('behavior.modal','a.modal');
?>
<script type="text/javascript">
    jQuery.noConflict();
   
      function subscribeUser() {			
		   	var varName = ''; 
			var varList = '';
           
            if (jQuery("#showname").val() == 1) {
                if(jQuery("#subscribername").val().trim() == '') {
                    alert("Enter an Name");
                    return false;
                }
				varName = jQuery('#subscribername').val();
            }

           
                if(jQuery('#subscriberemail').val() == '') {
                    alert("Enter an Email");
                    return false;
                }
				

            if (jQuery('#showterms').val() == 1) {
				if(!jQuery('#terms_checkbox').is(':checked')){
                   alert("Please check Terms and Condition");
                    return false;
                }
            }
			jQuery('#subscribebutton').html('<img src="media/com_constantcontact/assets/images/loading5.gif">');
            var checkeditems = jQuery('input:checkbox[name="lists[]"]:checked').map(function() { return jQuery(this).val() }).get().join(",");
			
			if (checkeditems == '') {
				varList = 1;
			}else {
				varList = checkeditems;
			}
			
			var response = jQuery.ajax({
                url: 'index.php?option=com_constantcontact&task=contact.subscribe&format=json',
				data: jQuery("#constantcontact").serialize(),
                dataType: 'json',
                type: 'POST',
                success: function(data) {
                   jQuery('#mod_newsletter').html(data.message);
			    },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    alert("Error: " + errorThrown); 
                }  
            });
        }
  
</script>

<form name="constantcontact" id="constantcontact" method="post" action="return false;">
    <div id="mod_newsletter">
        <table width="100%" border="0">
            <?php if ($params->get('showNameField')): ?>
            <tr>
                <td>
                    <?php echo JText::_('MOD_CONSTANTCONTACT_NAME_LABEL')?>:
                </td>
                <td>
                    <input type="text" size="18" name="name" id="subscribername" value="" class="input-small">
                </td>
            </tr>
            <?php endif; ?>            
                <tr>
                    <td>
                        <?php echo JText::_('MOD_CONSTANTCONTACT_EMAIL_LABEL')?>:
                    </td>
                    <td>
                        <input type="text" size="18" name="emailid" id="subscriberemail" value="" class="input-small">
                    </td>
                </tr>          
            <?php if ($params->get('showMailingList')): ?>
            <tr>
                <td>
                    <?php echo JText::_('MOD_CONSTANTCONTACT_MAILING_LIST_LABEL')?>:
                </td>
                <td>
                    <?php foreach ($modelConstactsList->getOptions() as $option): ?>
                        <?php if (in_array($option->value, $displayListArray)): ?>
                            <input class="checkbox" type="checkbox"  name="lists[]" value="<?php echo $option->value;?>" checked="checked" />
                            <?php echo $option->text;?>
                            <br />
                        <?php endif; ?>
                    <?php endforeach; ?>
                </td>
            </tr>
            <?php endif; ?>
            <?php
            $termsLink = '';
            if ($params->get('showTermsConditions')) {
                $articleId = $params->get('termsContent');
                if (intval( $articleId )) {
                    $url = "index.php?option=com_content&view=article&tmpl=component&id=".	$articleId;
                    if ($params->get('showTermsasPopup')) {
                        $termsLink = '	<input id="terms_checkbox" class="checkbox" type="checkbox" name="terms_checkbox"/><a class="modal" title="'.JText::_('MOD_CONSTANTCONTACT_EXT_TERMS',true).'"  href="'.$url.'" rel="{handler: \'iframe\', size: {x: 650, y: 375}}">'.JText::_('MOD_CONSTANTCONTACT_EXT_TERMS').'</a>';
                    } else {
                        $termsLink = '	<input id="terms_checkbox" class="checkbox" type="checkbox" name="terms_checkbox"/><a title="'.JText::_('MOD_CONSTANTCONTACT_EXT_TERMS',true).'"  href="'.$url.'" target="_blank">'.JText::_('MOD_CONSTANTCONTACT_EXT_TERMS').'</a>';
                    }
                } else {
                    $termsLink = JText::_('MOD_CONSTANTCONTACT_EXT_TERMS');
                }
            }
            ?>
            <tr>
                <td>&nbsp;</td>
                <td><?php echo $termsLink; ?></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><div id="subscribebutton"><button type="button"  name="subscribe" id="subscribe" class="btn btn-primary" onclick="subscribeUser();"><?php echo $params->get('buttontext'); ?></button></div></td>
            </tr>
        </table>
    </div>
    <input type="hidden" name="subscribercreateuser" value="<?php echo $params->get('createJoomlaUser'); ?>">
    <input type="hidden" name="showterms" id="showterms" value="<?php echo $params->get('showTermsConditions'); ?>">
    <input type="hidden" name="showname" id="showname" value="<?php echo $params->get('showNameField'); ?>">
    <?php echo JHtml::_('form.token'); ?>
</form>