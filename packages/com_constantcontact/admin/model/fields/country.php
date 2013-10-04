<?php
/**
 * @version     1.0.0
 * @package     com_constantcontact
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      tharuna <tharuna@cloudaccess.net> - http://cloudaccess.net
 */
defined('_JEXEC') or die('Restricted access');
 
jimport('joomla.form.formfield');
 
class JFormFieldCountry extends JFormFieldList  {
 
        protected $type = 'country';
								//get countries list from db 
       public function getInput() {	
								$db	=JFactory::getDBO();
							$returnArr = array();
							$query="Select * from #__constantcontact_countries";
							$db->setQuery( $query );
							$val	= $db->loadObjectList();
							for($i=0;$i<count($val);$i++){
							$line=$val[$i]->country_name;
								$tmp = explode(" - ", $line);      
												if (sizeof($tmp) == 2) {
																$returnArr[trim($tmp[1])] = trim($tmp[0]);
																	
																				}
														}	
														foreach ($returnArr as $k=>$list)
              {
																	// Build options object here
																	$tmp = JHtml::_(
																					'select.option',
																					$k,
																					$list
																	);
			
															 $country[] = $tmp;
              }		
														 return JHTML::_(
            'select.genericlist',
            $country,
            'jform[params][country_code]',
            '',
            'value',
            'text',
            'us',
            $this->id
        );

	     }
}
?>