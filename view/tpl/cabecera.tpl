<div class="cabecera">

    <div>
        <h1><a href="index.php"> MathGraf </a></abbr></h1>
        <b>Aprende más rápido a graficar</b>
    </div>

    <div class="menu">
        <ul>
            {foreach from=$menu item=m }
                <li><a {if $m.select == $select}class="select"{/if} href="{$m.url}">{$m.texto}</a></li>
            {/foreach}
        </ul>
    </div>

</div>

<div class="sepcabecera"></div>