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

namespace MU\VideoModule\Controller\Base;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Zikula\Core\Controller\AbstractController;
use DataUtil;
use ServiceUtil;
use MU\VideoModule\Form\Type\GetVideosType;
use MU\VideoModule\Form\Type\GetPlaylistsType;

/**
 * Config controller base class.
 */
abstract class AbstractYoutubeController extends AbstractController
{
	
	/**
	 * This method takes care of the application configuration.
	 *
	 * @param Request $request Current request instance
	 *
	 * @return Response Output
	 *
	 * @throws AccessDeniedException Thrown if the user doesn't have required permissions
	 */
	public function getVideosAction(Request $request)
	{
		if (!$this->hasPermission($this->name . '::', '::', ACCESS_ADMIN)) {
			throw new AccessDeniedException();
		}
	
		$form = $this->createForm(GetVideosType::class);
		//$datas = $form->getData();

		if ($form->handleRequest($request)->isValid()) {
			if ($form->get('getDatas')->isClicked()) {

				$datas = $form->getData();
				
				$this->getYoutubeVideos($datas['channelId'], $datas['collectionId']);
	
				$this->addFlash('status', $this->__('Done! Video import complete.'));
				$userName = $this->get('zikula_users_module.current_user')->get('uname');
				$this->get('logger')->notice('{app}: User {user} updated the configuration.', ['app' => 'MUVideoModule', 'user' => $userName]);
			} elseif ($form->get('cancel')->isClicked()) {
				$this->addFlash('status', $this->__('Operation cancelled.'));
			}
	
			// redirect to therelevant collection
			return $this->redirectToRoute('muvideomodule_collection_display', array('id' => $datas['collectionId']));
		}
	
		$templateParameters = [
				'form' => $form->createView()
		];
	
		// render the get videos form
		return $this->render('@MUVideoModule/Youtube/getVideos.html.twig', $templateParameters);
	}
	
	/**
	 * This method takes care of the application configuration.
	 *
	 * @param Request $request Current request instance
	 *
	 * @return Response Output
	 *
	 * @throws AccessDeniedException Thrown if the user doesn't have required permissions
	 */
	public function getPlaylistsAction(Request $request)
	{
		if (!$this->hasPermission($this->name . '::', '::', ACCESS_ADMIN)) {
			throw new AccessDeniedException();
		}
	
		$form = $this->createForm(GetPlaylistsType::class);
		//$datas = $form->getData();
	
		if ($form->handleRequest($request)->isValid()) {
			if ($form->get('getDatas')->isClicked()) {
	
				$datas = $form->getData();
	
				$this->getYoutubeplaylists($datas['channelId'], $datas['collectionId']);
	
				$this->addFlash('status', $this->__('Done! Playlist import complete.'));
				$userName = $this->get('zikula_users_module.current_user')->get('uname');
				$this->get('logger')->notice('{app}: User {user} updated the configuration.', ['app' => 'MUVideoModule', 'user' => $userName]);
			} elseif ($form->get('cancel')->isClicked()) {
				$this->addFlash('status', $this->__('Operation cancelled.'));
			}
	
			// redirect to therelevant collection
			return $this->redirectToRoute('muvideomodule_collection_display', array('id' => $datas['collectionId']));
		}
	
		$templateParameters = [
				'form' => $form->createView()
		];
	
		// render the get playlists form
		return $this->render('@MUVideoModule/Youtube/getPlaylists.html.twig', $templateParameters);
	}
	
