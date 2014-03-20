var chartColours = GetColorsRandom(7);
//graph options
var options = {
    grid: {
        show: true,
        aboveData: true,
        color: "#3f3f3f",
        labelMargin: 5,
        axisMargin: 0,
        borderWidth: 0,
        borderColor: null,
        minBorderMargin: 5,
        clickable: true,
        hoverable: true,
        autoHighlight: true,
        mouseActiveRadius: 20
    },

    series: {
        grow: {active: true},
        lines: {
            show: true,
            fill: false,
            lineWidth: 2,
            steps: false
        },
        points: {
            show: true,
            radius: 4,
            symbol: "circle",
            fill: true,
            borderColor: "#fff"
        }
    },
    xaxis: {show: true},
    yaxis: {show: true},
    legend: { position: "se" },
    //colors:chartColours,
    shadowSize: 1,
    tooltip: true, //activate tooltip
    tooltipOpts: {
        content: "%s : %y.3",
        shifts: {
            x: -30,
            y: -50
        }
    }
};

$(function () {
    $(".simple-chart").bind("plothover", function (event, pos, item) {
        if (item) {
            if (previousPoint != item.dataIndex) {
                previousPoint = item.dataIndex;

                $("#tooltip").remove();
                /*var x = item.datapoint[0],
                 y = Math.round(item.datapoint[1]);*/
                var x = item.datapoint[0],
                    y = item.datapoint[1];

                var dt = new Date(x);
                showTooltip(item.pageX, item.pageY, x + " , " + y);
            }
        }
        else {
            $("#tooltip").remove();
            previousPoint = null;
        }
    });

});


$(function () {

    var v = $("#da-ex-wizard-form").validate({ onsubmit: false });
    $("#da-ex-wizard-form").daWizard({
        onLeaveStep: function (index, elem) {
            return v.form();
        },
        onBeforeSubmit: function () {
            return v.form();
        }
    });

    //para el paso entre pasos
    $(".boton-next").click(function () {
        if ($("#paso-1").css("display") == 'block') {
            IrPaso2();
        }
        if ($("#paso-2").css("display") == 'block')//quitar despues esta por gusto
        {
            IrPaso3();
        }
        if ($("#paso-3").css("display") == 'block')//quitar despues esta por gusto
        {
            IrPaso4();
        }
        if ($("#paso-4").css("display") == 'block')//quitar despues esta por gusto
        {
            IrPaso5();
        }
        if ($("#paso-5").css("display") == 'block')//quitar despues esta por gusto
        {
            IrPaso6();
        }
        if ($("#paso-6").css("display") == 'block')//quitar despues esta por gusto
        {
            IrPaso7();
        }
        if ($("#paso-7").css("display") == 'block')//quitar despues esta por gusto
        {
            IrPaso8();
        }
        if ($("#paso-8").css("display") == 'block')//quitar despues esta por gusto
        {
            IrPaso9();
        }
        if ($("#paso-9").css("display") == 'block')//quitar despues esta por gusto
        {
            $("#da-ex-wizard-form").submit(function () {
                return false;
            });
        }

    });
    $(".boton-terminar").click(function () {
        IrPaso10();
    });
});


