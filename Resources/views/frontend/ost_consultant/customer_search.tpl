

{foreach $customers as $customer}




    <div class="customer"

    >



        {$customer.customernumber}<br />
        {$customer.firstname} {$customer.lastname}<br />
        {$customer.street}<br />
        {$customer.zipcode} {$customer.city}<br /><br />







        <form name="sLogin" method="post" action="{url controller="OstConsultant" action="customerLogin"}" id="login--form">



            <input type="hidden" name="email" value="{$customer.email}"/>
            <input type="hidden" name="passwordMD5" value='{$customer.hashPassword}'/>



            <button type="submit" class="register--login-btn btn is--primary is--large" name="Submit">Login</button>


        </form>


    </div>




    {foreachelse}

    Es wurden keine Kunden gefunden.

{/foreach}