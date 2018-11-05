
{* file to extend *}
{extends file="parent:frontend/register/index.tpl"}

{* set our namespace *}
{namespace name="frontend/ost-consultant/register/index"}







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




    {$smarty.block.parent}


{/block}








{* remove advantages *}
{block name='frontend_register_index_advantages'}{/block}


{* remove data protection notice *}
{block name='frontend_register_index_form_privacy'}{/block}