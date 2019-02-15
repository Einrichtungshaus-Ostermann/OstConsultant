
{* file to extend *}
{extends file="parent:frontend/checkout/items/product.tpl"}

{* set namespace *}
{namespace name="frontend/ost-consultant/checkout/items/product"}



{* ... *}
{block name='frontend_checkout_cart_item_delete_article'}

    <div class="panel--td column--actions">
        <button class="btn ost-consultant--discount-button" title="Nachlass geben" data-id="{$sBasketItem.id}">
            %
        </button>
        <form action="{url action='deleteArticle' sDelete=$sBasketItem.id sTargetAction=$sTargetAction}" method="post">
            {s name="CartItemLinkDelete" assign="snippetCartItemLinkDelete"}Löschen{/s}
            <button type="submit" class="btn" title="{$snippetCartItemLinkDelete|escape}">
                X
            </button>
        </form>
    </div>

{/block}
