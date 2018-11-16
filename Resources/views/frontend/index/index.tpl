
{* file to extend *}
{extends file="parent:frontend/index/index.tpl"}

{* set our namespace *}
{namespace name="frontend/ost-consultant/index/index"}






{* append our javascript *}
{block name='frontend_index_header_javascript_jquery'}


        {* our plugin configuration *}
        <script type="text/javascript">

            {* javascript variables *}
            var ostConsultantConfiguration = {



                baseUrl:       '{url controller="index"}',
                loginUrl:       '{url controller="OstConsultant" action="login"}',
                logoutUrl:       '{url controller="OstConsultant" action="logout"}',
                customerSearchUrl:       '{url controller="OstConsultant" action="customerSearch"}',
                erpCustomerSearchUrl:       '{url controller="OstConsultant" action="erpCustomerSearch"}',
            };

        </script>



    {* smarty parent *}
    {$smarty.block.parent}

{/block}




{* ... *}
{block name='frontend_index_body_classes'}{strip}{$smarty.block.parent} {action module="widgets" controller="OstConsultant" action="getBodyTag"}{/strip}{/block}






{block name='frontend_index_before_page'}

    {$smarty.block.parent}




    {action module="widgets" controller="OstConsultant" action="getBadge"}

{/block}