<?php
/**
 * MUVideo.
 *
 * @copyright Michael Ueberschaer (MU)
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @package MUVideo
 * @author Michael Ueberschaer <kontakt@webdesign-in-bremen.com>.
 * @link http://webdesign-in-bremen.com
 * @link http://zikula.org
 * @version Generated by ModuleStudio 0.7.0 (http://modulestudio.de).
 */

/**
 * Admin controller class.
 */
class MUVideo_Controller_Base_Admin extends Zikula_AbstractController
{
    /**
     * Post initialise.
     *
     * Run after construction.
     *
     * @return void
     */
    protected function postInitialize()
    {
        // Set caching to false by default.
        $this->view->setCaching(Zikula_View::CACHE_DISABLED);
    }

    /**
     * This is the default action handling the main area called without defining arguments.
     *
     *
     * @return mixed Output
     */
    public function main()
    {
        // parameter specifying which type of objects we are treating
        $objectType = $this->request->query->filter('ot', 'collection', FILTER_SANITIZE_STRING);
        
        $permLevel = ACCESS_ADMIN;
        $this->throwForbiddenUnless(SecurityUtil::checkPermission($this->name . '::', '::', $permLevel), LogUtil::getErrorMsgPermission());
        
        // redirect to view action
        $redirectUrl = ModUtil::url($this->name, 'admin', 'view', array('lct' => 'admin'));
        
        return $this->redirect($redirectUrl);
    }

    /**
     * This action provides an item list overview.
     *
     * @param string  $ot           Treated object type
     * @param string  $sort         Sorting field
     * @param string  $sortdir      Sorting direction
     * @param int     $pos          Current pager position
     * @param int     $num          Amount of entries to display
     * @param string  $tpl          Name of alternative template (to be used instead of the default template)
     * @param boolean $raw          Optional way to display a template instead of fetching it (required for standalone output)
     *
     * @return mixed Output
     */
    public function view()
    {
        $controllerHelper = new MUVideo_Util_Controller($this->serviceManager);
        
        // parameter specifying which type of objects we are treating
        $objectType = $this->request->query->filter('ot', 'collection', FILTER_SANITIZE_STRING);
        $utilArgs = array('controller' => 'admin', 'action' => 'view');
        if (!in_array($objectType, $controllerHelper->getObjectTypes('controllerAction', $utilArgs))) {
            $objectType = $controllerHelper->getDefaultObjectType('controllerAction', $utilArgs);
        }
        $permLevel = ACCESS_ADMIN;
        $this->throwForbiddenUnless(SecurityUtil::checkPermission($this->name . ':' . ucfirst($objectType) . ':', '::', $permLevel), LogUtil::getErrorMsgPermission());
        
        // redirect to entity controller
        
        System::queryStringSetVar('lct', 'admin');
        $this->request->query->set('lct', 'admin');
        
        return ModUtil::func($this->name, $objectType, 'view', array('lct' => 'admin'));
    }

    /**
     * This action provides a item detail view.
     *
     * @param string  $ot           Treated object type
     * @param int     $id           Identifier of entity to be shown
     * @param string  $tpl          Name of alternative template (to be used instead of the default template)
     * @param boolean $raw          Optional way to display a template instead of fetching it (required for standalone output)
     *
     * @return mixed Output
     */
    public function display()
    {
        $controllerHelper = new MUVideo_Util_Controller($this->serviceManager);
        
        // parameter specifying which type of objects we are treating
        $objectType = $this->request->query->filter('ot', 'collection', FILTER_SANITIZE_STRING);
        $utilArgs = array('controller' => 'admin', 'action' => 'display');
        if (!in_array($objectType, $controllerHelper->getObjectTypes('controllerAction', $utilArgs))) {
            $objectType = $controllerHelper->getDefaultObjectType('controllerAction', $utilArgs);
        }
        $permLevel = ACCESS_ADMIN;
        $this->throwForbiddenUnless(SecurityUtil::checkPermission($this->name . ':' . ucfirst($objectType) . ':', '::', $permLevel), LogUtil::getErrorMsgPermission());
        
        // redirect to entity controller
        
        System::queryStringSetVar('lct', 'admin');
        $this->request->query->set('lct', 'admin');
        
        return ModUtil::func($this->name, $objectType, 'display', array('lct' => 'admin'));
    }

    /**
     * This action provides a handling of edit requests.
     *
     * @param string  $ot           Treated object type
     * @param string  $tpl          Name of alternative template (to be used instead of the default template)
     * @param boolean $raw          Optional way to display a template instead of fetching it (required for standalone output)
     *
     * @return mixed Output
     */
    public function edit()
    {
        $controllerHelper = new MUVideo_Util_Controller($this->serviceManager);
        
        // parameter specifying which type of objects we are treating
        $objectType = $this->request->query->filter('ot', 'collection', FILTER_SANITIZE_STRING);
        $utilArgs = array('controller' => 'admin', 'action' => 'edit');
        if (!in_array($objectType, $controllerHelper->getObjectTypes('controllerAction', $utilArgs))) {
            $objectType = $controllerHelper->getDefaultObjectType('controllerAction', $utilArgs);
        }
        $permLevel = ACCESS_ADMIN;
        $this->throwForbiddenUnless(SecurityUtil::checkPermission($this->name . ':' . ucfirst($objectType) . ':', '::', $permLevel), LogUtil::getErrorMsgPermission());
        
        // redirect to entity controller
        
        System::queryStringSetVar('lct', 'admin');
        $this->request->query->set('lct', 'admin');
        
        return ModUtil::func($this->name, $objectType, 'edit', array('lct' => 'admin'));
    }

    /**
     * This action provides a handling of simple delete requests.
     *
     * @param string  $ot           Treated object type
     * @param int     $id           Identifier of entity to be deleted
     * @param boolean $confirmation Confirm the deletion, else a confirmation page is displayed
     * @param string  $tpl          Name of alternative template (to be used instead of the default template)
     * @param boolean $raw          Optional way to display a template instead of fetching it (required for standalone output)
     *
     * @return mixed Output
     */
    public function delete()
    {
        $controllerHelper = new MUVideo_Util_Controller($this->serviceManager);
        
        // parameter specifying which type of objects we are treating
        $objectType = $this->request->query->filter('ot', 'collection', FILTER_SANITIZE_STRING);
        $utilArgs = array('controller' => 'admin', 'action' => 'delete');
        if (!in_array($objectType, $controllerHelper->getObjectTypes('controllerAction', $utilArgs))) {
            $objectType = $controllerHelper->getDefaultObjectType('controllerAction', $utilArgs);
        }
        $permLevel = ACCESS_ADMIN;
        $this->throwForbiddenUnless(SecurityUtil::checkPermission($this->name . ':' . ucfirst($objectType) . ':', '::', $permLevel), LogUtil::getErrorMsgPermission());
        
        // redirect to entity controller
        
        System::queryStringSetVar('lct', 'admin');
        $this->request->query->set('lct', 'admin');
        
        return ModUtil::func($this->name, $objectType, 'delete', array('lct' => 'admin'));
    }


    /**
     * This method takes care of the application configuration.
     *
     * @return string Output
     */
    public function config()
    {
        $this->throwForbiddenUnless(SecurityUtil::checkPermission($this->name . '::', '::', ACCESS_ADMIN));
        
        // Create new Form reference
        $view = \FormUtil::newForm($this->name, $this);
        
        $templateName = 'admin/config.tpl';
        
        // Execute form using supplied template and page event handler
        return $view->execute($templateName, new MUVideo_Form_Handler_Admin_Config());
    }
}
