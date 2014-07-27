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
 * Controller for external calls base class.
 */
class MUVideo_Controller_Base_External extends Zikula_AbstractController
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
        $controllerHelper = new MUVideo_Util_Controller($this->serviceManager);
    
        $objectType = isset($args['objectType']) ? $args['objectType'] : $getData->filter('ot', '', FILTER_SANITIZE_STRING);
        $utilArgs = array('controller' => 'external', 'action' => 'display');
        if (!in_array($objectType, $controllerHelper->getObjectTypes('controller', $utilArgs))) {
            $objectType = $controllerHelper->getDefaultObjectType('controllerType', $utilArgs);
        }
    
        $id = isset($args['id']) ? $args['id'] : $getData->filter('id', null, FILTER_SANITIZE_STRING);
    
        $component = $this->name . ':' . ucwords($objectType) . ':';
        if (!SecurityUtil::checkPermission($component, $id . '::', ACCESS_READ)) {
            return '';
        }
    
        $source = isset($args['source']) ? $args['source'] : $getData->filter('source', '', FILTER_SANITIZE_STRING);
        if (!in_array($source, array('contentType', 'scribite'))) {
            $source = 'contentType';
        }
    
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
                  ->assign('displayMode', $displayMode);
    
        return $this->view->fetch('external/' . $objectType . '/display.tpl');
    }
    
    /**
     * Popup selector for Scribite plugins.
     * Finds items of a certain object type.
     *
     * @param string $objectType The object type.
     * @param string $editor     Name of used Scribite editor.
     * @param string $sort       Sorting field.
     * @param string $sortdir    Sorting direction.
     * @param int    $pos        Current pager position.
     * @param int    $num        Amount of entries to display.
     *
     * @return output The external item finder page
     */
    public function finder()
    {
        PageUtil::addVar('stylesheet', ThemeUtil::getModuleStylesheet('MUVideo'));
    
        $getData = $this->request->query;
        $controllerHelper = new MUVideo_Util_Controller($this->serviceManager);
    
        $objectType = $getData->filter('objectType', 'collection', FILTER_SANITIZE_STRING);
        $utilArgs = array('controller' => 'external', 'action' => 'finder');
        if (!in_array($objectType, $controllerHelper->getObjectTypes('controller', $utilArgs))) {
            $objectType = $controllerHelper->getDefaultObjectType('controllerType', $utilArgs);
        }
    
        $this->throwForbiddenUnless(SecurityUtil::checkPermission('MUVideo:' . ucwords($objectType) . ':', '::', ACCESS_COMMENT), LogUtil::getErrorMsgPermission());
    
        $entityClass = 'MUVideo_Entity_' . ucwords($objectType);
        $repository = $this->entityManager->getRepository($entityClass);
        $repository->setControllerArguments(array());
    
        $editor = $getData->filter('editor', '', FILTER_SANITIZE_STRING);
        if (empty($editor) || !in_array($editor, array('xinha', 'tinymce'/*, 'ckeditor'*/))) {
            return $this->__('Error: Invalid editor context given for external controller action.');
        }
        $sort = $getData->filter('sort', '', FILTER_SANITIZE_STRING);
        if (empty($sort) || !in_array($sort, $repository->getAllowedSortingFields())) {
            $sort = $repository->getDefaultSortingField();
        }
    
        $sortdir = $getData->filter('sortdir', '', FILTER_SANITIZE_STRING);
        $sdir = strtolower($sortdir);
        if ($sdir != 'asc' && $sdir != 'desc') {
            $sdir = 'asc';
        }
    
        $sortParam = $sort . ' ' . $sdir;
    
        // the current offset which is used to calculate the pagination
        $currentPage = (int) $getData->filter('pos', 1, FILTER_VALIDATE_INT);
    
        // the number of items displayed on a page for pagination
        $resultsPerPage = (int) $getData->filter('num', 0, FILTER_VALIDATE_INT);
        if ($resultsPerPage == 0) {
            $resultsPerPage = $this->getVar('pageSize', 20);
        }
        $where = '';
        list($entities, $objectCount) = $repository->selectWherePaginated($where, $sortParam, $currentPage, $resultsPerPage);
    
        foreach ($entities as $k => $entity) {
            $entity->initWorkflow();
        }
    
        $view = Zikula_View::getInstance('MUVideo', false);
    
        $view->assign('editorName', $editor)
             ->assign('objectType', $objectType)
             ->assign('items', $entities)
             ->assign('sort', $sort)
             ->assign('sortdir', $sdir)
             ->assign('currentPage', $currentPage)
             ->assign('pager', array('numitems'     => $objectCount,
                                     'itemsperpage' => $resultsPerPage));
    
        return $view->display('external/' . $objectType . '/find.tpl');
    }
}
