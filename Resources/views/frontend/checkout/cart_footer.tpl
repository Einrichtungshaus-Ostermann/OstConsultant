
{* file to extend *}
{extends file="parent:frontend/checkout/cart_footer.tpl"}

{* set namespace *}
{namespace name="frontend/ost-consultant/checkout/cart_footer"}



{* add our custom js *}
{block name="frontend_checkout_cart_footer_add_product"}

    {* add button *}
    <div class="table--tr block-group row--product ost-consultant--head-discount-container">
        <button class="btn ost-consultant--head-discount-button" data-id="0">Kopfnachlass hinzufügen</button>
    </div>

    {* prepend parent *}
    {$smarty.block.parent}

{/block}
