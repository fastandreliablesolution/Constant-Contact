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
 * Default controller class.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_constantcontact
 * @since		1.1
 */
abstract class ConstantcontactControllerDefault extends JControllerLegacy
{
    /**
     * JInput
     *
     * @var     JInput
     * @since   1.1
     */
    protected $input;

    /**
     * Request Format
     *
     * @var     String
     * @since   1.1
     */
    protected $format;

    /**
     * Default Controller Constructor
     *
     * @param   array $config
     *
     * @since   1.1
     */
    public function __construct($config = array())
    {
        $config['model_path'] = JPATH_COMPONENT.'/model';
        $config['view_path'] = JPATH_COMPONENT.'/view';

        $this->input = JFactory::getApplication()->input;

        parent::__construct($config);

        $this->format = $this->input->getCmd('format','html');
    }

    /**
     * Override Create view to work with structure
     *
     * @param $name
     *
     * @param string $prefix
     *
     * @param string $type
     *
     * @param array $config
     *
     * @return null
     *
     * @since   1.1
     */
    protected function createView($name, $prefix = '', $type = '', $config = array())
    {
        // Clean the view name
        $viewName = preg_replace('/[^A-Z0-9_]/i', '', $name);
        $classPrefix = preg_replace('/[^A-Z0-9_]/i', '', $prefix);
        $viewType = preg_replace('/[^A-Z0-9_]/i', '', $type);
        $viewFormat = $this->format;

        // Build the view class name
        $viewClass = $classPrefix . $viewName . $viewFormat;

        if (!class_exists($viewClass))
        {
            jimport('joomla.filesystem.path');
            $path = JPath::find($this->paths['view'], sprintf('%s/%s.php',$viewName,$viewFormat));

            if ($path)
            {
                require_once $path;

                if (!class_exists($viewClass))
                {
                    JError::raiseError(500, JText::sprintf('JLIB_APPLICATION_ERROR_VIEW_CLASS_NOT_FOUND', $viewClass, $path));

                    return null;
                }
            }
            else
            {
                return parent::createView($name, $prefix, $type, $config);
            }
        }

        $config['template_path'] = JPATH_COMPONENT.'/view/'.$viewName.'/tmpl/';
        $config['helper_path'] = JPATH_COMPONENT.'/helper/';

        return new $viewClass($config);
    }

    /**
     * Method to get a model object, loading it if required.
     *
     * @param   string  $name    The model name. Optional.
     *
     * @param   string  $prefix  The class prefix. Optional.
     *
     * @param   array   $config  Configuration array for model. Optional.
     *
     * @return  object  The model.
     *
     * @since   1.1
     */
    public function getModel($name = '', $prefix = '', $config = array())
    {
        $config['table_path'] = JPATH_COMPONENT.'/table/';

        if (empty($name))
        {
            preg_match('/Controller(.*)/i', get_class($this), $r);
            $r[1] = strtolower($r[1]);
            if (ConstantcontactHelperInflector::isPlural($r[1])) {
                $name = ConstantcontactHelperInflector::singularise($r[1]);
            } else {
                $name = $r[1];
            }
            $prefix = $this->getName().'Model';
        }

        return parent::getModel($name, $prefix, $config);
    }
}