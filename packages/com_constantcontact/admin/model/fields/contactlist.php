<?php
/**
 * @version 1.0
 * @package com_constantcontact
 * @copyright Copyright (C) 2013. All rights reserved.
 * @license GNU General Public License version 2 or later; see LICENSE.txt
 * @author Cloud Access <constantcontact@cloudaccess.net> - http://cloudaccess.net
 */
 
defined('_JEXEC') or die('Restricted access');
 
jimport('joomla.form.formfield');
jimport('joomla.cms.model.legacy');
 
class JFormFieldContactlist extends JFormField
{
	protected $type = 'Contactlist';
	
	 /**
     * Set Label for field 
     *
     * @return  array
     *
     * @since   1.1
     */	
	public function getLabel(){
		       
            $this->label = "<label>".JText::_('COM_CONSTANTCONTACT_TITLE_CONTACT_LIST')."</label>";        
            return $this->label;
    }     
		
	 /**
     * Return selectlist of contact Lists 
     *
     * @return  array
     *
     * @since   1.1
     */
	public function getInput() {		
	    
		 
		//select model to get contactlist options	
		JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_constantcontact/model');   
		$model = JModelLegacy::getInstance('contactslist','ConstantcontactModel');
		$contactmodel = JModelLegacy::getInstance('contact','ConstantcontactModel');		
		 
		 $contactLists = $contactmodel->getContactLists();
		 if(empty($contactLists)) {
			 $contactLists = array("1"); 
		 }
		
		 return JHTML::_(
            'select.genericlist',
            $model->getOptions(),
            'jform[lists][]',
            'multiple = "multiple"',
            'value',
            'text',
            $contactLists,
            $this->id
        );
	}
}