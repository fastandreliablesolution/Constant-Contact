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

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_constantcontact'))
{
    throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}

// Include dependencies
$controllerPrefix = 'Constantcontact';
// Autoload component files
JLoader::registerPrefix($controllerPrefix, __DIR__);

$controller	= JControllerLegacy::getInstance($controllerPrefix);
$controller->execute(JFactory::getApplication()->input->getCmd('task'));
$controller->redirect();