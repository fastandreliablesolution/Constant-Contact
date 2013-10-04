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
 * Authentication table
 *
 * @package     Joomla.Administrator
 * @subpackage  com_constantcontact
 * @since       1.1
 */
class ConstantcontactTableAuthentication extends JTable
{
    /**
     * Constructor
     *
     * @since   1.1
     */
    public function __construct(&$_db)
    {
        parent::__construct('#__constantcontact_authentication', 'id', $_db);
    }
}