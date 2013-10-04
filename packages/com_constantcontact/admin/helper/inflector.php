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
abstract class ConstantcontactHelperInflector
{
    /**
     * List of singular words
     *
     * @var     array
     * @since   1.1
     */
    static $_singular = array(

    );

    /**
     * Check if word is singular
     *
     * @param   $word
     *
     * @return  bool
     *
     * @since   1.1
     */
    static public function isPlural($word)
    {
        //if end word has 'S' letter
        if (substr($word,-1) == 's')
        {
            return true;
        }

        return false;
    }

    /**
     * Singularise a word
     *
     * @param   $word
     *
     * @return  mixed
     *
     * @since   1.1
     */
    static public function singularise($word)
    {
        if (self::isPlural($word))
        {
            if (empty(self::$_singular[$word])) {
                self::$_singular[$word] = substr($word,0,-1);
            }
            return self::$_singular[$word];
        }

        return $word;
    }

    /**
     * Pluralise a word
     *
     * @param   $word
     *
     * @return  mixed|string
     *
     * @since   1.1
     */
    static public function pluralise($word)
    {
        $pluralized = array_search($word,self::$_singular);
        if ($pluralized === false) {
            if (substr($word,-1) != 's')
            {
                return $word.'s';
            } else {
                return $word;
            }

        } else {
            return $pluralized;
        }
    }
}