var dominio = [];
var y = [];
var x = [];
var signos = [];
var asintotaDerecha = "";
var asintotaIzquierda = "";
var asintotasVertical = [];
var asintotaOblicua = "";
var ptosasintotaOblicua = [];
var extremos = [];
var inflexion = [];
var monotonia = [];
var concavidadConvexidad = [];
var grafico = "";
var funcionsimple = "";
function IrPaso2() {
    var funcion = $("#texto-funcionnormal").val();
    $(".funcion-paso-x").html(funcion);

    $.ajax({
        type: "POST",
        url: "index.php",
        dataType: "json",
        data: {action: 'procesar-paso-1', funcion: funcion},
        success: function (responce) {
            dominio = responce['dominio'];
            $("#funcion-paso-2-coment").html(responce['coment_dom']);
            y = responce['y'];
            x = responce['x'];
            $("#y-paso-3-coment").html(responce['coment_y']);
            $("#x-paso-3-coment").html(responce['coment_x']);
            if (x[0] == "no") {
                $("#paso-3-x-0").parent().html("Este valor se obtiene mediante métodos numéricos");
                $(".x-paso-x").html("Este valor se obtiene mediante métodos numéricos");
            }
            var dom = "";
            $.each(dominio, function (index, value) {
                dom += "<b>" + value + " </b> &nbsp&nbsp";
            });
            $(".dominio-paso-x").html(dom);

            var xs = "";
            $.each(x, function (index, value) {
                xs += "<b>" + value + " </b> &nbsp&nbsp";
            });
            $(".x-paso-x").html(xs);

            var ys = "<b>" + y + " </b>";
            if (y != "no") {
                $(".y-paso-x").html(ys);
            }
            else {
                $(".y-paso-x").html("Este valor no esta definido.");
                $("#paso-3-y").parent().prepend('Este valor no está definido.');
                $("#paso-3-y").remove();
            }


            signos = responce['signos'];
            $("#paso-4-coment").html(responce['coment_signos']);
            var sig = "";
            var sigs = "";

            if (signos[0] != "n" && signos[1] != "o") {
                $.each(signos, function (index, value) {
                    var val = value.split(" ")[0];
                    sig += "<b id='paso-4-signo-b-" + index + "'>" + val + " = </b>" +
                        "<select class='signo-dominio' id='paso-4-signo-" + index + "' onchange='ProbarSigno($(this))'>" +
                        "<option> ... </option>" +
                        "<option> + </option>" +
                        "<option> - </option>" +
                        "</select> <br>";

                    sigs += "<b>" + value + " </b> &nbsp&nbsp&nbsp";
                });
                $(".signos-items").html(sig);
                $(".signos-paso-x").html(sigs);
            }
            else {
                $("#paso-4-signo-b-0").parent().html("Este valor se obtiene mediante métodos numéricos");
                $(".signos-items").html("Este valor se obtiene mediante métodos numéricos");
                $(".signos-paso-x").html("Este valor se obtiene mediante métodos numéricos");
            }


            asintotaDerecha = responce['asintotaDerecha'];
            asintotaIzquierda = responce['asintotaIzquierda'];
            asintotasVertical = responce['asintotasVertical'];
            asintotaOblicua = responce['asintotaOblicua'];
            ptosasintotaOblicua = responce['ptosasintotaOblicua'];
            if (asintotaDerecha == "no") {
                $("#asintota-derecha").parent().prepend("No Tiene.");
                $("#asintota-derecha").remove();
                var h = "<br><br><b>Asíntota Horizontal Derecha: </b> No Tiene.";
                $(".asintota-paso-x").append(h);
            }
            else {
                var h = "<br><br><b>Asíntota Horizontal Derecha: </b>" + asintotaDerecha;
                $(".asintota-paso-x").append(h);
            }
            if (asintotaIzquierda == "no") {
                $("#asintota-izquierda").parent().prepend("No Tiene.");
                $("#asintota-izquierda").remove();
                var h = "<br><b>Asíntota Horizontal Izquierda: </b> No Tiene.";
                $(".asintota-paso-x").append(h);
            }
            else {
                var h = "<br><b>Asíntota Horizontal Izquierda: </b>" + asintotaIzquierda;
                $(".asintota-paso-x").append(h);
            }
            if (asintotasVertical.length == 0) {
                $("#asintota-vertical-0").parent().prepend("No Tiene.");
                $("#asintota-vertical-0").remove();
                var h = "<br><b>Asíntota Vertical: </b> No Tiene.";
                $(".asintota-paso-x").append(h);
            }
            else {
                var h = "<br><b>Asíntota Vertical: </b>";
                $.each(asintotasVertical, function (index, value) {
                    var coma = " ";
                    if (index != 0)
                        coma = ", ";
                    h += coma + value;
                });
                $(".asintota-paso-x").append(h);
            }
            if (asintotaOblicua == "no") {
                $("#asintota-oblicua").parent().prepend("No Tiene.");
                $("#asintota-oblicua").remove();
                var h = "<br><b>Asíntota Oblicua: </b> No Tiene.";
                $(".asintota-paso-x").append(h);
            }
            else {
                var h = "<br><b>Asíntota Oblicua: </b>" + asintotaOblicua;
                $(".asintota-paso-x").append(h);
            }

            //Para los extremos
            extremos = responce['extremos'];
            if (extremos.length == 0) {
                $("#extremos-max-min-0").parent().html("No Tiene.");
                var h = "<b>  No Tiene.</b>";
                $(".extremos-paso-x").append(h);
            }
            else {
                var h = "";
                $.each(extremos, function (index, value) {
                    var coma = " ";
                    if (index != 0)
                        coma = ",    ";
                    h += coma + value;
                });
                $(".extremos-paso-x").append(h);
            }

            //Para la inflexion
            inflexion = responce['inflexion'];

            if (inflexion.length == 0) {
                $("#inflexion-x-0").parent().html("No Tiene.");
                var h = "<b>  No Tiene.</b>";
                $(".inflexion-paso-x").append(h);
            }
            else {
                var h = "";
                $.each(inflexion, function (index, value) {
                    var coma = " ";
                    if (index != 0)
                        coma = ", ";
                    h += coma + value;
                });
                $(".inflexion-paso-x").append(h);
            }

            //Para Monotonia
            monotonia = responce['monotonia'];
            //$("#paso-7-coment").html( responce['coment_monotonia'] );
            var mon = "";
            var mons = "";

            if (monotonia != "no") {
                $.each(monotonia, function (index, value) {
                    var val = value.split(" ")[0];
                    mon += "<b id='paso-7-monotonia-b-" + index + "'>" + val + " = </b>" +
                        "<select class='monotonia-dominio' id='paso-7-monotonia-" + index + "' onchange='ProbarMonotonia($(this))'>" +
                        "<option> ... </option>" +
                        "<option> Creciente </option>" +
                        "<option> Decreciente </option>" +
                        "</select> <br>";

                    mons += "<b>" + value + " </b> &nbsp&nbsp&nbsp";
                });
                $(".monotonia-items").html(mon);
                $(".monotonia-paso-x").html(mons);
            }
            else {
                $("#paso-7-monotonia-b-0").parent().html("La monotonía es constante.");
                $(".monotonia-items").html("La monotonía es constante.");
                $(".monotonia-paso-x").html("La monotonía es constante.");
            }

            //Para concavidad y convexidad
            concavidadConvexidad = responce['concavidadConvexidad'];
            //$("#paso-7-coment").html( responce['coment_monotonia'] );
            var mon = "";
            var mons = "";

            if (concavidadConvexidad.length > 0) {
                $.each(concavidadConvexidad, function (index, value) {
                    var val = value.split(" ")[0];
                    mon += "<b id='paso-9-concavidadConvexidad-b-" + index + "'>" + val + " = </b>" +
                        "<select class='concavidadConvexidad-dominio' id='paso-9-concavidadConvexidad-" + index + "' onchange='ProbarConcavidadConvexidad($(this))'>" +
                        "<option> ... </option>" +
                        "<option> Convexa </option>" +
                        "<option> Cóncava </option>" +
                        "</select> <br>";

                    mons += "<b>" + value + " </b> &nbsp&nbsp&nbsp";
                });
                $(".concavidadConvexidad-items").html(mon);
                $(".concavidadConvexidad-paso-x").html(mons);
            }
            else {
                $("#paso-9-monotonia-b-0").parent().html("La función no es ni cóncava ni convexa.");
                $(".concavidadConvexidad-items").html("La función no es ni cóncava ni convexa.");
                $(".concavidadConvexidad-paso-x").html("La función no es ni cóncava ni convexa.");
            }


            //para la funcion ya reducida
            funcionsimple = responce['funcion'];


        }
    });
}
function IrPaso3() {
    var ok = true;
    if (inddomok.length != dominio.length) {
        ok = false;
    }
    $.each(inddomok, function (index, value) {
        if (!value)
            ok = false;
    });
    if (!ok) {
        alert('Inserte todos los valores para poder continuar');
    }
}
function IrPaso4() {
    var ok = true;
    if (inddomok.length != dominio.length) {
        ok = false;
    }
    $.each(inddomok, function (index, value) {
        if (!value)
            ok = false;
    });
    if (!ok) {
        alert('Inserte todos los valores para poder continuar');
        ;
    }
}
function IrPaso5() {
    //PintarAsintotas();
}
function IrPaso6() {
    //PintarAsintotas();
}
function IrPaso7() {
    //PintarAsintotas();
}
function IrPaso8() {
    //PintarAsintotas();
}
function IrPaso9() {
    //PintarAsintotas();
}

