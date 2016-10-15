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
 * @version Generated by ModuleStudio (http://modulestudio.de).
 */

/**
 * Event handler implementation class for group-related events.
 */
abstract class MUVideo_Listener_Base_AbstractGroup
{
    /**
     * Listener for the `group.create` event.
     *
     * Occurs after a group is created. All handlers are notified.
     * The full group record created is available as the subject.
     *
     * @param Zikula_Event $event The event instance
     */
    public static function create(Zikula_Event $event)
    {
    }
    
    /**
     * Listener for the `group.update` event.
     *
     * Occurs after a group is updated. All handlers are notified.
     * The full updated group record is available as the subject.
     *
     * @param Zikula_Event $event The event instance
     */
    public static function update(Zikula_Event $event)
    {
    }
    
    /**
     * Listener for the `group.delete` event.
     *
     * Occurs after a group is deleted from the system. All handlers are notified.
     * The full group record deleted is available as the subject.
     *
     * @param Zikula_Event $event The event instance
     */
    public static function delete(Zikula_Event $event)
    {
    }
    
    /**
     * Listener for the `group.adduser` event.
     *
     * Occurs after a user is added to a group. All handlers are notified.
     * It does not apply to pending membership requests.
     * The uid and gid are available as the subject.
     *
     * @param Zikula_Event $event The event instance
     */
    public static function addUser(Zikula_Event $event)
    {
    }
    
    /**
     * Listener for the `group.removeuser` event.
     *
     * Occurs after a user is removed from a group. All handlers are notified.
     * The uid and gid are available as the subject.
     *
     * @param Zikula_Event $event The event instance
     */
    public static function removeUser(Zikula_Event $event)
    {
    }
}
