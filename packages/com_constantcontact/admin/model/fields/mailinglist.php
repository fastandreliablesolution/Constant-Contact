<?php
/**
 * @version 1.0
 * @package com_constantcontact
 * @copyright Copyright (C) 2013. All rights reserved.
 * @license GNU General Public License version 2 or later; see LICENSE.txt
 * @author Cloud Access <constantcontact@cloudaccess.net> - http://cloudaccess.net
 */

defined('JPATH_PLATFORM') or die;
// Include dependencies
$controllerPrefix = 'Constantcontact';
// Autoload component files
JLoader::registerPrefix($controllerPrefix, JPATH_ADMINISTRATOR.'/components/com_constantcontact');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('checkboxes');

JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_constantcontact/model');

/**
 * Form Field class for the Joomla Framework.
 *
 * @package     Joomla.Platform
 * @subpackage  Form
 * @since       1.1
 */
class JFormFieldMailinglist extends JFormFieldCheckboxes
{
    /**
     * The form field type.
     *
     * @var     string
     * @since   1.1
     */
    protected $type = 'Mailinglist';

    /**
     * Mailing list options
     *
     * @return array
     *
     * @since   1.1
     */
    public function getOptions()
    {
       $modelContactList = JModelLegacy::getInstance('Contactslist','ConstantcontactModel');
       $options = array_merge(parent::getOptions(), $modelContactList->getOptions());

        return $options;
    }
}