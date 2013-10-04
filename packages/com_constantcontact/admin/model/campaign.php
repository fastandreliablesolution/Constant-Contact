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
 * Campign Details Model class.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_constantcontact
 * @since		1.1
 */
class ConstantcontactModelcampaign extends ConstantcontactModelApi
{
	/**
     * Return individual campaign details
     */
    public function getCampaign()
    { 
        // Initialise variables.
        $input	= JFactory::getApplication()->input;
        $campaignId	= $input->get->get('id');
		
        $http = $this->api('get',sprintf('emailmarketing/campaigns/%s',$campaignId));

        $response = json_decode($http->body);	
				
        return $response;
    }
}