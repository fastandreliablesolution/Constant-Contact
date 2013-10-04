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
 * Authentication View
 *
 * @package		Joomla.Administrator
 * @subpackage	com_constantcontact
 * @since		1.1
 */
class ConstantcontactViewAuthenticationHtml extends JViewLegacy
{
    /**
     * Display view
     *
     * @param   null $tpl
     *
     * @since   1.1
     */
    public function display($tpl = null)
    {
        if ($this->getModel('authentication')->isAuthenticated()) {
            JFactory::getApplication()->redirect('index.php?option=com_constantcontact',JText::_('COM_CONSTANTCONTACT_VIEW_AUTHENTICATION_ALREADY_AUTHENTICATED'));
        }

        $this->addToolbar();

        parent::display($tpl);
    }

    /**
     * Add toolbare to authentication
     *
     * @since   1.1
     */
    protected function addToolbar()
    {
        JToolBarHelper::title(JText::_('COM_CONSTNATCONTACT_VIEW_AUTHENTICATION_TITLE'));
    }
}