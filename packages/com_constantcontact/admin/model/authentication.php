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
 * Authentication Model
 *
 * Check authentication
 *
 * @package		Joomla.Administrator
 * @subpackage	com_constantcontact
 * @since		1.1
 */
class ConstantcontactModelAuthentication extends ConstantcontactModelDefault
{
    /**
     * Return is are authenticated
     *
     * @return  bool
     *
     * @since   1.1
     */
    public final function isAuthenticated()
    {
        $token = $this->getState('access_token','');
        return !empty($token) ? true : false ;
    }

    /**
     * Override construct to load config access token
     *
     * @param   array $config
     *
     * @since   1.1
     */
    public function __construct($config = array())
    {
        parent::__construct($config);

        $query = $this->_db->getQuery(true);
        $query->select('access_token');
        $query->from('#__constantcontact_authentication');
        $this->_db->setQuery($query);
        $this->setState('access_token', $this->_db->loadResult());
    }

    /**
     * Save token
     *
     * @since   1.1
     */
    public function save($data)
    {
        return $this->getTable()->save($data);
    }
}