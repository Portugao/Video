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
 * Collection controller class providing navigation and interaction functionality.
 */
class MUVideo_Controller_Collection extends MUVideo_Controller_Base_AbstractCollection
{
    /**
     * This method takes care of getting youtube videos.
     *
     * @return string Output
     */
    public function getVideos()
    {
        // DEBUG: permission check aspect starts
        $this->throwForbiddenUnless(SecurityUtil::checkPermission('MUVideo::', '::', ACCESS_EDIT));
        // DEBUG: permission check aspect ends
        // parameter specifying which type of objects we are treating
        $objectType = (isset($args['ot']) && !empty($args['ot'])) ? $args['ot'] : $this->request->getGet()->filter('ot', 'collection', FILTER_SANITIZE_STRING);
        $utilArgs = array('controller' => 'user', 'action' => 'getVideos');
        if (!in_array($objectType, MUVideo_Util_Controller::getObjectTypes('controllerAction', $utilArgs))) {
            $objectType = MUVideo_Util_Controller::getDefaultObjectType('controllerAction', $utilArgs);
        }
        // create new Form reference
        $view = FormUtil::newForm($this->name, $this);
    
        // build form handler class name
        $handlerClass = 'MUVideo_Form_Handler_' . ucfirst($objectType) . '_GetVideos';
    
        // determine the output template
        $viewHelper = new MUVideo_Util_View($this->serviceManager);
        $template = $viewHelper->getViewTemplate($this->view, $objectType, 'getVideos', array());
        
        // execute form using supplied template and page event handler
        return $view->execute($template, new $handlerClass());
    }
}
