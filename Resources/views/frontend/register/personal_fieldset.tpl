
{* file to extend *}
{extends file="parent:frontend/register/personal_fieldset.tpl"}

{* set our namespace *}
{namespace name="frontend/ost-consultant/register/personal_fieldset"}











{* set default password and remove description *}


{block name='frontend_register_personal_fieldset_input_password'}
    <input type="hidden" name="register[personal][password]" value="12345678" id="register_personal_password" class="register--field password" />
{/block}

{block name='frontend_register_personal_fieldset_input_password_confirm'}
    {if {config name=doublePasswordValidation}}
        <input type="hidden" name="register[personal][passwordConfirmation]" value="12345678" id="register_personal_passwordConfirmation" class="register--field passwordConfirmation" />
    {/if}
{/block}

{block name='frontend_register_personal_fieldset_password_description'}{/block}






{block name='frontend_register_personal_fieldset_input_mail'}
    <div class="register--email">
        <input autocomplete="section-personal email"
               name="register[personal][email]"
               type="email"
               placeholder="{s name='RegisterPlaceholderMail' namespace="frontend/register/personal_fieldset"}{/s}"
               id="register_personal_email"
               value="{$form_data.email|escape}"
               class="register--field email" />
    </div>

    {if {config name=doubleEmailValidation}}
        <div class="register--emailconfirm">
            <input autocomplete="section-personal email"
                   name="register[personal][emailConfirmation]"
                   type="email"
                   placeholder="{s name='RegisterPlaceholderMailConfirmation' namespace="frontend/register/personal_fieldset"}{/s}"
                   id="register_personal_emailConfirmation"
                   value="{$form_data.emailConfirmation|escape}"
                   class="register--field emailConfirmation" />
        </div>
    {/if}
{/block}





{* remove guest accounts *}
{block name='frontend_register_personal_fieldset_skip_login'}

        <input type="hidden"
               value="0"
               id="register_personal_skipLogin"
               name="register[personal][accountmode]"
               class="register--checkbox chkbox"/>

{/block}