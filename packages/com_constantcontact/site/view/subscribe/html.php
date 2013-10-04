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
 * Constant Contact subscribe View
 *
 * @package		Joomla.site
 * @subpackage	com_constantcontact
 * @since		1.1
 */
class ConstantcontactViewSubscribeHtml extends JViewLegacy
{
    /**
     * Display subscribe
     *
     * @param null $tpl
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
		
	    parent::display($tpl);			
		
    }
}