{* purpose of this template: movies view json view *}
{muvideoTemplateHeaders contentType='application/json'}
[
{foreach item='item' from=$items name='movies'}
    {if not $smarty.foreach.movies.first},{/if}
    {$item->toJson()}
{/foreach}
]
