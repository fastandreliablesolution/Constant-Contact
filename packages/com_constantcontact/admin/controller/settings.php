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
 * Settings Controller class.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_constantcontact
 * @since		1.1
 */
class ConstantcontactControllerSettings extends ConstantcontactControllerAuthentication
{
    /**
     * Override Constructor
     *
     * @param   array $config
     *
     * @since   1.1
     */
    public function __construct($config = array())
    {
        parent::__construct($config);
		
		 // Apply, Save & New
        $this->registerTask('apply', 'save');
        $this->registerTask('save2new', 'save');

    }
	
	/**
     * Synchronise joomla user with CC
     *
     * @since   1.1
     */

    public function syncUsers()
    {
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		
		if (!$this->getModel('settings')->syncUsers())
        {
            JFactory::getApplication()->enqueueMessage(JText::_('COM_CONSTANTCONTACT_ERROR_SAVE'),'error');
        } else {
            JFactory::getApplication()->enqueueMessage(JText::_('COM_CONSTANTCONTACT_VIEW_CONTACTS_SYNCHONISED_SUCESSFULY'));
        }

        $this->setRedirect('index.php?option=com_constantcontact&view=settings&tmpl=component');
    }
	
	/**
     * save method for settings
     *
     * @since   1.1
     */

    public function save()
    {
        
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        if (!$this->getModel('settings')->save())
        {
            JFactory::getApplication()->enqueueMessage(JText::_('COM_CONSTANTCONTACT_ERROR_SAVE'),'error');
        } else {
            JFactory::getApplication()->enqueueMessage(JText::_('COM_CONSTANTCONTACT_VIEW_SETTINGS_SAVE_SUCESSFULY'));
        }

        $this->setRedirect('index.php?option=com_constantcontact&view=settings&tmpl=component');
    }
}