<?php
/**
 * @version 1.1
 * @package com_constantcontact
 * @copyright Copyright (C) 2013. All rights reserved.
 * @license GNU General Public License version 2 or later; see LICENSE.txt
 * @author Cloud Access <constantcontact@cloudaccess.net> - http://cloudaccess.net
 */

// No direct access
defined('_JEXEC') or die;

/**
 * subscribe Model class.
 *
 * @package		Joomla.Site
 * @subpackage	com_constantcontact
 * @since		1.1
 */
class ConstantcontactModelSubscribe extends ConstantcontactModelApi
{
	/**
	 * Contact subscribe method
	 *
     * @return  mixed
     *
     * @since   1.1
     */
	public function subscribe(array $temp = array()) {
		
		$input = JFactory::getApplication()->input;
		//initialise variables
        $data = array();
        $data['id'] = $input->get('contactid', '', 'post');
        $data['email_addresses'][0]['email_address'] = $input->get('emailid', '', 'post');
		$data['email_addresses'][0]['status'] = "ACTIVE";
		$data['email_addresses'][0]['opt_in_source'] = "ACTION_BY_VISITOR";
        $data['confirmed'] = "true";
		$data['status'] = "ACTIVE";		
		$data['lists'] = $input->get('lists', '', 'post');

        if (empty($data['status']) && empty($data['lists'])) {
            $data['status'] = 'OPTOUT';
            $data['confirmed'] = "false";
        }

        $data = array_merge($temp,$data);

        JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_constantcontact/model');
        $contactModel = JModelLegacy::getInstance('Contact','ConstantcontactModel');
        $contactModel->setState('user.create', $this->getState('user.create',false));
        $contactModel->setState('redirect', $this->getState('redirect',false));
		
		if ($contactModel->save($data)) {
           return true;
        } else {
           return false;
        }
		
	}
}