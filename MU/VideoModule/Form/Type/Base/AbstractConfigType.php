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

namespace MU\VideoModule\Form\Type\Base;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Zikula\Common\Translator\TranslatorInterface;
use Zikula\Common\Translator\TranslatorTrait;

/**
 * Configuration form type base class.
 */
abstract class AbstractConfigType extends AbstractType
{
    use TranslatorTrait;

    /**
     * @var array
     */
    protected $moduleVars;

    /**
     * ConfigType constructor.
     *
     * @param TranslatorInterface $translator  Translator service instance
     * @param object              $moduleVars  Existing module vars
     */
    public function __construct(
        TranslatorInterface $translator,
        $moduleVars
    ) {
        $this->setTranslator($translator);
        $this->moduleVars = $moduleVars;
    }

    /**
     * Sets the translator.
     *
     * @param TranslatorInterface $translator Translator service instance
     */
    public function setTranslator(/*TranslatorInterface */$translator)
    {
        $this->translator = $translator;
    }

    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->addVariablesFields($builder, $options);
        $this->addListViewsFields($builder, $options);
        $this->addImagesFields($builder, $options);
        $this->addIntegrationFields($builder, $options);

        $builder
            ->add('save', SubmitType::class, [
                'label' => $this->__('Update configuration'),
                'icon' => 'fa-check',
                'attr' => [
                    'class' => 'btn btn-success'
                ]
            ])
            ->add('cancel', SubmitType::class, [
                'label' => $this->__('Cancel'),
                'icon' => 'fa-times',
                'attr' => [
                    'class' => 'btn btn-default',
                    'formnovalidate' => 'formnovalidate'
                ]
            ])
        ;
    }

    /**
     * Adds fields for variables fields.
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options The options
     */
    public function addVariablesFields(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pageSize', IntegerType::class, [
                'label' => $this->__('Page size') . ':',
                'required' => false,
                'data' => isset($this->moduleVars['pageSize']) ? intval($this->moduleVars['pageSize']) : intval(10),
                'empty_data' => intval('10'),
                'attr' => [
                    'maxlength' => 255,
                    'title' => $this->__('Enter the page size.') . ' ' . $this->__('Only digits are allowed.')
                ],'scale' => 0
            ])
            ->add('maxSizeOfMovie', IntegerType::class, [
                'label' => $this->__('Max size of movie') . ':',
                'required' => false,
                'data' => isset($this->moduleVars['maxSizeOfMovie']) ? intval($this->moduleVars['maxSizeOfMovie']) : intval(1024000000),
                'empty_data' => intval('1024000000'),
                'attr' => [
                    'maxlength' => 255,
                    'title' => $this->__('Enter the max size of movie.') . ' ' . $this->__('Only digits are allowed.')
                ],'scale' => 0
            ])
            ->add('maxSizeOfPoster', IntegerType::class, [
                'label' => $this->__('Max size of poster') . ':',
                'required' => false,
                'data' => isset($this->moduleVars['maxSizeOfPoster']) ? intval($this->moduleVars['maxSizeOfPoster']) : intval(102400),
                'empty_data' => intval('102400'),
                'attr' => [
                    'maxlength' => 255,
                    'title' => $this->__('Enter the max size of poster.') . ' ' . $this->__('Only digits are allowed.')
                ],'scale' => 0
            ])
            ->add('standardPoster', TextType::class, [
                'label' => $this->__('Standard poster') . ':',
                'required' => false,
                'data' => isset($this->moduleVars['standardPoster']) ? $this->moduleVars['standardPoster'] : '',
                'empty_data' => '/images/poster.png',
                'attr' => [
                    'maxlength' => 255,
                    'title' => $this->__('Enter the standard poster.')
                ],
            ])
            ->add('youtubeApi', TextType::class, [
                'label' => $this->__('Youtube api') . ':',
                'required' => false,
                'data' => isset($this->moduleVars['youtubeApi']) ? $this->moduleVars['youtubeApi'] : '',
                'empty_data' => '',
                'attr' => [
                    'maxlength' => 255,
                    'title' => $this->__('Enter the youtube api.')
                ],
            ])
            ->add('channelIds', TextType::class, [
                'label' => $this->__('Channel ids') . ':',
                'required' => false,
                'data' => isset($this->moduleVars['channelIds']) ? $this->moduleVars['channelIds'] : '',
                'empty_data' => '',
                'attr' => [
                    'maxlength' => 255,
                    'title' => $this->__('Enter the channel ids.')
                ],
            ])
            ->add('overrideVars', CheckboxType::class, [
                'label' => $this->__('Override vars') . ':',
                'label_attr' => [
                    'class' => 'tooltips',
                    'title' => $this->__('If this option is enabled, title and description of existing youtube videos will be overridden using the import function.')
                ],
                'help' => $this->__('If this option is enabled, title and description of existing youtube videos will be overridden using the import function.'),
                'required' => false,
                'data' => (bool)(isset($this->moduleVars['overrideVars']) ? $this->moduleVars['overrideVars'] : false),
                'attr' => [
                    'title' => $this->__('The override vars option.')
                ],
            ])
        ;
    }

    /**
     * Adds fields for list views fields.
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options The options
     */
    public function addListViewsFields(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('collectionEntriesPerPage', IntegerType::class, [
                'label' => $this->__('Collection entries per page') . ':',
                'label_attr' => [
                    'class' => 'tooltips',
                    'title' => $this->__('The amount of collections shown per page')
                ],
                'help' => $this->__('The amount of collections shown per page'),
                'required' => false,
                'data' => isset($this->moduleVars['collectionEntriesPerPage']) ? intval($this->moduleVars['collectionEntriesPerPage']) : intval(10),
                'empty_data' => intval('10'),
                'attr' => [
                    'maxlength' => 255,
                    'title' => $this->__('Enter the collection entries per page.') . ' ' . $this->__('Only digits are allowed.')
                ],'scale' => 0
            ])
            ->add('linkOwnCollectionsOnAccountPage', CheckboxType::class, [
                'label' => $this->__('Link own collections on account page') . ':',
                'label_attr' => [
                    'class' => 'tooltips',
                    'title' => $this->__('Whether to add a link to collections of the current user on his account page')
                ],
                'help' => $this->__('Whether to add a link to collections of the current user on his account page'),
                'required' => false,
                'data' => (bool)(isset($this->moduleVars['linkOwnCollectionsOnAccountPage']) ? $this->moduleVars['linkOwnCollectionsOnAccountPage'] : true),
                'attr' => [
                    'title' => $this->__('The link own collections on account page option.')
                ],
            ])
            ->add('movieEntriesPerPage', IntegerType::class, [
                'label' => $this->__('Movie entries per page') . ':',
                'label_attr' => [
                    'class' => 'tooltips',
                    'title' => $this->__('The amount of movies shown per page')
                ],
                'help' => $this->__('The amount of movies shown per page'),
                'required' => false,
                'data' => isset($this->moduleVars['movieEntriesPerPage']) ? intval($this->moduleVars['movieEntriesPerPage']) : intval(10),
                'empty_data' => intval('10'),
                'attr' => [
                    'maxlength' => 255,
                    'title' => $this->__('Enter the movie entries per page.') . ' ' . $this->__('Only digits are allowed.')
                ],'scale' => 0
            ])
            ->add('linkOwnMoviesOnAccountPage', CheckboxType::class, [
                'label' => $this->__('Link own movies on account page') . ':',
                'label_attr' => [
                    'class' => 'tooltips',
                    'title' => $this->__('Whether to add a link to movies of the current user on his account page')
                ],
                'help' => $this->__('Whether to add a link to movies of the current user on his account page'),
                'required' => false,
                'data' => (bool)(isset($this->moduleVars['linkOwnMoviesOnAccountPage']) ? $this->moduleVars['linkOwnMoviesOnAccountPage'] : true),
                'attr' => [
                    'title' => $this->__('The link own movies on account page option.')
                ],
            ])
            ->add('playlistEntriesPerPage', IntegerType::class, [
                'label' => $this->__('Playlist entries per page') . ':',
                'label_attr' => [
                    'class' => 'tooltips',
                    'title' => $this->__('The amount of playlists shown per page')
                ],
                'help' => $this->__('The amount of playlists shown per page'),
                'required' => false,
                'data' => isset($this->moduleVars['playlistEntriesPerPage']) ? intval($this->moduleVars['playlistEntriesPerPage']) : intval(10),
                'empty_data' => intval('10'),
                'attr' => [
                    'maxlength' => 255,
                    'title' => $this->__('Enter the playlist entries per page.') . ' ' . $this->__('Only digits are allowed.')
                ],'scale' => 0
            ])
            ->add('linkOwnPlaylistsOnAccountPage', CheckboxType::class, [
                'label' => $this->__('Link own playlists on account page') . ':',
                'label_attr' => [
                    'class' => 'tooltips',
                    'title' => $this->__('Whether to add a link to playlists of the current user on his account page')
                ],
                'help' => $this->__('Whether to add a link to playlists of the current user on his account page'),
                'required' => false,
                'data' => (bool)(isset($this->moduleVars['linkOwnPlaylistsOnAccountPage']) ? $this->moduleVars['linkOwnPlaylistsOnAccountPage'] : true),
                'attr' => [
                    'title' => $this->__('The link own playlists on account page option.')
                ],
            ])
        ;
    }

    /**
     * Adds fields for images fields.
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options The options
     */
    public function addImagesFields(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('enableShrinkingForMoviePoster', CheckboxType::class, [
                'label' => $this->__('Enable shrinking') . ':',
                'label_attr' => [
                    'class' => 'tooltips',
                    'title' => $this->__('Whether to enable shrinking huge images to maximum dimensions. Stores downscaled version of the original image.')
                ],
                'help' => $this->__('Whether to enable shrinking huge images to maximum dimensions. Stores downscaled version of the original image.'),
                'required' => false,
                'data' => (bool)(isset($this->moduleVars['enableShrinkingForMoviePoster']) ? $this->moduleVars['enableShrinkingForMoviePoster'] : false),
                'attr' => [
                    'title' => $this->__('The enable shrinking option.'),
                    'class' => 'shrink-enabler'
                ],
            ])
            ->add('shrinkWidthMoviePoster', IntegerType::class, [
                'label' => $this->__('Shrink width') . ':',
                'label_attr' => [
                    'class' => 'tooltips',
                    'title' => $this->__('The maximum image width in pixels.')
                ],
                'help' => $this->__('The maximum image width in pixels.'),
                'required' => false,
                'data' => isset($this->moduleVars['shrinkWidthMoviePoster']) ? intval($this->moduleVars['shrinkWidthMoviePoster']) : intval(800),
                'empty_data' => intval('800'),
                'attr' => [
                    'maxlength' => 4,
                    'title' => $this->__('Enter the shrink width.') . ' ' . $this->__('Only digits are allowed.'),
                    'class' => 'shrinkdimension-shrinkwidthmovieposter'
                ],'scale' => 0,
                'input_group' => ['right' => $this->__('pixels')]
            ])
            ->add('shrinkHeightMoviePoster', IntegerType::class, [
                'label' => $this->__('Shrink height') . ':',
                'label_attr' => [
                    'class' => 'tooltips',
                    'title' => $this->__('The maximum image height in pixels.')
                ],
                'help' => $this->__('The maximum image height in pixels.'),
                'required' => false,
                'data' => isset($this->moduleVars['shrinkHeightMoviePoster']) ? intval($this->moduleVars['shrinkHeightMoviePoster']) : intval(600),
                'empty_data' => intval('600'),
                'attr' => [
                    'maxlength' => 4,
                    'title' => $this->__('Enter the shrink height.') . ' ' . $this->__('Only digits are allowed.'),
                    'class' => 'shrinkdimension-shrinkheightmovieposter'
                ],'scale' => 0,
                'input_group' => ['right' => $this->__('pixels')]
            ])
            ->add('thumbnailModeMoviePoster', ChoiceType::class, [
                'label' => $this->__('Thumbnail mode') . ':',
                'label_attr' => [
                    'class' => 'tooltips',
                    'title' => $this->__('Thumbnail mode (inset or outbound).')
                ],
                'help' => $this->__('Thumbnail mode (inset or outbound).'),
                'data' => isset($this->moduleVars['thumbnailModeMoviePoster']) ? $this->moduleVars['thumbnailModeMoviePoster'] : '',
                'empty_data' => 'inset',
                'attr' => [
                    'title' => $this->__('Choose the thumbnail mode.')
                ],'choices' => [
                    $this->__('Inset') => 'inset',
                    $this->__('Outbound') => 'outbound'
                ],
                'choices_as_values' => true,
                'multiple' => false
            ])
            ->add('thumbnailWidthMoviePosterView', IntegerType::class, [
                'label' => $this->__('Thumbnail width view') . ':',
                'label_attr' => [
                    'class' => 'tooltips',
                    'title' => $this->__('Thumbnail width on view pages in pixels.')
                ],
                'help' => $this->__('Thumbnail width on view pages in pixels.'),
                'required' => false,
                'data' => isset($this->moduleVars['thumbnailWidthMoviePosterView']) ? intval($this->moduleVars['thumbnailWidthMoviePosterView']) : intval(32),
                'empty_data' => intval('32'),
                'attr' => [
                    'maxlength' => 4,
                    'title' => $this->__('Enter the thumbnail width view.') . ' ' . $this->__('Only digits are allowed.')
                ],'scale' => 0,
                'input_group' => ['right' => $this->__('pixels')]
            ])
            ->add('thumbnailHeightMoviePosterView', IntegerType::class, [
                'label' => $this->__('Thumbnail height view') . ':',
                'label_attr' => [
                    'class' => 'tooltips',
                    'title' => $this->__('Thumbnail height on view pages in pixels.')
                ],
                'help' => $this->__('Thumbnail height on view pages in pixels.'),
                'required' => false,
                'data' => isset($this->moduleVars['thumbnailHeightMoviePosterView']) ? intval($this->moduleVars['thumbnailHeightMoviePosterView']) : intval(24),
                'empty_data' => intval('24'),
                'attr' => [
                    'maxlength' => 4,
                    'title' => $this->__('Enter the thumbnail height view.') . ' ' . $this->__('Only digits are allowed.')
                ],'scale' => 0,
                'input_group' => ['right' => $this->__('pixels')]
            ])
            ->add('thumbnailWidthMoviePosterDisplay', IntegerType::class, [
                'label' => $this->__('Thumbnail width display') . ':',
                'label_attr' => [
                    'class' => 'tooltips',
                    'title' => $this->__('Thumbnail width on display pages in pixels.')
                ],
                'help' => $this->__('Thumbnail width on display pages in pixels.'),
                'required' => false,
                'data' => isset($this->moduleVars['thumbnailWidthMoviePosterDisplay']) ? intval($this->moduleVars['thumbnailWidthMoviePosterDisplay']) : intval(240),
                'empty_data' => intval('240'),
                'attr' => [
                    'maxlength' => 4,
                    'title' => $this->__('Enter the thumbnail width display.') . ' ' . $this->__('Only digits are allowed.')
                ],'scale' => 0,
                'input_group' => ['right' => $this->__('pixels')]
            ])
            ->add('thumbnailHeightMoviePosterDisplay', IntegerType::class, [
                'label' => $this->__('Thumbnail height display') . ':',
                'label_attr' => [
                    'class' => 'tooltips',
                    'title' => $this->__('Thumbnail height on display pages in pixels.')
                ],
                'help' => $this->__('Thumbnail height on display pages in pixels.'),
                'required' => false,
                'data' => isset($this->moduleVars['thumbnailHeightMoviePosterDisplay']) ? intval($this->moduleVars['thumbnailHeightMoviePosterDisplay']) : intval(180),
                'empty_data' => intval('180'),
                'attr' => [
                    'maxlength' => 4,
                    'title' => $this->__('Enter the thumbnail height display.') . ' ' . $this->__('Only digits are allowed.')
                ],'scale' => 0,
                'input_group' => ['right' => $this->__('pixels')]
            ])
            ->add('thumbnailWidthMoviePosterEdit', IntegerType::class, [
                'label' => $this->__('Thumbnail width edit') . ':',
                'label_attr' => [
                    'class' => 'tooltips',
                    'title' => $this->__('Thumbnail width on edit pages in pixels.')
                ],
                'help' => $this->__('Thumbnail width on edit pages in pixels.'),
                'required' => false,
                'data' => isset($this->moduleVars['thumbnailWidthMoviePosterEdit']) ? intval($this->moduleVars['thumbnailWidthMoviePosterEdit']) : intval(240),
                'empty_data' => intval('240'),
                'attr' => [
                    'maxlength' => 4,
                    'title' => $this->__('Enter the thumbnail width edit.') . ' ' . $this->__('Only digits are allowed.')
                ],'scale' => 0,
                'input_group' => ['right' => $this->__('pixels')]
            ])
            ->add('thumbnailHeightMoviePosterEdit', IntegerType::class, [
                'label' => $this->__('Thumbnail height edit') . ':',
                'label_attr' => [
                    'class' => 'tooltips',
                    'title' => $this->__('Thumbnail height on edit pages in pixels.')
                ],
                'help' => $this->__('Thumbnail height on edit pages in pixels.'),
                'required' => false,
                'data' => isset($this->moduleVars['thumbnailHeightMoviePosterEdit']) ? intval($this->moduleVars['thumbnailHeightMoviePosterEdit']) : intval(180),
                'empty_data' => intval('180'),
                'attr' => [
                    'maxlength' => 4,
                    'title' => $this->__('Enter the thumbnail height edit.') . ' ' . $this->__('Only digits are allowed.')
                ],'scale' => 0,
                'input_group' => ['right' => $this->__('pixels')]
            ])
        ;
    }

    /**
     * Adds fields for integration fields.
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options The options
     */
    public function addIntegrationFields(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('enabledFinderTypes', ChoiceType::class, [
                'label' => $this->__('Enabled finder types') . ':',
                'label_attr' => [
                    'class' => 'tooltips',
                    'title' => $this->__('Which sections are supported in the Finder component (used by Scribite plug-ins).')
                ],
                'help' => $this->__('Which sections are supported in the Finder component (used by Scribite plug-ins).'),
                'data' => isset($this->moduleVars['enabledFinderTypes']) ? $this->moduleVars['enabledFinderTypes'] : '',
                'empty_data' => '',
                'attr' => [
                    'title' => $this->__('Choose the enabled finder types.')
                ],'choices' => [
                    $this->__('Collection') => 'collection',
                    $this->__('Movie') => 'movie',
                    $this->__('Playlist') => 'playlist'
                ],
                'choices_as_values' => true,
                'multiple' => true
            ])
        ;
    }

    /**
     * @inheritDoc
     */
    public function getBlockPrefix()
    {
        return 'muvideomodule_config';
    }
}
