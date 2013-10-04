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
 * subscribe controller class.
 *
 * @package		Joomla.Site
 * @subpackage	com_constantcontact
 * @since		1.1
 */
class ConstantcontactControllerSubscribe extends ConstantcontactControllerDefault
{
	/**
	 * Contact subscribe method
	 *
     * @return  mixed
     *
     * @since   1.1
     */
	public function subscribe()
    {		        
	    JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		
		if ($this->getModel('subscribe')->subscribe()) {
            JFactory::getApplication()->enqueueMessage(JText::_('COM_CONSTANTCONTACT_SUBSCRIBING_THANK'));
        } else {
            JFactory::getApplication()->enqueueMessage(JText::_('COM_CONSTANTCONTACT_SUBSCRIBING_ERROR'),'error');
        }
        $this->setRedirect('index.php?option=com_constantcontact&view=unsubscribe');
	}
}