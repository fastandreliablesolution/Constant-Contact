<?php
/**
 * @version 1.0
 * @package com_constantcontact
 * @copyright Copyright (C) 2013. All rights reserved.
 * @license GNU General Public License version 2 or later; see LICENSE.txt
 * @author Cloud Access <constantcontact@cloudaccess.net> - http://cloudaccess.net
 */

// No direct access
defined('_JEXEC') or die;

/**
 * Contacts Model class.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_constantcontact
 * @since		1.0
 */
class ConstantcontactModelContacts extends ConstantcontactModelApi
{
	
    /**
     * Return list of items
     */
    public function getItems()
    {
        $extraUrl = array();

        $email = $this->getState('filter.search');
        if (!empty($email)) {
            $extraUrl['email'] = $email;
        }

        $status = $this->getState('filter.status');
        if (!empty($status)) {
            $extraUrl['status'] = $status;
        }

        $next = $this->getState('list.next');
        if (!empty($next)) {
            $extraUrl['next'] = $next;
        } else {
            $limit = $this->getState('list.limitstart', 20);
            if (!empty($limit)) {
                $extraUrl['limit'] = $limit;
            }
        }

        $arguments = array();
        $headers = array();

        $contactlist_id = $this->getState('filter.contactlist_id');

        //diff api request if get contacts from specific list id
        if ($contactlist_id > 0) {

            $path = 'lists/'.$contactlist_id.'/contacts';
        } else {
            $path = 'contacts';
        }

        $http = $this->api('get',$path, $arguments, $headers,$extraUrl);

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
        $contact_list_id = $app->getUserStateFromRequest($context.'.filter.contactlist_id', 'filter_contactlist_id');
        $limitstart = $input->getInt('limit');
        $next = $input->getString('next');

        $this->setState('filter.search', $search);
        $this->setState('filter.contactlist_id', $contact_list_id);
        $this->setState('list.limitstart', $limitstart);
        $this->setState('list.next', $next);

    }

    /**
     * Delete a list of contacts
     *
     * @param   $contactIds  Array  List of contactIds to be deleted
     *
     * @return  bool  True if are successfully deleted
     *
     * @since   1.1
     */
    public function delete($contactIds)
    {
		if (count($contactIds) == 0) {
            $this->application->enqueueMessage(JText::_('COM_CONSTANTCONTACT_SELECT_ITEMS_TO_DELETE'));
            return false;
        }

        foreach ($contactIds as $contactId)
        {
			$response = $this->api('delete',sprintf('contacts/%s',$contactId));
        }

        return true;
    }

    /**
     * Batch copy items to a new category or current.
     *
     * @param   integer  $vars     The new contactlist.
     * @param   array    $cid       An array of row IDs.
     *
     * @return  mixed  An array of new IDs on success, boolean false on failure.
     *
     * @since	1.1
     */
    public function batchCopy($vars, $cid, $contactlistId)
    {	
		
        //modify and customise contact lists array before passing
        $newList = array();
        if(!empty($contactlistId)){

            $newList['id'] = $contactlistId;
            $newList['status'] = "ACTIVE";
        }

        $method = 'put';
        $headers = array(
            'action-by' =>  'ACTION_BY_OWNER',
            'content-type' => 'application/json'
        );
       
        foreach ($cid as $contactId)
        {
			
            $path = 'contacts/'.$contactId;
            $data['contactId'] = $contactId;

            //get details of the contact
            $contactDetails = $this->api('get',sprintf('contacts/%s',$contactId));

            $contactDetails = json_decode($contactDetails->body, true);

            foreach($contactDetails['lists'] as $key => $value) {

                if($vars == "move"){
                    $contactDetails['lists'][$key]['id'] = $value['id'];
                    $contactDetails['lists'][$key]['status'] = "HIDDEN";
                }else{
                    $contactDetails['lists'][$key]['id'] = $value['id'];
                    $contactDetails['lists'][$key]['status'] = "ACTIVE";
                }

                $contactDetails['lists'][$key+1]['id'] = $contactlistId;
                $contactDetails['lists'][$key+1]['status'] = "ACTIVE";
            }

            $response = $this->api($method, $path, json_encode($contactDetails), $headers);
			
        }

        return true;
    }
}