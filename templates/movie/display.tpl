{* purpose of this template: movies display view *}
{assign var='lct' value='user'}
{if isset($smarty.get.lct) && $smarty.get.lct eq 'admin'}
    {assign var='lct' value='admin'}
{/if}
{include file="`$lct`/header.tpl"}
{pageaddvar name='javascript' value='jquery'}
{pageaddvar name='javascript' value='jquery-ui'}
{if $movie.urlOfYoutube eq ''}
{pageaddvar name='javascript' value='modules/MUVideo/lib/vendor/projekktor/projekktor-1.3.09.min.js'}
{pageaddvar name='stylesheet' value='modules/MUVideo/lib/vendor/projekktor/themes/maccaco/projekktor.style.css'}
{pageaddvar name='javascript' value='modules/MUVideo/lib/vendor/leanback_player/js.player/leanbackPlayer.pack.js'}
{pageaddvar name='javascript' value='modules/MUVideo/lib/vendor/leanback_player/js.player/leanbackPlayer.de.js'}
{pageaddvar name='stylesheet' value='modules/MUVideo/lib/vendor/leanbackplayer/css.player/leanbackPlayer.default.css'}
{/if}
{if $movie.urlOfYoutube ne ''}
{pageaddvar name='javascript' value='modules/MUVideo/lib/vendor/lazyYT/lazyYT.js'}
{pageaddvar name='stylesheet' value='modules/MUVideo/lib/vendor/lazyYT/lazyYT.css'}
{/if}
<div class="muvideo-movie muvideo-display">
    {gt text='Movie' assign='templateTitle'}
    {assign var='templateTitle' value=$movie->getTitleFromDisplayPattern()|default:$templateTitle}
    {pagesetvar name='title' value=$templateTitle|@html_entity_decode}
    {if $lct eq 'admin'}
        <div class="z-admin-content-pagetitle">
            {icon type='display' size='small' __alt='Details'}
            <h3>{$templateTitle|notifyfilters:'muvideo.filter_hooks.movies.filter'}{icon id="itemActions`$movie.id`Trigger" type='options' size='extrasmall' __alt='Actions' class='z-pointer z-hide'}
            </h3>
        </div>
    {else}
        <h2>{$templateTitle|notifyfilters:'muvideo.filter_hooks.movies.filter'}{icon id="itemActions`$movie.id`Trigger" type='options' size='extrasmall' __alt='Actions' class='z-pointer z-hide'}
        </h2>
    {/if}
    <dl>
       {* <dt>{gt text='Title'}</dt>
        <dt>{gt text='Title'}</dt>
        <dd>{$movie.title}</dd>
        <dt>{gt text='Description'}</dt> *}
        {if $movie.description ne ''}
        <dd>{$movie.description}</dd>
        {/if}
        {if $movie.urlOfYoutube ne ''}
        	YOUTUBE[{$movie.id}]
        {/if}
        {if $movie.urlOfYoutube eq ''}
          {*  <video id="player_a" class="projekktor" poster="{$movie.posterFullPathUrl}" title="{$movie.title}" width="{$movie.widthOfMovie}" height="{$movie.heightOfMovie}" controls>             
                <source src="{$movie.uploadOfMovieFullPathUrl}" />         
            </video> *}
            
            <!-- surrounding element with class - needed!! -->
            <div class="leanback-player-video">
            <!-- HTML5 <video> element -->
                <video width="{$movie.widthOfMovie}" height="{$movie.heightOfMovie} preload="metadata" controls poster="{$movie.posterFullPathUrl}">
                <!-- HTML5 <video> sources -->
		            <source src="{$movie.uploadOfMovieFullPathUrl}" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'/>
                    {* <source src="./folder/video.ogv" type='video/ogg; codecs="theora, vorbis"'/> *}
                </video>
           </div>
     
        {/if}
       {* <dt>{gt text='Upload of movie'}</dt>
        <dd>{if $movie.uploadOfMovie ne ''}
        <a href="{$movie.uploadOfMovieFullPathURL}" title="{$movie->getTitleFromDisplayPattern()|replace:"\"":""}"{if $movie.uploadOfMovieMeta.isImage} rel="imageviewer[movie]"{/if}>
        {if $movie.uploadOfMovieMeta.isImage}
            {thumb image=$movie.uploadOfMovieFullPath objectid="movie-`$movie.id`" preset=$movieThumbPresetUploadOfMovie tag=true img_alt=$movie->getTitleFromDisplayPattern()}
        {else}
            {gt text='Download'} ({$movie.uploadOfMovieMeta.size|muvideoGetFileSize:$movie.uploadOfMovieFullPath:false:false})
        {/if}
        </a>
        {else}&nbsp;{/if}
        </dd>
        <dt>{gt text='Url of youtube'}</dt>
        <dd>{if $movie.urlOfYoutube ne ''}
        {if !isset($smarty.get.theme) || $smarty.get.theme ne 'Printer'}
        <a href="{$movie.urlOfYoutube}" title="{gt text='Visit this page'}">{icon type='url' size='extrasmall' __alt='Homepage'}</a>
        {else}
          {$movie.urlOfYoutube}
        {/if}
        {else}&nbsp;{/if}
        </dd>
        <dt>{gt text='Poster'}</dt>
        <dd>{if $movie.poster ne ''}
        <a href="{$movie.posterFullPathURL}" title="{$movie->getTitleFromDisplayPattern()|replace:"\"":""}"{if $movie.posterMeta.isImage} rel="imageviewer[movie]"{/if}>
        {if $movie.posterMeta.isImage}
            {thumb image=$movie.posterFullPath objectid="movie-`$movie.id`" preset=$movieThumbPresetPoster tag=true img_alt=$movie->getTitleFromDisplayPattern()}
        {else}
            {gt text='Download'} ({$movie.posterMeta.size|muvideoGetFileSize:$movie.posterFullPath:false:false})
        {/if}
        </a>
        {else}&nbsp;{/if}
        </dd>
        <dt>{gt text='Width of movie'}</dt>
        <dd>{$movie.widthOfMovie}</dd>
        <dt>{gt text='Height of movie'}</dt>
        <dd>{$movie.heightOfMovie}</dd>
        <dt>{gt text='Collection'}</dt>
        <dd>
        {if isset($movie.collection) && $movie.collection ne null}
          {if !isset($smarty.get.theme) || $smarty.get.theme ne 'Printer'}
          <a href="{modurl modname='MUVideo' type=$lct func='display' ot='collection'  id=$movie.collection.id}">{strip}
            {$movie.collection->getTitleFromDisplayPattern()}
          {/strip}</a>
          <a id="collectionItem{$movie.collection.id}Display" href="{modurl modname='MUVideo' type=$lct func='display' ot='collection'  id=$movie.collection.id theme='Printer' forcelongurl=true}" title="{gt text='Open quick view window'}" class="z-hide">{icon type='view' size='extrasmall' __alt='Quick view'}</a>
          <script type="text/javascript">
          /* <![CDATA[ */
              document.observe('dom:loaded', function() {
                  mUMUVideoInitInlineWindow($('collectionItem{{$movie.collection.id}}Display'), '{{$movie.collection->getTitleFromDisplayPattern()|replace:"'":""}}');
              });
          /* ]]> */
          </script>
          {else}
            {$movie.collection->getTitleFromDisplayPattern()}
          {/if}
        {else}
            {gt text='Not set.'}
        {/if}
        </dd>
        
    </dl>
    {include file='helper/includeCategoriesDisplay.tpl' obj=$movie}
    {include file='helper/includeStandardFieldsDisplay.tpl' obj=$movie}

    {if !isset($smarty.get.theme) || $smarty.get.theme ne 'Printer'}
        {* include display hooks *}
        {notifydisplayhooks eventname='muvideo.ui_hooks.movies.display_view' id=$movie.id urlobject=$currentUrlObject assign='hooks'}
        {foreach name='hookLoop' key='providerArea' item='hook' from=$hooks}
            {if $providerArea ne 'provider.scribite.ui_hooks.editor'}{* fix for #664 *}
                {$hook}
            {/if}
        {/foreach}
        {if count($movie._actions) gt 0}
            <p id="itemActions{$movie.id}">
                {foreach item='option' from=$movie._actions}
                    <a href="{$option.url.type|muvideoActionUrl:$option.url.func:$option.url.arguments}" title="{$option.linkTitle|safetext}" class="z-icon-es-{$option.icon}">{$option.linkText|safetext}</a>
                {/foreach}
            </p>
            <script type="text/javascript">
            /* <![CDATA[ */
                document.observe('dom:loaded', function() {
                    mUMUVideoInitItemActions('movie', 'display', 'itemActions{{$movie.id}}');
                });
        
        var MU = jQuery.noConflict(); 
               
        MU(document).ready(function() {
        {{if $movie.urlOfYoutube ne ''}}     
        jQuery('.lazyYT').lazyYT(); 
        {{/if}} 
        {{if $movie.urlOfYoutube eq ''}}           
        projekktor('#player_a', {
        poster: '{{$movie.poster}}',
        title: '{{$movie.title}}',
        playerFlashMP4: '/modules/MUVideo/lib/vendor/projekktor/swf/StrobeMediaPlayback/StrobeMediaPlayback.swf',
        playerFlashMP3: '/modules/MUVideo/lib/vendor/projekktor/swf/StrobeMediaPlayback/StrobeMediaPlayback.swf',
        width: 640,
        height: 385,
        playlist: [
            {
            0: {src: {{if $movie.urlOfYoutube ne ''}}'{{$movie.urlOfYoutube}}', type: 'video/youtube'{{else}}'{{$movie.uploadOfMovieFullPathURL}}'{{/if}}}
            }
        ]    
        });
        {{/if}}
    });
            /* ]]> */
            </script>
        {/if}
</div>
{include file="`$lct`/footer.tpl"}
