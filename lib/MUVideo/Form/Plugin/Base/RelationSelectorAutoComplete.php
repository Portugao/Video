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
 * @version Generated by ModuleStudio 0.7.0 (http://modulestudio.de).
 */

    /**
     * Relation selector plugin base class.
     */
    class MUVideo_Form_Plugin_Base_RelationSelectorAutoComplete extends MUVideo_Form_Plugin_AbstractObjectSelector
    {
        /**
         * Identifier prefix (unique name for JS).
         *
         * @var string
         */
        public $idPrefix = '';

        /**
         * Url for inline creation of new related items (if allowed).
         *
         * @var string
         */
        public $createLink = '';

        /**
         * Whether the treated entity has an image field or not.
         *
         * @var boolean
         */
        public $withImage = false;

        /**
         * Get filename of this file.
         * The information is used to re-establish the plugins on postback.
         *
         * @return string
         */
        public function getFilename()
        {
            return __FILE__;
        }

        /**
         * Load event handler.
         *
         * @param Zikula_Form_View $view    Reference to Zikula_Form_View object.
         * @param array            &$params Parameters passed from the Smarty plugin function.
         *
         * @return void
         */
        public function load(Zikula_Form_View $view, &$params)
        {
            $this->processRequestData($view, 'GET');

            $params['fetchItemsDuringLoad'] = false;
            // load list items
            parent::load($view, $params);

            if (isset($params['idPrefix'])) {
                $this->idPrefix = $params['idPrefix'];
                unset($params['idPrefix']);
                $this->inputName = $this->idPrefix . 'ItemList';
            }

            if (isset($params['createLink'])) {
                $this->createLink = $params['createLink'];
                unset($params['createLink']);
            }

            if (isset($params['withImage'])) {
                $this->withImage = $params['withImage'];
                unset($params['withImage']);
            }

            // preprocess selection: collect id list for related items
            $this->preprocessIdentifiers($view, $params);
        }

        /**
         * Entry point for customised css class.
         */
        protected function getStyleClass()
        {
            return 'z-form-relationlist autocomplete';
        }

        /**
         * Render event handler.
         *
         * @param Zikula_Form_View $view Reference to Zikula_Form_View object.
         *
         * @return string The rendered output
         */
        public function render(Zikula_Form_View $view)
        {
            $dom = ZLanguage::getModuleDomain('MUVideo');
            $many = ($this->selectionMode == 'multiple');

            $entityNameTranslated = '';
            switch ($this->objectType) {
                case 'collection':
                    $entityNameTranslated = __('collection', $dom);
                    break;
                case 'movie':
                    $entityNameTranslated = __('movie', $dom);
                    break;
            }

            $addLinkText = $many ? __f('Add %s', array($entityNameTranslated), $dom) : __f('Select %s', array($entityNameTranslated), $dom);
            $selectLabelText = __f('Find %s', array($entityNameTranslated), $dom);
            $searchIconText = __f('Search %s', array($entityNameTranslated), $dom);

            $idPrefix = $this->idPrefix;

            $addLink = '<a id="' . $idPrefix . 'AddLink" href="javascript:void(0);" class="z-hide">' . $addLinkText . '</a>';
            $createLink = '';
            if ($this->createLink != '') {
                $createLink = '<a id="' . $idPrefix . 'SelectorDoNew" href="' . DataUtil::formatForDisplay($this->createLink) . '" title="' . __f('Create new %s', array($entityNameTranslated), $dom) . '" class="z-button muvideo-inline-button">' . __('Create', $dom) . '</a>';
            }

            $alias = $this->id;
            $class = $this->getStyleClass();

            $result = '
                <div class="muvideo-relation-rightside">'
                    . $addLink . '
                    <div id="' . $idPrefix . 'AddFields muvideo-autocomplete' . (($this->withImage) ? '-with-image' : '') . '">
                        <label for="' . $idPrefix . 'Selector">' . $selectLabelText . '</label>
                        <br />';

            $result .= '<img src="' . System::getBaseUrl() . 'images/icons/extrasmall/search.png" width="16" height="16" alt="' . $searchIconText . '" />
                        <input type="text" name="' . $idPrefix . 'Selector" id="' . $idPrefix . 'Selector" value="" />
                        <input type="hidden" name="' . $idPrefix . 'Scope" id="' . $idPrefix . 'Scope" value="' . ((!$many) ? '0' : '1') . '" />
                        <img src="' . System::getBaseUrl() . 'images/ajax/indicator_circle.gif" width="16" height="16" alt="" id="' . $idPrefix . 'Indicator" style="display: none" />
                        <span id="' . $idPrefix . 'NoResultsHint" class="z-hide">' . __('No results found!', $dom) . '</span>
                        <div id="' . $idPrefix . 'SelectorChoices" class=""></div>';
            $result .= '
                            <input type="button" id="' . $idPrefix . 'SelectorDoCancel" name="' . $idPrefix . 'SelectorDoCancel" value="' . __('Cancel', $dom) . '" class="z-button muvideo-inline-button" />'
                            . $createLink . '
                            <noscript><p>' . __('This function requires JavaScript activated!', $dom) . '</p></noscript>
                        </div>
                    </div>' . "\n";

            return $result;
        }

        /**
         * Decode event handler.
         *
         * @param Zikula_Form_View $view Reference to Zikula_Form_View object.
         *
         * @return void
         */
        public function decode(Zikula_Form_View $view)
        {
            parent::decode($view);

            // postprocess selection: reinstantiate objects for identifiers
            $this->processRequestData($view, 'POST');
        }
    }
