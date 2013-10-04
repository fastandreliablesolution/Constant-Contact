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
 * Campaigns Controller class.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_constantcontact
 * @since		1.1
 */
class ConstantcontactControllerCampaigns extends ConstantcontactControllerAuthentication
{
	/**
     * Delete method for campaigns
     *
     * @since   1.1
     */
    public function delete()
    {
		$cids = $this->input->get('cid',0,'array');
		
		if (!$this->getModel('campaigns')->delete($cids))
        {
            JFactory::getApplication()->enqueueMessage('COM_CONSTANTCONTACT_ERROR_CAMPAIGNS_DELETE','error');
        } else {
            JFactory::getApplication()->enqueueMessage('COM_CONSTANTCONTACT_VIEW_CAMPAIGNS_DELETED_SUCESSFULY');
        }

        $this->setRedirect('index.php?option=com_constantcontact&view=campaigns');
    }
}