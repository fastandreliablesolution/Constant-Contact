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
 * Constant Contact Contact View
 *
 * @package		Joomla.Administrator
 * @subpackage	com_constantcontact
 * @since		1.1
 */
class ConstantcontactViewContactHtml extends JViewLegacy
{
    public function display($tpl = null)
    {
        $modelContact = JModelLegacy::getInstance('contact','constantcontactModel');

        $this->item     = $modelContact->getItem();
        $this->form     = $modelContact->getForms();

        $this->addToolbar();
        parent::display($tpl);
    }
	
	/**
		* Add the page title and toolbar.
		*
		* @since	1.6
		*/

    public function addToolbar()
    {
        JToolBarHelper::title(JText::_('COM_CONSTANTCONTACT_VIEW_CONTACT_TITLE'));

        $canDo = ConstantcontactHelperConstantcontact::getActions();

        if ($canDo->get('core.edit')) {
            JToolBarHelper::apply('contact.apply');
            JToolBarHelper::save('contact.save');
        }

        JToolBarHelper::cancel('contact.cancel', 'JTOOLBAR_CLOSE');
    }
}