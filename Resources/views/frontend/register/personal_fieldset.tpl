
{* file to extend *}
{extends file="parent:frontend/register/personal_fieldset.tpl"}

{* set our namespace *}
{namespace name="frontend/ost-consultant/register/personal_fieldset"}





{* remove advantages *}
{block name='frontend_register_index_advantages'}{/block}


{* remove data protection notice *}
{block name='frontend_register_index_form_privacy'}{/block}





{block name='frontend_register_personal_fieldset_input_password'}
    <input type="hidden" name="register[personal][password]" value="12345678" id="register_personal_password" class="register--field password" />
{/block}

{* Password confirmation *}
{block name='frontend_register_personal_fieldset_input_password_confirm'}
    {if {config name=doublePasswordValidation}}
        <input type="hidden" name="register[personal][passwordConfirmation]" value="12345678" id="register_personal_passwordConfirmation" class="register--field passwordConfirmation" />
    {/if}
{/block}

{* remove password description *}
{block name='frontend_register_personal_fieldset_password_description'}{/block}