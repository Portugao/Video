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
 * Installer base class.
 */
class MUVideo_Base_Installer extends Zikula_AbstractInstaller
{
    /**
     * Install the MUVideo application.
     *
     * @return boolean True on success, or false.
     */
    public function install()
    {
        // Check if upload directories exist and if needed create them
        try {
            $controllerHelper = new MUVideo_Util_Controller($this->serviceManager);
            $controllerHelper->checkAndCreateAllUploadFolders();
        } catch (\Exception $e) {
            return LogUtil::registerError($e->getMessage());
        }
        // create all tables from according entity definitions
        try {
            DoctrineHelper::createSchema($this->entityManager, $this->listEntityClasses());
        } catch (\Exception $e) {
            if (System::isDevelopmentMode()) {
                return LogUtil::registerError($this->__('Doctrine Exception: ') . $e->getMessage());
            }
            $returnMessage = $this->__f('An error was encountered while creating the tables for the %s extension.', array($this->name));
            if (!System::isDevelopmentMode()) {
                $returnMessage .= ' ' . $this->__('Please enable the development mode by editing the /config/config.php file in order to reveal the error details.');
            }
            return LogUtil::registerError($returnMessage);
        }
    
        // set up all our vars with initial values
        $this->setVar('pageSize', 10);
        $this->setVar('maxSizeOfMovie', 1024000000);
        $this->setVar('maxSizeOfPoster', 102400);
        $this->setVar('standardPoster', '/images/poster.png');
    
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
    
        // create the default data
        $this->createDefaultData($categoryRegistryIdsPerEntity);
    
        // register persistent event handlers
        $this->registerPersistentEventHandlers();
    
        // register hook subscriber bundles
        HookUtil::registerSubscriberBundles($this->version->getHookSubscriberBundles());
        
    
        // initialisation successful
        return true;
    }
    
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
    /*
        // Upgrade dependent on old version number
        switch ($oldVersion) {
            case '1.0.0':
                // do something
                // ...
                // update the database schema
                try {
                    DoctrineHelper::updateSchema($this->entityManager, $this->listEntityClasses());
                } catch (\Exception $e) {
                    if (System::isDevelopmentMode()) {
                        return LogUtil::registerError($this->__('Doctrine Exception: ') . $e->getMessage());
                    }
                    return LogUtil::registerError($this->__f('An error was encountered while updating tables for the %s extension.', array($this->getName())));
                }
        }
    */
    