	/*
	 *
	 * this function is to get youtube videos into Video
	 *
	 */
	public function getYoutubeVideos($channelId = '', $collectionId = 0)
	{
		$youtubeApi = $this->getVar('youtubeApi');
		
		$modelHelper = $this->get('mu_video_module.model_helper');
	
		// we get collection repository and the relevant collection object
		$collectionRepository = $modelHelper->getRepository('collection');

		// we get the relevant collection object
		$collectionObject = $collectionRepository->selectById($collectionId);
		
		// we get a movie repository
		$movieRepository = $modelHelper->getRepository('movie');
		//$movieRepository = $this->container->get('mu_video_module.video_factory')->getRepository('movie');

		// we get the videos from youtube
		$api = self::getData("https://www.googleapis.com/youtube/v3/search?part=snippet&type=video&channelId=" . $channelId  . "&maxResults=50&key=" . $youtubeApi);
	
		// we decode the jason array to php array
		$videos = json_decode($api, true);
		//die($videos['items']);
	
		$where = 'tbl.urlOfYoutube != \'' . DataUtil::formatForStore('') . '\'';
		// we look for movies with a youtube url entered
		$existingYoutubeVideos = $movieRepository->selectWhere($where);
	
		if ($existingYoutubeVideos && count($existingYoutubeVideos > 0)) {
			foreach ($existingYoutubeVideos as $existingYoutubeVideo) {
				$youtubeId = str_replace('https://www.youtube.com/watch?v=', '', $existingYoutubeVideo['urlOfYoutube']);
				$videoIds[] = $youtubeId;
			}
		}
	
		$serviceManager = \ServiceUtil::getManager();
		$entityManager = $serviceManager->getService('doctrine.entitymanager');
	
		if (is_array($videos)) {
	
			foreach ($videos['items'] as $videoData) {
				if (isset($videoData['id']['videoId'])) {
					if (isset($videoIds) && is_array($videoIds)) {
						if (in_array($videoData['id']['videoId'], $videoIds)) {
							$fragment = $videoData['id']['videoId'];
							$where2 = 'tbl.urlOfYoutube LIKE \'%' . $fragment . '\'';
							$thisExistingVideo = $movieRepository->selectWhere($where2);
							if(is_array($thisExistingVideo) && count($thisExistingVideo) == 1 && $this->getVar('overrideVars') == 1) {
								$thisExistingVideoObject = $movieRepository->selectById($thisExistingVideo[0]['id']);
	
								$thisExistingVideoObject->setTitle($videoData['snippet']['title']);
								$thisExistingVideoObject->setDescription($videoData['snippet']['description']);
								$thisExistingVideoObject->setCollection($collectionObject);
	
								$entityManager->flush();
								$this->addFlash('status', $this->__('The video') . ' ' . $videoData['snippet']['title'] . ' ' . $this->__('was overridden'));
						        }
							continue;
						}
					}

					$newYoutubeVideo = new \MU\VideoModule\Entity\MovieEntity();
					$newYoutubeVideo->setTitle($videoData['snippet']['title']);
					$newYoutubeVideo->setDescription($videoData['snippet']['description']);
					$newYoutubeVideo->setUrlOfYoutube('https://www.youtube.com/watch?v=' . $videoData['id']['videoId']);
					$newYoutubeVideo->setWidthOfMovie('400');
					$newYoutubeVideo->setHeightOfMovie('300');
					$newYoutubeVideo->setWorkflowState('approved');
					$newYoutubeVideo->setCollection($collectionObject);
	
					$entityManager->persist($newYoutubeVideo);
					$entityManager->flush();
					$this->addFlash('status', $this->__('The video')  . ' ' . $videoData['snippet']['title'] . ' ' . $this->__('was created and put into the collection') . ' ' . $collectionObject['title']);
					//LogUtil::registerStatus(__('The video', $dom) . ' ' . $videoData['snippet']['title'] . ' ' . __('was created and put into the collection', $dom) . ' ' . $collectionObject['title']);
				}
			}
		} else {
			$this->addFlash('error', 'No videos available!');
		}
	
		return $this->redirectToRoute('muvideomodule_collection_display', array('id'=> $collectionId));
	}
	
