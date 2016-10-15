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

use Doctrine\ORM\Mapping as ORM;

/**
 * Entity extension domain class storing playlist categories.
 *
 * This is the base category class for playlist entities.
 */
abstract class MUVideo_Entity_Base_AbstractPlaylistCategory extends Zikula_Doctrine2_Entity_EntityCategory
{
    /**
     * @ORM\ManyToOne(targetEntity="MUVideo_Entity_Playlist", inversedBy="categories")
     * @ORM\JoinColumn(name="entityId", referencedColumnName="id")
     * @var MUVideo_Entity_Playlist
     */
    protected $entity;
    
    /**
     * Get reference to owning entity.
     *
     * @return MUVideo_Entity_Playlist
     */
    public function getEntity()
    {
        return $this->entity;
    }
    
    /**
     * Set reference to owning entity.
     *
     * @param MUVideo_Entity_Playlist $entity
     */
    public function setEntity(/*MUVideo_Entity_Playlist */$entity)
    {
        $this->entity = $entity;
    }
}
