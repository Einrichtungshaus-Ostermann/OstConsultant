
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

{/block}



{* add table actions *}
{block name='frontend_checkout_confirm_product_table_content'}

    {* add parent *}
    {$smarty.block.parent}

    <div class="panel has--border ost-consultant--advance-payment--container">

        <div class="panel--body is--rounded">
            <div class="table--header block-group">
                <div class="panel--th column--product block">
                    Anzahlung
                </div>
            </div>
            <div class="table--tr block-group row--product is--last-row">
                Möchten Sie eine Anzahlung leisten?
                <br />
                <input type="text" data-ost-consultant-advance-payment-input="true" style="width: 150px;" disabled/>
                <button class="btn" data-ost-consultant-advance-payment-button="true">Anzahlung</button>
            </div>
        </div>
    </div>

{/block}