var xpt = [];
var ypt = [];
function IrPaso10() {
    var x1 = $('#escx1').val();
    var x2 = $('#escx2').val();

    var html = "<div id='wait'> <img src='view/images/large-loading.gif'> </div>";
    $('.graph').append(html);

    //Para buscar los valores para graficar
    $.ajax({
        type: "POST",
        url: "index.php",
        dataType: "json",
        data: {action: 'procesar-paso-2', funcion: funcionsimple, x1: x1, x2: x2, asintotaOblicua: asintotaOblicua},
        success: function (responce) {


            //para la asintota oblicua
            ptosasintotaOblicua = responce['ptosasintotaOblicua'];

            //para el grafico
            grafico = responce['grafico'];


            $('#wait').remove();

            Graficar(grafico);

        }
    });


}

//Para ver si dominio esta bien
var iddom = 0;
function AddDominio(obj) {
    var id = obj.attr("id").split("-")[2];
    if (obj.valid() && id == iddom) {
        if (DominioOk(id)) {
            iddom++;
            var html = "<div class='dominio-items'>  " +
                "<b>x</b>                 " +
                "<select class='signo-dominio' id='signo-dominio-" + iddom + "'>    " +
                "<option> < </option>                " +
                "<option> > </option>          " +
                "<option> ≥ </option>          " +
                "<option> ≤ </option>          " +
                "<option> ≠ </option>        " +
                "<option> = </option>         " +
                "<option> Є </option>         " +
                "</select>                     " +
                "<input type='text' name='dominio' id='texto-dominio-" + iddom + "' class='texto-dominio required' onchange='AddDominio($(this))'  />    " +
                "</div>";


            var ok = true;
            $.each(inddomok, function (index, value) {
                if (!value || inddomok.length != dominio.length) {
                    ok = false;
                }
            });
            if (!ok)
                obj.parent().after(html);
            obj.parent().remove();
        }
        else {
            obj.val("");
            MarcarError(2);
            alert("Dominio Incorrecto.");
        }
    }
}

var inddomok = [];

function DominioOk(id) {
    var r = false;
    var dom = "x " + $("#signo-dominio-" + id).val().trim() + " " + $("#texto-dominio-" + id).val().toUpperCase();

    $.each(dominio, function (index, value) {
        if (dom == value && !inddomok[index]) {
            r = true;
            inddomok[index] = true;
            var html = "<b> x " + $("#signo-dominio-" + id).val() + " " + $("#texto-dominio-" + id).val().toUpperCase() + " </b><br>";
            $("#signo-dominio-" + id).parent().before(html);
        }
    });
    return r;
}

function showTooltip(x, y, contents) {
    $('<div id="tooltip">' + contents + '</div>').css({
        position: 'absolute',
        display: 'none',
        top: y + 5,
        left: x + 5,
        padding: '4px',
        color: "#ffffff",
        'background-color': '#000',
        opacity: 0.75,
        'border-radius': '3px'
    }).appendTo("body").fadeIn(200);
}

function GetColorsRandom(cant) {
    var col = ["#edc240", "#afd8f8", "#cb4b4b", "#4da74d", "#9440ed"];

    // produce colors as needed
    var colors = [], variation = 0;
    i = 0;
    while (colors.length < cant) {
        var c;
        if (col.length == i) // check degenerate case
            c = $.color.make(100, 100, 100);
        else
            c = $.color.parse(col[i]);

        // vary color if needed
        var sign = variation % 2 == 1 ? -1 : 1;
        c.scale('rgb', 1 + sign * Math.ceil(variation / 2) * 0.2)

        // FIXME: if we're getting to close to something else,
        // we should probably skip this one
        colors.push(c);

        ++i;
        if (i >= col.length) {
            i = 0;
            ++variation;
        }
    }
    return colors;
}


