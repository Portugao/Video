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
 * Admin controller class providing navigation and interaction functionality.
 */
class MUVideo_Controller_Admin extends MUVideo_Controller_Base_Admin
{
    /**
     * This method is the default function handling the admin area called without defining arguments.
     *
     *
     * @return mixed Output.
     */
    public function main()
    {
        // parameter specifying which type of objects we are treating
        $objectType = $this->request->query->filter('ot', 'collection', FILTER_SANITIZE_STRING);
        
        $permLevel = ACCESS_ADMIN;
        $this->throwForbiddenUnless(SecurityUtil::checkPermission($this->name . '::', '::', $permLevel), LogUtil::getErrorMsgPermission());
        
        $redirectUrl = ModUtil::url($this->name, 'admin', 'view', array('lct' => 'admin'));
        
        return $this->redirect($redirectUrl);
    }
}
