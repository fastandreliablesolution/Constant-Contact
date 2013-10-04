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
 * Pagination Helper class.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_constantcontact
 * @since		1.1
 */
abstract class ConstantcontactHelperPagination
{
    /**
     * Build pagination
     *
     * @return  string
     *
     * @since   1.1
     */
    public static function buildPagination($pagination)
    {
        if (count((array)$pagination) == 0) {
            return '';
        }

		$url = JURI::getInstance();
        $url->delVar('next');
		


        if (intval(JVERSION) > 2) {
            $html = '<ul class="pager">';

            if (isset($pagination->next_link)) {
                $url = JURI::getInstance();

                $parsedUrl = parse_url($pagination->next_link);
                parse_str($parsedUrl['query'], $query);
                $html .= '<li class="previous"><a onclick="document.getElementById(\'filter_search\').value=\'\';document.getElementById(\'next\').value=\'\';document.getElementById(\'adminForm\').submit();" href="javascript:void(0);">Start</a></li>';
                $html .= '<li class="next"><a title="Next" onclick="document.getElementById(\'next\').value=\''.$query['next'].'\';document.getElementById(\'adminForm\').submit();" href="javascript:void(0);">Next</a></li>';
            }

            $html .= '</ul>';
        } else {
            $html = '<div class="pagination">';

            if (isset($pagination->next_link)) {
                $url = JURI::getInstance();

                $parsedUrl = parse_url($pagination->next_link);
                parse_str($parsedUrl['query'], $query);
                $html .= '<div class="button2-right"><div class="prev"><a onclick="document.getElementById(\'filter_search\').value=\'\';document.getElementById(\'next\').value=\'\';document.getElementById(\'adminForm\').submit();" href="javascript:void(0);">Start</a></div></div>';
                $html .= '<div class="button2-left"><div class="next"><a title="Next" onclick="document.getElementById(\'next\').value=\''.$query['next'].'\';document.getElementById(\'adminForm\').submit();" href="javascript:void(0);">Next</a></div></div>';
            }

            $html .= '</div>';
        }

        return $html;
    }

    public static function startPage()
    {


        if (intval(JVERSION) > 2) {
            $html = '<ul class="pager">';
            $html .= '<li class="previous"><a onclick="document.getElementById(\'filter_search\').value=\'\';document.getElementById(\'next\').value=\'\';document.getElementById(\'adminForm\').submit();" href="javascript:void(0);">Start</a></li>';
            $html .= '</ul>';
        } else {
            $html = '<div class="pagination pagination-centered">';
            $html .= '<div class="button2-right"><div class="prev"><a onclick="document.getElementById(\'filter_search\').value=\'\';document.getElementById(\'next\').value=\'\';document.getElementById(\'adminForm\').submit();" href="javascript:void(0);">Start</a></div></div>';
            $html .= '</div>';
        }

        return $html;
    }
}