var operador = [];
operador['normal'] = '';
operador['dialog'] = '';


$(function () {

//metodo para agregar las funciones
    $(".button-funcion").click(function () {
        BotonFuncion($(this));
    });

    function BotonFuncion(obj) {
        var item = obj.attr("item");

        var text = $("#texto-funcion" + item).val();
        var boton = obj.text();

        if (text != '') {
            if (operador[item] != '') {
                var op = operador[item];
                if (op == '/' || op == '*') {
                    text = Invertir(text);
                    text = text.replace(op, ")");
                    text = Invertir(text);
                    $("#texto-funcion" + item).val("(" + text + op + "(" + boton + ")");
                }
                else {
                    $("#texto-funcion" + item).val(text + boton);
                }

            }
            else {
                boton = boton.replace('x', text);
                $("#texto-funcion" + item).val(boton);
            }
        }
        else {
            $("#texto-funcion" + item).val(boton);
        }

        operador[item] = '';
    }


    //metodo para hacer negativa o positiva la funcion
    $(".button-signo").click(function () {
        BotonSigno($(this));
    });

    function BotonSigno(obj) {
        var item = obj.attr("item");

        var text = $("#texto-funcion" + item).val();
        var boton = '';
        if (text != '') {
            if (operador[item] != '') {
                $("#texto-funcion" + item).val(text);
            }
            else {
                if (text[0] != '-') {
                    boton = '-(x)';
                    boton = boton.replace('x', text);
                }
                else {
                    var aux = '';
                    for (var i = 2; i <= text.length - 2; i++) {
                        aux += text[i];
                    }
                    boton = aux;
                }
                $("#texto-funcion" + item).val(boton);
            }
        }
        else {
            $("#texto-funcion" + item).val(boton);
        }
    }

//metodo para poner operadores
    $(".button-operador").click(function () {
        BotonOperador($(this));
    });

    function BotonOperador(obj) {
        var item = obj.attr("item");

        var text = $("#texto-funcion" + item).val();
        var boton = obj.text();
        if (text != '') {
            if (operador[item] != '') {
                if (boton == text[text.length - 1]) {
                    var aux = '';
                    for (var i = 0; i <= text.length - 2; i++) {
                        aux += text[i];
                    }
                    text = aux;
                    operador[item] = "";
                }
                else {
                    text = Invertir(text);
                    text = text.replace(operador[item], boton);
                    text = Invertir(text);
                    operador[item] = boton;
                }
                $("#texto-funcion" + item).val(text);
            }
            else {
                $("#texto-funcion" + item).val(text + boton);
                operador[item] = boton;
            }
        }
    }

//metodo para agregar numeros a la funcion
    $(".button-numero").click(function () {
        BotonNumero($(this));
    });

    function BotonNumero(obj) {
        var item = obj.attr("item");

        if (item == "normal") {
            if (operador[item] != '') {
                var num = prompt("Escriba un numero");
                num = parseFloat(num);
                if (!isNaN(num) && num > 0) {
                    if (operador[item] != '') {
                        var text = $("#texto-funcion" + item).val();
                        if (operador[item] == "/") {
                            text = Invertir(text);
                            text = text.replace(operador[item], ')');
                            text = Invertir(text);
                            $("#texto-funcion" + item).val('(' + text + operador[item] + "(" + num + ")");
                        }
                        else {
                            $("#texto-funcion" + item).val(text + num);
                        }


                        operador[item] = '';
                    }
                }
                else alert('Debe escribir un numero positivo.');
            }
        }
        else {
            if ($("#texto-funcion" + item).val() != "") {
                if (operador[item] != '') {
                    var num = prompt("Escriba un numero");
                    num = parseFloat(num);
                    if (!isNaN(num) && num > 0) {
                        var text = $("#texto-funcion" + item).val();
                        if (operador[item] == "/") {
                            text = Invertir(text);
                            text = text.replace(operador[item], ')');
                            text = Invertir(text);
                            $("#texto-funcion" + item).val('(' + text + operador[item] + "(" + num + ")");
                        }
                        else {
                            $("#texto-funcion" + item).val(text + num);
                        }


                        operador[item] = '';
                    }
                    else {
                        alert('Debe escribir un numero positivo.');
                    }
                }
            }
            else {
                var num = prompt("Escriba un numero");
                num = parseFloat(num);
                if (!isNaN(num) && num > 0) {
                    var text = $("#texto-funcion" + item).val();
                    if (operador[item] == "/") {
                        text = Invertir(text);
                        text = text.replace(operador[item], ')');
                        text = Invertir(text);
                        $("#texto-funcion" + item).val('(' + text + operador[item] + "(" + num + ")");
                    }
                    else {
                        $("#texto-funcion" + item).val(text + num);
                    }
                }
                else {
                    alert('Debe escribir un numero positivo.');
                }

            }
        }
    }


    //metodo
    $(".button-potencia").click(function () {

        var obj = $(this);
        $("#texto-funciondialog").val("");

        $("#dialog-funcion").dialog({
            autoOpen: false,
            title: 'Escoja Función',
            modal: true,
            width: '640',
            buttons: [
                {
                    text: 'Aceptar',
                    click: function () {
                        Potencia(obj);
                        $(this).dialog('close');
                    }
                },
                {
                    text: 'Cerrar',
                    click: function () {
                        $(this).dialog('close');
                    }
                }

            ]

        }).dialog('open');
    });

    function Potencia(obj) {
        var item = obj.attr("item");

        var num = $("#texto-funciondialog").val();
        var text = $("#texto-funcionnormal").val();
        var boton = obj.text();
        boton = boton.replace('y', '(' + num + ')');

        if (text != '') {

            if (operador[item] != '') {
                if (operador["normal"] == "/") {
                    text = Invertir(text);
                    text = text.replace("/", ")");
                    text = Invertir(text);
                    $("#texto-funcionnormal").val("(" + text + "/(" + boton + ")");
                }
                else
                    $("#texto-funcionnormal").val(text + boton);
            }
            else {

                if (obj.text() == "(x)^y") {
                    boton = boton.replace('x', text);
                    $("#texto-funcionnormal").val(boton);
                }
                else {
                    boton = Invertir(boton);
                    text = Invertir(text);
                    boton = boton.replace('x', text);
                    boton = Invertir(boton);
                    $("#texto-funcionnormal").val(boton);
                }


            }
        }
        else {
            $("#texto-funcionnormal").val(boton);
        }

        operador[item] = '';
    }


    $(".button-clear").click(function () {

        var item = $(this).attr("item");

        $("#texto-funcion" + item).val("");
    });

//para no permitir que peguen o escriban en el textbox
    /*$("#texto-funcionnormal,#texto-funciondialog").bind('keypress mousedown',function(){
     return false;
     });  */

});

