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
 * Contactslist Controller class.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_constantcontact
 * @since		1.1
 */
class ConstantcontactControllerContactsList extends ConstantcontactControllerAuthentication
{
	/**
     * Delete method for contact lists
     *
     * @since   1.1
     */
    public function delete()
    {
		$cids = $this->input->get('cid',0,'array');
		
		if (!$this->getModel('contactslist')->delete($cids))
        {
            JFactory::getApplication()->enqueueMessage(JText::_('COM_CONSTANTCONTACT_ERROR_CONTACTSLIST_DELETE'),'error');
        } else {
            JFactory::getApplication()->enqueueMessage(JText::_('COM_CONSTANTCONTACT_VIEW_CONTACTSLIST_DELETED_SUCESSFULY'));
        }

        $this->setRedirect('index.php?option=com_constantcontact&view=contactslist');
    }
}