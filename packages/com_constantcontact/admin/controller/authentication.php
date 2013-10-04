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
 * Authentication Controller class.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_constantcontact
 * @since		1.1
 */
class ConstantcontactControllerAuthentication extends ConstantcontactControllerDefault
{
    /**
     * @var     ConstantcontactModelAuthentication
     * @since   1.1
     */
    protected $modelAuthentication;

    /**
     * Default Controller Constructor
     *
     * @param   array $config
     *
     * @since   1.1
     */
    public function __construct($config = array())
    {
        parent::__construct($config);

        $this->modelAuthentication = new ConstantcontactModelAuthentication();
    }

    /**
     * add check for verify authentication after define task
     *
     * @param   $task
     *
     * @since   1.1
     */
    public function execute($task)
    {
        if (!$this->modelAuthentication->isAuthenticated()) {
            $view = $this->input->getCmd('view');

            if ((!empty($task) && $task != 'validate')) {
                $this->setRedirect('index.php?option=com_constantcontact&view=authentication');
                $this->redirect();
            }
            if (!in_array($view,array('authentication','signup')) && empty($task)) {
                $this->setRedirect('index.php?option=com_constantcontact&view=authentication');
                $this->redirect();
            }
        }

        parent::execute($task);
    }

    /**
     * Create a new CC account
     */
    public function create()
    {
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        $data = array(
            'email' => $this->input->getEmail('email'),
            'login_name' => $this->input->getUsername('username'),
            'password' => $this->input->getString('password'),
            'firstname' => $this->input->getString('firstname'),
            'lastname' => $this->input->getString('lastname'),
            'phone' => $this->input->getString('phone'),
            'country' => $this->input->getString('country'),
            'state' => $this->input->getString('state')
        );

        if (!$this->getModel('signup')->register($data)) {
            JFactory::getApplication()->enqueueMessage(JText::_('COM_CONSTANTCONTACT_VIEW_SINGUP_ERROR'));
            $this->setRedirect('index.php?option=com_constantcontact&view=signup&tmpl=component');
        } else {
            echo '<script>window.parent.location.href = "'.ConstantcontactHelperAuthentication::getAuthenticationLink().'"</script>';
            JFactory::getApplication()->close();
        }
    }

    /**
     * Save token
     *
     * @since   1.1
     */
    final function validate()
    {
        JSession::checkToken('get') or jexit(JText::_('JINVALID_TOKEN'));
        $user = JFactory::getUser();

        $token = $this->input->getString('access_token');
        $email = $this->input->getString('email', $user->email);

        $data = array(
            'email' => $email,
            'access_token' => $token
        );

        if (!$this->getModel()->save($data)) {
            $this->setRedirect('index.php?option=com_constantcontact',JText::_('COM_CONSTANTCONTACT_ERROR_SAVE_TOKEN'),'error');
        }

        $this->setRedirect('index.php?option=com_constantcontact');
    }
}