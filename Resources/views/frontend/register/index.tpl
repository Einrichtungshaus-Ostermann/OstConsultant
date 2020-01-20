
{* file to extend *}
{extends file="parent:frontend/register/index.tpl"}

{* set our namespace *}
{namespace name="frontend/ost-consultant/register/index"}



{* ... *}
{block name='frontend_register_index_form'}

    <form method="post" action="{url controller='OstConsultant' action='register'}" class="panel ost-consultant--register--form" id="ost-consultant--register--form">
        <div class="register--content">

            {include file="frontend/register/personal_fieldset.tpl" form_data=$register.personal error_flags=$errors.personal}
            {include file="frontend/register/billing_fieldset.tpl" form_data=$register.billing error_flags=$errors.billing country_list=$countryList}
            {include file="frontend/register/shipping_fieldset.tpl" form_data=$register.shipping error_flags=$errors.shipping country_list=$countryList}

            <div style="text-align: right; padding: 0 20px;">
                <input class="btn is--primary is--large" type="submit" value="{s name="register-customer-button"}Kunde registrieren{/s}">
            </div>
        </div>
    </form>

{/block}



{* ... *}
{block name='frontend_register_index_dealer_register'}

    <div class="panel register--personal ost-consultant--erp-customer-search" style="padding-bottom: 0;">
        <h2 class="panel--title is--underline">
            {s name='search-customer-headline'}EINFACH IHREN KUNDEN FINDEN{/s}
        </h2>
        <div class="panel--body is--wide">
            <input style="width: 70%;" type="text" placeholder="{s name='search-customer-placeholder' force}Name [und/oder] Vorname [und/oder] PLZ [und/oder] Wohnort eingeben...{/s}">
            <button style="width:20%; float: right; text-align: center;" class="btn is--primary">{s name='search-customer-button'}Kunden finden{/s}</button>
            <button style="width:60px; float: right; text-align: center; margin-right: 10px;" class="btn camera--button">
                <i class="icon--camera" style="font-size: 20px;vertical-align: middle;"></i>
            </button>
            <div class="search-result-container" style=""></div>
        </div>
    </div>

    {$smarty.block.parent}

{/block}



{block name='frontend_register_index_login'}

    <button class="btn ost-consultant--display-registration" style="float: right;">
        {s name='show-registration-form-button'}Kunde neu anlegen{/s}
    </button>

    {$smarty.block.parent}

{/block}



{* remove advantages *}
{block name='frontend_register_index_advantages'}{/block}

{* remove data protection notice *}
{block name='frontend_register_index_form_privacy'}{/block}
