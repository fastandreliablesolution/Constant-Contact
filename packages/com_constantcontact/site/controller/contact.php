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
 * contact controller class.
 *
 * @package		Joomla.Site
 * @subpackage	com_constantcontact
 * @since		1.1
 */
class ConstantcontactControllerContact extends ConstantcontactControllerDefault
{
    /**
     * subscribe a user
     *
     * @since   1.1
     */
    public function subscribe()
    {
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        $subscribeModel = $this->getModel('Subscribe');
		// if joomla user creation is set, create user
        if ($this->input->get('subscribercreateuser') == 1) {
            $subscribeModel->setState('user.create', true);
        }

        $data = array(
            'first_name' => $this->input->getString('name')
        );
		
        if ($subscribeModel->subscribe($data)) {
            $response = JText::_('COM_CONSTANTCONTACT_SUBSCRIBING_THANK');
        } else {
            $response = JText::_('COM_CONSTANTCONTACT_SUBSCRIBING_ERROR');
        }
		
        echo json_encode(array('message' => $response));
        JFactory::getApplication()->close();
    }
}