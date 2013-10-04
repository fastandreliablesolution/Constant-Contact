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
 * Campaign Details Controller class.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_constantcontact
 * @since		1.1
 */
class ConstantcontactControllerCampaign extends ConstantcontactControllerAuthentication
{
	/**
     * Cancel method for campaign
     *
     * @since   1.1
     */

    public function cancel()
    {
        $this->setRedirect('index.php?option=com_constantcontact&view=campaigns');
    }
	
}