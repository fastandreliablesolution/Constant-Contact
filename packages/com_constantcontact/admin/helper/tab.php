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
 * Tab Helper class.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_constantcontact
 * @since		1.1
 */
abstract class ConstantcontactHelperTab
{
    /**
     * @var     String
     * @since   1.1
     */
    static $tabId = '';

    /**
     * Start tabs
     *
     * @param   $id
     * @return  mixed
     *
     * @since   1.1
     */
    public static function startTabs($id, $activeTab)
    {
        self::$tabId = $id;
        if (intval(JVERSION) > 2) {
            return JHtml::_('bootstrap.startTabSet', self::$tabId, array('active' => $activeTab));
        } else {
            return JHtml::_('tabs.start', self::$tabId, array('useCookie'=>'1'));
        }
    }

    /**
     * Add tab
     *
     * @param $id
     * @param $title
     * @return mixed
     *
     * @since   1.1
     */
    public static function addTab($title, $id)
    {
        if (intval(JVERSION) > 2) {
            return JHtml::_('bootstrap.addTab', self::$tabId, $id, $title);
        } else {
            return JHtml::_('tabs.panel', $title, $id);
        }
    }

    /**
     * Close tab
     *
     * @return mixed
     *
     * @since   1.1
     */
    public static function closeTab()
    {
        if (intval(JVERSION) > 2) {
            return JHtml::_('bootstrap.endTab');
        }
    }

    /**
     * end tabs
     *
     * @return mixed
     *
     * @since   1.1
     */
    public static function endTabs()
    {
        if (intval(JVERSION) > 2) {
            return JHtml::_('bootstrap.endTabSet');
        } else {
            return JHtml::_('tabs.end');
        }
    }
}