{* Purpose of this template: Display collections in html mailings *}
{*
<ul>
{foreach item='collection' from=$items}
    <li>
        <a href="{modurl modname='MUVideo' type='user' func='display' id=$$objectType.id fqurl=true}">{$collection->getTitleFromDisplayPattern()}
        </a>
    </li>
{foreachelse}
    <li>{gt text='No collections found.'}</li>
{/foreach}
</ul>
*}

{include file='contenttype/itemlist_collection_display_description.tpl'}
