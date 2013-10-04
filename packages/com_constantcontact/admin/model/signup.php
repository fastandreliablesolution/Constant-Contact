<?php
/**
 * @version 1.0
 * @package com_constantcontact
 * @copyright Copyright (C) 2013. All rights reserved.
 * @license GNU General Public License version 2 or later; see LICENSE.txt
 * @author Cloud Access <constantcontact@cloudaccess.net> - http://cloudaccess.net
 */

// No direct access
defined('_JEXEC') or die;

JForm::addFormPath(__DIR__.'/forms');

/**
 * Signup Model class.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_constantcontact
 * @since		1.0
 */
class ConstantcontactModelSignup extends JModelLegacy
{
    /**
     * Return Signup form
     *
     * @return  mixed
     *
     * @since   1.1
     */
    public function getForm()
    {
        return JForm::getInstance('signup', 'signup');
    }

    /**
     * save new account
     *
     * @param $data
     *
     * @since   1.1
     */
    public function register($data)
    {
        $xml = '<atom:entry xmlns:atom="http://www.w3.org/2005/Atom">'.
            '<atom:id>data:,</atom:id>'.
            '<atom:title />'.
            '<atom:author />'.
            '<atom:updated>2013-01-04</atom:updated>'.
            '<atom:content type="application/vnd.ctct+xml">'.
            '<SiteOwner>'.
                '<LoginName>%s</LoginName>'.
                '<Password>%s</Password>'.
            '<Site>'.
            '<Name>cloudaccess.net</Name>'.
            '<Phone></Phone>'.
            '<URL></URL>'.
            '<SignatureName></SignatureName>'.
            '</Site>'.
            '<EmailCode></EmailCode>'.
            '<SiteContact>'.
            '<FirstName>%s</FirstName>'.
            '<LastName>%s</LastName>'.
            '<Email>%s</Email>'.
            '<Phone>%s</Phone>'.
            '<CountryCode>%s</CountryCode>'.
            '<StateCode>%s</StateCode>'.
            '</SiteContact>'.
            '<Products>'.
            '<Product>EmailMarketing</Product>'.
            '</Products>'.
            '<AccountId></AccountId>'.
            '<SingleBilling>No</SingleBilling>'.
            '<ReferralCode></ReferralCode>'.
            '</SiteOwner>'.
            '</atom:content>'.
            '</atom:entry>';

        $xml = sprintf($xml, $data['login_name'], $data['password'], $data['firstname'], $data['lastname'], $data['email'], $data['phone'], $data['country'], $data['state']);
        $url = "https://api.constantcontact.com/ws/partners/cloudaccess/siteowners";
		
		$process = curl_init($url);									
		curl_setopt($process, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($process, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($process, CURLOPT_HTTPHEADER, array('Content-Type: application/atom+xml'));
		curl_setopt($process, CURLOPT_HEADER, 1);
		curl_setopt($process, CURLOPT_USERPWD, "228f07af-d667-4f47-9e9b-7cfdd465c03b%cloudaccess:ERegal345");
		curl_setopt($process, CURLOPT_TIMEOUT, 30);
		curl_setopt($process, CURLOPT_POST, 1);
		curl_setopt($process, CURLOPT_POSTFIELDS, $xml);
		curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
		
		$output = curl_exec($process);
        $code = curl_getinfo ($process, CURLINFO_HTTP_CODE);
        		
        return true ;
    }
}