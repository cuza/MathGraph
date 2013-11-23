<div class="panelpasos">
    <div class="da-panel">

        <div class="da-panel-header">
            <span class="da-panel-title">
                Escoja una función...
            </span>
        </div>

        <div class="da-panel-content">

            <form class="da-form" id="func-form">
                <div class="da-form-row">
                    {if count($funciones)==0}
                        El Profesor no ha insertado ninguna funcion.
                    {/if}
                    {foreach from=$funciones item=f}
                        <a class="da-button gray small button-funcion" item="normal" href="#"
                           onclick='GraficarFuncEstudiante("{$f.funcion}")'>{$f.desc}</a>
                    {/foreach}
                </div>

                <div class="da-form-row" id="escala-row">
                    <label>Escala: </label>

                    <div class="escala">
                        <b>x1: </b> <input type="text" value="" id="escx1" onchange="ValidarX1($(this))"/>
                        <b>x2: </b> <input type="text" value="" id="escx2" onchange="ValidarX2($(this))"/>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>