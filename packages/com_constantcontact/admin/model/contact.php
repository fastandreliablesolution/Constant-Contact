<?php
/**
 * @version 1.1
 * @package com_constantcontact
 * @copyright Copyright (C) 2013. All rights reserved.
 * @license GNU General Public License version 2 or later; see LICENSE.txt
 * @author Cloud Access <constantcontact@cloudaccess.net> - http://cloudaccess.net
 */

// No direct access
defined('_JEXEC') or die;

JLoader::register('ConstantcontactModelApi', JPATH_ADMINISTRATOR.'/components/com_constantcontact/model/api.php');

/**
 * Contacts Model class.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_constantcontact
 * @since		1.1
 */
class ConstantcontactModelContact extends ConstantcontactModelApi
{
    /**
     * @return  mixed
     *
     * @since   1.1
     */
    public function getItem()
    {
        $contact_id = $this->getState('id');

        if ($contact_id) {
            $response 	= $this->api('get',sprintf('contacts/%s', $contact_id));
            $this->item = json_decode($response->body);
        } else {
            $this->item = array();
        }

        return $this->item;
    }

    /**
     * Save contact
     *
     * @param   $data
     *
     * @param   $juser
     *
     * @return  bool
     *
     * @since   1.1
     */
    public function save($data)
    {
        //modify and customise contact lists array before passing
        $newList = array();
        if (!empty($data['lists'])) {
            foreach($data['lists'] as $listKey => $listValue){
                $newList[$listKey]['id'] = $listValue;
                $newList[$listKey]['status'] = "ACTIVE";
            }
        }

        $data['lists'] = $newList;

        if (intval($data['id']) > 0) {
            $method = 'put';
            $path = 'contacts/'.$data['id'];
        } else {
            //check required fields
            if (empty($data['lists']) || empty($data['email_addresses'])) {
                return false;
            }

            $method = 'post';
            $path = 'contacts';
            $data['email_addresses'][0]['opt_in_date'] = date('Y-m-d\TH:i:s\.000\Z');
            $data['email_addresses'][0]['opt_in_source'] =  'ACTION_BY_VISITOR';
        }

        foreach ($data['email_addresses'] as &$email_address) {
            if(!empty($data['status'])){
                if ($data['status'] == 'OPTOUT') {
                    $email_address['opt_out_date'] = date('Y-m-d\TH:i:s\.000\Z');
                }
            }

            if (empty($email_address['opt_out_date'])) {
                unset($email_address['opt_out_date']);
            }
        }

        $data['confirmed'] = (bool)$data['confirmed'];
        $headers = array(
            'action_by' =>  'ACTION_BY_VISITOR',
            'content-type' => 'application/json'
        );

        $extraUrl['action_by'] =  'ACTION_BY_VISITOR';

        $response = $this->api($method, $path, json_encode($data), $headers, $extraUrl);

        $userState = $this->getState('user.create');

        if (!(bool)$userState) {
            return true;
        }

        jimport('joomla.user.helper');
        //generate a 6 digit random password
        $password = JUserHelper::genRandomPassword(32);

        //generate a random password and store in database
        $salt   = JUserHelper::genRandomPassword(32);
        $crypted  = JUserHelper::getCryptedPassword($password, $salt);
        $cpassword = $crypted.':'.$salt;

        $db = $this->_db;
        $query = $db->getQuery(true);
        $query->select('id')->from('#__users')->where('email='.$db->quote($data['email_addresses'][0]['email_address']));
        $db->setQuery($query);
        $userId = $db->loadResult();

        // user already exists
        if ($userId) {
            return true;
        }

        if ($data['first_name'] !='') {
            $name = $data['first_name'];
        } else {
            $name = $data['email_addresses'][0]['email_address'];
        }

        $userData = array(
            "id" => intval($userId),
            "name" => $name,
            "username" =>  $data['email_addresses'][0]['email_address'],
            "password" =>  $cpassword,
            "email"     => $data['email_addresses'][0]['email_address'],
            "block" => 0,
            "groups" => array(
                1,
                2
            )
        );

        if ($userId > 0) {
            unset($userData['username']);
            unset($userData['password']);
        }

        JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_users/models');
        $modelUsers  = JModelLegacy::getInstance('User','UsersModel');

        //Write to database
        if (!$modelUsers->save($userData)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Return list of forms to use on contact
     *
     * @return  array
     *
     * @since   1.1
     */
    public function getForms()
    {
        $form = array(
            'address' => array(),
            'email_addresses' => array()
        );

        JForm::addFormPath(JPATH_COMPONENT.'/model/forms');

        $form['basic'] = JForm::getInstance('contact', 'contact', array('control' => 'jform'));

        //bind data and load form according with item data
        if (!empty($this->item)) {
            $form['basic']->bind($this->item);

            foreach ($this->item->addresses as $key => $address) {
                $formAddress = JForm::getInstance('address.'.$key, 'address', array('control' => 'jform[addresses]['.$key.']'));
                $formAddress->bind($address);
                $form['address'][$key] = $formAddress;
            }

            foreach ($this->item->email_addresses as $key => $email_address) {
                $formEmailAddress = JForm::getInstance('email_addresses.'.$key, 'email_addresses', array('control' => 'jform[email_addresses]['.$key.']'));
                $formEmailAddress->bind($email_address);
                $form['email_addresses'][$key] = $formEmailAddress;
            }
        } else {
            $form['address'][] = JForm::getInstance('address', 'address', array('control' => 'jform[addresses][0]'));
            $form['email_addresses'][] = JForm::getInstance('email_addresses', 'email_addresses', array('control' => 'jform[email_addresses][0]'));
        }

        return $form;
    }

    /**
     * Populate State
     *
     * @since   1.1
     */
    public function populateState()
    {
        $id = JFactory::getApplication()->input->getInt('id');
        $this->setState('id', $id);
    }

    /**
     * Populate State
     *
     * @since   1.1
     */

    public function getContactLists()
    {

        $contact_id = JFactory::getApplication()->input->getInt('id');

        if ($contact_id) {
            $response 	= $this->api('get',sprintf('contacts/%s', $contact_id));
            $userDetails = json_decode($response->body, true);

            foreach ($userDetails['lists'] as $contactList) {
                $userLists[] = $contactList['id'];
            }
        } else {
            $userLists = array();
        }

        return $userLists;
    }
}