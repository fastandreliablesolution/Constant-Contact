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
 * unsubscribe controller class.
 *
 * @package		Joomla.Site
 * @subpackage	com_constantcontact
 * @since		1.1
 */
class ConstantcontactControllerUnsubscribe extends ConstantcontactControllerDefault
{
	
	/**
	 * Contact Unsubscription method
	 *
     * @return  mixed
     *
     * @since   1.1
     */
	public function unsubscribe()
    {	
	  JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
	    
		$response = $this->getModel('unsubscribe')->unsubscribe();
		$responseData  = json_decode($response->body);		
		
		 if ($response->code == '200') {			 
			JFactory::getApplication()->enqueueMessage(	JText::_('COM_CONSTANTCONTACT_USER_UNSUBSCRIBED_SUCCESS') );			
		 } else {			 
			 JFactory::getApplication()->enqueueMessage( $responseData[0]->error_message );
		 }
		 
		//check if unsubscribe link is been set in module
		jimport( 'joomla.application.module.helper' );
		jimport( 'joomla.html.parameter' );
		
		$module = JModuleHelper::getModule('mod_constantcontact');		
		$moduleParams =  new JRegistry($module->params);		
		
		if ($moduleParams->get('unsubscribeRedirectLink') != '') {
			JFactory::getApplication()->redirect($moduleParams->get('unsubscribeRedirectLink'));						
		} else {					
			JFactory::getApplication()->redirect('index.php');	
		}		
		
	}	
	
}