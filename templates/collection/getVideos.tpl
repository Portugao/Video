{* purpose of this template: module configuration *}
{include file='user/header.tpl'}
<div class="muvideo-getvideos">
    {gt text='Get Videos' assign='templateTitle'}
    {pagesetvar name='title' value=$templateTitle}
    <div class="z-admin-content-pagetitle">
        {icon type='config' size='small' __alt='Get Videos'}
        <h3>{$templateTitle}</h3>
    </div>

    {form cssClass='z-form'}
        {* add validation summary and a <div> element for styling the form *}
        {muvideoFormFrame}
            {formsetinitialfocus inputId='pageSize'}
            {gt text='Import' assign='tabTitle'}
            <fieldset>
                <legend>{$tabTitle}</legend>
            
                <p class="z-confirmationmsg">{gt text='Here you can get videos from your youtube channel into MUVideo.'}</p>
            
                <div class="z-formrow">
                	{gt text='Here you can choose a channel' assign='toolTip'}
                    	{formlabel for='channelId' __text='Id of channel' cssClass='muimage-form-tooltips' title=$toolTip}
                        {formdropdownlist id='channelId' group='getVideos' __title='Choose the channel'}
                </div>
            </fieldset>

            <div class="z-buttons z-formbuttons">
                {formbutton commandName='get' __text='Get videos' class='z-bt-save'}
                {formbutton commandName='cancel' __text='Cancel' class='z-bt-cancel'}
            </div>
        {/muvideoFormFrame}
    {/form}
</div>
{include file='user/footer.tpl'}