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
 * Api Model
 *
 * Handle api calls
 *
 * @package		Joomla.Administrator
 * @subpackage	com_constantcontact
 * @since		1.1
 */
class ConstantcontactModelApi extends ConstantcontactModelAuthentication
{
    /**
     * Constant Contact Api Url
     *
     * @var     string
     * @since   1.1
     */
    protected $apiUrl = 'https://api.constantcontact.com/v2/%s';

    /**
     * JHttp
     *
     * @var     JHttp
     * @since   1.1
     */
    protected $http;

    /**
     * @var     JApplication
     * @since   1.1
     */
    protected $application;

    /**
     * JCache
     *
     * @var     JCache
     * @since   1.1
     */
    protected $cache;

    /**
     * Override constructor
     *
     * @param   array $config
     *
     * @since   1.1
     */
    public function __construct($config = array())
    {
        parent::__construct($config);

        // Initinalise vars
        $options            = new JRegistry;
        $transport          = new JHttpTransportCurl($options);
        $this->http         = new JHttp($options, $transport);
        $this->application  = JFactory::getApplication();
        $this->cache        = JCache::getInstance('output',array('defaultgroup' => 'com_constantcontact'));

        // Set api_key
        $this->setState('api_key', ConstantcontactHelperAuthentication::getApiKey());
		// Set redirect state
		$this->setState('redirect', 'true');

    }

    /**
     * Call constantcontact v2 api
     *
     * @param   string  $method  GET, PUT, POST, DELETE
     *
     * @param   string  $path  String name of resource from api call
     *
     * @param   array  $data  Array with sent data
     *
     * @return  mixed
     *
     * @since   1.1
     */
    final public function api($method, $path, $data = array(), array $headers = array(), array $extraUrl = array())
    {
		
        if (is_array($extraUrl)) {
             $extraUrl['api_key'] = $this->getState('api_key');
        }
      
	     /*if (empty($data['next'])) {
			   	echo "testing";die();
				$extraUrl['next'] = $data['next'];
				if (isset($data['limit'])) {
				   unset($data['limit']);
				}
			}
		

        if (!empty($data['limit']) && intval($data['limit'])) {
            $extraUrl['limit'] = intval($data['limit']);
        }*/
		

        $parameters = array();

        switch ($method)
        {
           	case 'get':
			    $parameters[] = sprintf($this->apiUrl,$path.'?'.http_build_query($extraUrl));
                break;			
            case 'put':
			case 'post':
			    $parameters[] = sprintf($this->apiUrl,$path.'?'.http_build_query($extraUrl));
                $parameters[] = $data;
                break;
            case 'delete':
                $parameters[] = sprintf($this->apiUrl,$path.'?'.http_build_query($extraUrl));
                break;
            default:
                throw new Exception(JText::sprintf('COM_CONSTANTCONTACT_ERROR_INVALID_METHOD','GET, POST, PUT, DELETE'), 500);
                break;
        }

        // headers
        $parameters[] = array_merge(array(
            'authorization' => sprintf('Bearer %s',$this->getState('access_token'))
        ),$headers);
		
		//use cache if enabled
        if ($this->cache->getCaching()) {
            $id = md5(json_encode($parameters));

            $http = $this->cache->get($id);
            if ($http == false) {
                $http = call_user_func_array(array($this->http,$method), $parameters);
                $this->cache->store($http, $id);
		    }
		} else {			
			$http = call_user_func_array(array($this->http,$method), $parameters);
        }
		
		//var_dump($http);
		//die();
		
		
        if (!in_array($http->code, array(200,201))) {
            JFactory::getLanguage()->load('com_constantcontact');
			$redirect = $this->getState('redirect', 'true');          

            switch ($http->code) {
                case 401:
                case 400:
                    $response = json_decode($http->body);
                    $this->application->enqueueMessage(JText::_($response[0]->error_message),'error');
                    if ($redirect == 'true') {
						$this->application->redirect('index.php?option=com_constantcontact');
					}
                    break;
				 case 409:
                    $response = json_decode($http->body);
                    $this->application->enqueueMessage(JText::sprintf('COM_CONSTANTCONTACT_ERROR_RESPONSE_API_DATA_ALREADY_EXIST', $http->code, $response[0]->error_message),'error');
					if ($redirect == 'true') {
                    	$this->application->redirect('index.php?option=com_constantcontact&view=dashboard');
					}
                    break;	
            }
        }
		
		
        return $http;
    }
}