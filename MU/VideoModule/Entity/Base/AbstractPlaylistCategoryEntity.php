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

namespace MU\VideoModule\Entity\Base;

use Doctrine\ORM\Mapping as ORM;
use Zikula\CategoriesModule\Entity\AbstractCategoryAssignment;

/**
 * Entity extension domain class storing playlist categories.
 *
 * This is the base category class for playlist entities.
 */
abstract class AbstractPlaylistCategoryEntity extends AbstractCategoryAssignment
{
    /**
     * @ORM\ManyToOne(targetEntity="\MU\VideoModule\Entity\PlaylistEntity", inversedBy="categories")
     * @ORM\JoinColumn(name="entityId", referencedColumnName="id")
     * @var \MU\VideoModule\Entity\PlaylistEntity
     */
    protected $entity;
    
    /**
     * Get reference to owning entity.
     *
     * @return \MU\VideoModule\Entity\PlaylistEntity
     */
    public function getEntity()
    {
        return $this->entity;
    }
    
    /**
     * Set reference to owning entity.
     *
     * @param \MU\VideoModule\Entity\PlaylistEntity $entity
     */
    public function setEntity(/*\MU\VideoModule\Entity\PlaylistEntity */$entity)
    {
        $this->entity = $entity;
    }
}
