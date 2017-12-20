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
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use Symfony\Component\Validator\Constraints as Assert;
use Zikula\Core\Doctrine\EntityAccess;
use MU\VideoModule\Traits\StandardFieldsTrait;
use MU\VideoModule\Validator\Constraints as VideoAssert;

/**
 * Entity class that defines the entity structure and behaviours.
 *
 * This is the base entity class for collection entities.
 * The following annotation marks it as a mapped superclass so subclasses
 * inherit orm properties.
 *
 * @ORM\MappedSuperclass
 */
abstract class AbstractCollectionEntity extends EntityAccess implements Translatable
{
    /**
     * Hook standard fields behaviour embedding createdBy, updatedBy, createdDate, updatedDate fields.
     */
    use StandardFieldsTrait;

    /**
     * @var string The tablename this object maps to
     */
    protected $_objectType = 'collection';
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", unique=true)
     * @var integer $id
     */
    protected $id = 0;
    
    /**
     * the current workflow state
     *
     * @ORM\Column(length=20)
     * @Assert\NotBlank()
     * @VideoAssert\ListEntry(entityName="collection", propertyName="workflowState", multiple=false)
     * @var string $workflowState
     */
    protected $workflowState = 'initial';
    
    /**
     * @Gedmo\Translatable
     * @ORM\Column(length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min="0", max="255")
     * @var string $title
     */
    protected $title = '';
    
    /**
     * @Gedmo\Translatable
     * @ORM\Column(type="text", length=4000)
     * @Assert\NotNull()
     * @Assert\Length(min="0", max="4000")
     * @var text $description
     */
    protected $description = '';
    
    
    /**
     * Used locale to override Translation listener's locale.
     * this is not a mapped field of entity metadata, just a simple property.
     *
     * @Assert\Locale()
     * @Gedmo\Locale
     * @var string $locale
     */
    protected $locale;
    
    /**
     * @ORM\OneToMany(targetEntity="\MU\VideoModule\Entity\CollectionCategoryEntity", 
     *                mappedBy="entity", cascade={"all"}, 
     *                orphanRemoval=true)
     * @var \MU\VideoModule\Entity\CollectionCategoryEntity
     */
    protected $categories = null;
    
    /**
     * Bidirectional - One collection [collection] has many movie [movies] (INVERSE SIDE).
     *
     * @ORM\OneToMany(targetEntity="MU\VideoModule\Entity\MovieEntity", mappedBy="collection")
     * @ORM\JoinTable(name="mu_video_collectionmovie")
     * @ORM\OrderBy({"title" = "ASC"})
     * @var \MU\VideoModule\Entity\MovieEntity[] $movie
     */
    protected $movie = null;
    
    /**
     * Bidirectional - One collection [collection] has many playlists [playlists] (INVERSE SIDE).
     *
     * @ORM\OneToMany(targetEntity="MU\VideoModule\Entity\PlaylistEntity", mappedBy="collection")
     * @ORM\JoinTable(name="mu_video_collectionplaylists")
     * @ORM\OrderBy({"title" = "ASC"})
     * @var \MU\VideoModule\Entity\PlaylistEntity[] $playlists
     */
    protected $playlists = null;
    
    
    /**
     * CollectionEntity constructor.
     *
     * Will not be called by Doctrine and can therefore be used
     * for own implementation purposes. It is also possible to add
     * arbitrary arguments as with every other class method.
     */
    public function __construct()
    {
        $this->movie = new ArrayCollection();
        $this->playlists = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }
    
    /**
     * Returns the _object type.
     *
     * @return string
     */
    public function get_objectType()
    {
        return $this->_objectType;
    }
    
    /**
     * Sets the _object type.
     *
     * @param string $_objectType
     *
     * @return void
     */
    public function set_objectType($_objectType)
    {
        if ($this->_objectType != $_objectType) {
            $this->_objectType = $_objectType;
        }
    }
    
    
    /**
     * Returns the id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Sets the id.
     *
     * @param integer $id
     *
     * @return void
     */
    public function setId($id)
    {
        if (intval($this->id) !== intval($id)) {
            $this->id = intval($id);
        }
    }
    
