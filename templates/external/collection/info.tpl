{* Purpose of this template: Display item information for previewing from other modules *}
<dl id="collection{$collection.id}">
<dt>{$collection->getTitleFromDisplayPattern()|notifyfilters:'muvideo.filter_hooks.collections.filter'|htmlentities}</dt>
{if $collection.description ne ''}<dd>{$collection.description}</dd>{/if}
</dl>
