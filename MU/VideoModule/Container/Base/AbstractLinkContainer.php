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

namespace MU\VideoModule\Container\Base;

use Symfony\Component\Routing\RouterInterface;
use Zikula\Common\Translator\TranslatorInterface;
use Zikula\Common\Translator\TranslatorTrait;
use Zikula\Core\Doctrine\EntityAccess;
use Zikula\Core\LinkContainer\LinkContainerInterface;
use Zikula\ExtensionsModule\Api\ApiInterface\VariableApiInterface;
use Zikula\PermissionsModule\Api\ApiInterface\PermissionApiInterface;
use MU\VideoModule\Helper\ControllerHelper;

/**
 * This is the link container service implementation class.
 */
abstract class AbstractLinkContainer implements LinkContainerInterface
{
    use TranslatorTrait;

    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @var PermissionApiInterface
     */
    protected $permissionApi;

    /**
     * @var VariableApiInterface
     */
    protected $variableApi;

    /**
     * @var ControllerHelper
     */
    protected $controllerHelper;

    /**
     * LinkContainer constructor.
     *
     * @param TranslatorInterface $translator       Translator service instance
     * @param Routerinterface     $router           Router service instance
     * @param PermissionApiInterface       $permissionApi    PermissionApi service instance
     * @param VariableApiInterface         $variableApi      VariableApi service instance
     * @param ControllerHelper    $controllerHelper ControllerHelper service instance
     */
    public function __construct(
        TranslatorInterface $translator,
        RouterInterface $router,
        PermissionApiInterface $permissionApi,
        VariableApiInterface $variableApi,
        ControllerHelper $controllerHelper
    ) {
        $this->setTranslator($translator);
        $this->router = $router;
        $this->permissionApi = $permissionApi;
        $this->variableApi = $variableApi;
        $this->controllerHelper = $controllerHelper;
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
     * Returns available header links.
     *
     * @param string $type The type to collect links for
     *
     * @return array Array of header links
     */
    public function getLinks($type = LinkContainerInterface::TYPE_ADMIN)
    {
        $contextArgs = ['api' => 'linkContainer', 'action' => 'getLinks'];
        $allowedObjectTypes = $this->controllerHelper->getObjectTypes('api', $contextArgs);

        $permLevel = LinkContainerInterface::TYPE_ADMIN == $type ? ACCESS_ADMIN : ACCESS_READ;

        // Create an array of links to return
        $links = [];

        if (LinkContainerInterface::TYPE_ACCOUNT == $type) {
            if (!$this->permissionApi->hasPermission($this->getBundleName() . '::', '::', ACCESS_OVERVIEW)) {
                return $links;
            }

            if (true === $this->variableApi->get('MUVideoModule', 'linkOwnCollectionsOnAccountPage', true)) {
                $objectType = 'collection';
                if ($this->permissionApi->hasPermission($this->getBundleName() . ':' . ucfirst($objectType) . ':', '::', ACCESS_READ)) {
                    $links[] = [
                        'url' => $this->router->generate('muvideomodule_' . strtolower($objectType) . '_view', ['own' => 1]),
                        'text' => $this->__('My collections', 'muvideomodule'),
                        'icon' => 'list-alt'
                    ];
                }
            }

            if (true === $this->variableApi->get('MUVideoModule', 'linkOwnMoviesOnAccountPage', true)) {
                $objectType = 'movie';
                if ($this->permissionApi->hasPermission($this->getBundleName() . ':' . ucfirst($objectType) . ':', '::', ACCESS_READ)) {
                    $links[] = [
                        'url' => $this->router->generate('muvideomodule_' . strtolower($objectType) . '_view', ['own' => 1]),
                        'text' => $this->__('My movies', 'muvideomodule'),
                        'icon' => 'list-alt'
                    ];
                }
            }

            if (true === $this->variableApi->get('MUVideoModule', 'linkOwnPlaylistsOnAccountPage', true)) {
                $objectType = 'playlist';
                if ($this->permissionApi->hasPermission($this->getBundleName() . ':' . ucfirst($objectType) . ':', '::', ACCESS_READ)) {
                    $links[] = [
                        'url' => $this->router->generate('muvideomodule_' . strtolower($objectType) . '_view', ['own' => 1]),
                        'text' => $this->__('My playlists', 'muvideomodule'),
                        'icon' => 'list-alt'
                    ];
                }
            }

            if ($this->permissionApi->hasPermission($this->getBundleName() . '::', '::', ACCESS_ADMIN)) {
                $links[] = [
                    'url' => $this->router->generate('muvideomodule_collection_adminindex'),
                    'text' => $this->__('Video Backend', 'muvideomodule'),
                    'icon' => 'wrench'
                ];
            }


            return $links;
        }

        $routeArea = LinkContainerInterface::TYPE_ADMIN == $type ? 'admin' : '';
        if (LinkContainerInterface::TYPE_ADMIN == $type) {
            if ($this->permissionApi->hasPermission($this->getBundleName() . '::', '::', ACCESS_READ)) {
                $links[] = [
                    'url' => $this->router->generate('muvideomodule_collection_index'),
                    'text' => $this->__('Frontend', 'muvideomodule'),
                    'title' => $this->__('Switch to user area.', 'muvideomodule'),
                    'icon' => 'home'
                ];
            }
        } else {
            if ($this->permissionApi->hasPermission($this->getBundleName() . '::', '::', ACCESS_ADMIN)) {
                $links[] = [
                    'url' => $this->router->generate('muvideomodule_collection_adminindex'),
                    'text' => $this->__('Backend', 'muvideomodule'),
                    'title' => $this->__('Switch to administration area.', 'muvideomodule'),
                    'icon' => 'wrench'
                ];
            }
        }
        
        if (in_array('collection', $allowedObjectTypes)
            && $this->permissionApi->hasPermission($this->getBundleName() . ':Collection:', '::', $permLevel)) {
            $links[] = [
                'url' => $this->router->generate('muvideomodule_collection_' . $routeArea . 'view'),
                'text' => $this->__('Collections', 'muvideomodule'),
                'title' => $this->__('Collection list', 'muvideomodule')
            ];
        }
        if (in_array('movie', $allowedObjectTypes)
            && $this->permissionApi->hasPermission($this->getBundleName() . ':Movie:', '::', $permLevel)) {
            $links[] = [
                'url' => $this->router->generate('muvideomodule_movie_' . $routeArea . 'view'),
                'text' => $this->__('Movies', 'muvideomodule'),
                'title' => $this->__('Movie list', 'muvideomodule')
            ];
        }
        if (in_array('playlist', $allowedObjectTypes)
            && $this->permissionApi->hasPermission($this->getBundleName() . ':Playlist:', '::', $permLevel)) {
            $links[] = [
                'url' => $this->router->generate('muvideomodule_playlist_' . $routeArea . 'view'),
                'text' => $this->__('Playlists', 'muvideomodule'),
                'title' => $this->__('Playlist list', 'muvideomodule')
            ];
        }
        if ($routeArea == 'admin' && $this->permissionApi->hasPermission($this->getBundleName() . '::', '::', ACCESS_ADMIN)) {
            $links[] = [
                'url' => $this->router->generate('muvideomodule_config_config'),
                'text' => $this->__('Configuration', 'muvideomodule'),
                'title' => $this->__('Manage settings for this application', 'muvideomodule'),
                'icon' => 'wrench'
            ];
        }

        return $links;
    }

    /**
     * Returns the name of the providing bundle.
     *
     * @return string The bundle name
     */
    public function getBundleName()
    {
        return 'MUVideoModule';
    }
}
