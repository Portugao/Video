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

namespace MU\VideoModule\Validator\Constraints\Base;

use Symfony\Component\Validator\Constraint;

/**
 * List entry validation constraint.
 */
abstract class AbstractListEntry extends Constraint
{
    /**
     * Entity name
     * @var string
     */
    public $entityName = '';

    /**
     * Property name
     * @var string
     */
    public $propertyName = '';

    /**
     * Whether multiple list values are allowed or not
     * @var boolean
     */
    public $multiple = false;

    /**
     * Minimum amount of values for multiple lists
     * @var integer
     */
    public $min;

    /**
     * Maximum amount of values for multiple lists
     * @var integer
     */
    public $max;

    /**
     * @inheritDoc
     */
    public function validatedBy()
    {
        return 'mu_video_module.validator.list_entry.validator';
    }
}
