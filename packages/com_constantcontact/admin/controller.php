<?php
/**
 * @version 1.1
 * @package com_constantcontact
 * @copyright Copyright (C) 2013. All rights reserved.
 * @license GNU General Public License version 2 or later; see LICENSE.txt
 * @author Cloud Access <constantcontact@cloudaccess.net> - http://cloudaccess.net
 */

defined('_JEXEC') or die;

/**
 * Component Controller
 *
 * @package     Joomla.Administrator
 * @subpackage  com_constantcontact
 * @since       1.1
 */
class ConstantcontactController extends ConstantcontactControllerAuthentication
{
    /**
     * Default view
     *
     * @var     string
     *
     * @since   1.1
     */
    public $default_view = 'contacts';
}