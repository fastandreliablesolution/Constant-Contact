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
 * Constant Contact Campaigns View
 *
 * @package		Joomla.Administrator
 * @subpackage	com_constantcontact
 * @since		1.1
 */
class ConstantcontactViewCampaignsHtml extends JViewLegacy
{
    public function display($tpl = null)
    {
        $modelCampaigns  = JModelLegacy::getInstance('campaigns','ConstantcontactModel');
        $this->setModel($modelCampaigns);

        $this->items        = $modelCampaigns->getItems();
        $this->state        = $modelCampaigns->getState();
        $this->pagination   = $modelCampaigns->getPagination();

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
        $canDo	= ConstantcontactHelperConstantcontact::getActions();

        if ($canDo->get('core.delete')) {
            JToolBarHelper::deleteList('', 'campaigns.delete', 'JTOOLBAR_EMPTY_TRASH');
            JToolBarHelper::divider();
        }

        JToolBarHelper::title(JText::_('COM_CONSTANTCONTACT_VIEW_CAMPAIGNS_TITLE'));

        JToolBar::getInstance('toolbar')->appendButton('Popup', 'options', JText::_('COM_CONSTANTCONTACT_TITLE_SETTINGS'), 'index.php?option=com_constantcontact&amp;view=settings&amp;tmpl=component', 875, 550, 0, 0, '');

        ConstantcontactHelperConstantcontact::addSubmenu('campaigns');
    }
}