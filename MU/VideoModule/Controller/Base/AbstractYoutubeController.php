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
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Zikula\Core\Controller\AbstractController;

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
	 * @return string Output
	 *
	 * @throws AccessDeniedException Thrown if the user doesn't have required permissions
	 */
	public function getVideosAction(Request $request)
	{
		if (!$this->hasPermission($this->name . '::', '::', ACCESS_ADMIN)) {
			throw new AccessDeniedException();
		}
	
		$form = $this->createForm('MU\VideoModule\Form\GetVideosType');
		$datas = $form->getData();
		//print_r($datas);
		if ($form->handleRequest($request)->isValid()) {
			if ($form->get('getDatas')->isClicked()) {
				//$this->setVars($form->getData());
				$datas = $form->getData();
				//print_r($datas);
				
				$this->getYoutubeVideos($datas['channelId'], $datas['collectionId']);
	
				$this->addFlash('status', $this->__('Done! Module configuration updated.'));
				$userName = $this->get('zikula_users_module.current_user')->get('uname');
				$this->get('logger')->notice('{app}: User {user} updated the configuration.', ['app' => 'MUVideoModule', 'user' => $userName]);
			} elseif ($form->get('cancel')->isClicked()) {
				$this->addFlash('status', $this->__('Operation cancelled.'));
			}
	
			// redirect to config page again (to show with GET request)
			return $this->redirectToRoute('muvideomodule_youtube_getvideos');
		}
	
		$templateParameters = [
				'form' => $form->createView()
		];
	
		// render the get videos form
		return $this->render('@MUVideoModule/Youtube/getVideos.html.twig', $templateParameters);
	}
	
	/*
	 *
	 * this function is to get youtube videos into MUVideo
	 *
	 */
	public function getYoutubeVideos($channelId = '', $collectionId = 0)
	{
		$dom = ZLanguage::getModuleDomain($this->name);
		$youtubeApi = $this->getVar($this->name, 'youtubeApi');
	
		// we get collection repository and the relevant collection object
		$collectionRepository = MUVideo_Util_Model::getCollectionRepository();
		$collectionObject = $collectionRepository->selectById($collectionId);
	
		// we get a movie repository
		$movieRepository = MUVideo_Util_Model::getMovieRepository();
		// we get the videos from youtube
		$api = self::getData("https://www.googleapis.com/youtube/v3/search?part=snippet&channelId=" . $channelId  . "&maxResults=50&key=" . $youtubeApi);
	
		// we decode the jason array to php array
		$videos = json_decode($api, true);
	
		$where = 'tbl.urlOfYoutube != \'' . DataUtil::formatForStore('') . '\'';
		// we look for movies with a youtube url entered
		$existingYoutubeVideos = $movieRepository->selectWhere($where);
	
		if ($existingYoutubeVideos && count($existingYoutubeVideos > 0)) {
			foreach ($existingYoutubeVideos as $existingYoutubeVideo) {
				$youtubeId = str_replace('https://www.youtube.com/watch?v=', '', $existingYoutubeVideo['urlOfYoutube']);
				$videoIds[] = $youtubeId;
			}
		}
	
		$serviceManager = ServiceUtil::getManager();
		$entityManager = $serviceManager->getService('doctrine.entitymanager');
	
		if (is_array($videos['items'])) {
	
			foreach ($videos['items'] as $videoData) {
				if (isset($videoData['id']['videoId'])) {
					if (isset($videoIds) && is_array($videoIds)) {
						if (in_array($videoData['id']['videoId'], $videoIds)) {
							$fragment = $videoData['id']['videoId'];
							$where2 = 'tbl.urlOfYoutube LIKE \'%' . $fragment . '\'';
							$thisExistingVideo = $movieRepository->selectWhere($where2);
							if(is_array($thisExistingVideo) && count($thisExistingVideo) == 1 && ModUtil::getVar($this->name, 'overrideVars') == 1) {
								$thisExistingVideoObject = $movieRepository->selectById($thisExistingVideo[0]['id']);
	
								$thisExistingVideoObject->setTitle($videoData['snippet']['title']);
								$thisExistingVideoObject->setDescription($videoData['snippet']['description']);
								$thisExistingVideoObject->setCollection($collectionObject);
	
								$entityManager->flush();
								LogUtil::registerStatus(__('The video', $dom) . ' ' . $videoData['snippet']['title'] . ' ' . __('was overrided', $dom));
							}
							continue;
						}
					}
					 
					$newYoutubeVideo = new MUVideo_Entity_Movie();
					$newYoutubeVideo->setTitle($videoData['snippet']['title']);
					$newYoutubeVideo->setDescription($videoData['snippet']['description']);
					$newYoutubeVideo->setUrlOfYoutube('https://www.youtube.com/watch?v=' . $videoData['id']['videoId']);
					$newYoutubeVideo->setWidthOfMovie('400');
					$newYoutubeVideo->setHeightOfMovie('300');
					$newYoutubeVideo->setWorkflowState('approved');
					$newYoutubeVideo->setCollection($collectionObject);
	
					$entityManager->persist($newYoutubeVideo);
					$entityManager->flush();
					LogUtil::registerStatus(__('The video', $dom) . ' ' . $videoData['snippet']['title'] . ' ' . __('was created and put into the collection', $dom) . ' ' . $collectionObject['title']);
				}
			}
		}
	
		$redirectUrl = ModUtil::url($this->name, 'user', 'display', array('ot' => 'collection', 'id' => $collectionId));
		return System::redirect($redirectUrl);
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
}
