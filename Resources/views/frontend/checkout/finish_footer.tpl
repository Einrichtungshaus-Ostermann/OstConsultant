
{* file to extend *}
{extends file="parent:frontend/checkout/finish_footer.tpl"}

{* set namespace *}
{namespace name="frontend/ost-consultant/checkout/finish_footer"}



{* after tax information *}
{block name='frontend_checkout_cart_footer_field_labels_taxes'}

    {* prepend parent *}
    {$smarty.block.parent}

    {* do we have an advance payment? *}
    {if $ostConsultantAdvancePayment > 0}

        {* empty row for separation *}
        <li class="list--entry block-group entry--sum"><br /></li>

        {* advance payment *}
        <li class="list--entry block-group entry--sum">
            <div class="entry--label block">
                {s name="advance-payment"}Anzahlung:{/s}
            </div>
            <div class="entry--value block is--no-star">
                -{$ostConsultantAdvancePayment|currency}
            </div>
        </li>

        {* remaining sum *}
        <li class="list--entry block-group entry--total">
            <div class="entry--label block">
                {s name="remainder-amount"}Restbetrag:{/s}
            </div>
            <div class="entry--value block is--no-star">
                {if $sAmountWithTax && $sUserData.additional.charge_vat}{($sAmountWithTax - $ostConsultantAdvancePayment)|currency}{else}{($sAmount - $ostConsultantAdvancePayment)|currency}{/if}
            </div>
        </li>

    {/if}

{/block}

