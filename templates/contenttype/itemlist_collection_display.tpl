{* Purpose of this template: Display collections within an external context *}
{foreach item='collection' from=$items}
    <h3>{$collection->getTitleFromDisplayPattern()}</h3>
    <p><a href="{modurl modname='MUVideo' type='user' ot='collection' func='display'  id=$collection.id}">{gt text='Read more'}</a>
    </p>
{/foreach}
