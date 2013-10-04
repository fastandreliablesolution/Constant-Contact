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

/**
 * Constant Contact Unsubscribe View
 *
 * @package		Joomla.site
 * @subpackage	com_constantcontact
 * @since		1.1
 */
class ConstantcontactViewUnsubscribeHtml extends JViewLegacy
{
    /**
     * Display unsubscribe
     *
     * @param   null $tpl
     *
     * @since   1.1
     */
    public function display($tpl = null)
    {
        $input =  JFactory::getApplication()->input;

        $modelUnsubscribe  = JModelLegacy::getInstance('Unsubscribe','ConstantcontactModel');
        $modelContactslist = JModelLegacy::getInstance('contactslist','ConstantcontactModel');

        $this->setModel($modelUnsubscribe);
        $this->setModel($modelContactslist);

		$this->contactDetails = $modelUnsubscribe->getContactSubsciption();
        $this->options = $modelContactslist->getOptions();
		
		$this->prepareDocument();
		
		//check for user status and load template accordingly
		if($this->contactDetails->status == "OPTOUT") {
			JFactory::getApplication()->redirect('index.php?option=com_constantcontact&view=subscribe');        
		} else {			 
			parent::display($tpl);			
		}
    }
	/**
	 * Prepares the document
	 *
	 * @since	1.1
	 */
	protected function prepareDocument()
	{
        if(JFactory::getUser()->guest) {
            JFactory::getApplication()->redirect('index.php?option=com_users&view=login', JText::_('COM_CONSTANTCONTACT_LOGINTO_UNSUBSCRIBE'), 'error');
		}
	}
}