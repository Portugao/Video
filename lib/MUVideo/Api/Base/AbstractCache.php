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
 * Cache api base class.
 */
abstract class MUVideo_Api_Base_AbstractCache extends Zikula_AbstractApi
{
    /**
     * Clear cache for given item. Can be called from other modules to clear an item cache.
     *
     * @param $args['ot']   the treated object type
     * @param $args['item'] the actual object
     */
    public function clearItemCache(array $args = array())
    {
        if (!isset($args['ot']) || !isset($args['item'])) {
            return;
        }
    
        $objectType = $args['ot'];
        $item = $args['item'];
    
        $controllerHelper = new MUVideo_Util_Controller($this->serviceManager);
        $utilArgs = array('api' => 'cache', 'action' => 'clearItemCache');
        if (!in_array($objectType, $controllerHelper->getObjectTypes('controllerAction', $utilArgs))) {
            return;
        }
    
        if ($item && !is_array($item) && !is_object($item)) {
            $item = ModUtil::apiFunc($this->name, 'selection', 'getEntity', array('ot' => $objectType, 'id' => $item, 'useJoins' => false, 'slimMode' => true));
        }
    
        if (!$item) {
            return;
        }
    
        $instanceId = $item->createCompositeIdentifier();
    
        // Clear View_cache
        $cacheIds = array();
        $cacheIds[] = 'user_main';
        switch ($objectType) {
            case 'collection':
                $cacheIds[] = 'collection_main';
                $cacheIds[] = $objectType . '_view';
                $cacheIds[] = $objectType . '_display|' . $instanceId;
                
                
                break;
            case 'movie':
                $cacheIds[] = 'movie_main';
                $cacheIds[] = $objectType . '_view';
                $cacheIds[] = $objectType . '_display|' . $instanceId;
                
                
                break;
            case 'playlist':
                $cacheIds[] = 'playlist_main';
                $cacheIds[] = $objectType . '_view';
                
                
                break;
        }
    
        $view = Zikula_View::getInstance('MUVideo');
        foreach ($cacheIds as $cacheId) {
            $view->clear_cache(null, $cacheId);
        }
    
    
        // Clear Theme_cache
        $cacheIds = array();
        $cacheIds[] = 'homepage'; // for homepage (can be assigned in the Settings module)
        $cacheIds[] = 'MUVideo/user/main'; // main function
        switch ($objectType) {
            case 'collection':
                $cacheIdPrefix = 'MUVideo/' . $objectType . '/';
                $cacheIds[] = $cacheIdPrefix . 'main'; // main function
                $cacheIds[] = $cacheIdPrefix . 'view/'; // view function (list views)
                $cacheIds[] = $cacheIdPrefix . 'display/' . $instanceId; // display function (detail views)
                
                
                break;
            case 'movie':
                $cacheIdPrefix = 'MUVideo/' . $objectType . '/';
                $cacheIds[] = $cacheIdPrefix . 'main'; // main function
                $cacheIds[] = $cacheIdPrefix . 'view/'; // view function (list views)
                $cacheIds[] = $cacheIdPrefix . 'display/' . $instanceId; // display function (detail views)
                
                
                break;
            case 'playlist':
                $cacheIdPrefix = 'MUVideo/' . $objectType . '/';
                $cacheIds[] = $cacheIdPrefix . 'main'; // main function
                $cacheIds[] = $cacheIdPrefix . 'view/'; // view function (list views)
                
                
                break;
        }
        $theme = Zikula_View_Theme::getInstance();
        $theme->clear_cacheid_allthemes($cacheIds);
    }
}