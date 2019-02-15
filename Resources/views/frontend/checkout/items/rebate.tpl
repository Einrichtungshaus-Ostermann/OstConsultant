
{* file to extend *}
{extends file="parent:frontend/checkout/items/rebate.tpl"}

{* set namespace *}
{namespace name="frontend/ost-consultant/checkout/items/rebate"}



{* ... *}
{block name='frontend_checkout_cart_item_rebate_total_sum'}

    {* prepend parent *}
    {$smarty.block.parent}

    {* add delete button *}
    {if $sBasketItem.ostConsultantDiscount == true}
        <div class="panel--td column--actions">
            <form action="{url module='widgets' controller='OstConsultant' action='removeDiscount' basketId=$sBasketItem.ostConsultantDiscountParentBasketId}" method="post">
                {s name="CartDiscountLinkDelete" assign="snippetCartDiscountLinkDelete"}Löschen{/s}
                <button type="submit" class="btn" title="{$snippetCartDiscountLinkDelete|escape}">
                    X
                </button>
            </form>
        </div>
    {/if}

{/block}
