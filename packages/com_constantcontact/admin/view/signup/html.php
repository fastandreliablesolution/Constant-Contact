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
 * Constant Contact Dashboard View
 *
 * @package		Joomla.Administrator
 * @subpackage	com_constantcontact
 * @since		1.1
 */
class ConstantcontactViewSignupHtml extends JViewLegacy
{
    public function display($tpl = null)
    {
        $modelSignup = $this->getModel('signup');

        $this->form = $modelSignup->getForm();

        parent::display($tpl);
    }
}