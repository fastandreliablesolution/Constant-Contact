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
 * Default Model
 *
 * @package		Joomla.Administrator
 * @subpackage	com_constantcontact
 * @since		1.1
 */
class ConstantcontactModelDefault extends JModelLegacy
{
    /**
     * Returns a JTable object, always creating it.
     *
     * @param   string  $type    The table type to instantiate. [optional]
     *
     * @param   string  $prefix  A prefix for the table class name. [optional]
     *
     * @param   array   $config  Configuration array for model. [optional]
     *
     * @return  JTable  A database object
     *
     * @since   1.1
     */
    public function getTable($type = '', $prefix = '', $config = array())
    {
        if ($type == '')
        {
            $capital_split = preg_split('/(?=[A-Z])/',get_class($this));
            $parts = array_slice($capital_split,1);

            $type = ConstantcontactHelperInflector::singularise($parts[2]);
            $prefix = $parts[0].'Table';
        }

        return JTable::getInstance($type, $prefix, $config);
    }
}