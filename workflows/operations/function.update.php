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
 * Update operation.
 * @param object $entity The treated object.
 * @param array  $params Additional arguments.
 *
 * @return bool False on failure or true if everything worked well.
 */
function MUVideo_operation_update(&$entity, $params)
{
    $dom = ZLanguage::getModuleDomain('MUVideo');


    // initialise the result flag
    $result = false;

    $objectType = $entity['_objectType'];
    $currentState = $entity['workflowState'];
    
    // get attributes read from the workflow
    if (isset($params['nextstate']) && !empty($params['nextstate'])) {
        // assign value to the data object
        $entity['workflowState'] = $params['nextstate'];
        if ($params['nextstate'] == 'archived') {
            // bypass validator (for example an end date could have lost it's "value in future")
            $entity['_bypassValidation'] = true;
        }
    }
    
    // get entity manager
    $serviceManager = ServiceUtil::getManager();
    $entityManager = $serviceManager->getService('doctrine.entitymanager');
    
    // save entity data
    try {
        //$this->entityManager->transactional(function($entityManager) {
        $entityManager->persist($entity);
        $entityManager->flush();
        //});
        $result = true;
    } catch (\Exception $e) {
        LogUtil::registerError($e->getMessage());
    }

    // return result of this operation
    return $result;
}
