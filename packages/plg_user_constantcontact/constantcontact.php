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

// Include dependencies
$controllerPrefix = 'Constantcontact';
// Autoload component files
JLoader::registerPrefix($controllerPrefix, JPATH_ADMINISTRATOR.'/components/com_constantcontact');

/**
 * Constant contact user integration plugin
 *
 * @package		Joomla.Plugin
 * @subpackage	User.constantcontact
 * @since		1.1
 */
class plgUserConstantcontact extends JPlugin
{
    /**
     * Constructor
     *
     * @access protected
     *
     * @param object $subject The object to observe
     *
     * @param array $config An array that holds the plugin configuration
     *
     * @since 1.5
     */
    public function __construct(& $subject, $config)
    {
        parent::__construct($subject, $config);
        JFactory::getLanguage()->load('com_constantcontact');
        JFormHelper::addFieldPath(JPATH_ADMINISTRATOR . 'components/com_constantcontact/model/fields');
    }

    /**
     * Utility method to act on a user after it has been saved.
     *
     * This method sends a registration email to new users created in the backend.
     *
     * @param	array		$user		Holds the new user data.
     *
     * @param	boolean		$isnew		True if a new user is stored.
     *
     * @param	boolean		$success	True if user was succesfully stored in the database.
     *
     * @param	string		$msg		Message.
     *
     * @return	void
     *
     * @since	1.1
     */
    public function onUserAfterSave($user, $isnew, $success, $msg)
    {
		
		// initialise vars
		$ccUserData = array();
		$ccUserData['id'] = "0"; //creating a new cc user in api
		$ccUserData['first_name'] = $user['name'];
		$ccUserData['email_addresses'][0]['email_address'] = $user['email'];
		$ccUserData['confirmed'] = "true";
		
		if (!empty($user['profile']['lists'])) {
			$ccUserData['lists'] = $user['profile']['lists'];
		} else {
			$ccUserData['lists'] = array ("1"); //assign to the default contactlist			
		}
				
		//call contact model to save user to api
        $contactModel = JModelLegacy::getInstance('Contact','ConstantcontactModel');
        $contactModel->setState('user.create', true);
		$contactModel->setState('redirect', 'false');
        $contactModel->save($ccUserData);
    }

    /**
     * @param JForm $form The form to be altered.
     *
     * @param array $data The associated data for the form.
     *
     * @return boolean
     *
     * @since 1.6
     */
    function onContentPrepareForm($form, $data)
    {
        if (!($form instanceof JForm))
        {
            $this->_subject->setError('JERROR_NOT_A_FORM');
            return false;
        }

        // Check we are manipulating a valid form.
        $name = $form->getName();
        if (!in_array($name, array('com_admin.profile', 'com_users.user', 'com_users.profile', 'com_users.registration')))
        {
            return true;
        }
		
		if($this->params->get('showlist', '0') == "1"){
            // Add the registration fields to the form.
            JForm::addFormPath(dirname(__FILE__) . '/forms');
            $form->loadFile('constantcontact', false);
		}

        return true;
    }

    /**
     * @param string $context The context for the data
     *
     * @param int $data The user id
     *
     * @param object
     *
     * @return boolean
     *
     * @since 1.6
     */
    function onContentPrepareData($context, $data)
    {
        // Check we are manipulating a valid form.
        if (!in_array($context, array('com_users.profile', 'com_users.user', 'com_users.registration', 'com_admin.profile')))
        {
            return true;
        }

        if (is_object($data))
        {
            $userId = isset($data->id) ? $data->id : 0;

            if (!isset($data->constantcontact) and $userId > 0)
            {
                // Load the profile data from the database.
                $db = JFactory::getDbo();
                $db->setQuery(
                    'SELECT profile_key, profile_value FROM #__user_profiles' .
                    ' WHERE user_id = '.(int) $userId." AND profile_key LIKE 'constantcontact.%'" .
                    ' ORDER BY ordering'
                );
                $results = $db->loadRowList();

                // Check for a database error.
                if ($db->getErrorNum())
                {
                    $this->_subject->setError($db->getErrorMsg());
                    return false;
                }

                // Merge the constantcontact data.
                $data->constantcontact = array();				
				
                foreach ($results as $v)
                {
                    $k = str_replace('constantcontact.', '', $v[0]);
                    $data->constantcontact[$k] = json_decode($v[1], true);
                    if ($data->constantcontact[$k] === null)
                    {
                        $data->constantcontact[$k] = $v[1];
                    }
                }
            }
        }

        return true;
    }

    /**
     * Remove all user profile information for the given user ID
     *
     * Method is called after user data is deleted from the database
     *
     * @param array $user Holds the user data
     *
     * @param boolean $success True if user was succesfully stored in the database
     *
     * @param string $msg Message
     */
    function onUserAfterDelete($user, $success, $msg)
    {
        if (!$success)
        {
            return false;
        }

        $userId	= JArrayHelper::getValue($user, 'id', 0, 'int');

        if ($userId)
        {
            try
            {
                $db = JFactory::getDbo();
                $db->setQuery(
                    'DELETE FROM #__user_profiles WHERE user_id = '.$userId .
                    " AND profile_key LIKE 'constantcontact.%'"
                );

                if (!$db->query())
                {
                    throw new Exception($db->getErrorMsg());
                }
            }
            catch (JException $e)
            {
                $this->_subject->setError($e->getMessage());
                return false;
            }
        }

        return true;
    }
}