//invierte una cadena
function Invertir(text) {
    var aux = '';
    for (var i = text.length - 1; i >= 0; i--) {
        aux += text[i];
    }
    return aux;
}


//Para ver si x esta bien
var idx = 0;
function ProbarX(obj) {
    var id = obj.attr("id").split("-")[3];
    if (obj.valid() && id == idx) {
        if (!isNaN(parseInt(obj.val())) || obj.val() == "-INF" || obj.val() == "INF") {
            if (XOk(id)) {
                idx++;
                var html = "<div class='x-items'>  " +
                    "<b>x = </b>                 " +
                    "<input type='text' id='paso-3-x-" + idx + "' class='paso-3-x required' onchange='ProbarX($(this))'  />    " +
                    "</div>";

                var ok = true;
                $.each(indxok, function (index, value) {
                    if (!value || indxok.length != x.length) {
                        ok = false;
                    }
                });
                if (!ok)
                    obj.parent().after(html);
                obj.parent().remove();

                xpt.push([parseInt(obj.val()), 0]);
            }
            else {
                MarcarError(3);
                alert("X Incorrecta.");
                obj.val("");
            }
        }
        else {
            obj.val("");
        }
    }

    PintarXY();
}

var indxok = [];
function XOk(id) {
    var r = false;
    var xaux = "x = " + $("#paso-3-x-" + id).val();
    $.each(x, function (index, value) {
        if (xaux == value && !indxok[index]) {
            r = true;
            indxok[index] = true;
            var html = "<b> x = " + $("#paso-3-x-" + id).val() + " </b><br>";
            $("#paso-3-x-" + id).parent().before(html);
        }
    });
    return r;
}


//Para ver si y esta bien
function ProbarY(obj) {
    if (obj.valid()) {
        if (!isNaN(parseInt(obj.val())) || obj.val() == "-INF" || obj.val() == "INF") {

            if (y == obj.val()) {
                var html = "<b>" + y + " </b>";
                obj.parent().prepend(html);
                obj.remove();

                ypt.push([0, y]);
            }
            else {
                MarcarError(3);
                alert("Y Incorrecta.");
                obj.val("");
            }
        }
        else {
            obj.val("");
        }
    }

    PintarXY();
}


function PintarXY() {
    var arr = [];
    for (var i = 0; i < xpt.length; i++) {
        arr.push([xpt[i][0], 0]);
    }
    if (ypt[0])
        arr.push([0, ypt[0][1]]);
    draw([
        {
            label: "",
            data: arr,
            lines: {fillColor: "#f2f7f9", show: false},
            points: {fillColor: "#88bbc8"}
        }
    ]);
}


//Para ver si signo esta bien
function ProbarSigno(obj) {
    var id = obj.attr("id").split("-")[3];
    if (obj.valid()) {
        if (SignoOk(id, obj)) {
            $("#paso-4-signo-b-" + id).html($("#paso-4-signo-b-" + id).html() + obj.val());
            obj.remove();
        }
        else {
            MarcarError(4);
            alert("Signo Incorrecto.");
        }
    }
}

function SignoOk(id, obj) {
    var r = false;
    var val = signos[id].split(" ")[1];
    if (val == obj.val())
        var r = true;
    return r;
}


//Para ver si asintotas esta bien
function ProbarAsintotaIzquierda(obj) {
    if (obj.valid()) {
        if (!isNaN(parseInt(obj.val()))) {

            if (asintotaIzquierda == obj.val()) {
                var html = "<b>" + asintotaIzquierda + " </b>";
                obj.parent().prepend(html);
                obj.remove();
            }
            else {
                MarcarError(5);
                alert("Asintota Incorrecta.");
                obj.val("");
            }
        }
        else {
            obj.val("");
        }
    }

    PintarAsintotas();
}