    /**
     * Returns the workflow state.
     *
     * @return string
     */
    public function getWorkflowState()
    {
        return $this->workflowState;
    }
    
    /**
     * Sets the workflow state.
     *
     * @param string $workflowState
     *
     * @return void
     */
    public function setWorkflowState($workflowState)
    {
        if ($this->workflowState !== $workflowState) {
            $this->workflowState = isset($workflowState) ? $workflowState : '';
        }
    }
    
    /**
     * Returns the title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * Sets the title.
     *
     * @param string $title
     *
     * @return void
     */
    public function setTitle($title)
    {
        if ($this->title !== $title) {
            $this->title = isset($title) ? $title : '';
        }
    }
    
    /**
     * Returns the description.
     *
     * @return text
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    /**
     * Sets the description.
     *
     * @param text $description
     *
     * @return void
     */
    public function setDescription($description)
    {
        if ($this->description !== $description) {
            $this->description = isset($description) ? $description : '';
        }
    }
    
    /**
     * Returns the locale.
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }
    
    /**
     * Sets the locale.
     *
     * @param string $locale
     *
     * @return void
     */
    public function setLocale($locale)
    {
        if ($this->locale != $locale) {
            $this->locale = $locale;
        }
    }
    
    /**
     * Returns the categories.
     *
     * @return ArrayCollection[]
     */
    public function getCategories()
    {
        return $this->categories;
    }
    
    
    /**
     * Sets the categories.
     *
     * @param ArrayCollection $categories List of categories
     *
     * @return void
     */
    public function setCategories(ArrayCollection $categories)
    {
        foreach ($this->categories as $category) {
            if (false === $key = $this->collectionContains($categories, $category)) {
                $this->categories->removeElement($category);
            } else {
                $categories->remove($key);
            }
        }
        foreach ($categories as $category) {
            $this->categories->add($category);
        }
    }
    
    /**
     * Checks if a collection contains an element based only on two criteria (categoryRegistryId, category).
     *
     * @param ArrayCollection $collection Given collection
     * @param \MU\VideoModule\Entity\CollectionCategoryEntity $element Element to search for
     *
     * @return bool|int
     */
    private function collectionContains(ArrayCollection $collection, \MU\VideoModule\Entity\CollectionCategoryEntity $element)
    {
        foreach ($collection as $key => $category) {
            /** @var \MU\VideoModule\Entity\CollectionCategoryEntity $category */
            if ($category->getCategoryRegistryId() == $element->getCategoryRegistryId()
                && $category->getCategory() == $element->getCategory()
            ) {
                return $key;
            }
        }
    
        return false;
    }
    
    /**
     * Returns the movie.
     *
     * @return \MU\VideoModule\Entity\MovieEntity[]
     */
    public function getMovie()
    {
        return $this->movie;
    }
    
    /**
     * Sets the movie.
     *
     * @param \MU\VideoModule\Entity\MovieEntity[] $movie
     *
     * @return void
     */
    public function setMovie($movie)
    {
        foreach ($this->movie as $movieSingle) {
            $this->removeMovie($movieSingle);
        }
        foreach ($movie as $movieSingle) {
            $this->addMovie($movieSingle);
        }
    }
    
    /**
     * Adds an instance of \MU\VideoModule\Entity\MovieEntity to the list of movie.
     *
     * @param \MU\VideoModule\Entity\MovieEntity $movie The instance to be added to the collection
     *
     * @return void
     */
    public function addMovie(\MU\VideoModule\Entity\MovieEntity $movie)
    {
        $this->movie->add($movie);
        $movie->setCollection($this);
    }
    
    /**
     * Removes an instance of \MU\VideoModule\Entity\MovieEntity from the list of movie.
     *
     * @param \MU\VideoModule\Entity\MovieEntity $movie The instance to be removed from the collection
     *
     * @return void
     */
    public function removeMovie(\MU\VideoModule\Entity\MovieEntity $movie)
    {
        $this->movie->removeElement($movie);
        $movie->setCollection(null);
    }
    
