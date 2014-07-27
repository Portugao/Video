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
 * Event handler implementation class for module installer events.
 */
class MUVideo_Listener_Installer extends MUVideo_Listener_Base_Installer
{
    /**
     * Listener for the `installer.module.installed` event.
     *
     * Called after a module has been successfully installed.
     * Receives `$modinfo` as args.
     *
     * @param Zikula_Event $event The event instance.
     */
    public static function moduleInstalled(Zikula_Event $event)
    {
        parent::moduleInstalled($event);
    
        // you can access general data available in the event
        
        // the event name
        // echo 'Event: ' . $event->getName();
        
        // type of current request: MASTER_REQUEST or SUB_REQUEST
        // if a listener should only be active for the master request,
        // be sure to check that at the beginning of your method
        // if ($event->getRequestType() !== HttpKernelInterface::MASTER_REQUEST) {
        //     // don't do anything if it's not the master request
        //     return;
        // }
        
        // kernel instance handling the current request
        // $kernel = $event->getKernel();
        
        // the currently handled request
        // $request = $event->getRequest();
    }
    
    /**
     * Listener for the `installer.module.upgraded` event.
     *
     * Called after a module has been successfully upgraded.
     * Receives `$modinfo` as args.
     *
     * @param Zikula_Event $event The event instance.
     */
    public static function moduleUpgraded(Zikula_Event $event)
    {
        parent::moduleUpgraded($event);
    
        // you can access general data available in the event
        
        // the event name
        // echo 'Event: ' . $event->getName();
        
        // type of current request: MASTER_REQUEST or SUB_REQUEST
        // if a listener should only be active for the master request,
        // be sure to check that at the beginning of your method
        // if ($event->getRequestType() !== HttpKernelInterface::MASTER_REQUEST) {
        //     // don't do anything if it's not the master request
        //     return;
        // }
        
        // kernel instance handling the current request
        // $kernel = $event->getKernel();
        
        // the currently handled request
        // $request = $event->getRequest();
    }
    
    /**
     * Listener for the `installer.module.uninstalled` event.
     *
     * Called after a module has been successfully uninstalled.
     * Receives `$modinfo` as args.
     *
     * @param Zikula_Event $event The event instance.
     */
    public static function moduleUninstalled(Zikula_Event $event)
    {
        parent::moduleUninstalled($event);
    
        // you can access general data available in the event
        
        // the event name
        // echo 'Event: ' . $event->getName();
        
        // type of current request: MASTER_REQUEST or SUB_REQUEST
        // if a listener should only be active for the master request,
        // be sure to check that at the beginning of your method
        // if ($event->getRequestType() !== HttpKernelInterface::MASTER_REQUEST) {
        //     // don't do anything if it's not the master request
        //     return;
        // }
        
        // kernel instance handling the current request
        // $kernel = $event->getKernel();
        
        // the currently handled request
        // $request = $event->getRequest();
    }
    
    /**
     * Listener for the `installer.subscriberarea.uninstalled` event.
     *
     * Called after a hook subscriber area has been unregistered.
     * Receives args['areaid'] as the areaId. Use this to remove orphan data associated with this area.
     *
     * @param Zikula_Event $event The event instance.
     */
    public static function subscriberAreaUninstalled(Zikula_Event $event)
    {
        parent::subscriberAreaUninstalled($event);
    
        // you can access general data available in the event
        
        // the event name
        // echo 'Event: ' . $event->getName();
        
        // type of current request: MASTER_REQUEST or SUB_REQUEST
        // if a listener should only be active for the master request,
        // be sure to check that at the beginning of your method
        // if ($event->getRequestType() !== HttpKernelInterface::MASTER_REQUEST) {
        //     // don't do anything if it's not the master request
        //     return;
        // }
        
        // kernel instance handling the current request
        // $kernel = $event->getKernel();
        
        // the currently handled request
        // $request = $event->getRequest();
    }
}