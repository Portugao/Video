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

namespace MU\VideoModule\Helper\Base;

use MU\VideoModule\Entity\Factory\VideoFactory;

/**
 * Helper base class for model layer methods.
 */
abstract class AbstractModelHelper
{
    /**
     * @var VideoFactory
     */
    protected $entityFactory;

    /**
     * ModelHelper constructor.
     *
     * @param VideoFactory $entityFactory VideoFactory service instance
     */
    public function __construct(VideoFactory $entityFactory)
    {
        $this->entityFactory = $entityFactory;
    }

    /**
     * Determines whether creating an instance of a certain object type is possible.
     * This is when
     *     - no tree is used
     *     - it has no incoming bidirectional non-nullable relationships.
     *     - the edit type of all those relationships has PASSIVE_EDIT and auto completion is used on the target side
     *       (then a new source object can be created while creating the target object).
     *     - corresponding source objects exist already in the system.
     *
     * Note that even creation of a certain object is possible, it may still be forbidden for the current user
     * if he does not have the required permission level.
     *
     * @param string $objectType Name of treated entity type
     *
     * @return boolean Whether a new instance can be created or not
     *
     * @throws Exception If an invalid object type is used
     */
    public function canBeCreated($objectType)
    {
        $result = false;
    
        switch ($objectType) {
            case 'collection':
                $result = true;
                break;
            case 'movie':
                $result = true;
                break;
            case 'playlist':
                $result = true;
                break;
        }
    
        return $result;
    }

    /**
     * Determines whether there exists at least one instance of a certain object type in the database.
     *
     * @param string $objectType Name of treated entity type
     *
     * @return boolean Whether at least one instance exists or not
     *
     * @throws Exception If an invalid object type is used
     */
    protected function hasExistingInstances($objectType)
    {
        $repository = $this->entityFactory->getRepository($objectType);
        if (null === $repository) {
            return false;
        }
    
        return $repository->selectCount() > 0;
    }
}