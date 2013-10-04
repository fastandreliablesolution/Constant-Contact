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
 * Contactlist Model class.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_constantcontact
 * @since		1.1
 */
class ConstantcontactModelContactList extends ConstantcontactModelApi
{
    /**
     * @return  mixed
     *
     * @since   1.1
     */
    public function getItem()
    {
		$list_id = $this->getState('id');
		
		if ($list_id) {
			$response 	= $this->api('get',sprintf('lists/%s', $list_id));
			$this->item = json_decode($response->body);
		} else {
			$this->item = array();
		}
		
		return $this->item;
    }

    /**
     * Save contactlist
     *
     * @param   $data
     *
     * @return  bool
     *
     * @since   1.1
     */
    public function save($data)
    {		
	   //check required fields
        if (empty($data)) {
            return false;
        }	
		
		//check if joomla category is been selected to be as contact list
		if($data['joomlacategory'] != ''){
			$data['name'] = $data['joomlacategory'];
			unset($data['joomlacategory']);				 			
		}		
		
		if (isset($data['joomlacategory'])) {
			array_splice($data, "-2", 1);
		}		
		
		$data['contact_count'] = (int)$data['contact_count'];
		
	   if (intval($data['id']) > 0) {
            $method = 'put';
            $path = 'lists/'.$data['id'];

            unset($data['id']);
        } else {
            $method = 'post';
            $path = 'lists';
		}
		
        $headers = array(
            'action-by' =>  'ACTION_BY_OWNER',
            'content-type' => 'application/json'
        );
	    
        $response = $this->api($method, $path, json_encode($data), $headers);

        $contactList = json_decode($response->body);

        $this->setState('contactlist.id', $contactList->id);
		
        return true ;
        
    }

    /**
     * Return list of forms to use on contactlist
     *
     * @return  array
     *
     * @since   1.1
     */
    public function getForms()
    {
        
        JForm::addFormPath(JPATH_COMPONENT.'/model/forms');

        $form = JForm::getInstance('contactlist', 'contactlist', array('control' => 'jform'));

        //bind data and load form according with item data
        if (!empty($this->item)) {
		  $form->bind($this->item);            
        } 

        return $form;
    }

    /**
     * Populate State
     *
     * @since   1.1
     */
    public function populateState()
    {
        $id = JFactory::getApplication()->input->getInt('id');
        $this->setState('id', $id);
    }	
			
}