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
 * Replaces a given needle id by the corresponding content.
 *
 * @param array $args Arguments array
 *     int nid The needle id
 *
 * @return string Replaced value for the needle
 */
function MUVideo_needleapi_collection_base($args)
{
    // Get arguments from argument array
    $nid = $args['nid'];
    unset($args);

    // cache the results
    static $cache;
    if (!isset($cache)) {
        $cache = array();
    }

    $dom = \ZLanguage::getModuleDomain('MUVideo');

    if (empty($nid)) {
        return '<em>' . \DataUtil::formatForDisplay(__('No correct needle id given.', $dom)) . '</em>';
    }

    if (isset($cache[$nid])) {
        // needle is already in cache array
        return $cache[$nid];
    }

    if (!\ModUtil::available('MUVideo')) {
        $cache[$nid] = '<em>' . \DataUtil::formatForDisplay(__f('Module %s is not available.', array('MUVideo'), $dom)) . '</em>';

        return $cache[$nid];
    }

    // strip application prefix from needle
    $needleId = str_replace('MUVIDEO', '', $nid);

    if ($needleId == 'COLLECTIONS') {
        if (!\SecurityUtil::checkPermission('MUVideo:Collection:', '::', ACCESS_READ)) {
            $cache[$nid] = '';

            return $cache[$nid];
        }
    }

    $cache[$nid] = '<a href="' . ModUtil::url('MUVideo', 'collection', 'view') . '" title="' . __('View collections', $dom) . '">' . __('Collections', $dom) . '</a>';
    $needleParts = explode('-', $needleId);
    if ($needleParts[0] != 'COLLECTION' || count($needleParts) < 2) {
        $cache[$nid] = '';

        return $cache[$nid];
    }

    $entityId = (int)$needleParts[1];

    if (!\SecurityUtil::checkPermission('MUVideo:Collection:', $entityId . '::', ACCESS_READ)) {
        $cache[$nid] = '';

        return $cache[$nid];
    }

    $entity = \ModUtil::apiFunc('MUVideo', 'selection', 'getEntity', array('ot' => 'collection, 'id' => $entityId));
    if (null === $entity) {
        $cache[$nid] = '<em>' . __f('Collection with id %s could not be found', array($entityId), $dom) . '</em>';

        return $cache[$nid];
    }

    $title = $entity->getTitleFromDisplayPattern();

    $cache[$nid] = '<a href="' . ModUtil::url('MUVideo', 'collection', 'display', array('id' => $entityId)) . '" title="' . str_replace('"', '', $title) . '">' . $title . '</a>';

    return $cache[$nid];
}
