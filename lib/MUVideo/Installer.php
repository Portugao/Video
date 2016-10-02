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
 * Installer implementation class.
 */
class MUVideo_Installer extends MUVideo_Base_AbstractInstaller
{
    /**
     * Upgrade the MUVideo application from an older version.
     *
     * If the upgrade fails at some point, it returns the last upgraded version.
     *
     * @param integer $oldVersion Version to upgrade from.
     *
     * @return boolean True on success, false otherwise.
     */
    public function upgrade($oldVersion)
    {
        // Upgrade dependent on old version number
        switch ($oldVersion) {
            case '1.0.0':
                // update the database schema
                try {
                    DoctrineHelper::updateSchema($this->entityManager, $this->listEntityClasses());
                } catch (\Exception $e) {
                    if (System::isDevelopmentMode()) {
                        return LogUtil::registerError($this->__('Doctrine Exception: ') . $e->getMessage());
                    }
                    return LogUtil::registerError($this->__f('An error was encountered while updating tables for the %s extension.', array($this->getName())));
                }
                $categoryRegistryIdsPerEntity = array();
                
                // add default entry for category registry (property named Main)
                include_once 'modules/MUVideo/lib/MUVideo/Api/Base/Category.php';
                include_once 'modules/MUVideo/lib/MUVideo/Api/Category.php';
                $categoryApi = new MUVideo_Api_Category($this->serviceManager);
                $categoryGlobal = CategoryUtil::getCategoryByPath('/__SYSTEM__/Modules/Global');
                
                $registryData = array();
                $registryData['modname'] = $this->name;
                $registryData['table'] = 'Collection';
                $registryData['property'] = $categoryApi->getPrimaryProperty(array('ot' => 'Collection'));
                $registryData['category_id'] = $categoryGlobal['id'];
                $registryData['id'] = false;
                if (!DBUtil::insertObject($registryData, 'categories_registry')) {
                    LogUtil::registerError($this->__f('Error! Could not create a category registry for the %s entity.', array('collection')));
                }
                $categoryRegistryIdsPerEntity['collection'] = $registryData['id'];
                
                $registryData = array();
                $registryData['modname'] = $this->name;
                $registryData['table'] = 'Movie';
                $registryData['property'] = $categoryApi->getPrimaryProperty(array('ot' => 'Movie'));
                $registryData['category_id'] = $categoryGlobal['id'];
                $registryData['id'] = false;
                if (!DBUtil::insertObject($registryData, 'categories_registry')) {
                    LogUtil::registerError($this->__f('Error! Could not create a category registry for the %s entity.', array('movie')));
                }
                $categoryRegistryIdsPerEntity['movie'] = $registryData['id'];
                
               // unregister persistent event handlers
               EventUtil::unregisterPersistentModuleHandlers($this->name);
               
               // register persistent event handlers
               $this->registerPersistentEventHandlers();
                           
            case '1.1.0':

            	$this->setVar('youtubeApi', '');
            	$this->setVar('channelIds', '');
            	$this->setVar('supportedModuls', '');
            	$this->setVar('overrideVars', false);
            	$this->setVar('enableShrinkingForMoviePoster', false);
            	$this->setVar('shrinkWidthMoviePoster', 800);
            	$this->setVar('shrinkHeightMoviePoster', 600);
            	
            case '1.2.0':
            	// for later updates
        }
    
        // update successful
        return true;
    }
}
