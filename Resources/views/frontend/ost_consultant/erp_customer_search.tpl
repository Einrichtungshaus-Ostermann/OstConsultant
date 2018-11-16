




{if $customers|@count > 0 }




    <style>

        table {
            width: 100%;
            margin-top: 20px;
        }

        table tr td {
            width: 20%;
        }

        table tr td:nth-child(1), table tr td:nth-child(2) {
            width: 27.5%;
        }

        table tr td:nth-child(3), table tr td:nth-child(4), table tr td:nth-child(5) {
            width: 15%;
        }

        table tr td:nth-child(5) {
            text-align: center;
        }


    </style>



<table>
    <thead>
    <tr>
        <td>Kunde</td>
        <td>Anschrift</td>
        <td>PLZ</td>
        <td>Stadt</td>
        <td></td>


    </tr>
    </thead>
    <tbody>



    {foreach $customers as $customer}

    <tr class="customer"
        data-firstname="{$customer->getFirstname()}"
        data-lastname="{$customer->getLastname()}"

        data-salutation="{if $customer->getSalutation() == "01"}ms{else}mr{/if}"

        data-phone="{$customer->getPhone()}"
        data-street="{$customer->getStreet()}"
        data-zipcode="{$customer->getZip()}"
        data-city="{$customer->getCity()}"
        data-country="{$customer->getCountry()}"
    >

        <td>


            {if $customer->getSalutation() == "01"}Frau{else}Herr{/if}

            {$customer->getFirstname()} {$customer->getLastname()}

        </td>


        <td>

            {$customer->getStreet()}

        </td>

        <td>

            {$customer->getZip()}


        </td>


        <td>

            {$customer->getCity()}


        </td>


        <td>


            <button class="btn">Übernehmen</button>


        </td>



    </tr>





    {/foreach}





    </tbody>
</table>





{else}

    <div class="alert is--error is--rounded">
        <div class="alert--icon">
            <i class="icon--element icon--warning"></i>
        </div>
        <div class="alert--content">
            Es wurden keine Kunden zu Ihrem Suchbegriff gefunden.
        </div>
    </div>
{/if}


