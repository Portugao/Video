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
 * Movie controller class providing navigation and interaction functionality.
 */
class MUVideo_Controller_Movie extends MUVideo_Controller_Base_Movie
{
    /**
     * This method provides a item detail view.
     *
     * @param string  $tpl          Name of alternative template (to be used instead of the default template).
     * @param boolean $raw          Optional way to display a template instead of fetching it (required for standalone output).
     *
     * @return mixed Output.
     */
    public function display()
    {
        $legacyControllerType = $this->request->query->filter('lct', 'user', FILTER_SANITIZE_STRING);
        System::queryStringSetVar('type', $legacyControllerType);
        $this->request->query->set('type', $legacyControllerType);
    
        $controllerHelper = new MUVideo_Util_Controller($this->serviceManager);
        
        // parameter specifying which type of objects we are treating
        $objectType = 'movie';
        $utilArgs = array('controller' => 'movie', 'action' => 'display');
        $permLevel = $legacyControllerType == 'admin' ? ACCESS_ADMIN : ACCESS_READ;
        $this->throwForbiddenUnless(SecurityUtil::checkPermission($this->name . ':' . ucwords($objectType) . ':', '::', $permLevel), LogUtil::getErrorMsgPermission());
        $entityClass = $this->name . '_Entity_' . ucwords($objectType);
        $repository = $this->entityManager->getRepository($entityClass);
        $repository->setControllerArguments(array());
        
        $idFields = ModUtil::apiFunc($this->name, 'selection', 'getIdFields', array('ot' => $objectType));
        
        // retrieve identifier of the object we wish to view
        $idValues = $controllerHelper->retrieveIdentifier($this->request, array(), $objectType, $idFields);
        $hasIdentifier = $controllerHelper->isValidIdentifier($idValues);
        
        $this->throwNotFoundUnless($hasIdentifier, $this->__('Error! Invalid identifier received.'));
        
        $selectionArgs = array('ot' => $objectType, 'id' => $idValues);
        
        
        $entity = ModUtil::apiFunc($this->name, 'selection', 'getEntity', $selectionArgs);
        $this->throwNotFoundUnless($entity != null, $this->__('No such item.'));
        unset($idValues);
        
        $entity->initWorkflow();
        
        // build ModUrl instance for display hooks; also create identifier for permission check
        $currentUrlArgs = $entity->createUrlArgs();
        $instanceId = $entity->createCompositeIdentifier();
        $currentUrlArgs['id'] = $instanceId; // TODO remove this
        $currentUrlObject = new Zikula_ModUrl($this->name, 'movie', 'display', ZLanguage::getLanguageCode(), $currentUrlArgs);
        
        $this->throwForbiddenUnless(SecurityUtil::checkPermission($this->name . ':' . ucwords($objectType) . ':', $instanceId . '::', $permLevel), LogUtil::getErrorMsgPermission());
        
        $viewHelper = new MUVideo_Util_View($this->serviceManager);
        $templateFile = $viewHelper->getViewTemplate($this->view, $objectType, 'display', array());
        
        // set cache id
        $component = $this->name . ':' . ucwords($objectType) . ':';
        $instance = $instanceId . '::';
        $accessLevel = ACCESS_READ;
        if (SecurityUtil::checkPermission($component, $instance, ACCESS_COMMENT)) {
            $accessLevel = ACCESS_COMMENT;
        }
        if (SecurityUtil::checkPermission($component, $instance, ACCESS_EDIT)) {
            $accessLevel = ACCESS_EDIT;
        }
        $this->view->setCacheId($objectType . '|' . $instanceId . '|a' . $accessLevel);
        
        // assign output data to view object.
        $this->view->assign($objectType, $entity)
                   ->assign('currentUrlObject', $currentUrlObject)
                   ->assign($repository->getAdditionalTemplateParameters('controllerAction', $utilArgs));
        
        // initialize 
        $youtubeId = '';
        // we get the id from the url
        $youtubeId = explode('=', $entity['urlOfYoutube']);
        
        // assign to template
        $this->view->assign('youtubeId', $youtubeId[1]);
        
        // fetch and return the appropriate template
        return $viewHelper->processTemplate($this->view, $objectType, 'display', array(), $templateFile);
    }
}
