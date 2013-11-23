<div class="panelpasos">

<div class="da-panel">

<div class="da-panel-header">
                                	<span class="da-panel-title">
                                        Pasos a seguir...
                                    </span>

</div>


<div class="da-panel-content">
<form id="da-ex-wizard-form" class="da-form">

<fieldset class="da-form-inline" id="paso-1">

    <legend>Funci&oacute;n</legend>

    <div class="da-form-row">
        <label>Funci&oacute;n <span class="required">*</span></label>

        <div class="da-form-item large">
            <input type="text" name="funcion" id="texto-funcionnormal" class="required"/>
        </div>
    </div>

    <div class="da-form-row">
        <a class="da-button gray small button-funcion" item="normal" href="#">sen(x)</a>
        <a class="da-button gray small button-funcion" item="normal" href="#">cos(x)</a>
        <a class="da-button gray small button-funcion" item="normal" href="#">tan(x)</a>
        <a class="da-button gray small button-funcion" item="normal" href="#">log(x)</a>
        <a class="da-button gray small button-funcion" item="normal" href="#">x</a>
        <a class="da-button gray small button-potencia" item="normal" href="#">(x)^y</a>
        <a class="da-button gray small button-potencia" item="normal" href="#">y‍‍‍‍√(x)</a>

        <br>

        <a class="da-button blue small button-operador" item="normal" href="#">+</a>
        <a class="da-button blue small button-operador" item="normal" href="#">-</a>
        <a class="da-button blue small button-operador" item="normal" href="#">*</a>
        <a class="da-button blue small button-operador" item="normal" href="#">/</a>

        <a class="da-button orange small button-numero" item="normal" href="#">Numero</a>

        <br><br>
        <a class="da-button gray small button-clear" item="normal" href="#">Limpiar</a>

    </div>

</fieldset>


<fieldset class="da-form-inline" id="paso-2">

    <legend>Dominio</legend>

    <div class="da-form-row">
        <label>Dominio <span class="required">*</span> <img class="info" src="view/images/info_about.png"
                                                            style="margin-left: 10px;"
                                                            coment="Son los valores para los cuales <br>la función está definida."></label>
        <br><br><br>

        <div class="dominio-items">
            <b>x</b>
            <select class="signo-dominio" id="signo-dominio-0">
                <option> <</option>
                <option> ></option>
                <option> ≥</option>
                <option> ≤</option>
                <option> ≠</option>
                <option> =</option>
                <option> Є</option>
            </select>
            <input type="text" name="dominio" id="texto-dominio-0" class="texto-dominio required"
                   onchange="AddDominio($(this))"/>
        </div>
    </div>

</fieldset>


<fieldset class="da-form-inline" id="paso-3">

    <legend>Interceptos</legend>

    <div class="da-form-row">
        <label>Valor de Y <span class="required">*</span> = </label>

        <div class="y-items">
            <input type="text" id="paso-3-y" class="required" onchange="ProbarY($(this))"/>
            <img class="info" src="view/images/info_about.png" style="margin-left: 10px;"
                 coment="El valor de Y se obtiene<br>cuando la X en la función se hace 0.">
        </div>
        <br>
        <b id="y-paso-3-coment" style="color: orange;">hgfh</b>
    </div>

    <div class="da-form-row">
        <label>Valor(es) de X <span class="required">*</span></label> <img class="info" src="view/images/info_about.png"
                                                                           style="margin-left: 10px;"
                                                                           coment="El valor de X se obtiene<br>cuando la Y en la función se hace 0.">
        <br><br>

        <div class="x-items">
            <b>x = </b>
            <input type="text" id="paso-3-x-0" class="paso-3-x required" onchange="ProbarX($(this))"/>
        </div>
        <br>
        <b id="x-paso-3-coment" style="color: orange;"></b>
    </div>

</fieldset>