        // update successful
        return true;
    }
    
    /**
     * Uninstall MUVideo.
     *
     * @return boolean True on success, false otherwise.
     */
    public function uninstall()
    {
        // delete stored object workflows
        $result = Zikula_Workflow_Util::deleteWorkflowsForModule($this->getName());
        if ($result === false) {
            return LogUtil::registerError($this->__f('An error was encountered while removing stored object workflows for the %s extension.', array($this->getName())));
        }
    
        try {
            DoctrineHelper::dropSchema($this->entityManager, $this->listEntityClasses());
        } catch (\Exception $e) {
            if (System::isDevelopmentMode()) {
                return LogUtil::registerError($this->__('Doctrine Exception: ') . $e->getMessage());
            }
            return LogUtil::registerError($this->__f('An error was encountered while dropping tables for the %s extension.', array($this->name)));
        }
    
        // unregister persistent event handlers
        EventUtil::unregisterPersistentModuleHandlers($this->name);
    
        // unregister hook subscriber bundles
        HookUtil::unregisterSubscriberBundles($this->version->getHookSubscriberBundles());
        
    
        // remove all module vars
        $this->delVars();
    
        // remove category registry entries
        ModUtil::dbInfoLoad('Categories');
        DBUtil::deleteWhere('categories_registry', 'modname = \'' . $this->name . '\'');
    
        // remove all thumbnails
        $manager = $this->getServiceManager()->getService('systemplugin.imagine.manager');
        $manager->setModule($this->name);
        $manager->cleanupModuleThumbs();
    
        // remind user about upload folders not being deleted
        $uploadPath = FileUtil::getDataDirectory() . '/' . $this->name . '/';
        LogUtil::registerStatus($this->__f('The upload directories at [%s] can be removed manually.', $uploadPath));
    
        // uninstallation successful
        return true;
    }
    
    /**
     * Build array with all entity classes for MUVideo.
     *
     * @return array list of class names.
     */
    protected function listEntityClasses()
    {
        $classNames = array();
        $classNames[] = 'MUVideo_Entity_Collection';
        $classNames[] = 'MUVideo_Entity_CollectionCategory';
        $classNames[] = 'MUVideo_Entity_Movie';
        $classNames[] = 'MUVideo_Entity_MovieCategory';
    
        return $classNames;
    }
    
    /**
     * Create the default data for MUVideo.
     *
     * @param array $categoryRegistryIdsPerEntity List of category registry ids.
     *
     * @return void
     */
    protected function createDefaultData($categoryRegistryIdsPerEntity)
    {
        $entityClass = 'MUVideo_Entity_Collection';
        $this->entityManager->getRepository($entityClass)->truncateTable();
        $entityClass = 'MUVideo_Entity_Movie';
        $this->entityManager->getRepository($entityClass)->truncateTable();
    }
    
    /**
     * Register persistent event handlers.
     * These are listeners for external events of the core and other modules.
     */
    protected function registerPersistentEventHandlers()
    {
        // core -> 
        EventUtil::registerPersistentModuleHandler('MUVideo', 'api.method_not_found', array('MUVideo_Listener_Core', 'apiMethodNotFound'));
        EventUtil::registerPersistentModuleHandler('MUVideo', 'core.preinit', array('MUVideo_Listener_Core', 'preInit'));
        EventUtil::registerPersistentModuleHandler('MUVideo', 'core.init', array('MUVideo_Listener_Core', 'init'));
        EventUtil::registerPersistentModuleHandler('MUVideo', 'core.postinit', array('MUVideo_Listener_Core', 'postInit'));
        EventUtil::registerPersistentModuleHandler('MUVideo', 'controller.method_not_found', array('MUVideo_Listener_Core', 'controllerMethodNotFound'));
    
        // front controller -> MUVideo_Listener_FrontController
        EventUtil::registerPersistentModuleHandler('MUVideo', 'frontcontroller.predispatch', array('MUVideo_Listener_FrontController', 'preDispatch'));
    
        // installer -> MUVideo_Listener_Installer
        EventUtil::registerPersistentModuleHandler('MUVideo', 'installer.module.installed', array('MUVideo_Listener_Installer', 'moduleInstalled'));
        EventUtil::registerPersistentModuleHandler('MUVideo', 'installer.module.upgraded', array('MUVideo_Listener_Installer', 'moduleUpgraded'));
        EventUtil::registerPersistentModuleHandler('MUVideo', 'installer.module.uninstalled', array('MUVideo_Listener_Installer', 'moduleUninstalled'));
        EventUtil::registerPersistentModuleHandler('MUVideo', 'installer.subscriberarea.uninstalled', array('MUVideo_Listener_Installer', 'subscriberAreaUninstalled'));
    
        // modules -> MUVideo_Listener_ModuleDispatch
        EventUtil::registerPersistentModuleHandler('MUVideo', 'module_dispatch.postloadgeneric', array('MUVideo_Listener_ModuleDispatch', 'postLoadGeneric'));
        EventUtil::registerPersistentModuleHandler('MUVideo', 'module_dispatch.preexecute', array('MUVideo_Listener_ModuleDispatch', 'preExecute'));
        EventUtil::registerPersistentModuleHandler('MUVideo', 'module_dispatch.postexecute', array('MUVideo_Listener_ModuleDispatch', 'postExecute'));
        EventUtil::registerPersistentModuleHandler('MUVideo', 'module_dispatch.custom_classname', array('MUVideo_Listener_ModuleDispatch', 'customClassname'));
        EventUtil::registerPersistentModuleHandler('MUVideo', 'module_dispatch.service_links', array('MUVideo_Listener_ModuleDispatch', 'serviceLinks'));
    
        // mailer -> MUVideo_Listener_Mailer
        EventUtil::registerPersistentModuleHandler('MUVideo', 'module.mailer.api.sendmessage', array('MUVideo_Listener_Mailer', 'sendMessage'));
    
        // page -> MUVideo_Listener_Page
        EventUtil::registerPersistentModuleHandler('MUVideo', 'pageutil.addvar_filter', array('MUVideo_Listener_Page', 'pageutilAddvarFilter'));
        EventUtil::registerPersistentModuleHandler('MUVideo', 'system.outputfilter', array('MUVideo_Listener_Page', 'systemOutputfilter'));
    
        // errors -> MUVideo_Listener_Errors
        EventUtil::registerPersistentModuleHandler('MUVideo', 'setup.errorreporting', array('MUVideo_Listener_Errors', 'setupErrorReporting'));
        EventUtil::registerPersistentModuleHandler('MUVideo', 'systemerror', array('MUVideo_Listener_Errors', 'systemError'));
    
        // theme -> MUVideo_Listener_Theme
        EventUtil::registerPersistentModuleHandler('MUVideo', 'theme.preinit', array('MUVideo_Listener_Theme', 'preInit'));
        EventUtil::registerPersistentModuleHandler('MUVideo', 'theme.init', array('MUVideo_Listener_Theme', 'init'));
        EventUtil::registerPersistentModuleHandler('MUVideo', 'theme.load_config', array('MUVideo_Listener_Theme', 'loadConfig'));
        EventUtil::registerPersistentModuleHandler('MUVideo', 'theme.prefetch', array('MUVideo_Listener_Theme', 'preFetch'));
        EventUtil::registerPersistentModuleHandler('MUVideo', 'theme.postfetch', array('MUVideo_Listener_Theme', 'postFetch'));
    
        // view -> MUVideo_Listener_View
        EventUtil::registerPersistentModuleHandler('MUVideo', 'view.init', array('MUVideo_Listener_View', 'init'));
        EventUtil::registerPersistentModuleHandler('MUVideo', 'view.postfetch', array('MUVideo_Listener_View', 'postFetch'));
    
        // user login -> MUVideo_Listener_UserLogin
        EventUtil::registerPersistentModuleHandler('MUVideo', 'module.users.ui.login.started', array('MUVideo_Listener_UserLogin', 'started'));
        EventUtil::registerPersistentModuleHandler('MUVideo', 'module.users.ui.login.veto', array('MUVideo_Listener_UserLogin', 'veto'));
        EventUtil::registerPersistentModuleHandler('MUVideo', 'module.users.ui.login.succeeded', array('MUVideo_Listener_UserLogin', 'succeeded'));
        EventUtil::registerPersistentModuleHandler('MUVideo', 'module.users.ui.login.failed', array('MUVideo_Listener_UserLogin', 'failed'));
    
        // user logout -> MUVideo_Listener_UserLogout
        EventUtil::registerPersistentModuleHandler('MUVideo', 'module.users.ui.logout.succeeded', array('MUVideo_Listener_UserLogout', 'succeeded'));
    
        // user -> MUVideo_Listener_User
        EventUtil::registerPersistentModuleHandler('MUVideo', 'user.gettheme', array('MUVideo_Listener_User', 'getTheme'));
        EventUtil::registerPersistentModuleHandler('MUVideo', 'user.account.create', array('MUVideo_Listener_User', 'create'));
        EventUtil::registerPersistentModuleHandler('MUVideo', 'user.account.update', array('MUVideo_Listener_User', 'update'));
        EventUtil::registerPersistentModuleHandler('MUVideo', 'user.account.delete', array('MUVideo_Listener_User', 'delete'));
    
        // registration -> MUVideo_Listener_UserRegistration
        EventUtil::registerPersistentModuleHandler('MUVideo', 'module.users.ui.registration.started', array('MUVideo_Listener_UserRegistration', 'started'));
        EventUtil::registerPersistentModuleHandler('MUVideo', 'module.users.ui.registration.succeeded', array('MUVideo_Listener_UserRegistration', 'succeeded'));
        EventUtil::registerPersistentModuleHandler('MUVideo', 'module.users.ui.registration.failed', array('MUVideo_Listener_UserRegistration', 'failed'));
        EventUtil::registerPersistentModuleHandler('MUVideo', 'user.registration.create', array('MUVideo_Listener_UserRegistration', 'create'));
        EventUtil::registerPersistentModuleHandler('MUVideo', 'user.registration.update', array('MUVideo_Listener_UserRegistration', 'update'));
        EventUtil::registerPersistentModuleHandler('MUVideo', 'user.registration.delete', array('MUVideo_Listener_UserRegistration', 'delete'));
    
        // users module -> MUVideo_Listener_Users
        EventUtil::registerPersistentModuleHandler('MUVideo', 'module.users.config.updated', array('MUVideo_Listener_Users', 'configUpdated'));
    
        // group -> MUVideo_Listener_Group
        EventUtil::registerPersistentModuleHandler('MUVideo', 'group.create', array('MUVideo_Listener_Group', 'create'));
        EventUtil::registerPersistentModuleHandler('MUVideo', 'group.update', array('MUVideo_Listener_Group', 'update'));
        EventUtil::registerPersistentModuleHandler('MUVideo', 'group.delete', array('MUVideo_Listener_Group', 'delete'));
        EventUtil::registerPersistentModuleHandler('MUVideo', 'group.adduser', array('MUVideo_Listener_Group', 'addUser'));
        EventUtil::registerPersistentModuleHandler('MUVideo', 'group.removeuser', array('MUVideo_Listener_Group', 'removeUser'));
    
        // special purposes and 3rd party api support -> MUVideo_Listener_ThirdParty
        EventUtil::registerPersistentModuleHandler('MUVideo', 'get.pending_content', array('MUVideo_Listener_ThirdParty', 'pendingContentListener'));
        EventUtil::registerPersistentModuleHandler('MUVideo', 'module.content.gettypes', array('MUVideo_Listener_ThirdParty', 'contentGetTypes'));
        EventUtil::registerPersistentModuleHandler('MUVideo', 'module.scribite.editorhelpers', array('MUVideo_Listener_ThirdParty', 'getEditorHelpers'));
        EventUtil::registerPersistentModuleHandler('MUVideo', 'moduleplugin.tinymce.externalplugins', array('MUVideo_Listener_ThirdParty', 'getTinyMcePlugins'));
        EventUtil::registerPersistentModuleHandler('MUVideo', 'moduleplugin.ckeditor.externalplugins', array('MUVideo_Listener_ThirdParty', 'getCKEditorPlugins'));
    }
}
