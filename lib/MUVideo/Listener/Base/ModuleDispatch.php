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
 * Event handler base class for dispatching modules.
 */
class MUVideo_Listener_Base_ModuleDispatch
{
    /**
     * Listener for the `module_dispatch.postloadgeneric` event.
     *
     * Called after a module api or controller has been loaded.
     * Receives the args `array('modinfo' => $modinfo, 'type' => $type, 'force' => $force, 'api' => $api)`.
     *
     * @param Zikula_Event $event The event instance
     */
    public static function postLoadGeneric(Zikula_Event $event)
    {
    }
    
    /**
     * Listener for the `module_dispatch.preexecute` event.
     *
     * Occurs in `ModUtil::exec()` before function call with the following args:
     *     `array(
     *          'modname' => $modname,
     *          'modfunc' => $modfunc,
     *          'args' => $args,
     *          'modinfo' => $modinfo,
     *          'type' => $type,
     *          'api' => $api
     *      )`
     * .
     *
     * @param Zikula_Event $event The event instance
     */
    public static function preExecute(Zikula_Event $event)
    {
    }
    
    /**
     * Listener for the `module_dispatch.postexecute` event.
     *
     * Occurs in `ModUtil::exec()` after function call with the following args:
     *     `array(
     *          'modname' => $modname,
     *          'modfunc' => $modfunc,
     *          'args' => $args,
     *          'modinfo' => $modinfo,
     *          'type' => $type,
     *          'api' => $api
     *      )`
     * .
     * Receives the modules output with `$event->getData();`.
     * Can modify this output with `$event->setData($data);`.
     *
     * @param Zikula_Event $event The event instance
     */
    public static function postExecute(Zikula_Event $event)
    {
    }
    
    /**
     * Listener for the `module_dispatch.custom_classname` event.
     *
     * In order to override the classname calculated in `ModUtil::exec()`.
     * In order to override a pre-existing controller/api method, use this event type to override the class name that is loaded.
     * This allows to override the methods using inheritance.
     * Receives no subject, args of `array('modname' => $modname, 'modinfo' => $modinfo, 'type' => $type, 'api' => $api)`
     * and 'event data' of `$className`. This can be altered by setting `$event->setData()` followed by `$event->stop()`.
     *
     * @param Zikula_Event $event The event instance
     */
    public static function customClassname(Zikula_Event $event)
    {
    }
    
    /**
     * Listener for the `module_dispatch.service_links` event.
     *
     * Occurs when building admin menu items.
     * Adds sublinks to a Services menu that is appended to all modules if populated.
     * Triggered by module_dispatch.postexecute in bootstrap.
     *
     * @param Zikula_Event $event The event instance
     */
    public static function serviceLinks(Zikula_Event $event)
    {
    }
}
