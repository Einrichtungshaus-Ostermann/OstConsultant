
{* file to extend *}
{extends file="parent:frontend/register/index.tpl"}

{* set our namespace *}
{namespace name="frontend/ost-consultant/register/index"}



{block name='frontend_register_index_form'}




    <form method="post" action="{url controller='OstConsultant' action='register'}" class="panel ost-consultant--register--form" id="ost-consultant--register--form">
        <div class="register--content">





                {include file="frontend/register/personal_fieldset.tpl" form_data=$register.personal error_flags=$errors.personal}



                {include file="frontend/register/billing_fieldset.tpl" form_data=$register.billing error_flags=$errors.billing country_list=$countryList}

                {include file="frontend/register/shipping_fieldset.tpl" form_data=$register.shipping error_flags=$errors.shipping country_list=$countryList}





            <div style="text-align: right;">
                <input class="btn is--primary is--large" type="submit" value="{s name="register-customer-button"}Kunde registrieren{/s}">
            </div>
        </div>
    </form>

{/block}











{* ... *}

{block name='frontend_register_index_dealer_register'}


    <div class="panel register--personal ost-consultant--erp-customer-search">
        <h2 class="panel--title is--underline">
            Kunde suchen
        </h2>
        <div class="panel--body is--wide">



            Bitte geben Sie hier Informationen aus der IWM ein.<br /><br />

            <input type="text">

            <button class="btn">Suchen</button>

            <div class="search-result-container">

            </div>

        </div>
    </div>




    <button class="btn ost-consultant--display-registration" style="margin: 20px 0;">
        Registrierung anzeigen
    </button>




    {$smarty.block.parent}


{/block}








{* remove advantages *}
{block name='frontend_register_index_advantages'}{/block}


{* remove data protection notice *}
{block name='frontend_register_index_form_privacy'}{/block}



