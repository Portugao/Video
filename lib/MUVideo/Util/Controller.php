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
 * @version Generated by ModuleStudio 0.6.2 (http://modulestudio.de).
 */

/**
 * Utility implementation class for controller helper methods.
 */
class MUVideo_Util_Controller extends MUVideo_Util_Base_Controller
{
    /*
     *
     * this function is to get youtube videos into MUVideo
     *
     */
    public function getYoutubeVideos($channelId = '')
    {
        $youtubeApi = ModUtil::getVar($this->name, 'youtubeApi');

        $api = self::getData("https://www.googleapis.com/youtube/v3/search?part=snippet&channelId=" . $channelId  . "&key=" . $youtubeApi);
        // https://www.googleapis.com/youtube/v3/search?part=snippet&channelId=UCJC8ynLpY_q89tmNhqIf1Sg&key={YOUR_API_KEY}
        //$api = self::getData("https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&playlistId={DEINE_PLAYLIST_ID}&maxResults=10&fields=items%2Fsnippet&key=" . $youtubeApi);

        $videos = json_decode($api, true);

        foreach ($videos['items'] as $videoData) {
            if (isset($videoData['id']['videoId'])) {
                LogUtil::registerError($videoData['id']['videoId']);
                 
                $newYoutubeVideo = new MUVideo_Entity_Movie();
                $newYoutubeVideo->setTitle($videoData['snippet']['title']);
                $newYoutubeVideo->setDescription($videoData['snippet']['description']);
                $newYoutubeVideo->setUrlOfYoutube('https://www.youtube.com/watch?v=' . $videoData['id']['videoId']);
                
                
            }
        }
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
}
