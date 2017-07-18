<?php
/**
 * Video.
 *
 * @copyright Michael Ueberschaer (MU)
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @author Michael Ueberschaer <info@homepages-mit-zikula.de>.
 * @link http://homepages-mit-zikula.de
 * @link http://zikula.org
 * @version Generated by ModuleStudio (http://modulestudio.de).
 */

namespace MU\VideoModule\Listener\Base;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Zikula\Core\Event\GenericEvent;

/**
 * Event handler implementation class for special purposes and 3rd party api support.
 */
abstract class AbstractThirdPartyListener implements EventSubscriberInterface
{
    /**
     * Makes our handlers known to the event system.
     */
    public static function getSubscribedEvents()
    {
        return [
            'module.content.gettypes'               => ['contentGetTypes', 5],
            'module.scribite.editorhelpers'         => ['getEditorHelpers', 5],
            'moduleplugin.tinymce.externalplugins'  => ['getTinyMcePlugins', 5],
            'moduleplugin.ckeditor.externalplugins' => ['getCKEditorPlugins', 5]
        ];
    }
    
    
    /**
     * Listener for the `module.content.gettypes` event.
     *
     * This event occurs when the Content module is 'searching' for Content plugins.
     * The subject is an instance of Content_Types.
     * You can register custom content types as well as custom layout types.
     *
     * You can access general data available in the event.
     *
     * The event name:
     *     `echo 'Event: ' . $event->getName();`
     *
     * The current request's type: `MASTER_REQUEST` or `SUB_REQUEST`.
     * If a listener should only be active for the master request,
     * be sure to check that at the beginning of your method.
     *     `if ($event->getRequestType() !== HttpKernelInterface::MASTER_REQUEST) {
     *         return;
     *     }`
     *
     * The kernel instance handling the current request:
     *     `$kernel = $event->getKernel();`
     *
     * The currently handled request:
     *     `$request = $event->getRequest();`
     *
     * @param \Zikula_Event $event The event instance
     */
    public function contentGetTypes(\Zikula_Event $event)
    {
        // intended is using the add() method to add a plugin like below
        $types = $event->getSubject();
        
        
        // plugin for showing a single item
        $types->add('MUVideoModule_ContentType_Item');
        
        // plugin for showing a list of multiple items
        $types->add('MUVideoModule_ContentType_ItemList');
    }
    
    /**
     * Listener for the `module.scribite.editorhelpers` event.
     *
     * This occurs when Scribite adds pagevars to the editor page.
     * MUVideoModule will use this to add a javascript helper to add custom items.
     *
     * You can access general data available in the event.
     *
     * The event name:
     *     `echo 'Event: ' . $event->getName();`
     *
     * The current request's type: `MASTER_REQUEST` or `SUB_REQUEST`.
     * If a listener should only be active for the master request,
     * be sure to check that at the beginning of your method.
     *     `if ($event->getRequestType() !== HttpKernelInterface::MASTER_REQUEST) {
     *         return;
     *     }`
     *
     * The kernel instance handling the current request:
     *     `$kernel = $event->getKernel();`
     *
     * The currently handled request:
     *     `$request = $event->getRequest();`
     *
     * @param \Zikula_Event $event The event instance
     */
    public function getEditorHelpers(\Zikula_Event $event)
    {
        // intended is using the add() method to add a helper like below
        $helpers = $event->getSubject();
        
        $helpers->add(
            [
                'module' => 'MUVideoModule',
                'type'   => 'javascript',
                'path'   => 'modules/MU/VideoModule/Resources/public/js/MUVideoModule.Finder.js'
            ]
        );
    }
    
    /**
     * Listener for the `moduleplugin.tinymce.externalplugins` event.
     *
     * Adds external plugin to TinyMCE.
     *
     * You can access general data available in the event.
     *
     * The event name:
     *     `echo 'Event: ' . $event->getName();`
     *
     * The current request's type: `MASTER_REQUEST` or `SUB_REQUEST`.
     * If a listener should only be active for the master request,
     * be sure to check that at the beginning of your method.
     *     `if ($event->getRequestType() !== HttpKernelInterface::MASTER_REQUEST) {
     *         return;
     *     }`
     *
     * The kernel instance handling the current request:
     *     `$kernel = $event->getKernel();`
     *
     * The currently handled request:
     *     `$request = $event->getRequest();`
     *
     * @param \Zikula_Event $event The event instance
     */
    public function getTinyMcePlugins(\Zikula_Event $event)
    {
        // intended is using the add() method to add a plugin like below
        $plugins = $event->getSubject();
        
        $plugins->add(
            [
                'name' => 'muvideomodule',
                'path' => 'modules/MU/VideoModule/Resources/docs/scribite/plugins/TinyMce/vendor/tinymce/plugins/muvideomodule/plugin.js'
            ]
        );
    }
    
    /**
     * Listener for the `moduleplugin.ckeditor.externalplugins` event.
     *
     * Adds external plugin to CKEditor.
     *
     * You can access general data available in the event.
     *
     * The event name:
     *     `echo 'Event: ' . $event->getName();`
     *
     * The current request's type: `MASTER_REQUEST` or `SUB_REQUEST`.
     * If a listener should only be active for the master request,
     * be sure to check that at the beginning of your method.
     *     `if ($event->getRequestType() !== HttpKernelInterface::MASTER_REQUEST) {
     *         return;
     *     }`
     *
     * The kernel instance handling the current request:
     *     `$kernel = $event->getKernel();`
     *
     * The currently handled request:
     *     `$request = $event->getRequest();`
     *
     * @param \Zikula_Event $event The event instance
     */
    public function getCKEditorPlugins(\Zikula_Event $event)
    {
        // intended is using the add() method to add a plugin like below
        $plugins = $event->getSubject();
        
        $plugins->add(
            [
                'name' => 'muvideomodule',
                'path' => 'modules/MU/VideoModule/Resources/docs/scribite/plugins/CKEditor/vendor/ckeditor/plugins/muvideomodule/',
                'file' => 'plugin.js',
                'img'  => 'ed_muvideomodule.gif'
            ]
        );
    }
}
