
{* file to extend *}
{extends file="parent:frontend/checkout/confirm.tpl"}

{* set namespace *}
{namespace name="frontend/ost-consultant/checkout/confirm"}



{* add our custom js *}
{block name="frontend_checkout_confirm_tos_panel"}

    {* prepend parent *}
    {$smarty.block.parent}

    {* hidden fields *}
    <input type="hidden" id="ost-consultant--advance-payment" name="ost-consultant--advance-payment" value="0">
    <input type="hidden" id="ost-consultant--customer-notification-type" name="ost-consultant--customer-notification-type" value="">
    <input type="hidden" id="ost-consultant--pickup-date" name="ost-consultant--pickup-date" value="{$smarty.now|date_format:"%d.%m.%Y"}">

{/block}



{* add table actions *}
{block name='frontend_checkout_confirm_product_table_content'}

    {* add parent *}
    {$smarty.block.parent}

    <div class="panel has--border ost-consultant--pick-up-date--container">
        <div class="panel--body is--rounded">
            <div class="table--header block-group">
                <div class="panel--th column--product block">
                    Abholdatum
                </div>
            </div>
            <div class="table--tr block-group row--product is--last-row">
                <div class="btn date-selection" data-ost-consultant-pickup-date="true">{$smarty.now|date_format:"%d.%m.%Y"}</div>
            </div>
        </div>
    </div>

    <div class="panel has--border ost-consultant--advance-payment--container" data-amount="{if $sAmountWithTax && $sUserData.additional.charge_vat}{$sAmountWithTax}{else}{$sAmount}{/if}">
        <div class="panel--body is--rounded">
            <div class="table--header block-group">
                <div class="panel--th column--product block">
                    Anzahlung
                </div>
            </div>
            <div class="table--tr block-group row--product is--last-row">
                <input type="text" data-ost-consultant-advance-payment-input="true" disabled/>
                <button class="btn" data-ost-consultant-advance-payment-button="true">Anzahlung</button>
            </div>
        </div>
    </div>

    <div class="panel has--border ost-consultant--customer-notification-type--container">
        <div class="panel--body is--rounded">
            <div class="table--header block-group">
                <div class="panel--th column--product block">
                    Benachrichtigungsart
                </div>
            </div>
            <div class="table--tr block-group row--product is--last-row">
                <select data-ost-consultant-customer-notification-type-select="true">
                    {foreach $ostConsultantCustomerNotificationTypes as $key => $name}
                        <option value="{$key}"{if $name@iteration == 1} selected{/if}>{$name}</option>
                    {/foreach}
                </select>
            </div>
        </div>
    </div>

{/block}