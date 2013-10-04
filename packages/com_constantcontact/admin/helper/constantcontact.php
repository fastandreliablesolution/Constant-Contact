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
 * Default Helper class.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_constantcontact
 * @since		1.1
 */
abstract class ConstantcontactHelperConstantcontact
{
    /**
     * Component Submenu
     *
     * @param   string $vName
     *
     * @since   1.1
     */
    public static function addSubmenu($vName = '')
    {
        JSubMenuHelper::addEntry(
            JText::_('COM_CONSTANTCONTACT_TITLE_CONTACTS'),
            'index.php?option=com_constantcontact&view=contacts',
            $vName == 'contacts'
        );
        JSubMenuHelper::addEntry(
            JText::_('COM_CONSTANTCONTACT_TITLE_CONTACT_LIST'),
            'index.php?option=com_constantcontact&view=contactslist',
            $vName == 'contactslist'
        );
        JSubMenuHelper::addEntry(
            JText::_('COM_CONSTANTCONTACT_TITLE_CAMPAIGNS'),
            'index.php?option=com_constantcontact&view=campaigns',
            $vName == 'campaigns'
        );
    }

    /**
     * Return user actions
     *
     * @return  JObject
     *
     * @since   1.1
     */
    public static function getActions()
    {
        $user	= JFactory::getUser();
        $result	= new JObject;

        $assetName = 'com_constantcontact';

        $actions = array(
            'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
        );

        foreach ($actions as $action) {
            $result->set($action, $user->authorise($action, $assetName));
        }

        return $result;
    }
}