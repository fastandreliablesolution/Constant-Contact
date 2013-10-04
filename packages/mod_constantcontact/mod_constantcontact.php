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

$modelConstactsList = JModelLegacy::getInstance('contactslist','ConstantcontactModel');
$displayListArray = $params->get('lists');

require JModuleHelper::getLayoutPath('mod_constantcontact', $params->get('layout', 'default'));