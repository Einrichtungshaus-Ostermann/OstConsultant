
{* file to extend *}
{extends file="parent:frontend/register/login.tpl"}

{* set our namespace *}
{namespace name="frontend/ost-consultant/register/login"}





{* replace login *}
{block name='frontend_register_login_customer_title'}
    <h2 class="panel--title is--underline">Ich bin bereits Kunde</h2>
{/block}



{block name='frontend_register_login_form'}


    Hier Kunde suchen und per Klick einloggen
    <br /><br />

    <input type="text">
    <br /><br />

    Eike Brandt-Warneke<br />
    Irgendeine Straße 123<br />
    12345 Stadt<br />
    Deutschland<br /><br />







<form name="sLogin" method="post" action="{url controller="OstConsultant" action="customerLogin"}" id="login--form">



    <input type="hidden" name="email" value="asdasd@asdasdasd.de"/>
    <input type="hidden" name="passwordMD5" value='$2y$10$JemMl0006gX/Hq8m0Eqsq.Q1SPmuLLX3oUc8jMjYq4Vk2HLCiD8uy'/>



    <button type="submit" class="register--login-btn btn is--primary is--large" name="Submit">Login</button>


</form>

{/block}
