
{* set our namespace *}
{namespace name="frontend/ost-consultant/erp-customer-search"}



{* do we even have customers? *}
{if $customers|@count > 0 }

    <table class="ost-consultant--erp-customer-search--search-result">
        <thead>
        <tr>
            <td>Kunde</td>
            <td>Straße / Nr.</td>
            <td>PLZ</td>
            <td>Wohnort</td>
            <td></td>
        </tr>
        </thead>
        <tbody>

        {foreach $customers as $customer}

            <tr class="customer"
                data-firstname="{$customer->getFirstname()|trim}"
                data-lastname="{$customer->getLastname()|trim}"
                data-salutation="{if $customer->getSalutation() == "01"}ms{else}mr{/if}"
                data-phone="{$customer->getPhone()|trim}"
                data-street="{$customer->getStreet()|trim}"
                data-zipcode="{$customer->getZip()|trim}"
                data-city="{$customer->getCity()|trim}"
                data-country="{$customer->getCountry()|trim}"
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
                    <button class="btn">{s name='submit-customer-button'}Kunde übernehmen{/s}</button>
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
