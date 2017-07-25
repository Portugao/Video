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

/**
 * The muvideomoduleObjectTypeSelector plugin provides items for a dropdown selector.
 *
 * Available parameters:
 *   - assign: If set, the results are assigned to the corresponding variable instead of printed out.
 *
 * @param  array            $params All attributes passed to this function from the template
 * @param  Zikula_Form_View $view   Reference to the view object
 *
 * @return string The output of the plugin
 */
function smarty_function_muvideomoduleObjectTypeSelector($params, $view)
{
    $dom = ZLanguage::getModuleDomain('MUVideoModule');
    $result = [];

    $result[] = [
        'text' => __('Collections', $dom),
        'value' => 'collection'
    ];
    $result[] = [
        'text' => __('Movies', $dom),
        'value' => 'movie'
    ];
    $result[] = [
        'text' => __('Playlists', $dom),
        'value' => 'playlist'
    ];

    if (array_key_exists('assign', $params)) {
        $view->assign($params['assign'], $result);

        return;
    }

    return $result;
}
