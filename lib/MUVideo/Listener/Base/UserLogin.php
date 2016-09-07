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
 * Event handler base class for user login events.
 */
class MUVideo_Listener_Base_UserLogin
{
    /**
     * Listener for the `module.users.ui.login.started` event.
     *
     * Occurs at the beginning of the log-in process, before the registration form is displayed to the user.
     *
     * NOTE: This event will not fire if the log-in process is entered through any other method
     * other than visiting the log-in screen directly.
     * For example, if automatic log-in is enabled following registration, then this event
     * will not fire when the system passes control from the registration process to the log-in process.
     *
     * Likewise, this event will not fire if a user begins the log-in process from the log-in block or a log-in
     * plugin if the user provides valid authentication information.
     * This event will fire, however, if invalid information is provided to the log-in block or log-in plugin,
     * resulting in the user being redirected to the full log-in screen for corrections.
     *
     * This event does not have any subject, arguments, or data.
     *
     * @param Zikula_Event $event The event instance
     */
    public static function started(Zikula_Event $event)
    {
    }
    
    /**
     * Listener for the `module.users.ui.login.veto` event.
     *
     * Occurs immediately prior to a log-in that is expected to succeed.
     * (All prerequisites for a successful login have been checked and are satisfied.)
     * This event allows a module to intercept the login process and prevent a successful login from taking place.
     *
     * A handler that needs to veto a login attempt should call `stop()`. This will prevent other handlers
     * from receiving the event, will return to the login process, and will prevent the login from taking place.
     * A handler that vetoes a login attempt should set an appropriate error message and give any additional
     * feedback to the user attempting to log in that might be appropriate.
     *
     * If vetoing the login, the 'returnUrl' argument should be set to redirect the user to an appropriate action.
     *
     * Note: the user __will not__ be logged in when the event handler is executing.
     * Any attempt to check a user's permissions, his logged-in status, or any operation will
     * return a value equivalent to what an anonymous (guest) user would see.
     * Care should be taken to ensure that sensitive operations done within a handler for this event
     * do not introduce breaches of security.
     *
     * The subject of the event will contain the UserEntity.
     * The arguments of the event are:
     *     `'authentication_method'` will contain the name of the module and the name of the method that was used to authenticated the user.
     *
     * @param Zikula_Event $event The event instance
     */
    public static function veto(Zikula_Event $event)
    {
    }
    
    /**
     * Listener for the `module.users.ui.login.succeeded` event.
     *
     * Occurs right after a successful attempt to log in, and just prior to redirecting the user to the desired page.
     *
     * The event subject contains the UserEntity.
     * The arguments of the event are as follows:
     *     `'authentication_module'` an array containing the authenticating module name (`'modname'`) and method (`'method'`) 
     *       used to log the user in.
     *     `'redirecturl'` will contain the value of the 'returnurl' parameter, if one was supplied, or an empty
     *       string. This can be modified to change where the user is redirected following the login.
     *
     * If a `'redirecturl'` is specified by any entity intercepting and processing the `module.users.ui.login.succeeded` event, then
     * the URL provided replaces the one provided by the returnurl parameter to the login process. If it is set to an empty
     * string, then the user is redirected to the site's home page. An event handler should carefully consider whether 
     * changing the `'redirecturl'` argument is appropriate. First, the user may be expecting to return to the page where
     * he was when he initiated the log-in process. Being redirected to a different page might be disorienting to the user.
     * Second, an event handler that was notified prior to the current handler may already have changed the `'returnUrl'`.
     *
     * Finally, this event only fires in the event of a "normal" UI-oriented log-in attempt. A module attempting to log in
     * programmatically by directly calling the core functions will not see this event fired.
     *
     * @param Zikula_Event $event The event instance
     */
    public static function succeeded(Zikula_Event $event)
    {
    }
    
    /**
     * Listener for the `module.users.ui.login.failed` event.
     *
     * Occurs right after an unsuccessful attempt to log in.
     *
     * The event subject contains the UserEntity if it has been found, otherwise null.
     * The arguments of the event are as follows:
     * `'authentication_module'` an array containing the authenticating module name (`'modname'`) and method (`'method'`) 
     *   used to log the user in.
     * `'authentication_info'` an array containing the authentication information entered by the user (contents will vary by method).
     * `'redirecturl'` will initially contain an empty string. This can be modified to change where the user is redirected following the failed login.
     *
     * If a `'redirecturl'` is specified by any entity intercepting and processing the `module.users.ui.login.failed` event, then
     * the user will be redirected to the URL provided.
     *
     * An event handler should carefully consider whether changing the `'returnUrl'` argument is appropriate.
     * First, the user may be expecting to return to the log-in screen.
     * Being redirected to a different page might be disorienting to the user.
     * Second, an event handler that was notified prior to the current handler may already have changed the `'returnUrl'`.
     *
     * Finally, this event only fires in the event of a "normal" UI-oriented log-in attempt. A module attempting to log in
     * programmatically by directly calling core functions will not see this event fired.
     *
     * @param Zikula_Event $event The event instance
     */
    public static function failed(Zikula_Event $event)
    {
    }
}
