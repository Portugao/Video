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
 * The muvideoTemplateSelector plugin provides items for a dropdown selector.
 *
 * Available parameters:
 *   - assign: If set, the results are assigned to the corresponding variable instead of printed out.
 *
 * @param  array            $params All attributes passed to this function from the template.
 * @param  Zikula_Form_View $view   Reference to the view object.
 *
 * @return string The output of the plugin.
 */
function smarty_function_muvideoTemplateSelector($params, $view)
{
    $dom = ZLanguage::getModuleDomain('MUVideo');
    $result = array();

    $result[] = array('text' => __('Only item titles', $dom), 'value' => 'itemlist_display.tpl');
    $result[] = array('text' => __('With description', $dom), 'value' => 'itemlist_display_description.tpl');
    $result[] = array('text' => __('Custom template', $dom), 'value' => 'custom');

    if (array_key_exists('assign', $params)) {
        $view->assign($params['assign'], $result);

        return;
    }

    return $result;
}
