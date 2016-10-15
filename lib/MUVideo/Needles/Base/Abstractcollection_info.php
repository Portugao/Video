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
 * MUVideo collection needle information.
 *
 * @param none
 *
 * @return string with short usage description
 */
function MUVideo_needleapi_collection_baseInfo()
{
    $info = array(
        // module name
        'module'  => 'MUVideo',
        // possible needles
        'info'    => 'MUVIDEO{COLLECTIONS|COLLECTION-collectionId}',
        // whether a reverse lookup is possible, needs MUVideo_needleapi_collection_inspect() function
        'inspect' => false
    );

    return $info;
}
