
{* file to extend *}
{extends file="parent:frontend/index/index.tpl"}

{* set our namespace *}
{namespace name="frontend/ost-consultant/dashboard"}



{* remove left sidebar *}
{block name='frontend_index_content_left'}{/block}



{* main content *}
{block name='frontend_index_content'}

    <div class="content content--ost-consultant">
        <button class="is--button" data-ost-consultant-dashboard="home">Startseite</button>
        <br />
        <button class="is--button" data-ost-consultant-dashboard="account">Kundenkonto</button>
        <br />
        <button class="is--button" data-ost-consultant-dashboard="cart">Warenkorb</button>
        <br />
        <button class="is--button" data-ost-consultant-dashboard="qr">QR Scan</button>
        <br />
        <button class="is--button" data-ost-consultant-dashboard="search">Artikelsuche</button>
        <br />
        <button class="is--button" data-ost-consultant-dashboard="logout">Logout</button>
        <br />
        <button class="is--button" data-ost-consultant-dashboard="login">Login</button>
        <br />
        <button class="is--button" data-ost-consultant-dashboard="calculator">Taschenrechner</button>
        <br />
        <button class="is--button" data-ost-consultant-dashboard="calendar">Kalender</button>
        <br />
        <button class="is--button" data-ost-consultant-dashboard="mailer">Mailer</button>
        <br />
        <button class="is--button" data-ost-consultant-dashboard="reset">Reset</button>
        <br />
        <a class="btn" href="/OstArticleSearch/search">Artikelsuche</a>
    </div>

{/block}
