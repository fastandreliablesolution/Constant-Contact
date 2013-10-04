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
 * unsubscribe Model class.
 *
 * @package		Joomla.Site
 * @subpackage	com_constantcontact
 * @since		1.1
 */
class ConstantcontactModelUnsubscribe extends ConstantcontactModelApi
{
	/**
	 * Contact Unsubscription method
	 *
     * @return  mixed
     *
     * @since   1.1
     */
	public function getContactSubsciption(){	
	
	    $data = array();
		$contactId = '';		
		$user = JFactory::getUser();
		$data['email'] = $user->email;
		
		JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_constantcontact/model');
		$modelApi = JModelLegacy::getInstance('Api','ConstantcontactModel');
		
		$data['api_key'] = ConstantcontactHelperAuthentication::getApiKey();		
		$path = 'contacts';		
		$http = $modelApi->api('get',$path, $data);		
		$response = json_decode($http->body);	
		foreach ($response->results as $i => $result) {
			$contactEmail = $result->email_addresses[0]->email_address;
			if( $user->email == $contactEmail) {				 
				 $contactId = $result->id;
				 break;
			 }			
		}
		
		$contactResponse 	= $modelApi->api('get',sprintf('contacts/%s', $contactId));
		$contactDetails  = json_decode($contactResponse->body);
		
		return $contactDetails;		
	}
	
	/**
	 * Contact list Status method
	 *
     * @return  mixed
     *
     * @since   1.1
     */
	public function getListStatus($listId){
		
		 $modelContactslist = JModelLegacy::getInstance('contactslist','ConstantcontactModel');
	     $modelApi = JModelLegacy::getInstance('Api','ConstantcontactModel');
		 
		 $response 	= $modelApi->api('get',sprintf('lists/%s', $listId)); 
		 $listData = json_decode($response->body);
		 
		 return $listData->status;
	}
	
	/**
	 * Contact unsubscribe method
	 *
     * @return  mixed
     *
     * @since   1.1
     */
	
	public function unsubscribe() {
		
		$data = array();
		$newList = array();
		$jinput = JFactory::getApplication()->input;		
        $contactId = $jinput->get('contactid', '', 'post'); 
		$newlists = $jinput->get('lists', '', 'array');
		
		JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_constantcontact/model');
		$apiModel = JModelLegacy::getInstance('Api','ConstantcontactModel');
		$apiModel->setState('redirect', 'false');
		
		//check if user wants to be removed from all mailing lists
		$removeAll = $jinput->get('removeall', '', 'post');
		if ($removeAll == 1){			
			$response = $apiModel->api('delete',sprintf('contacts/%s', $contactId));
		} else {
			
			$contactResponse 	= $apiModel->api('get',sprintf('contacts/%s', $contactId));
		    $contactDetails  = json_decode($contactResponse->body);
			$contactLists = $contactDetails->lists;
			$contactEmail = $contactDetails->email_addresses[0]->email_address;
			
			foreach ($contactLists as $key => $list) {
				$newContactList[] = $list->id;
			}			
			
			$hiddenArray = array_diff($newContactList, $newlists);  // check if any contact lists have been removed          
			$activeArray = array_diff($newlists, $newContactList);  // check if any contact lists have been added
           
			//make the lists which have been removed as HIDDEN			
			if (!empty($hiddenArray)) {
			
				foreach ($contactLists as $key => $list) {
					$listId = $list->id;
					if (in_array($listId, $hiddenArray)) {
						
						$newArray[$key]['id'] = $listId;
						$newArray[$key]['status'] = "HIDDEN";
						
					} else {
						
						$newArray[$key]['id'] = $listId;
						$newArray[$key]['status'] = "ACTIVE";
					}			
					
				 }	
			} else {
				foreach ($contactLists as $key => $list) {
					 $listId = $list->id;
				     $newArray[$key]['id'] = $listId;
				     $newArray[$key]['status'] = "ACTIVE";
				}
				
			}
			
			 //add new contact lists to the array
			 if(!empty($activeArray)) {
				 $activeArray = array_values($activeArray);
				 for ($i=0; $i < count($activeArray); $i++) {				
					
					 $newArray[$key+($i+1)]['id'] = $activeArray[$i];
					 $newArray[$key+($i+1)]['status'] = "ACTIVE";	
				 }				 
			 }			
			 
			
			$data['lists'] = $newArray;
			$data['id'] = $contactId;
			$data['email_addresses'][0]['email_address'] = $contactEmail;
			
			$method = 'put';
            $path = 'contacts/'.$data['id'];
			
			$headers = array(
                'action-by' =>  'ACTION_BY_VISITOR',
                'content-type' => 'application/json'
             );		
			 $extraUrl['action_by'] =  'ACTION_BY_VISITOR'; 
           $response = $apiModel->api($method, $path, json_encode($data), $headers, $extraUrl);
		}
		
		return $response;
		
	}
	
}