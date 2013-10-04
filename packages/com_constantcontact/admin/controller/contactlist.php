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
 * Contact Controller class.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_constantcontact
 * @since		1.1
 */
class ConstantcontactControllerContactlist extends ConstantcontactControllerAuthentication
{
    /**
     * Override Constructor
     *
     * @param   array $config
     *
     * @since   1.1
     */
    public function __construct($config = array())
    {
        parent::__construct($config);

        // Apply, Save & New
        $this->registerTask('apply', 'save');
        $this->registerTask('save2new', 'save');
    }

	/**
     * Add method for contactlist
     *
     * @since   1.1
     */
    public function add()
    {
        $url = 'index.php?option=com_constantcontact&view=contactlist&layout=new';
        $this->setRedirect($url);
    }


    /**
     * Edit method for contactlist
     *
     * @since   1.1
     */
    public function edit()
    {
		$listids = $this->input->get('cid',0,'array');
		jimport('joomla.utilities.arrayhelper');
		JArrayHelper::toInteger($listids);
		
        if (empty($listids)) {
            $this->setRedirect('index.php?option=com_constantcontact&view=contactslist',JText::_('COM_CONSTANTCONTACT_SELECT_ITEM_TO_EDIT'),'warning');
        }

        $url = 'index.php?option=com_constantcontact&view=contactlist&layout=edit';
		
        if ($listids[0]!=0) {
            $url .= '&id='.$listids[0];
        }

        $this->setRedirect($url);
    }
	
	/**
     * save method for contactlist saved using API
     *
     * @since   1.1
     */

    public function save()
    {
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        $data  = $this->input->get('jform','0','array');
		
        if (!$this->getModel()->save($data))
        {
            JFactory::getApplication()->enqueueMessage(JText::_('COM_CONSTANTCONTACT_ERROR_SAVE'),'error');
        } else {
            JFactory::getApplication()->enqueueMessage(JText::_('COM_CONSTANTCONTACT_VIEW_CONTACTLIST_SAVE_SUCESSFULY'));
        }
       
        // set user redirect according with task
        switch ($this->getTask())
        {
            case 'apply':
                $id = $this->getModel()->getState('contactlist.id'); 
				$this->setRedirect('index.php?option=com_constantcontact&task=contactlist.edit&cid[]='.$id);     
                break;
            case 'save2new':
                $this->setRedirect('index.php?option=com_constantcontact&task=contactlist.add');
                break;
            default:
                $this->setRedirect('index.php?option=com_constantcontact&view=contactslist');
                break;
        }
    }
	
	 /**
     * Cancel method for contactlist
     *
     * @since   1.1
     */

    public function cancel()
    {
        $this->setRedirect('index.php?option=com_constantcontact&view=contactslist');
    }
		
}