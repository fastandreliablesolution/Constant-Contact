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

JForm::addFormPath(__DIR__.'/forms');

/**
 * Signup Model class.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_constantcontact
 * @since		1.0
 */
class ConstantcontactModelSettings extends JModelLegacy
{
	 /**
     * get all forms
     *
     * @return  bool
     *
     * @since   1.1
     */
    public function getForms()
    {
        $forms = array();

        $forms['mod_constantcontact'] = $this->getModuleForm('site','mod_constantcontact');
        $forms['plg_user_profile'] = $this->getPluginForm('user','profile');
        $forms['plg_user_constantcontact'] = $this->getPluginForm('user','constantcontact');

        return $forms;
    }
	 /**
     * get module parameter form
     *
     * @return  bool
     *
     * @since   1.1
     */
    private function getModuleForm($application, $module)
    {
        $results = array();

        $base_path = JApplicationHelper::getClientInfo($application, true)->path;
        JFactory::getLanguage()->load($module, $base_path);

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('params, id, module, title, position')->from('#__modules')->where('module='.$db->quote($module))->where('client_id='.$db->quote(JApplicationHelper::getClientInfo($application, true)->id));
        $db->setQuery($query);
        foreach ($db->loadObjectList() as $module) {
            $form = JForm::getInstance($module->module, $base_path.'/modules/'.$module->module.'/'.$module->module.'.xml', array('control' => $module->module.'['.$module->id.']'), true, 'config');
            $form->bind(array('params' => json_decode($module->params)));
            $module->form = $form;

            $results[] = $module;
        }
        
        return $results;
    }

    /**
     * Synchronise joomla users with CC
     *
     * @return  bool
     *
     * @since   1.1
     */
    public function syncUsers()
    {
		$CCdata = array();
		$data = array();
	    $db = $this->_db;
        $query = $db->getQuery(true);
        $query->select(array('id', 'name', 'email'))->from('#__users');
        $db->setQuery($query);
        $userDetails = $db->loadObjectList(); 
		
		
		JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_constantcontact/model');
		$modelApi = JModelLegacy::getInstance('Api','ConstantcontactModel');
        $contactModel = JModelLegacy::getInstance('Contact','ConstantcontactModel');
		$contactModel->setState('user.create', false);
		
		$contactEmailArray = array();
		$data['api_key'] = ConstantcontactHelperAuthentication::getApiKey();		
		$path = 'contacts';		
		$http = $modelApi->api('get',$path, $data);		
		$response = json_decode($http->body);	
		foreach ($response->results as $i => $result) {
			$contactEmailArray[] = $result->email_addresses[0]->email_address; //all contacts from CC to be made as an array
		}	
		
		for ( $i=0; $i < count($userDetails); $i++) {
			$userEmail = $userDetails[$i]->email;
			  
			  if(!in_array($userEmail, $contactEmailArray)) {
					$CCdata['id'] = "0"; //creating a new cc user in api
					$CCdata['first_name']   = $userDetails[$i]->name;
					$CCdata['email_addresses'][0]['email_address'] = $userEmail;
					$CCdata['lists'] = array("1");  //will be added to default list, the first contact list
					$CCdata['confirmed'] = "true";
					if($contactModel->save($CCdata)) {
						return true;
					} else {
						return false;
					}
			  }
			
		}

    }

     /**
     * get plugin parameter form
     *
     * @return  bool
     *
     * @since   1.1
     */
    private function getPluginForm($folder, $element)
    {
        JFactory::getLanguage()->load(sprintf('plg_%s_%s', $folder, $element));
        JForm::addFormPath(JPATH_PLUGINS.'/'.$folder.'/');
        JForm::addFormPath(JPATH_PLUGINS.'/'.$folder.'/'.$element.'/');
        $form = JForm::getInstance($element, $element, array('control' => $element));
        // Try 1.6 format: /plugins/folder/element/element.xml
        $formFile = JPath::clean(JPATH_PLUGINS.'/'.$folder.'/'.$element.'/'.$element.'.xml');
        if (!file_exists($formFile)) {
            // Try 1.5 format: /plugins/folder/element/element.xml
            $formFile = JPath::clean(JPATH_PLUGINS.'/'.$folder.'/'.$element.'.xml');
            if (!file_exists($formFile)) {
                throw new Exception(JText::sprintf('COM_PLUGINS_ERROR_FILE_NOT_FOUND', $element.'.xml'));
                return false;
            }
        }

        if (file_exists($formFile)) {
            // Get the plugin form.
            if (!$form->loadFile($formFile, true, 'config')) {
                throw new Exception(JText::_('JERROR_LOADFILE_FAILED'));
            }
        }

        $plugin = JTable::getInstance('extension');
        $plugin->load($plugin->find(array(
            'folder' => $folder,
            'element' => $element,
            'type' => 'plugin'
        )));
        $form->bind(array('params' => json_decode($plugin->params, true)));

        return $form;
    }
	
	/**
     * Save settings
     *
     * @param   $data
     *
	 * @param   $juser
     *
     * @return  bool
     *
     * @since   1.1
     */
    public function save()
    {
        $input = JFactory::getApplication()->input;
        $settings = array();
        $settings['mod_constantcontact'] = $input->get('mod_constantcontact','','array');
        $settings['plg_user_constantcontact'] = $input->get('constantcontact','','array');
        $settings['plg_user_profile'] = $input->get('profile','','array');

        //change this save for foreach $settings module and get params by id on control and keep save query update
        foreach ($settings['mod_constantcontact'] as $module_id => $moduleForm) {
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query->select('params')->from('#__modules')->where('id='.$db->quote($module_id));
            $db->setQuery($query);
            $module = $db->loadObject();

            //update mod_constantcontact
            $parameters = new JRegistry($module->params);
            $parameters->merge(new JRegistry($moduleForm['params']));

            $query = $db->getQuery(true);
            $query->update('#__modules')->set('params='.$db->quote($parameters->toString()))->where('id='.$db->quote($module_id));
            $db->setQuery($query);
            $db->execute();
        }

        $extension = JTable::getInstance('extension');

        //update plg_user_profile
        $extension->load($extension->find(array('element' => 'profile', 'type' => 'plugin', 'folder' => 'user')));
        $parameters = new JRegistry($extension->params);
        $parameters->merge(new JRegistry($settings['plg_user_profile']['params']));
        $query = $db->getQuery(true);
        $query->update('#__extensions')->set('params='.$db->quote($parameters->toString()))->where('extension_id='.$db->quote($extension->extension_id));
        $db->setQuery($query);
        $db->execute();

        //update plg_user_constantcontact
        $extension->load($extension->find(array('element' => 'constantcontact', 'type' => 'plugin', 'folder' => 'user')));
        $parameters = new JRegistry($extension->params);
        $parameters->merge(new JRegistry($settings['plg_user_constantcontact']['params']));
        $query = $db->getQuery(true);
        $query->update('#__extensions')->set('params='.$db->quote($parameters->toString()))->where('extension_id='.$db->quote($extension->extension_id));
        $db->setQuery($query);
        $db->execute();

        return true;
	}
	
}