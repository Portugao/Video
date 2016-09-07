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
 * Event handler base class for events of the Users module.
 */
class MUVideo_Listener_Base_Users
{
    /**
     * Listener for the `module.users.config.updated` event.
     *
     * Occurs after the Users module configuration has been
     * updated via the administration interface.
     *
     * Event data is populated by the new values.
     *
     * @param Zikula_Event $event The event instance
     */
    public static function configUpdated(Zikula_Event $event)
    {
    }
}
