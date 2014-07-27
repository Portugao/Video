{* Purpose of this template: Display search options *}
<input type="hidden" id="mUVideoActive" name="active[MUVideo]" value="1" checked="checked" />
<div>
    <input type="checkbox" id="active_mUVideoCollections" name="mUVideoSearchTypes[]" value="collection"{if $active_collection} checked="checked"{/if} />
    <label for="active_mUVideoCollections">{gt text='Collections' domain='module_muvideo'}</label>
</div>
<div>
    <input type="checkbox" id="active_mUVideoMovies" name="mUVideoSearchTypes[]" value="movie"{if $active_movie} checked="checked"{/if} />
    <label for="active_mUVideoMovies">{gt text='Movies' domain='module_muvideo'}</label>
</div>