function ProbarAsintotaDerecha(obj) {
    if (obj.valid()) {
        if (!isNaN(parseInt(obj.val()))) {

            if (asintotaDerecha == obj.val()) {
                var html = "<b>" + asintotaDerecha + " </b>";
                obj.parent().prepend(html);
                obj.remove();
            }
            else {
                MarcarError(5);
                alert("Asintota Incorrecta.");
                obj.val("");
            }
        }
        else {
            obj.val("");
        }
    }

    PintarAsintotas();
}

//Para ver si asintota vertical esta bien
var idasintotavertical = 0;
function ProbarAsintotaVertical(obj) {
    var id = obj.attr("id").split("-")[2];
    if (obj.valid() && id == idasintotavertical) {
        if (!isNaN(parseInt(obj.val()))) {
            if (AsintotaVerticalOk(id)) {
                idasintotavertical++;
                var html = "<div class='asintotas'>  " +
                    "<input type='text' id='asintota-vertical-" + idasintotavertical + "' class='required' onchange='ProbarAsintotaVertical($(this))'  />    " +
                    "</div>";

                var ok = true;
                $.each(indasintotaverticalok, function (index, value) {
                    if (!value || indasintotaverticalok.length != asintotasVertical.length) {
                        ok = false;
                    }
                });
                if (!ok)
                    obj.parent().after(html);
                obj.parent().remove();
            }
            else {
                MarcarError(5);
                alert("Asintota Vertical Incorrecta.");
                obj.val("");
            }
        }
        else {
            obj.val("");
        }
    }

    PintarAsintotas();
}

var indasintotaverticalok = [];
function AsintotaVerticalOk(id) {
    var r = false;
    var aux = $("#asintota-vertical-" + id).val();

    $.each(asintotasVertical, function (index, value) {
        if (aux == value && !indasintotaverticalok[index]) {
            r = true;
            indasintotaverticalok[index] = true;
            var html = "<b>" + $("#asintota-vertical-" + id).val() + " </b><br>";
            $("#asintota-vertical-" + id).parent().before(html);
        }
    });
    return r;
}

function ProbarAsintotaOblicua(obj) {
    if (obj.valid()) {
        if (asintotaOblicua == obj.val()) {
            var html = "<b>" + asintotaOblicua + " </b>";
            obj.parent().prepend(html);
            obj.remove();
        }
        else {
            MarcarError(5);
            alert("Asintota Incorrecta.");
            obj.val("");
        }
    }

    PintarAsintotas();
}

//Para ver si asintota vertical esta bien
var idextremo = 0;
function ProbarExtremo(obj) {
    var id = obj.attr("id").split("-")[3];

    if ($("#extremos-x-" + id).valid() && $("#extremos-y-" + id).valid() && id == idextremo) {
        if (!isNaN(parseFloat($("#extremos-x-" + id).val())) && !isNaN(parseFloat($("#extremos-y-" + id).val()))) {
            if (ExtremoOk(id)) {
                idextremo++;
                var html = "<div class='extremos'>  " +
                    "<br><br>" +
                    "<b>x</b><input type='text' id='extremos-x-" + idextremo + "' class='required' />" +
                    "<b>y</b><input type='text' id='extremos-y-" + idextremo + "' class='required' />" +
                    "<select class='extremos-max-min' id='extremos-max-min-" + idextremo + "' onchange='ProbarExtremo($(this))'>" +
                    "<option> ... </option>" +
                    "<option> Máximo </option>" +
                    "<option> Mínimo </option>" +
                    "</select>" +
                    "</div>";

                var ok = true;
                $.each(idextremook, function (index, value) {
                    if (!value || idextremook.length != extremos.length) {
                        ok = false;
                    }
                });
                if (!ok)
                    obj.parent().after(html);
                obj.parent().remove();
            }
            else {
                MarcarError(6);
                alert("Extremo Incorrecto.");
                obj.val("");
                $("#extremos-x-" + id).val("");
                $("#extremos-y-" + id).val("");
            }
        }
        else {
            obj.val("");
            $("#extremos-x-" + id).val("");
            $("#extremos-y-" + id).val("");
        }
    }

    PintarExtremos();
}

var idextremook = [];
function ExtremoOk(id) {
    var r = false;
    var xaux = parseFloat($("#extremos-x-" + id).val());
    var yaux = parseFloat($("#extremos-y-" + id).val());
    var maxmin = $("#extremos-max-min-" + id).val();

    $.each(extremos, function (index, value) {
        var arr = value.split(" ");
        var maxmin1 = arr[1];
        arr = arr[0].split(",");
        var xaux1 = parseFloat(arr[0]);
        var yaux1 = parseFloat(arr[1]);
        if (maxmin == maxmin1 && xaux == xaux1 && yaux == yaux1 && !idextremook[index]) {
            r = true;
            idextremook[index] = true;
            var html = "<br><br><b>" + xaux + "," + yaux + " " + maxmin + "</b>";
            $("#extremos-max-min-" + id).parent().before(html);
        }
    });
    return r;
}


