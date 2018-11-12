
{* file to extend *}
{extends file="parent:frontend/index/index.tpl"}

{* set our namespace *}
{namespace name="frontend/ost-consultant/index/index"}



{* ... *}
{block name='frontend_index_body_classes'}{strip}{$smarty.block.parent} {action module="widgets" controller="OstConsultant" action="getBodyTag"}{/strip}{/block}






{block name='frontend_index_before_page'}

    {$smarty.block.parent}

    <div class="ost-consultant--badge" style="">VERKÄUEFER</div>


{/block}