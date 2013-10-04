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
 * Contacts List Model class.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_constantcontact
 * @since		1.1
 */
class ConstantcontactModelcontactslist extends ConstantcontactModelApi
{	
	/**
     * pagination variable
     *
     * @var     string
     * @since   1.1
     */	
	public $pagination='';	
	
    /**
     * Generate list options of contactlists
     *
     * @return  array
     *
     * @since   1.1
     */
    public function getOptions()
    {
        $options    = array();
        $this->cache->setCaching(true);
        $response   = $this->api('get','lists');
        $this->cache->setCaching(false);

        $contactLists = json_decode($response->body);
        if (count($contactLists)) {
            foreach ($contactLists as $contactList) {
                $options[] = JHTML::_('select.option', $contactList->id, $contactList->name);
            }
        }

        return $options;
    }
	
	/**
     * Return list of items
     */
    public function getItems()
    {
        $arguments = array(
            'name' => $this->getState('filter.search'),
            'status' => $this->getState('filter.status'),
            'limit' => $this->getState('list.limitstart', 50)
        );

        $http = $this->api('get','lists');

        $response = json_decode($http->body, true);
		
        if (!empty($response->meta->pagination)) {
            $this->pagination = $response->meta->pagination;
        }

        return $response;
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

        $this->setState('filter.search', $search);
        $this->setState('list.limitstart', $limitstart);

    }

    /**
     * Delete a list of contacts
     *
     * @param   $contactIds  Array  List of listIds to be deleted
     *
     * @return  bool  True if are successfully deleted
     *
     * @since   1.1
     */
    public function delete($listIds)
    {
		if (count($listIds) == 0) {
            $this->application->enqueueMessage(JText::_('COM_CONSTANTCONTACT_SELECT_ITEMS_TO_DELETE'));
            return false;
        }

        foreach ($listIds as $listId)
        {
			$response = $this->api('delete',sprintf('lists/%s',$listId));
        }

        return true;
    }
	
	
}