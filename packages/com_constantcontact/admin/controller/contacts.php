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
 * Contacts Controller class.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_constantcontact
 * @since		1.1
 */
class ConstantcontactControllerContacts extends ConstantcontactControllerAuthentication
{
	/**
     * Delete method for contacts
     *
     * @since   1.1
     */
    public function delete()
    {
		$cids = $this->input->get('cid',0,'array');

		if (!$this->getModel('contacts')->delete($cids))
        {
            JFactory::getApplication()->enqueueMessage(JText::_('COM_CONSTANTCONTACT_ERROR_CONTACTS_DELETE'),'error');
        } else {
            JFactory::getApplication()->enqueueMessage(JText::_('COM_CONSTANTCONTACT_VIEW_CONTACTS_DELETED_SUCESSFULY'));
        }

        $this->setRedirect('index.php?option=com_constantcontact&view=contacts');
    }

    /**
     * Method to run batch operations.
     * @since   1.1
     */
    public function batch($model = null)
    {	
        // Initialise variables.
       $input	= JFactory::getApplication()->input;
       $vars	= $input->get('action','','post');
	   $cids  =  $input->get('contacts','','post');
       $cid	= explode(",", $cids);
	   $list_id = $input->get('listid','','post');  
	   
	   if (!$this->getModel('contacts')->batchCopy($vars, $cid, $list_id))
        {
            $response = JText::_('COM_CONSTANTCONTACT_ERROR_BATCH_COPY');
        } else {
            $response = JText::_('COM_CONSTANTCONTACT_VIEW_CONTACTS_BATCH_COPY_SUCESSFULY');
        }
		
        echo json_encode(array('message' => $response));
        JFactory::getApplication()->close();
    }
}