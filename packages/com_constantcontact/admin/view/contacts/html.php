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
 * Constant Contact Contacts View
 *
 * @package		Joomla.Administrator
 * @subpackage	com_constantcontact
 * @since		1.1
 */
class ConstantcontactViewContactsHtml extends JViewLegacy
{
    public function display($tpl = null)
    {
        $modelContacts      = JModelLegacy::getInstance('contacts','ConstantcontactModel');

        $this->items        = $modelContacts->getItems();
        $this->state        = $modelContacts->getState();
        $this->pagination   = $modelContacts->getPagination();

        $modelContactsList  = JModelLegacy::getInstance('contactslist','ConstantcontactModel');
        $this->setModel($modelContactsList);

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
        $canDo	= ConstantcontactHelperConstantcontact::getActions();
			
        if ($canDo->get('core.create')) {
            JToolBarHelper::addNew('contact.add');
        }
        if ($canDo->get('core.edit')) {
            JToolBarHelper::editList('contact.edit');
        }
        if ($canDo->get('core.delete')) {
            JToolBarHelper::deleteList('', 'contacts.delete', 'JTOOLBAR_EMPTY_TRASH');
            JToolBarHelper::divider();
        }

        JToolBar::getInstance('toolbar')->appendButton('Popup', 'options', JText::_('COM_CONSTANTCONTACT_TITLE_SETTINGS'), 'index.php?option=com_constantcontact&amp;view=settings&amp;tmpl=component', 875, 550, 0, 0, '');
															
        JToolBarHelper::title(JText::_('COM_CONSTANTCONTACT_VIEW_CONTACTS_TITLE'));

        ConstantcontactHelperConstantcontact::addSubmenu('contacts');
    }
}