<fieldset class="da-form-inline" id="paso-4">

    <legend>Signos</legend>

    <div class="da-form-row">
        <label>Signos: <span class="required">*</span></label> <img class="info" src="view/images/info_about.png"
                                                                    style="margin-left: 10px;"
                                                                    coment="Los signos de la función se hallan<br> en los intervalos en los que no existe el dominio<br> o hay un corte con el eje X.">
        <br><br>

        <div class="signos-items">
            <b id="paso-4-signo-b-0"></b>
            <select class="signo-dominio" id="paso-4-signo-0" onchange="ProbarSigno($(this))">
                <option> ...</option>
                <option> +</option>
                <option> -</option>
            </select>
        </div>
        <br>
        <b id="paso-4-coment" style="color: orange;">hgfh</b>
    </div>

</fieldset>


<fieldset class="da-form-inline" id="paso-5">

    <legend>Asíntotas</legend>

    <div class="da-form-row">
        <label>Asíntota Horizontal Izquierda: </label>

        <div class="asintotas">
            <input type="text" id="asintota-izquierda" class="required" onchange="ProbarAsintotaIzquierda($(this))"/>
            <img class="info" src="view/images/info_about.png" style="margin-left: 10px;"
                 coment="Si el límite cuando x->-∞ tiende a un número,<br> decimos que hay asíntota horizontal por la izquierda.">
        </div>
        <br><br>
        <label>Asíntota Horizontal Derecha: </label>

        <div class="asintotas">
            <input type="text" id="asintota-derecha" class="required" onchange="ProbarAsintotaDerecha($(this))"/>
            <img class="info" src="view/images/info_about.png" style="margin-left: 10px;"
                 coment="Si el límite cuando x->+∞ tiende a un número,<br> decimos que hay asíntota horizontal por la derecha.">
        </div>
        <br><br>
        <label>Asíntotas Verticales: </label><img class="info" src="view/images/info_about.png"
                                                  style="margin-left: 10px;"
                                                  coment="Las asíntotas verticales ocurren<br> cuando la función tiende a infinito por un valor real de la variable.<br> Es decir, cuando el denominador es igual a 0."><br>

        <div class="asintotas">
            <input type="text" id="asintota-vertical-0" class="required" onchange="ProbarAsintotaVertical($(this))"/>
        </div>
        <br><br>
        <label>Asíntota Oblicua: </label>

        <div class="asintotas">
            <input type="text" id="asintota-oblicua" class="required" onchange="ProbarAsintotaOblicua($(this))"/>
            <img class="info" src="view/images/info_about.png" style="margin-left: 10px;"
                 coment="Las asíntotas oblicuas, si no son paralelas o perpendiculares a los ejes,<br> son de ecuación y=(m)*(x)+n.">
        </div>
    </div>

</fieldset>

<fieldset class="da-form-inline" id="paso-6">

    <legend>Extremos</legend>

    <div class="da-form-row">
        <label>Posibles Extremos: </label><img class="info" src="view/images/info_about.png" style="margin-left: 10px;"
                                               coment="Los extremos relativos se encuentran buscando<br> los valores por los que f '(x)=0.">

        <div class="extremos">
            <br><br>
            <b>x</b><input type="text" id="extremos-x-0" class="required"/>
            <b>y</b><input type="text" id="extremos-y-0" class="required"/>
            <select class="extremos-max-min" id="extremos-max-min-0" onchange="ProbarExtremo($(this))">
                <option> ...</option>
                <option> Máximo</option>
                <option> Mínimo</option>
            </select>
        </div>
    </div>

</fieldset>

<fieldset class="da-form-inline" id="paso-7">

    <legend>Monotonía</legend>

    <div class="da-form-row">
        <label>Monotonía: <span class="required">*</span></label> <img class="info" src="view/images/info_about.png"
                                                                       style="margin-left: 10px;"
                                                                       coment="Son los intervalos en los que la primera derivada es positiva o negativa,<br> es decir, los intervalos en los que la función crece o decrece.">
        <br><br>

        <div class="monotonia-items">
            <b id="paso-7-monotonia-b-0"></b>
            <select class="monotonia-dominio" id="paso-7-monotonia-0" onchange="ProbarMonotonia($(this))">
                <option> ...</option>
                <option> +</option>
                <option> -</option>
            </select>
        </div>
        <br>
        <b id="paso-7-coment" style="color: orange;"></b>
    </div>


