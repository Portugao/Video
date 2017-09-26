<?php
/**
 * Video.
 *
 * @copyright Michael Ueberschaer (MU)
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @author Michael Ueberschaer <info@homepages-mit-zikula.de>.
 * @link https://homepages-mit-zikula.de
 * @link http://zikula.org
 * @version Generated by ModuleStudio (https://modulestudio.de).
 */

namespace MU\VideoModule\Base;

use Doctrine\DBAL\Connection;
use RuntimeException;
use Zikula\Core\AbstractExtensionInstaller;
use Zikula\CategoriesModule\Entity\CategoryRegistryEntity;

/**
 * Installer base class.
 */
abstract class AbstractVideoModuleInstaller extends AbstractExtensionInstaller
{
    /**
     * Install the MUVideoModule application.
     *
     * @return boolean True on success, or false
     *
     * @throws RuntimeException Thrown if database tables can not be created or another error occurs
     */
    public function install()
    {
        $logger = $this->container->get('logger');
        $userName = $this->container->get('zikula_users_module.current_user')->get('uname');
    
        // Check if upload directories exist and if needed create them
        try {
            $container = $this->container;
            $uploadHelper = new \MU\VideoModule\Helper\UploadHelper(
                $container->get('translator.default'),
                $container->get('filesystem'),
                $container->get('session'),
                $container->get('logger'),
                $container->get('zikula_users_module.current_user'),
                $container->get('zikula_extensions_module.api.variable'),
                $container->getParameter('datadir')
            );
            $uploadHelper->checkAndCreateAllUploadFolders();
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            $logger->error('{app}: User {user} could not create upload folders during installation. Error details: {errorMessage}.', ['app' => 'MUVideoModule', 'user' => $userName, 'errorMessage' => $exception->getMessage()]);
        
            return false;
        }
        // create all tables from according entity definitions
        try {
            $this->schemaTool->create($this->listEntityClasses());
        } catch (\Exception $exception) {
            $this->addFlash('error', $this->__('Doctrine Exception') . ': ' . $exception->getMessage());
            $logger->error('{app}: Could not create the database tables during installation. Error details: {errorMessage}.', ['app' => 'MUVideoModule', 'errorMessage' => $exception->getMessage()]);
    
            return false;
        }
    
        // set up all our vars with initial values
        $this->setVar('maxSizeOfMovie', '200M');
        $this->setVar('maxSizeOfPoster', '200k');
        $this->setVar('standardPoster', '/images/poster.png');
        $this->setVar('youtubeApi', '');
        $this->setVar('channelIds', '');
        $this->setVar('overrideVars', false);
        $this->setVar('collectionEntriesPerPage', '10');
        $this->setVar('linkOwnCollectionsOnAccountPage', true);
        $this->setVar('movieEntriesPerPage', '10');
        $this->setVar('linkOwnMoviesOnAccountPage', true);
        $this->setVar('playlistEntriesPerPage', '10');
        $this->setVar('linkOwnPlaylistsOnAccountPage', true);
        $this->setVar('enableShrinkingForMoviePoster', false);
        $this->setVar('shrinkWidthMoviePoster', '800');
        $this->setVar('shrinkHeightMoviePoster', '600');
        $this->setVar('thumbnailModeMoviePoster',  'inset' );
        $this->setVar('thumbnailWidthMoviePosterView', '32');
        $this->setVar('thumbnailHeightMoviePosterView', '24');
        $this->setVar('thumbnailWidthMoviePosterDisplay', '240');
        $this->setVar('thumbnailHeightMoviePosterDisplay', '180');
        $this->setVar('thumbnailWidthMoviePosterEdit', '240');
        $this->setVar('thumbnailHeightMoviePosterEdit', '180');
        $this->setVar('enabledFinderTypes', [ 'collection' ,  'movie' ,  'playlist' ]);
    
        $categoryRegistryIdsPerEntity = [];
    
        // add default entry for category registry (property named Main)
        $categoryHelper = new \MU\VideoModule\Helper\CategoryHelper(
            $this->container->get('translator.default'),
            $this->container->get('request_stack'),
            $logger,
            $this->container->get('zikula_users_module.current_user'),
            $this->container->get('zikula_categories_module.category_registry_repository'),
            $this->container->get('zikula_categories_module.api.category_permission')
        );
        $categoryGlobal = $this->container->get('zikula_categories_module.category_repository')->findOneBy(['name' => 'Global']);
        $entityManager = $this->container->get('doctrine.orm.default_entity_manager');
    
        $registry = new CategoryRegistryEntity();
        $registry->setModname('MUVideoModule');
        $registry->setEntityname('CollectionEntity');
        $registry->setProperty($categoryHelper->getPrimaryProperty('Collection'));
        $registry->setCategory($categoryGlobal);
    
        try {
            $entityManager->persist($registry);
            $entityManager->flush();
        } catch (\Exception $exception) {
            $this->addFlash('error', $this->__f('Error! Could not create a category registry for the %entity% entity.', ['%entity%' => 'collection']));
            $logger->error('{app}: User {user} could not create a category registry for {entities} during installation. Error details: {errorMessage}.', ['app' => 'MUVideoModule', 'user' => $userName, 'entities' => 'collections', 'errorMessage' => $exception->getMessage()]);
        }
        $categoryRegistryIdsPerEntity['collection'] = $registry->getId();
    
        $registry = new CategoryRegistryEntity();
        $registry->setModname('MUVideoModule');
        $registry->setEntityname('MovieEntity');
        $registry->setProperty($categoryHelper->getPrimaryProperty('Movie'));
        $registry->setCategory($categoryGlobal);
    
        try {
            $entityManager->persist($registry);
            $entityManager->flush();
        } catch (\Exception $exception) {
            $this->addFlash('error', $this->__f('Error! Could not create a category registry for the %entity% entity.', ['%entity%' => 'movie']));
            $logger->error('{app}: User {user} could not create a category registry for {entities} during installation. Error details: {errorMessage}.', ['app' => 'MUVideoModule', 'user' => $userName, 'entities' => 'movies', 'errorMessage' => $exception->getMessage()]);
        }
        $categoryRegistryIdsPerEntity['movie'] = $registry->getId();
    
        $registry = new CategoryRegistryEntity();
        $registry->setModname('MUVideoModule');
        $registry->setEntityname('PlaylistEntity');
        $registry->setProperty($categoryHelper->getPrimaryProperty('Playlist'));
        $registry->setCategory($categoryGlobal);
    
        try {
            $entityManager->persist($registry);
            $entityManager->flush();
        } catch (\Exception $exception) {
            $this->addFlash('error', $this->__f('Error! Could not create a category registry for the %entity% entity.', ['%entity%' => 'playlist']));
            $logger->error('{app}: User {user} could not create a category registry for {entities} during installation. Error details: {errorMessage}.', ['app' => 'MUVideoModule', 'user' => $userName, 'entities' => 'playlists', 'errorMessage' => $exception->getMessage()]);
        }
        $categoryRegistryIdsPerEntity['playlist'] = $registry->getId();
    
        // initialisation successful
        return true;
    }
    
