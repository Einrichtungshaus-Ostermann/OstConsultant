

{foreach $customers as $customer}




    <div class="customer"
        data-firstname="{$customer->getFirstname()}"
         data-lastname="{$customer->getLastname()}"

         data-salutation="{if $customer->getSalutation() == "01"}ms{else}mr{/if}"

         data-phone="{$customer->getPhone()}"
         data-street="{$customer->getStreet()}"
         data-zipcode="{$customer->getZip()}"
         data-city="{$customer->getCity()}"


    >


        {$customer->getFirstname()} {$customer->getLastname()}


        <button>Übernehmen</button>


    </div>




    {foreachelse}

    Es wurden keine Kunden gefunden.

{/foreach}