</fieldset>

<fieldset class="da-form-inline" id="paso-8">

    <legend>Inflexión</legend>

    <div class="da-form-row">
        <label>Puntos de Inflexion: </label><img class="info" src="view/images/info_about.png"
                                                 style="margin-left: 10px;"
                                                 coment="Los puntos de inflexión se hallan<br> a partir de la segunda derivada f ''(x)">

        <div class="inflexion">
            <br><br>
            <b>x</b><input type="text" id="inflexion-x-0" class="required" onchange="ProbarInflexion($(this))"/>
            <b>y</b><input type="text" id="inflexion-y-0" class="required" onchange="ProbarInflexion($(this))"/>
        </div>
    </div>

</fieldset>


<fieldset class="da-form-inline" id="paso-9">

    <legend>Concavidad</legend>

    <div class="da-form-row">
        <label>Concavidad y Covexidad: <span class="required">*</span></label> <img class="info"
                                                                                    src="view/images/info_about.png"
                                                                                    style="margin-left: 10px;"
                                                                                    coment="Si f ''(x) > 0 es cóncava,<br> si f ''(x) < 0 es convexa.">
        <br><br>

        <div class="concavidadConvexidad-items">
            <b id="paso-9-concavidadConvexidad-b-0"></b>
            <select class="concavidadConvexidad-dominio" id="paso-9-concavidadConvexidad-0"
                    onchange="ProbarConcavidadConvexidad($(this))">
                <option> ...</option>
                <option> Convexa</option>
                <option> Concava</option>
            </select>
        </div>
        <br>
        <b id="paso-9-coment" style="color: orange;"></b>
    </div>

</fieldset>

<fieldset class="da-form-inline" id="paso-10">

    <legend>Graficar</legend>

    <div class="da-form-row" style="display: none;">
    <label>Función: </label> <b class="funcion-paso-x"></b>
    </div>

    <div class="da-form-row" style="display: none;">
    <label>Dominio: </label>

        <div class="dominio-paso-x"></div>
    </div>

    <div class="da-form-row" style="display: none;">
    <label>Valor de Y: </label>

        <div class="y-paso-x"></div>
        <br><br>
        <label>Valor(es) de X: </label>

        <div class="x-paso-x"></div>
    </div>

    <div class="da-form-row" style="display: none;">
    <label>Signos: </label>

        <div class="signos-paso-x"></div>
    </div>

    <div class="da-form-row" style="display: none;">
    <label>Asíntotas: </label>

        <div class="asintota-paso-x"></div>
    </div>

    <div class="da-form-row" style="display: none;">
    <label>Posibles Extremos: </label>

        <div class="extremos-paso-x"></div>
    </div>

    <div class="da-form-row" style="display: none;">
    <label>Monotonia: </label>

        <div class="monotonia-paso-x"></div>
    </div>

    <div class="da-form-row" style="display: none;">
    <label>Puntos de Inflexion: </label>

        <div class="inflexion-paso-x"></div>
    </div>

    <div class="da-form-row" style="display: none;">
    <label>Concavidad y Covexidad: </label>

        <div class="concavidadConvexidad-paso-x"></div>
    </div>

    <div class="da-form-row">
        <label>Escala: </label>

        <div class="escala">
            <b>x1: </b> <input type="text" value="" id="escx1" onchange="ValidarX1($(this))"/>
            <b>x2: </b> <input type="text" value="" id="escx2" onchange="ValidarX2($(this))"/>
        </div>
    </div>

</fieldset>

</form>
</div>


</div>


</div>