	/*
	 *
	 * this function is to get youtube playlists into Video
	 *
	 */
	public function getYoutubePlaylists($channelId = '', $collectionId = 0)
	{
		$youtubeApi = $this->getVar('youtubeApi');
	
		$modelHelper = $this->get('mu_video_module.model_helper');
	
		// we get collection repository and the relevant collection object
		$collectionRepository = $modelHelper->getRepository('collection');
	
		// we get the collection object
		$collectionObject = $collectionRepository->selectById($collectionId);
	
		// we get a movie repository
		$playlistRepository = $modelHelper->getRepository('playlist');
	
		// we get the playlists from youtube
		$api = self::getData("https://www.googleapis.com/youtube/v3/playlists?part=snippet&channelId=" . $channelId  . "&maxResults=50&key=" . $youtubeApi);
	
		// we decode the jason array to php array
		$playlists = json_decode($api, true);
	
		$where = 'tbl.urlOfYoutubePlaylist != \'' . DataUtil::formatForStore('') . '\'';
		// we look for movies with a youtube url entered
		$existingYoutubePlaylists = $playlistRepository->selectWhere($where);
	
		if ($existingYoutubePlaylists && count($existingYoutubePlaylists > 0)) {
			foreach ($existingYoutubePlaylists as $existingYoutubePlaylist) {
				$youtubeId = str_replace('https://www.youtube.com/watch?v=', '', $existingYoutubePlaylist['urlOfYoutubePlaylist']);
				$playlistIds[] = $youtubeId;
			}
		}
	
		$serviceManager = \ServiceUtil::getManager();
		$entityManager = $serviceManager->getService('doctrine.entitymanager');
	
		if (is_array($playlists['items'])) {
	
			die('T');
			foreach ($playlists['items'] as $playlistData) {
				if (isset($playlistData['id'])) {
					$api2 = self::getData("https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=1&playlistId=" . $playlistData['id'] . "&key=" . $youtubeApi);
					// we decode the jason array to php array
					$playlistVideos = json_decode($api2, true);
					$playlistVideoId = '';
					foreach ($playlistVideos['items'] as $video) {
						if ($playlistVideoId == '') {
							$playlistVideoId = $video['snippet']['resourceId']['videoId'];
						}
					}
					
					
					if (isset($playlistIds) && is_array($playlistIds)) {
						if (in_array($playlistData['id'], $playlistIds)) {
							$fragment = $playlistData['id'];
							$where2 = 'tbl.urlOfYoutubePlaylist LIKE \'%' . $fragment . '\'';
							$thisExistingPlaylist = $playlistRepository->selectWhere($where2);
							if(is_array($thisExistingPlaylist) && count($thisExistingPlaylist) == 1 && $this->getVar('overrideVars') == 1) {
								$thisExistingPlaylistObject = $playlistRepository->selectById($thisExistingPlaylist[0]['id']);
	
								$thisExistingPlaylistObject->setTitle($playlistData['snippet']['title']);
								$thisExistingPlaylistObject->setDescription($playlistData['snippet']['description']);
								$thisExistingPlaylistObject->setCollection($collectionObject);
	
								$entityManager->flush();
								$this->addFlash('status', $this->__('The playlist') . ' ' . $playlistData['snippet']['title'] . ' ' . $this->__('was overridden'));
							}
							continue;
						}
					}
	
					$newYoutubePlaylist = new \MU\VideoModule\Entity\PlaylistEntity();
					$newYoutubePlaylist->setTitle($playlistData['snippet']['title']);
					$newYoutubePlaylist->setDescription($playlistData['snippet']['description']);
					$newYoutubePlaylist->setUrlOfYoutubePlaylist('https://www.youtube.com/watch?v=' . $playlistVideoId . "&list=" .$playlistData['id']);
					$newYoutubePlaylist->setWorkflowState('approved');
					$newYoutubePlaylist->setCollection($collectionObject);
	
					$entityManager->persist($newYoutubePlaylist);
					$entityManager->flush();
					$this->addFlash('status', $this->__('The playlist')  . ' ' . $playlistData['snippet']['title'] . ' ' . $this->__('was created and put into the collection') . ' ' . $collectionObject['title']);
					//LogUtil::registerStatus(__('The video', $dom) . ' ' . $videoData['snippet']['title'] . ' ' . __('was created and put into the collection', $dom) . ' ' . $collectionObject['title']);
				}
			}
		} else {
			$this->addFlash('error', 'No playlists available!');
		}
	
		return $this->redirectToRoute('muvideomodule_collection_display', array('id'=> $collectionId));
	}
	
	/*
	 *
	 * this function is to call a url, for example a youtube call
	 */
	public function getData($url)
	{
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
	
	/**
	 * 
	 */
	public function getCollectionId(Request $request)
	{
		$collectionId = $request->get('collectionId');
		return $collectionId;
	}
	
	public function setEntityFactory(MU\VideoModule\Entity\Factory $entityFactory)
	{
		$this->entityFactory = $entityFactory;
	}
}
