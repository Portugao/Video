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
 * @version Generated by ModuleStudio 0.6.2 (http://modulestudio.de).
 */

/**
 * Controller for external calls implementation class.
 */
class MUVideo_Controller_External extends MUVideo_Controller_Base_External
{
    /**
     * Displays one item of a certain object type using a separate template for external usages.
     *
     * @param string $ot          The currently treated object type.
     * @param int    $id          Identifier of the entity to be shown.
     * @param string $source      Source of this call (contentType or scribite).
     * @param string $displayMode Display mode (link or embed).
     *
     * @return string Desired data output.
     */
    public function display(array $args = array())
    {
        $getData = $this->request->query;
        $getPostData = $this->request->request;
        $controllerHelper = new MUVideo_Util_Controller($this->serviceManager);
    
        $objectType = isset($args['objectType']) ? $args['objectType'] : $getData->filter('ot', '', FILTER_SANITIZE_STRING);
        $utilArgs = array('controller' => 'external', 'action' => 'display');
        if (!in_array($objectType, $controllerHelper->getObjectTypes('controller', $utilArgs))) {
            $objectType = $controllerHelper->getDefaultObjectType('controllerType', $utilArgs);
        }
    
        $id = isset($args['id']) ? $args['id'] : $getData->filter('id', null, FILTER_SANITIZE_STRING);
    
        $component = $this->name . ':' . ucwords($objectType) . ':';
       /* if (!SecurityUtil::checkPermission($component, $id . '::', ACCESS_READ)) {
            return '';
        }*/
        
        if (!SecurityUtil::checkPermission('MUVideoContentPlugin::', '::', ACCESS_READ)) {
            return '';
        }
    
        $source = isset($args['source']) ? $args['source'] : $getData->filter('source', '', FILTER_SANITIZE_STRING);
        if (!in_array($source, array('contentType', 'scribite'))) {
            $source = 'contentType';
        }
        
        $moviewidth = isset($args['moviewidth']) ? $args['moviewidth'] : $getPostData->filter('moviewidth', '', FILTER_SANITIZE_STRING);
        $movieheight = isset($args['movieheight']) ? $args['movieheight'] : $getPostData->filter('movieheight', '', FILTER_SANITIZE_STRING);
    
        $displayMode = isset($args['displayMode']) ? $args['displayMode'] : $getData->filter('displayMode', 'embed', FILTER_SANITIZE_STRING);
        if (!in_array($displayMode, array('link', 'embed'))) {
            $displayMode = 'embed';
        }
    
        $entityClass = 'MUVideo_Entity_' . ucwords($objectType);
        $repository = $this->entityManager->getRepository($entityClass);
        $repository->setControllerArguments(array());
        $idFields = ModUtil::apiFunc('MUVideo', 'selection', 'getIdFields', array('ot' => $objectType));
        $idValues = array('id' => $id);
    
        $hasIdentifier = $controllerHelper->isValidIdentifier($idValues);
        if (!$hasIdentifier) {
            return $this->__('Error! Invalid identifier received.');
        }
    
        // assign object data fetched from the database
        $entity = $repository->selectById($idValues);
        if ((!is_array($entity) && !is_object($entity)) || !isset($entity[$idFields[0]])) {
            return $this->__('No such item.');
        }
    
        $entity->initWorkflow();
    
        $instance = $entity->createCompositeIdentifier() . '::';
    
        $this->view->setCaching(Zikula_View::CACHE_ENABLED);
        // set cache id
        $accessLevel = ACCESS_READ;
        if (SecurityUtil::checkPermission($component, $instance, ACCESS_COMMENT)) {
            $accessLevel = ACCESS_COMMENT;
        }
        if (SecurityUtil::checkPermission($component, $instance, ACCESS_EDIT)) {
            $accessLevel = ACCESS_EDIT;
        }
        $this->view->setCacheId($objectType . '|' . $id . '|a' . $accessLevel);
    
        $this->view->assign('objectType', $objectType)
                  ->assign('source', $source)
                  ->assign($objectType, $entity)
                  ->assign('moviewidth', $moviewidth)
                  ->assign('movieheight', $movieheight)
                  ->assign('displayMode', $displayMode);
        
        // initialize
        $youtubeId = '';
        // we get the id from the url
        $youtubeId = explode('=', $entity['urlOfYoutube']);
        
        // assign to template
        $this->view->assign('youtubeId', $youtubeId[1]);
    
        return $this->view->fetch('external/' . $objectType . '/display.tpl');
    }
}
