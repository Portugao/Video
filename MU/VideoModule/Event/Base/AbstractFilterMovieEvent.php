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

namespace MU\VideoModule\Event\Base;

use Symfony\Component\EventDispatcher\Event;
use MU\VideoModule\Entity\MovieEntity;

/**
 * Event base class for filtering movie processing.
 */
class AbstractFilterMovieEvent extends Event
{
    /**
     * @var MovieEntity Reference to treated entity instance.
     */
    protected $movie;

    /**
     * @var array Entity change set for preUpdate events.
     */
    protected $entityChangeSet = [];

    /**
     * FilterMovieEvent constructor.
     *
     * @param MovieEntity $movie Processed entity
     * @param array $entityChangeSet Change set for preUpdate events
     */
    public function __construct(MovieEntity $movie, $entityChangeSet = [])
    {
        $this->movie = $movie;
        $this->entityChangeSet = $entityChangeSet;
    }

    /**
     * Returns the entity.
     *
     * @return MovieEntity
     */
    public function getMovie()
    {
        return $this->movie;
    }

    /**
     * Returns the change set.
     *
     * @return array
     */
    public function getEntityChangeSet()
    {
        return $this->entityChangeSet;
    }
}
