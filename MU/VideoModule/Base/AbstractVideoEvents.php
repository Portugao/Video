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

namespace MU\VideoModule\Base;

/**
 * Events definition base class.
 */
abstract class AbstractVideoEvents
{
    /**
     * The muvideomodule.collection_post_load event is thrown when collections
     * are loaded from the database.
     *
     * The event listener receives an
     * MU\VideoModule\Event\FilterCollectionEvent instance.
     *
     * @see MU\VideoModule\Listener\EntityLifecycleListener::postLoad()
     * @var string
     */
    const COLLECTION_POST_LOAD = 'muvideomodule.collection_post_load';
    
    /**
     * The muvideomodule.collection_pre_persist event is thrown before a new collection
     * is created in the system.
     *
     * The event listener receives an
     * MU\VideoModule\Event\FilterCollectionEvent instance.
     *
     * @see MU\VideoModule\Listener\EntityLifecycleListener::prePersist()
     * @var string
     */
    const COLLECTION_PRE_PERSIST = 'muvideomodule.collection_pre_persist';
    
    /**
     * The muvideomodule.collection_post_persist event is thrown after a new collection
     * has been created in the system.
     *
     * The event listener receives an
     * MU\VideoModule\Event\FilterCollectionEvent instance.
     *
     * @see MU\VideoModule\Listener\EntityLifecycleListener::postPersist()
     * @var string
     */
    const COLLECTION_POST_PERSIST = 'muvideomodule.collection_post_persist';
    
    /**
     * The muvideomodule.collection_pre_remove event is thrown before an existing collection
     * is removed from the system.
     *
     * The event listener receives an
     * MU\VideoModule\Event\FilterCollectionEvent instance.
     *
     * @see MU\VideoModule\Listener\EntityLifecycleListener::preRemove()
     * @var string
     */
    const COLLECTION_PRE_REMOVE = 'muvideomodule.collection_pre_remove';
    
    /**
     * The muvideomodule.collection_post_remove event is thrown after an existing collection
     * has been removed from the system.
     *
     * The event listener receives an
     * MU\VideoModule\Event\FilterCollectionEvent instance.
     *
     * @see MU\VideoModule\Listener\EntityLifecycleListener::postRemove()
     * @var string
     */
    const COLLECTION_POST_REMOVE = 'muvideomodule.collection_post_remove';
    
    /**
     * The muvideomodule.collection_pre_update event is thrown before an existing collection
     * is updated in the system.
     *
     * The event listener receives an
     * MU\VideoModule\Event\FilterCollectionEvent instance.
     *
     * @see MU\VideoModule\Listener\EntityLifecycleListener::preUpdate()
     * @var string
     */
    const COLLECTION_PRE_UPDATE = 'muvideomodule.collection_pre_update';
    
    /**
     * The muvideomodule.collection_post_update event is thrown after an existing new collection
     * has been updated in the system.
     *
     * The event listener receives an
     * MU\VideoModule\Event\FilterCollectionEvent instance.
     *
     * @see MU\VideoModule\Listener\EntityLifecycleListener::postUpdate()
     * @var string
     */
    const COLLECTION_POST_UPDATE = 'muvideomodule.collection_post_update';
    
    /**
     * The muvideomodule.movie_post_load event is thrown when movies
     * are loaded from the database.
     *
     * The event listener receives an
     * MU\VideoModule\Event\FilterMovieEvent instance.
     *
     * @see MU\VideoModule\Listener\EntityLifecycleListener::postLoad()
     * @var string
     */
    const MOVIE_POST_LOAD = 'muvideomodule.movie_post_load';
    
    /**
     * The muvideomodule.movie_pre_persist event is thrown before a new movie
     * is created in the system.
     *
     * The event listener receives an
     * MU\VideoModule\Event\FilterMovieEvent instance.
     *
     * @see MU\VideoModule\Listener\EntityLifecycleListener::prePersist()
     * @var string
     */
    const MOVIE_PRE_PERSIST = 'muvideomodule.movie_pre_persist';
    
    /**
     * The muvideomodule.movie_post_persist event is thrown after a new movie
     * has been created in the system.
     *
     * The event listener receives an
     * MU\VideoModule\Event\FilterMovieEvent instance.
     *
     * @see MU\VideoModule\Listener\EntityLifecycleListener::postPersist()
     * @var string
     */
    const MOVIE_POST_PERSIST = 'muvideomodule.movie_post_persist';
    