var idinflexion = 0;
function ProbarInflexion(obj) {
    var id = obj.attr("id").split("-")[2];

    if ($("#inflexion-x-" + id).valid() && $("#inflexion-y-" + id).valid() && id == idinflexion) {
        if (!isNaN(parseFloat($("#inflexion-x-" + id).val())) && !isNaN(parseFloat($("#inflexion-y-" + id).val()))) {
            if (InflexionOk(id)) {
                idinflexion++;
                var html = "<div class='extremos'>  " +
                    "<br><br>" +
                    "<b>x</b><input type='text' id='inflexion-x-" + idinflexion + "' class='required' onchange='ProbarInflexion($(this))' />" +
                    "<b>y</b><input type='text' id='inflexion-y-" + idinflexion + "' class='required' onchange='ProbarInflexion($(this))' />" +
                    "</div>";

                var ok = true;
                $.each(idinflexook, function (index, value) {
                    if (!value || idinflexook.length != inflexion.length) {
                        ok = false;
                    }
                });
                if (!ok)
                    obj.parent().after(html);
                obj.parent().remove();
            }
            else {
                MarcarError(8);
                alert("Punto de Inflexión Incorrecto.");
                obj.val("");
                $("#inflexion-x-" + id).val("");
                $("#inflexion-y-" + id).val("");
            }
        }
        else {
            obj.val("");
            $("#inflexion-x-" + id).val("");
            $("#inflexion-y-" + id).val("");
        }
    }
    PintarInflexion();
}

var idinflexook = [];
function InflexionOk(id) {
    var r = false;
    var xaux = parseFloat($("#inflexion-x-" + id).val());
    var yaux = parseFloat($("#inflexion-y-" + id).val());

    $.each(inflexion, function (index, value) {
        var arr = value.split(",");
        var xaux1 = parseFloat(arr[0]);
        var yaux1 = parseFloat(arr[1]);
        if (xaux == xaux1 && yaux == yaux1 && !idinflexook[index]) {
            r = true;
            idinflexook[index] = true;
            var html = "<br><br><b>" + xaux + "," + yaux + "</b>";
            $("#inflexion-x-" + id).parent().before(html);
        }
    });
    return r;
}


//Para ver si signo esta bien
function ProbarMonotonia(obj) {
    var id = obj.attr("id").split("-")[3];
    if (obj.valid()) {
        if (MonotoniaOk(id, obj)) {
            $("#paso-7-monotonia-b-" + id).html($("#paso-7-monotonia-b-" + id).html() + obj.val());
            obj.remove();
        }
        else {
            MarcarError(7);
            alert("Monotonia Incorrecta.");
        }
    }
}

function MonotoniaOk(id, obj) {
    var r = false;
    var val = monotonia[id].split(" ")[1];
    if (val == obj.val())
        var r = true;
    return r;
}


function ProbarConcavidadConvexidad(obj) {
    var id = obj.attr("id").split("-")[3];
    if (obj.valid()) {
        if (ConcavidadConvexidadOk(id, obj)) {
            $("#paso-9-concavidadConvexidad-b-" + id).html($("#paso-9-concavidadConvexidad-b-" + id).html() + obj.val());
            obj.remove();
        }
        else {
            MarcarError(9);
            alert("Incorrecto.");
        }
    }
}

function ConcavidadConvexidadOk(id, obj) {
    var r = false;
    var val = concavidadConvexidad[id].split(" ")[1];
    if (val == obj.val())
        var r = true;
    return r;
}


//Funciones para pintar

function DevAsintotas() {
    var curvas = [];

    //para los interceptos
    var arr = [];
    for (var i = 0; i < xpt.length; i++) {
        arr.push([xpt[i][0], 0]);
    }
    if (ypt[0])
        arr.push([0, ypt[0][1]]);

    curvas.push({
        label: "",
        data: arr,
        lines: {show: false},
        points: {fillColor: "#edc240"}
    });


    //para las asintotas horizontales
    var x1 = -5;
    var x2 = 6;
    var a = parseFloat($('#escx1').val());
    var b = parseFloat($('#escx2').val());
    if (!isNaN(a)) x1 = a;
    if (!isNaN(b)) x2 = b;

    var asintizq = [];
    if ($("#asintota-izquierda").val() == undefined) {
        for (var i = x1; i <= 0; i += 0.5) {
            asintizq.push([i, asintotaIzquierda]);
        }
    }
    var asintder = [];
    if ($("#asintota-derecha").val() == undefined) {
        for (var i = 0; i < x2; i += 0.5) {
            asintder.push([i, asintotaDerecha]);
        }
    }
    curvas.push({
        label: "",
        data: asintizq,
        points: {fillColor: "#ffffff", lineWidth: 1, show: false}
    });
    curvas.push({
        label: "",
        data: asintder,
        points: {fillColor: "#ffffff", lineWidth: 1, show: false}
    });


    //para las asintotas verticales
    var y1 = -5;
    var y2 = 6;
    if (grafico.length != 0) {
        y1 = 0;
        y2 = 0;
        for (var i = 0; i < grafico.length; i++) {
            for (var j = 0; j < grafico[i].length; j++) {
                if (grafico[i][j][1] < y1)
                    y1 = grafico[i][j][1];
                if (grafico[i][j][1] > y2)
                    y2 = grafico[i][j][1];
            }
        }
    }

    for (var j = 0; j < asintotasVertical.length; j++) {
        var asintvert = [];
        if (indasintotaverticalok[j]) {
            for (var i = y1; i < y2; i += 0.5) {
                asintvert.push([asintotasVertical[j], i]);
            }
            curvas.push({
                label: "",
                data: asintvert,
                points: {fillColor: "#ffffff", lineWidth: 1, show: false}
            });
        }
    }


    //para las asintotas oblicuas
    var asintobl = [];
    if ($("#asintota-oblicua").val() == undefined) {
        for (var i = 0; i < ptosasintotaOblicua.length; i++) {
            asintobl.push([ptosasintotaOblicua[i][0], ptosasintotaOblicua[i][1]]);
        }
    }
    curvas.push({
        label: "",
        data: asintobl,
        points: {fillColor: "#ffffff", lineWidth: 1, show: false}
    });

    return curvas;
}

