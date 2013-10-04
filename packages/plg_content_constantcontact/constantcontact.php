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

jimport('joomla.filter.output');
jimport('joomla.plugin.plugin');

/**
 * Constant contact content integration
 *
 * @package		Joomla.Plugin
 * @subpackage	User.constantcontact
 * @since		1.1
 */
class plgContentConstantcontact extends JPlugin
{
    /**
     * Example after save content method
     * Article is passed by reference, but after the save, so no changes will be saved.
     * Method is called right after the content is saved
     *
     * @param	string		The context of the content passed to the plugin (added in 1.6)
     * @param	object		A JTableContent object
     * @param	bool		If the content is just about to be created
     * @since	1.1
     */
    public function onContentAfterSave($context, &$table, $isNew)
    {
        if ( $context == "com_content.article" ) {
            $this->createCompaign($table, $isNew);
        }
	}

    public function createCompaign($article, $isNew)
    {
        //initialise vars
        $config = JFactory::getConfig();
        $db     = JFactory::getDbo();

        // load category from table
        $category = JTable::getInstance('category');
        $category->load($article->catid);

        //check if the category title is created as contact list
        $modelContactslist = JModelLegacy::getInstance('contactslist','ConstantcontactModel');
        $options   = $modelContactslist->getOptions();

        $listId = 0;
        foreach ($options as $option) {
            if ($category->title == $option->text) {
                $listId = $option->value;
                break;
            }
        }

        $headers = array(
            'action-by' =>  'ACTION_BY_OWNER',
            'content-type' => 'application/json'
        );
        $data['status'] = "CONFIRMED";
        $modelAPI = JModelLegacy::getInstance('api','ConstantcontactModel');
        $verifiedEmailResponse   = $modelAPI->api('get', 'account/verifiedemailaddresses', $data, $headers);
		
        if ($verifiedEmailResponse->code != "200") {			
			 JFactory::getApplication()->enqueueMessage('COM_CONSTANTCONTACT_ERROR_SAVE_CAMPAIGN','error');
			 			
        } else {
            //get verified Email address for the account to schedule campaign
            $verifiedEmailResponseData = json_decode($verifiedEmailResponse->body);
            $verifiedEmail = $verifiedEmailResponseData[0]->email_address;
        }

        $query = $db->getQuery(true);
        $query->select('email')->from('#__constantcontact_authentication');
        $db->setQuery($query);
        $userEmail = $db->loadResult();

        if ($isNew) {

            if (intval($listId)) {

                $campaign['name'] = $article->title;
                $campaign['subject'] = $article->title;
                $campaign['from_name'] = $verifiedEmail;
                $campaign['from_email'] = $verifiedEmail;
                $campaign['greeting_string'] = "Greetings";
                $campaign['reply_to_email'] = $verifiedEmail;
                $campaign['text_content'] = JFilterOutput::cleanText($article->introtext);
                $emailContent = "<html><body>".$article->introtext." </body></html>";
                $campaign['email_content'] = $emailContent;
                $campaign['email_content_format'] = "HTML";
                $campaign['message_footer']['organization_name'] = "Cloudaccess.net";
                $campaign['message_footer']['postal_code'] =  "49684";
                $campaign['message_footer']['country'] =  "US";
                $address = "10850 Traverse Hwy, Suite 4480,Traverse City";
                $campaign['message_footer']['address_line_1'] = JFilterOutput::cleanText($address);
                $campaign['message_footer']['city'] =  "Michigan";
                $campaign['message_footer']['state'] =  "MI";
                $campaign['sent_to_contact_lists'][0]['id'] = $listId; //joomla category set the contact list for campaign has to be sent

                $campaignMethod = 'post';
                $campaignPath = 'emailmarketing/campaigns';
                $modelAPI->setState('redirect', 'false');
                $campaignResponse = $modelAPI->api($campaignMethod, $campaignPath, json_encode($campaign), $headers);
                $campaignResponseData = json_decode($campaignResponse->body);
                $campaignId = $campaignResponseData->id;

                //if campaign added, schedule campaign to run after 5 hours from now
                if (intval($campaignId)) {
                    $scheduleMethod = 'post';
                    $schedulePath = 'emailmarketing/campaigns/'.$campaignId.'/schedules';
                    $schedulecampaign['scheduled_date'] = date('Y-m-d\TH:i:s\.000\Z', strtotime("+5 hours"));
                    $scheduleResponse = $modelAPI->api($scheduleMethod, $schedulePath, json_encode($schedulecampaign), $headers);
					$scheduleResponseData = json_decode($scheduleResponse->body);
					if($scheduleResponse->code != '200') {
					  JFactory::getApplication()->enqueueMessage($scheduleResponseData[0]->error_message,'error');
					}					
                }
            }
        }
    }
	
}