    /**
     * The muvideomodule.movie_pre_remove event is thrown before an existing movie
     * is removed from the system.
     *
     * The event listener receives an
     * MU\VideoModule\Event\FilterMovieEvent instance.
     *
     * @see MU\VideoModule\Listener\EntityLifecycleListener::preRemove()
     * @var string
     */
    const MOVIE_PRE_REMOVE = 'muvideomodule.movie_pre_remove';
    
    /**
     * The muvideomodule.movie_post_remove event is thrown after an existing movie
     * has been removed from the system.
     *
     * The event listener receives an
     * MU\VideoModule\Event\FilterMovieEvent instance.
     *
     * @see MU\VideoModule\Listener\EntityLifecycleListener::postRemove()
     * @var string
     */
    const MOVIE_POST_REMOVE = 'muvideomodule.movie_post_remove';
    
    /**
     * The muvideomodule.movie_pre_update event is thrown before an existing movie
     * is updated in the system.
     *
     * The event listener receives an
     * MU\VideoModule\Event\FilterMovieEvent instance.
     *
     * @see MU\VideoModule\Listener\EntityLifecycleListener::preUpdate()
     * @var string
     */
    const MOVIE_PRE_UPDATE = 'muvideomodule.movie_pre_update';
    
    /**
     * The muvideomodule.movie_post_update event is thrown after an existing new movie
     * has been updated in the system.
     *
     * The event listener receives an
     * MU\VideoModule\Event\FilterMovieEvent instance.
     *
     * @see MU\VideoModule\Listener\EntityLifecycleListener::postUpdate()
     * @var string
     */
    const MOVIE_POST_UPDATE = 'muvideomodule.movie_post_update';
    
    /**
     * The muvideomodule.playlist_post_load event is thrown when playlists
     * are loaded from the database.
     *
     * The event listener receives an
     * MU\VideoModule\Event\FilterPlaylistEvent instance.
     *
     * @see MU\VideoModule\Listener\EntityLifecycleListener::postLoad()
     * @var string
     */
    const PLAYLIST_POST_LOAD = 'muvideomodule.playlist_post_load';
    
    /**
     * The muvideomodule.playlist_pre_persist event is thrown before a new playlist
     * is created in the system.
     *
     * The event listener receives an
     * MU\VideoModule\Event\FilterPlaylistEvent instance.
     *
     * @see MU\VideoModule\Listener\EntityLifecycleListener::prePersist()
     * @var string
     */
    const PLAYLIST_PRE_PERSIST = 'muvideomodule.playlist_pre_persist';
    
    /**
     * The muvideomodule.playlist_post_persist event is thrown after a new playlist
     * has been created in the system.
     *
     * The event listener receives an
     * MU\VideoModule\Event\FilterPlaylistEvent instance.
     *
     * @see MU\VideoModule\Listener\EntityLifecycleListener::postPersist()
     * @var string
     */
    const PLAYLIST_POST_PERSIST = 'muvideomodule.playlist_post_persist';
    
    /**
     * The muvideomodule.playlist_pre_remove event is thrown before an existing playlist
     * is removed from the system.
     *
     * The event listener receives an
     * MU\VideoModule\Event\FilterPlaylistEvent instance.
     *
     * @see MU\VideoModule\Listener\EntityLifecycleListener::preRemove()
     * @var string
     */
    const PLAYLIST_PRE_REMOVE = 'muvideomodule.playlist_pre_remove';
    
    /**
     * The muvideomodule.playlist_post_remove event is thrown after an existing playlist
     * has been removed from the system.
     *
     * The event listener receives an
     * MU\VideoModule\Event\FilterPlaylistEvent instance.
     *
     * @see MU\VideoModule\Listener\EntityLifecycleListener::postRemove()
     * @var string
     */
    const PLAYLIST_POST_REMOVE = 'muvideomodule.playlist_post_remove';
    
    /**
     * The muvideomodule.playlist_pre_update event is thrown before an existing playlist
     * is updated in the system.
     *
     * The event listener receives an
     * MU\VideoModule\Event\FilterPlaylistEvent instance.
     *
     * @see MU\VideoModule\Listener\EntityLifecycleListener::preUpdate()
     * @var string
     */
    const PLAYLIST_PRE_UPDATE = 'muvideomodule.playlist_pre_update';
    
    /**
     * The muvideomodule.playlist_post_update event is thrown after an existing new playlist
     * has been updated in the system.
     *
     * The event listener receives an
     * MU\VideoModule\Event\FilterPlaylistEvent instance.
     *
     * @see MU\VideoModule\Listener\EntityLifecycleListener::postUpdate()
     * @var string
     */
    const PLAYLIST_POST_UPDATE = 'muvideomodule.playlist_post_update';
    
}
