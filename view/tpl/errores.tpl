<div class="editor">

{if $men}
    {$men.texto}
{/if}

    <div class="da-panel">

        <div class="da-panel-header">
            <span class="da-panel-title">
                Errores
            </span>
        </div>


        <div class="da-panel-content">

            <form action="index.php" method="post" class="da-form">
                <input type="hidden" name="action" value="buscar-errores"/>


                <div class="da-form-row">

                    Desde
                    <input type="text" id="from" name="from" class="peque" value="{$from}"/>
                    Hasta
                    <input type="text" id="to" name="to" class="peque" value="{$to}"/>

                    <input type="submit" value="Buscar" class="da-button gray"/>

                </div>

                <div class="da-form-row">
                {foreach from=$errores item=e}
                    {if $e.ind==2}
                        <div class="da-form-row">
                            <label>Dominio: </label><label style="padding-left: 0px">{$e.value}</label>
                        </div>
                    {/if}
                    {if $e.ind==3}
                        <div class="da-form-row">
                            <label>Interceptos:</label> <label style="padding-left: 0px">{$e.value}</label>
                        </div>
                    {/if}
                    {if $e.ind==4}
                        <div class="da-form-row">
                            <label>Signos:</label> <label style="padding-left: 0px">{$e.value}</label>
                        </div>
                    {/if}
                    {if $e.ind==5}
                        <div class="da-form-row">
                            <label>Asíntotas:</label> <label style="padding-left: 0px">{$e.value}</label>
                        </div>
                    {/if}
                    {if $e.ind==6}
                        <div class="da-form-row">
                            <label>Extremos:</label> <label style="padding-left: 0px">{$e.value}</label>
                        </div>
                    {/if}
                    {if $e.ind==7}
                        <div class="da-form-row">
                            <label>Monotonía:</label> <label style="padding-left: 0px">{$e.value}</label>
                        </div>
                    {/if}
                    {if $e.ind==8}
                        <div class="da-form-row">
                            <label>Inflexión:</label> <label style="padding-left: 0px">{$e.value}</label>
                        </div>
                    {/if}
                    {if $e.ind==9}
                        <div class="da-form-row">
                            <label>Concavidad y Convexidad:</label> <label style="padding-left: 0px">{$e.value}</label>
                        </div>
                    {/if}
                    {if $e.ind==1}
                        <div class="da-form-row">
                            <label>Gráfico a la función:</label> <label style="padding-left: 0px">{$e.value}</label>
                        </div>
                    {/if}


                {/foreach}
                </div>


            </form>

        </div>


    </div>


</div>