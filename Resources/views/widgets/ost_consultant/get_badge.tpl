
{* are we even a consultant? *}
{if $isConsultant == true}

    <div class="ost-consultant--badge" data-consultant-id="{$consultant.number}">
        Verkäufer<br />
        {$consultant.number}
    </div>

{/if}