    /**
     * Returns the playlists.
     *
     * @return \MU\VideoModule\Entity\PlaylistEntity[]
     */
    public function getPlaylists()
    {
        return $this->playlists;
    }
    
    /**
     * Sets the playlists.
     *
     * @param \MU\VideoModule\Entity\PlaylistEntity[] $playlists
     *
     * @return void
     */
    public function setPlaylists($playlists)
    {
        foreach ($this->playlists as $playlistSingle) {
            $this->removePlaylists($playlistSingle);
        }
        foreach ($playlists as $playlistSingle) {
            $this->addPlaylists($playlistSingle);
        }
    }
    
    /**
     * Adds an instance of \MU\VideoModule\Entity\PlaylistEntity to the list of playlists.
     *
     * @param \MU\VideoModule\Entity\PlaylistEntity $playlist The instance to be added to the collection
     *
     * @return void
     */
    public function addPlaylists(\MU\VideoModule\Entity\PlaylistEntity $playlist)
    {
        $this->playlists->add($playlist);
        $playlist->setCollection($this);
    }
    
    /**
     * Removes an instance of \MU\VideoModule\Entity\PlaylistEntity from the list of playlists.
     *
     * @param \MU\VideoModule\Entity\PlaylistEntity $playlist The instance to be removed from the collection
     *
     * @return void
     */
    public function removePlaylists(\MU\VideoModule\Entity\PlaylistEntity $playlist)
    {
        $this->playlists->removeElement($playlist);
        $playlist->setCollection(null);
    }
    
    
    
    /**
     * Creates url arguments array for easy creation of display urls.
     *
     * @return array List of resulting arguments
     */
    public function createUrlArgs()
    {
        return [
            'id' => $this->getId()
        ];
    }
    
    /**
     * Returns the primary key.
     *
     * @return integer The identifier
     */
    public function getKey()
    {
        return $this->getId();
    }
    
    /**
     * Determines whether this entity supports hook subscribers or not.
     *
     * @return boolean
     */
    public function supportsHookSubscribers()
    {
        return true;
    }
    
    /**
     * Return lower case name of multiple items needed for hook areas.
     *
     * @return string
     */
    public function getHookAreaPrefix()
    {
        return 'muvideomodule.ui_hooks.collections';
    }
    
    /**
     * Returns an array of all related objects that need to be persisted after clone.
     * 
     * @param array $objects Objects that are added to this array
     * 
     * @return array List of entity objects
     */
    public function getRelatedObjectsToPersist(&$objects = [])
    {
        return [];
    }
    
    /**
     * ToString interceptor implementation.
     * This method is useful for debugging purposes.
     *
     * @return string The output string for this entity
     */
    public function __toString()
    {
        return 'Collection ' . $this->getKey() . ': ' . $this->getTitle();
    }
    
    /**
     * Clone interceptor implementation.
     * This method is for example called by the reuse functionality.
     * Performs a quite simple shallow copy.
     *
     * See also:
     * (1) http://docs.doctrine-project.org/en/latest/cookbook/implementing-wakeup-or-clone.html
     * (2) http://www.php.net/manual/en/language.oop5.cloning.php
     * (3) http://stackoverflow.com/questions/185934/how-do-i-create-a-copy-of-an-object-in-php
     */
    public function __clone()
    {
        // if the entity has no identity do nothing, do NOT throw an exception
        if (!$this->id) {
            return;
        }
    
        // otherwise proceed
    
        // unset identifier
        $this->setId(0);
    
        // reset workflow
        $this->setWorkflowState('initial');
    
        $this->setCreatedBy(null);
        $this->setCreatedDate(null);
        $this->setUpdatedBy(null);
        $this->setUpdatedDate(null);
    
    
        // clone categories
        $categories = $this->categories;
        $this->categories = new ArrayCollection();
        foreach ($categories as $c) {
            $newCat = clone $c;
            $this->categories->add($newCat);
            $newCat->setEntity($this);
        }
    }
}