    /**
     * Upgrade the MUVideoModule application from an older version.
     *
     * If the upgrade fails at some point, it returns the last upgraded version.
     *
     * @param integer $oldVersion Version to upgrade from
     *
     * @return boolean True on success, false otherwise
     *
     * @throws RuntimeException Thrown if database tables can not be updated
     */
    public function upgrade($oldVersion)
    {
    /*
        $logger = $this->container->get('logger');
    
        // Upgrade dependent on old version number
        switch ($oldVersion) {
            case '1.0.0':
                // do something
                // ...
                // update the database schema
                try {
                    $this->schemaTool->update($this->listEntityClasses());
                } catch (\Exception $exception) {
                    $this->addFlash('error', $this->__('Doctrine Exception') . ': ' . $exception->getMessage());
                    $logger->error('{app}: Could not update the database tables during the upgrade. Error details: {errorMessage}.', ['app' => 'MUVideoModule', 'errorMessage' => $exception->getMessage()]);
    
                    return false;
                }
        }
    
        // Note there are several helpers available for making migrating your extension from Zikula 1.3 to 1.4 easier.
        // The following convenience methods are each responsible for a single aspect of upgrading to Zikula 1.4.x.
    
        // here is a possible usage example
        // of course 1.2.3 should match the number you used for the last stable 1.3.x module version.
        /* if ($oldVersion = '1.2.3') {
            // rename module for all modvars
            $this->updateModVarsTo14();
            
            // update extension information about this app
            $this->updateExtensionInfoFor14();
            
            // rename existing permission rules
            $this->renamePermissionsFor14();
            
            // rename existing category registries
            $this->renameCategoryRegistriesFor14();
            
            // rename all tables
            $this->renameTablesFor14();
            
            // remove event handler definitions from database
            $this->dropEventHandlersFromDatabase();
            
            // update module name in the hook tables
            $this->updateHookNamesFor14();
            
            // update module name in the workflows table
            $this->updateWorkflowsFor14();
        } * /
    
        // remove obsolete persisted hooks from the database
        //$this->hookApi->uninstallSubscriberHooks($this->bundle->getMetaData());
    */
    
        // update successful
        return true;
    }
    
