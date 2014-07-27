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
 * @version Generated by ModuleStudio 0.6.2 (http://modulestudio.de) at Tue May 06 22:49:35 CEST 2014.
 */

/**
 * Version information base class.
 */
class MUVideo_Base_Version extends Zikula_AbstractVersion
{
    /**
     * Retrieves meta data information for this application.
     *
     * @return array List of meta data.
     */
    public function getMetaData()
    {
        $meta = array();
        // the current module version
        $meta['version']              = '1.0.0';
        // the displayed name of the module
        $meta['displayname']          = $this->__('M u video');
        // the module description
        $meta['description']          = $this->__('M u video module generated by ModuleStudio 0.6.2.');
        //! url version of name, should be in lowercase without space
        $meta['url']                  = $this->__('muvideo');
        // core requirement
        $meta['core_min']             = '1.3.5'; // requires minimum 1.3.5
        $meta['core_max']             = '1.3.99'; // not ready for 1.4.0 yet

        // define special capabilities of this module
        $meta['capabilities'] = array(
                          HookUtil::SUBSCRIBER_CAPABLE => array('enabled' => true)/*,
                          HookUtil::PROVIDER_CAPABLE => array('enabled' => true), // TODO: see #15
                          'authentication' => array('version' => '1.0'),
                          'profile'        => array('version' => '1.0', 'anotherkey' => 'anothervalue'),
                          'message'        => array('version' => '1.0', 'anotherkey' => 'anothervalue')
*/
        );

        // permission schema
        $meta['securityschema'] = array(
            'MUVideo::' => '::',
            'MUVideo::Ajax' => '::',
            'MUVideo:ItemListBlock:' => 'Block title::',
            'MUVideo:Collection:' => 'Collection ID::',
            'MUVideo:Movie:' => 'Movie ID::',
            'MUVideo:Collection:Movie' => 'Collection ID:Movie ID:',
        );
        // DEBUG: permission schema aspect ends


        return $meta;
    }

    /**
     * Define hook subscriber bundles.
     */
    protected function setupHookBundles()
    {
        
        $bundle = new Zikula_HookManager_SubscriberBundle($this->name, 'subscriber.muvideo.ui_hooks.collections', 'ui_hooks', __('muvideo Collections Display Hooks'));
        
        // Display hook for view/display templates.
        $bundle->addEvent('display_view', 'muvideo.ui_hooks.collections.display_view');
        // Display hook for create/edit forms.
        $bundle->addEvent('form_edit', 'muvideo.ui_hooks.collections.form_edit');
        // Display hook for delete dialogues.
        $bundle->addEvent('form_delete', 'muvideo.ui_hooks.collections.form_delete');
        // Validate input from an ui create/edit form.
        $bundle->addEvent('validate_edit', 'muvideo.ui_hooks.collections.validate_edit');
        // Validate input from an ui create/edit form (generally not used).
        $bundle->addEvent('validate_delete', 'muvideo.ui_hooks.collections.validate_delete');
        // Perform the final update actions for a ui create/edit form.
        $bundle->addEvent('process_edit', 'muvideo.ui_hooks.collections.process_edit');
        // Perform the final delete actions for a ui form.
        $bundle->addEvent('process_delete', 'muvideo.ui_hooks.collections.process_delete');
        $this->registerHookSubscriberBundle($bundle);

        $bundle = new Zikula_HookManager_SubscriberBundle($this->name, 'subscriber.muvideo.filter_hooks.collections', 'filter_hooks', __('muvideo Collections Filter Hooks'));
        // A filter applied to the given area.
        $bundle->addEvent('filter', 'muvideo.filter_hooks.collections.filter');
        $this->registerHookSubscriberBundle($bundle);
        
        $bundle = new Zikula_HookManager_SubscriberBundle($this->name, 'subscriber.muvideo.ui_hooks.movies', 'ui_hooks', __('muvideo Movies Display Hooks'));
        
        // Display hook for view/display templates.
        $bundle->addEvent('display_view', 'muvideo.ui_hooks.movies.display_view');
        // Display hook for create/edit forms.
        $bundle->addEvent('form_edit', 'muvideo.ui_hooks.movies.form_edit');
        // Display hook for delete dialogues.
        $bundle->addEvent('form_delete', 'muvideo.ui_hooks.movies.form_delete');
        // Validate input from an ui create/edit form.
        $bundle->addEvent('validate_edit', 'muvideo.ui_hooks.movies.validate_edit');
        // Validate input from an ui create/edit form (generally not used).
        $bundle->addEvent('validate_delete', 'muvideo.ui_hooks.movies.validate_delete');
        // Perform the final update actions for a ui create/edit form.
        $bundle->addEvent('process_edit', 'muvideo.ui_hooks.movies.process_edit');
        // Perform the final delete actions for a ui form.
        $bundle->addEvent('process_delete', 'muvideo.ui_hooks.movies.process_delete');
        $this->registerHookSubscriberBundle($bundle);

        $bundle = new Zikula_HookManager_SubscriberBundle($this->name, 'subscriber.muvideo.filter_hooks.movies', 'filter_hooks', __('muvideo Movies Filter Hooks'));
        // A filter applied to the given area.
        $bundle->addEvent('filter', 'muvideo.filter_hooks.movies.filter');
        $this->registerHookSubscriberBundle($bundle);

        
    }
}
