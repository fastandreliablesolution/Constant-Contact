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
 * Constant Contact Campaign View
 *
 * @package		Joomla.Administrator
 * @subpackage	com_constantcontact
 * @since		1.1
 */
class ConstantcontactViewCampaignHtml extends JViewLegacy
{
    public function display($tpl = null)
    {
        $modelCampaign  = JModelLegacy::getInstance('campaign','ConstantcontactModel');
        $this->setModel($modelCampaign);

        $this->campaignDetails   = $modelCampaign->getCampaign();
		        
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
	
	 JToolBarHelper::cancel('campaign.cancel', 'JTOOLBAR_CLOSE');
	  
	 JToolBarHelper::title(JText::_('COM_CONSTANTCONTACT_VIEW_CAMPAIGNS_TITLE'));

     ConstantcontactHelperConstantcontact::addSubmenu('campaign');
    }
}