    /**
     * Renames the module name for variables in the module_vars table.
     */
    protected function updateModVarsTo14()
    {
        $conn = $this->getConnection();
        $conn->update('module_vars', ['modname' => 'MUVideoModule'], ['modname' => 'Video']);
    }
    
    /**
     * Renames this application in the core's extensions table.
     */
    protected function updateExtensionInfoFor14()
    {
        $conn = $this->getConnection();
        $conn->update('modules', ['name' => 'MUVideoModule', 'directory' => 'MU/VideoModule'], ['name' => 'Video']);
    }
    
    /**
     * Renames all permission rules stored for this app.
     */
    protected function renamePermissionsFor14()
    {
        $conn = $this->getConnection();
        $componentLength = strlen('Video') + 1;
    
        $conn->executeQuery("
            UPDATE group_perms
            SET component = CONCAT('MUVideoModule', SUBSTRING(component, $componentLength))
            WHERE component LIKE 'Video%';
        ");
    }
    
    /**
     * Renames all category registries stored for this app.
     */
    protected function renameCategoryRegistriesFor14()
    {
        $conn = $this->getConnection();
        $componentLength = strlen('Video') + 1;
    
        $conn->executeQuery("
            UPDATE categories_registry
            SET modname = CONCAT('MUVideoModule', SUBSTRING(modname, $componentLength))
            WHERE modname LIKE 'Video%';
        ");
    }
    
    /**
     * Renames all (existing) tables of this app.
     */
    protected function renameTablesFor14()
    {
        $conn = $this->getConnection();
    
        $oldPrefix = 'video_';
        $oldPrefixLength = strlen($oldPrefix);
        $newPrefix = 'mu_video_';
    
        $sm = $conn->getSchemaManager();
        $tables = $sm->listTables();
        foreach ($tables as $table) {
            $tableName = $table->getName();
            if (substr($tableName, 0, $oldPrefixLength) != $oldPrefix) {
                continue;
            }
    
            $newTableName = str_replace($oldPrefix, $newPrefix, $tableName);
    
            $conn->executeQuery("
                RENAME TABLE $tableName
                TO $newTableName;
            ");
        }
    }
    
    /**
     * Removes event handlers from database as they are now described by service definitions and managed by dependency injection.
     */
    protected function dropEventHandlersFromDatabase()
    {
        \EventUtil::unregisterPersistentModuleHandlers('Video');
    }
    
    /**
     * Updates the module name in the hook tables.
     */
    protected function updateHookNamesFor14()
    {
        $conn = $this->getConnection();
    
        $conn->update('hook_area', ['owner' => 'MUVideoModule'], ['owner' => 'Video']);
    
        $componentLength = strlen('subscriber.video') + 1;
        $conn->executeQuery("
            UPDATE hook_area
            SET areaname = CONCAT('subscriber.muvideomodule', SUBSTRING(areaname, $componentLength))
            WHERE areaname LIKE 'subscriber.video%';
        ");
    
        $conn->update('hook_binding', ['sowner' => 'MUVideoModule'], ['sowner' => 'Video']);
    
        $conn->update('hook_runtime', ['sowner' => 'MUVideoModule'], ['sowner' => 'Video']);
    
        $componentLength = strlen('video') + 1;
        $conn->executeQuery("
            UPDATE hook_runtime
            SET eventname = CONCAT('muvideomodule', SUBSTRING(eventname, $componentLength))
            WHERE eventname LIKE 'video%';
        ");
    
        $conn->update('hook_subscriber', ['owner' => 'MUVideoModule'], ['owner' => 'Video']);
    
        $componentLength = strlen('video') + 1;
        $conn->executeQuery("
            UPDATE hook_subscriber
            SET eventname = CONCAT('muvideomodule', SUBSTRING(eventname, $componentLength))
            WHERE eventname LIKE 'video%';
        ");
    }
    
    /**
     * Updates the module name in the workflows table.
     */
    protected function updateWorkflowsFor14()
    {
        $conn = $this->getConnection();
        $conn->update('workflows', ['module' => 'MUVideoModule'], ['module' => 'Video']);
        $conn->update('workflows', ['obj_table' => 'CollectionEntity'], ['module' => 'MUVideoModule', 'obj_table' => 'collection']);
        $conn->update('workflows', ['obj_table' => 'MovieEntity'], ['module' => 'MUVideoModule', 'obj_table' => 'movie']);
        $conn->update('workflows', ['obj_table' => 'PlaylistEntity'], ['module' => 'MUVideoModule', 'obj_table' => 'playlist']);
    }
    
    /**
     * Returns connection to the database.
     *
     * @return Connection the current connection
     */
    protected function getConnection()
    {
        $entityManager = $this->container->get('doctrine.orm.default_entity_manager');
    
        return $entityManager->getConnection();
    }
    
    /**
     * Uninstall MUVideoModule.
     *
     * @return boolean True on success, false otherwise
     *
     * @throws RuntimeException Thrown if database tables or stored workflows can not be removed
     */
    public function uninstall()
    {
        $logger = $this->container->get('logger');
    
        try {
            $this->schemaTool->drop($this->listEntityClasses());
        } catch (\Exception $exception) {
            $this->addFlash('error', $this->__('Doctrine Exception') . ': ' . $exception->getMessage());
            $logger->error('{app}: Could not remove the database tables during uninstallation. Error details: {errorMessage}.', ['app' => 'MUVideoModule', 'errorMessage' => $exception->getMessage()]);
    
            return false;
        }
    
        // remove all module vars
        $this->delVars();
    
        // remove category registry entries
        $entityManager = $this->container->get('doctrine.orm.default_entity_manager');
        $registries = $this->container->get('zikula_categories_module.category_registry_repository')->findBy(['modname' => 'MUVideoModule']);
        foreach ($registries as $registry) {
            $entityManager->remove($registry);
        }
        $entityManager->flush();
    
        // remind user about upload folders not being deleted
        $uploadPath = $this->container->getParameter('datadir') . '/MUVideoModule/';
        $this->addFlash('status', $this->__f('The upload directories at "%path%" can be removed manually.', ['%path%' => $uploadPath]));
    
        // uninstallation successful
        return true;
    }
    
    /**
     * Build array with all entity classes for MUVideoModule.
     *
     * @return array list of class names
     */
    protected function listEntityClasses()
    {
        $classNames = [];
        $classNames[] = 'MU\VideoModule\Entity\CollectionEntity';
        $classNames[] = 'MU\VideoModule\Entity\CollectionTranslationEntity';
        $classNames[] = 'MU\VideoModule\Entity\CollectionCategoryEntity';
        $classNames[] = 'MU\VideoModule\Entity\MovieEntity';
        $classNames[] = 'MU\VideoModule\Entity\MovieTranslationEntity';
        $classNames[] = 'MU\VideoModule\Entity\MovieCategoryEntity';
        $classNames[] = 'MU\VideoModule\Entity\PlaylistEntity';
        $classNames[] = 'MU\VideoModule\Entity\PlaylistTranslationEntity';
        $classNames[] = 'MU\VideoModule\Entity\PlaylistCategoryEntity';
    
        return $classNames;
    }
}
