
{* file to extend *}
{extends file="parent:frontend/register/login.tpl"}

{* set our namespace *}
{namespace name="frontend/ost-consultant/register/login"}



{* replace login *}
{block name='frontend_register_login_customer_title'}

    <h2 class="panel--title is--underline">Ich bin bereits Kunde</h2>

{/block}



{* replace register form with search form *}
{block name='frontend_register_login_form'}

    <div class="ost-consultant--customer-search">
        Hier Kunde suchen und per Klick einloggen
        <br /><br />
        <input type="text">
        <button class="btn">Suchen</button>
        <br /><br />
        <div class="search-result-container"></div>
    </div>

{/block}
