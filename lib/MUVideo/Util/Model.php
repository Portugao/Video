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
 * Utility implementation class for model helper methods.
 */
class MUVideo_Util_Model extends MUVideo_Util_Base_AbstractModel
{
    /**
     *
     This method is for getting a repository for collections
     *
     */

    public static function getCollectionRepository() 
    {
        $serviceManager = ServiceUtil::getManager();
        $entityManager = $serviceManager->getService('doctrine.entitymanager');
        $repository = $entityManager->getRepository('MUVideo_Entity_Collection');

        return $repository;
    }
    
    /**
     *
     This method is for getting a repository for movies
     *
     */
    
    public static function getMovieRepository()
    {
        $serviceManager = ServiceUtil::getManager();
        $entityManager = $serviceManager->getService('doctrine.entitymanager');
        $repository = $entityManager->getRepository('MUVideo_Entity_Movie');
    
        return $repository;
    }
    
    /**
     *
     This method is for getting a repository for playlists
     *
     */
    
    public static function getPlaylistRepository()
    {
    	$serviceManager = ServiceUtil::getManager();
    	$entityManager = $serviceManager->getService('doctrine.entitymanager');
    	$repository = $entityManager->getRepository('MUVideo_Entity_Playlist');
    
    	return $repository;
    }
}
