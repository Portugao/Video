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

/**
 * MUVideoModule playlist needle information.
 *
 * @param none
 *
 * @return string with short usage description
 */
function MUVideoModule_needleapi_playlist_baseInfo()
{
    $info = [
        // module name
        'module'  => 'MUVideoModule',
        // possible needles
        'info'    => 'VIDEO{PLAYLISTS|PLAYLIST-playlistId}',
        // whether a reverse lookup is possible, needs MUVideoModule_needleapi_playlist_inspect() function
        'inspect' => false
    ];

    return $info;
}