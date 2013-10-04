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
 * Authentication Helper class.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_constantcontact
 * @since		1.1
 */
abstract class ConstantcontactHelperAuthentication
{
    /**
     * @var     string
     * @since   1.1
     */
    private static $API_KEY = 'n9qwg2bg6zzsgbvz9fwd8cju';

    /**
     * Return API KEY
     *
     * @return string
     *
     * @since   1.1
     */
    public static function getApiKey()
    {
        return self::$API_KEY;
    }

    /**
     * Method for build authentication link to constantcontact api OAuth2
     *
     * @param array $query
     *
     * @return string
     *
     * @since   1.1
     */
    public static function getAuthenticationLink(array $query = array())
    {
        $link = 'https://oauth2.constantcontact.com/oauth2/oauth/siteowner/authorize?';

        if (empty($query['response_type'])) {
            $query['response_type'] = 'token';
        }

        if (empty($query['client_id'])) {
            $query['client_id'] = self::$API_KEY;
        }

        if (empty($query['redirect_uri'])) {
            $query['redirect_uri'] = 'http://constantcontact.cloudaccess.net/index.php?client_url='.base64_encode(JUri::getInstance()->base().'index.php?option=com_constantcontact&task=authentication.validate&'.JSession::getFormToken().'=1');
        }

        return $link.http_build_query($query);
    }

    /**
     * New account link
     *
     * @return string
     *
     * @since 1.1
     */
    public static function newaccountLink()
    {
        return 'index.php?option=com_constantcontact&view=signup&tmpl=component';
    }
}