function PintarAsintotas() {

    var curvas = DevAsintotas();

    options.series.lines.show = true;
    options.series.points.lineWidth = 3;

    var col = [];
    for (var i = 0; i < curvas.length; i++)
        col.push("#edc240");
    options.colors = col;

    draw(curvas);

}

function DevExtremos() {
    var curvas = DevAsintotas();

    //para los extremos
    var arr = [];
    $.each(extremos, function (index, value) {
        if (idextremook[index]) {
            var aux = value.split(" ");
            aux = aux[0].split(",");
            var xaux = parseFloat(aux[0]);
            var yaux = parseFloat(aux[1]);
            arr.push([xaux, yaux]);
        }
    });
    curvas.push({
        label: "",
        data: arr,
        lines: {show: false},
        points: {fillColor: "#edc240", show: true}
    });

    return curvas;
}

function PintarExtremos() {
    var curvas = DevExtremos();

    options.series.lines.show = true;
    options.series.points.lineWidth = 3;

    var col = [];
    for (var i = 0; i < curvas.length; i++)
        col.push("#edc240");
    options.colors = col;

    draw(curvas);

}

function DevInflexion() {
    var curvas = DevExtremos();

    //para la inflexion
    var arr = [];
    $.each(inflexion, function (index, value) {
        if (idinflexook[index]) {
            var aux = value.split(",");
            var xaux = parseFloat(aux[0]);
            var yaux = parseFloat(aux[1]);
            arr.push([xaux, yaux]);
        }
    });
    curvas.push({
        label: "",
        data: arr,
        lines: {show: false},
        points: {fillColor: "#edc240", show: true}
    });

    return curvas;
}

function PintarInflexion() {
    var curvas = DevInflexion();

    options.series.lines.show = true;
    options.series.points.lineWidth = 3;

    var col = [];
    for (var i = 0; i < curvas.length; i++)
        col.push("#edc240");
    options.colors = col;

    draw(curvas);
}

function Graficar(grafico) {
    var curvas = DevInflexion();

    //opciones del gráfico
    options.series.lines.show = true;
    options.series.points.show = true;

    //para graficar la funcion
    var label = funcionsimple;
    for (var i = 0; i < grafico.length; i++) {
        var ptos = [];
        if (i > 0)
            label = "";
        for (var j = 0; j < grafico[i].length; j++) {
            ptos.push([grafico[i][j][0], grafico[i][j][1]]);
        }
        curvas.push({
            label: label,
            data: ptos,
            color: "#444444",
            points: {fillColor: "#ffffff", show: false}
        });
    }
    draw(curvas);
}

function draw(curvas) {
    var xmin = 9999999, xmax = -9999999, ymin = 9999999, ymax = -9999999;
    var plot = [];
    var series = [
        {showMarker: false, color: "#999999"},//Axis
        {showMarker: false, color: "#999999"}//Axis
    ];
    for (var i = 0; i < curvas.length; i++) {
        plot[i] = [];
        if (curvas[i].points.show == undefined)
            curvas[i].points.show = true;
        series[i + 2] = {
            showMarker: curvas[i].points.show,
            showLine: !curvas[i].points.show,
            color: "#555555"
        };
        for (var j = 0; j < curvas[i].data.length; j++) {
            plot[i][j] = curvas[i].data[j];
            if (curvas[i].data[j][0] > xmax)xmax = curvas[i].data[j][0];
            if (curvas[i].data[j][1] > ymax)ymax = curvas[i].data[j][1];
            if (curvas[i].data[j][0] < xmin)xmin = curvas[i].data[j][0];
            if (curvas[i].data[j][1] < ymin)ymin = curvas[i].data[j][1];
        }
    }
    if (xmin == xmax) {
        xmin -= 1;
        xmax += 1;
    }
    if (ymin == ymax) {
        ymin -= 1;
        ymax += 1;
    }
    options.xaxis.min = xmin;
    options.xaxis.max = xmax;
    options.yaxis.min = ymin;
    options.yaxis.max = ymax;
    curvas.push({
        data: [
            [xmin, 0],
            [xmax, 0]
        ],
        color: "#999999",
        points: {show: false}
    });
    curvas.push({
        data: [
            [0, ymin],
            [0, ymax]
        ],
        color: "#999999",
        points: {show: false}
    });
    //console.log(curvas);
    plot1 = $.plot(
        $(".simple-chart"), curvas,
        options);

    for (var i = plot.length + 1; i >= 2; i--)
        plot[i] = plot[i - 2];
    plot[0] = [
        [xmin, 0],
        [xmax, 0]
    ];
    plot[1] = [
        [0, ymin],
        [0, ymax]
    ];
    plot2 = $.jqplot('chart1', plot, {
        series: series,
        axes: {
            xaxis: {min: xmin, max: xmax},
            yaxis: {min: ymin, max: ymax}
        },
        highlighter: {
            show: true,
            sizeAdjust: 7.5
        },
        cursor: {show: true, zoom: true, showTooltip: true}
    });
    var reset_button = "<button value=\"reset\" type=\"button\" onclick=\"plot2.resetZoom();\">Cancelar Zoom</button>"
    $(".reset-button").html(reset_button)
}

$(function () {
    $(".info").mouseover(function (e) {
        var coment = $(this).attr("coment");
        showTooltip(e.pageX + 10, e.pageY - 10, coment);
    });

    $(".info").mouseout(function (e) {
        $("#tooltip").remove();
    });
});