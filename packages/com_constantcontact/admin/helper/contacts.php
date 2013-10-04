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
abstract class ConstantcontactHelperContacts
{
    /**
     * List of status filter for contacts
     *
     * @return array
     *
     * @since   1.1
     */
    public static function getStatusOptions()
    {
        $options = array();

        $options[] = JHTML::_('select.option', 'ACTIVE', Jtext::_('COM_CONSTANTCONTACT_OPTION_CONTACTS_STATUS_ACTIVE'));
        $options[] = JHTML::_('select.option', 'UNCONFIRMED', Jtext::_('COM_CONSTANTCONTACT_OPTION_CONTACTS_STATUS_UNCONFIRMED'));
        $options[] = JHTML::_('select.option', 'OPTOUT', Jtext::_('COM_CONSTANTCONTACT_OPTION_CONTACTS_STATUS_OPTOUT'));
        $options[] = JHTML::_('select.option', 'REMOVED', Jtext::_('COM_CONSTANTCONTACT_OPTION_CONTACTS_STATUS_REMOVED'));

        return $options;
    }
}