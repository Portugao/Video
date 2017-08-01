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

namespace MU\VideoModule\Form\Type\Finder;

use MU\VideoModule\Form\Type\Finder\Base\AbstractMovieFinderType;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Movie finder form type implementation class.
 */
class MovieFinderType extends AbstractMovieFinderType
{
    /**
     * Adds a "paste as" field.
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options The options
     */
    public function addPasteAsField(FormBuilderInterface $builder, array $options)
    {
        $builder->add('pasteAs', ChoiceType::class, [
            'label' => $this->__('Paste as') . ':',
            'empty_data' => 1,
            'choices' => [
                $this->__('Relative link to the movie') => 1,
                $this->__('Absolute url to the movie') => 2,
                $this->__('Movie') => 3,
            	$this->__('Movie with description') => 10            		
            ],
            'choices_as_values' => true,
            'multiple' => false,
            'expanded' => false
        ]);
    }
}
