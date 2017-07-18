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

namespace MU\VideoModule\Form\Type\Base;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Zikula\Common\Translator\TranslatorInterface;
use Zikula\Common\Translator\TranslatorTrait;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\HttpFoundation\RequestStack;
use Zikula\ExtensionsModule\Api\ApiInterface\VariableApiInterface;

/**
 * GetVideos form type base class.
 */
abstract class AbstractGetVideosType extends AbstractType
{
    use TranslatorTrait;

    /**
     * @var array
     */
    protected $moduleVars;
    
    /**
     * @var RequestStack
     */
    protected $request;
    
    /**
     * @var VariableApiInterface
     */
    protected $variableApi;

    /**
     * GetVideosType constructor.
     *
     * @param TranslatorInterface $translator  Translator service instance
     * @param object              $moduleVars  Existing module vars
     * @param RequestStack        $request
     * @param VariableApiInterface $variableApi VariableApi service instance
     */
    public function __construct( TranslatorInterface $translator,
        $moduleVars, 
        RequestStack $request,
    	VariableApiInterface $variableApi) {
        $this->setTranslator($translator);
        $this->moduleVars = $moduleVars;
        $this->request = $request;
        $this->variableApi = $variableApi;
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
     * Sets the translator.
     *
     * @param TranslatorInterface $translator Translator service instance
     */
    public function setRequest(/*RequestStack */$request)
    {
    	$this->request = $request;
    }

    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->addInputFields($builder, $options);

        $builder
            ->add('getDatas', SubmitType::class, [
                'label' => $this->__('Get datas'),
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
    public function addInputFields(FormBuilderInterface $builder, array $options)
    {
    	$formVars = $this->getListEntries();
    	$builder
    	->add('channelId', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', [
    			'label' => $this->__('Channel') . ':',
    			'label_attr' => [
    					'class' => 'tooltips',
    					'title' => $this->__('Choose the channel for import.')
    			],
    			'help' => $this->__('Channel for import.'),
    			'required' => false,
    			//'data' => isset($this->modVars['thumbnailModeMovieUploadOfMovie']) ? $this->modVars['thumbnailModeMovieUploadOfMovie'] : '',
    			'empty_data' => 'inset',
    			'attr' => [
    					'title' => $this->__('Choose the thumbnail mode.')
    			],'choices' =>
    			/*$this->__('Inset') => 'inset'
    			 ,$this->__('Outbound') => 'outbound'*/
    			$formVars ,
    			'choices_as_values' => false,
    			'multiple' => false
    	])
    	->add('collectionId', 'hidden', [
    			'data' => $options['collectionId']
    	])
    	 
    	;
    }

    /**
     * @inheritDoc
     */
    public function getBlockPrefix()
    {
        return 'muvideomodule_youtube';
    }
    
    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
    	$resolver
    	->setDefaults([
    
    			'collectionId' => $this->getCollectionId(),
    
    	]);
    }
    
    /**
     *
     */
    public function getListEntries()
    {
    	$moduleVars = $this->variableApi->getAll('MUVideoModule');
    	$videos = $moduleVars['channelIds'];
    	$videos = explode(';', $videos);
    	$out = array();
    	if (count($videos) == 1) {
    		$thisVideo = explode(',', $videos[0]);
    		// initialise list entries for the 'channelId' setting
    		$out = array($thisVideo[0] => $thisVideo[1]);
    	} else {
    		foreach ($videos as $video) {
    			$thisVideo = explode(',', $video);
    			$out[] = array($thisVideo[0] => $thisVideo[1]);
    		}
    	}
    
    	return $out;
    }
    
    /**
     *
     */
    public function getCollectionId()
    {
    	$currentRequest = $this->request->getCurrentRequest();
    	$collectionId = $currentRequest->get('collectionId');
    	return $collectionId;
    }
}
