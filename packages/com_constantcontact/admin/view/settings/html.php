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
 * Constant Contact Settings View
 *
 * @package		Joomla.Administrator
 * @subpackage	com_constantcontact
 * @since		1.1
 */
class ConstantcontactViewSettingsHtml extends JViewLegacy
{
    public function display($tpl = null)
    {
        JFactory::getApplication()->input->sef('tmpl','component');
        $modelSettings = $this->getModel('settings');

        $this->forms = $modelSettings->getForms();
		$this->tmpl = JFactory::getApplication()->input->get('tmpl');		
		
        $this->addToolbar();
        parent::display($tpl);
    }
	
	/**
		* Add the page title and toolbar.
		*
		* @since	1.6
		*/

    public function addToolbar()
    {
        $canDo = ConstantcontactHelperConstantcontact::getActions();

        if ($canDo->get('core.edit')) {
            JToolBarHelper::apply('settings.apply');
            JToolBarHelper::save('settings.save');
        }

		ConstantcontactHelperConstantcontact::addSubmenu('settings');
    }
}