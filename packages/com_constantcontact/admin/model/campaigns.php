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
 * Campigns Model class.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_constantcontact
 * @since		1.1
 */
class ConstantcontactModelcampaigns extends ConstantcontactModelApi
{	
	/**
     * pagination variable
     *
     * @var     string
     * @since   1.1
     */	
	public $pagination = '';

    /**
     * Return list of items
     */
    public function getItems()
    {
        $arguments = array(
            'email' => $this->getState('filter.search'),
            'status' => $this->getState('filter.status'),
            'limit' => $this->getState('list.limitstart', 20),
			'next' => $this->getState('list.next')
        );

        $http = $this->api('get','emailmarketing/campaigns', $arguments);

        $response = json_decode($http->body);
		
        if (!empty($response->meta->pagination)) {
            $this->pagination = $response->meta->pagination;
        } 
		
        return $response->results;
    }

    /**
     * Just return pagination from response
     * Need to check how will works this pagination
     *
     * @since   1.1
     */
    public function getPagination()
    {
        return $this->pagination;
    }

    /**
     * Read filter from request
     *
     * @since   1.1
     */
    public function populateState()
    {
        $app = JFactory::getApplication();
        $input = $app->input;
        $context = $this->option.'.'.$input->getCmd('view');

        $search = $app->getUserStateFromRequest($context.'.filter.search', 'filter_search');
        $limitstart = $input->getInt('limit');
	    $next = $input->getString('next');

        $this->setState('filter.search', $search);
        $this->setState('list.limitstart', $limitstart);
		$this->setState('list.next', $next);

    }

    /**
     * Delete a list of campaigns
     *
     * @param   $campaignids  Array  List of listIds to be deleted
     *
     * @return  bool  True if are successfully deleted
     *
     * @since   1.1
     */
    public function delete($campaignIds)
    {
		if (count($campaignIds) == 0) {
            $this->application->enqueueMessage(JText::_('COM_CONSTANTCONTACT_SELECT_ITEMS_TO_DELETE'));
            return false;
        }

        foreach ($campaignIds as $campaignId)
        {
			$response = $this->api('delete',sprintf('emailmarketing/campaigns/%s',$campaignId));
        }

        return true;
    }
	
	
}