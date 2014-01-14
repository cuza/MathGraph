function EliminarSel(action) {
    $("#dialog-ui").html("<p>¿Desea realmente eliminar?</p>");

    //Dialog Modal
    $("#dialog-ui").dialog({
        autoOpen: false,
        title: "Alerta",
        modal: true,
        width: "300",
        buttons: [
            {
                text: "Aceptar",
                click: function () {
                    $("#check-form-action").val(action);
                    $("#check-form").submit();
                }
            },
            {
                text: "Cerrar",
                click: function () {
                    $(this).dialog("close");
                }
            }
        ]
    }).dialog("open");
}

function Eliminar(tipo, item) {
    $("#dialog-ui").html("<p>¿Desea realmente eliminar?</p>");

    var html = "<form action='index.php' method='post' id='send-form'>" +
        "<input type='hidden' name='action' value='del" + tipo + "'/>" +
        "<input type='hidden' name='item' value='" + item + "'/>" +
        "</form>";
    $('body').append(html);

    //Dialog Modal
    $("#dialog-ui").dialog({
        autoOpen: false,
        title: "Alerta",
        modal: true,
        width: "300",
        buttons: [
            {
                text: "Aceptar",
                click: function () {
                    $("#send-form").submit();
                }
            },
            {
                text: "Cerrar",
                click: function () {
                    $(this).dialog("close");
                }
            }
        ]
    }).dialog("open");
}

function Ver(tipo, item) {
    console.log(tipo, item)
    var html = "<div class=\"graph\">" +
        "<div class=\"box chart\" align=\"left\">" +
        "<h4>" +
        "<span class=\"icon16 icomoon-icon-bars\"></span>" +
        "</h4>" +
        "</div>" +
        "<div class=\"content\">" +
        "<div class=\"simple-chart\" style=\"height: 230px; width:450px;\">" +
        "</div>" +
        "<div id=\"chart1\" class=\"simple-chart-2\" style=\"height: 230px; width:450px;\">" +
        "</div>" +
        "</div>"
    $("#dialog-ui").html(html);
    //Dialog Modal
    $("#dialog-ui").dialog({
        autoOpen: false,
        title: "Grafica",
        modal: true,
        width: "500",
        resizable: false
    }).dialog("open");
    GraficarFuncEstudiante("(x)^(2)")
}


function AddUsuario() {
    var html = "<form class='da-form' id='add-form' method='post' action='index.php'>" +
        "<input type='hidden' name='action' value='addUsuario'/>" +
        "<div class='da-form-row'>" +
        "<label>Nombre</label>" +
        "<div class='da-form-item default'>" +
        "<input type='text' name='name' />" +
        "</div>" +
        "</div>" +
        "<div class='da-form-row'>" +
        "<label>Usuario</label>" +
        "<div class='da-form-item default'>" +
        "<input type='text' name='nick' />" +
        "</div>" +
        "</div>" +
        "<div class='da-form-row'>" +
        "<label>Contraseña</label>" +
        "<div class='da-form-item default'>" +
        "<input type='password' name='pass' />" +
        "</div>" +
        "</div>" +
        "<div class='da-form-row'>" +
        "<label>Rol</label>" +
        "<div class='da-form-item default'>" +
        "<select name='role'>" +
        "<option value='A'>Administrador</option>" +
        "<option value='P'>Profesor</option>" +
        "</select>" +
        "</div>" +
        "</div>" +
        "</form>";

    MostrarDialog('Agregar Usuario', '600', html, 'add-form');
}


function EditUsuario(id, name, nick, pass, role) {
    var html = "<form class='da-form' id='add-form' method='post' action='index.php'>" +
        "<input type='hidden' name='action' value='editUsuario'/>" +
        "<input type='hidden' name='item' value='" + id + "'/>" +
        "<div class='da-form-row'>" +
        "<label>Nombre</label>" +
        "<div class='da-form-item default'>" +
        "<input type='text' name='name' value='" + name + "' />" +
        "</div>" +
        "</div>" +
        "<div class='da-form-row'>" +
        "<label>Usuario</label>" +
        "<div class='da-form-item default'>" +
        "<input type='text' name='nick' value='" + nick + "' />" +
        "</div>" +
        "</div>" +
        "<div class='da-form-row'>" +
        "<label>Contraseña</label>" +
        "<div class='da-form-item default'>" +
        "<input type='password' name='pass' value='" + pass + "' />" +
        "</div>" +
        "</div>" +
        "<div class='da-form-row'>" +
        "<label>Rol</label>" +
        "<div class='da-form-item default'>" +
        "<select name='role'>";

    if (role == "Administrador") {
        html += "<option value='A' selected='selected'>Administrador</option>" +
            "<option value='P'>Profesor</option>";
    }
    else {
        html += "<option value='A'>Administrador</option>" +
            "<option value='P' selected='selected'>Profesor</option>";
    }

    html += "</select>" +
        "</div>" +
        "</div>" +
        "</form>";

    MostrarDialog('Editar Usuario', '600', html, 'add-form');
}


function AddAlumno() {
    var html = "<form class='da-form' id='add-form' method='post' action='index.php'>" +
        "<input type='hidden' name='action' value='addAlumno'/>" +
        "<div class='da-form-row'>" +
        "<label>Nombre</label>" +
        "<div class='da-form-item default'>" +
        "<input type='text' name='name' />" +
        "</div>" +
        "</div>" +
        "<div class='da-form-row'>" +
        "<label>Usuario</label>" +
        "<div class='da-form-item default'>" +
        "<input type='text' name='nick' />" +
        "</div>" +
        "</div>" +
        "<div class='da-form-row'>" +
        "<label>Contraseña</label>" +
        "<div class='da-form-item default'>" +
        "<input type='password' name='pass' />" +
        "</div>" +
        "</div>" +
        "</form>";

    MostrarDialog('Agregar Alumno', '600', html, 'add-form');
}


function EditAlumno(id, name, nick, pass) {
    var html = "<form class='da-form' id='add-form' method='post' action='index.php'>" +
        "<input type='hidden' name='action' value='editAlumno'/>" +
        "<input type='hidden' name='item' value='" + id + "'/>" +
        "<div class='da-form-row'>" +
        "<label>Nombre</label>" +
        "<div class='da-form-item default'>" +
        "<input type='text' name='name' value='" + name + "' />" +
        "</div>" +
        "</div>" +
        "<div class='da-form-row'>" +
        "<label>Usuario</label>" +
        "<div class='da-form-item default'>" +
        "<input type='text' name='nick' value='" + nick + "' />" +
        "</div>" +
        "</div>" +
        "<div class='da-form-row'>" +
        "<label>Contraseña</label>" +
        "<div class='da-form-item default'>" +
        "<input type='password' name='pass' value='" + pass + "' />" +
        "</div>" +
        "</div>" +
        "</form>";

    MostrarDialog('Editar Alumno', '600', html, 'add-form');
}


function AddFuncion() {
    var html = "<form class='da-form' id='add-form' method='post' action='index.php'>" +
        "<input type='hidden' name='action' value='addFuncion'/>" +
        "<div class='da-form-row'>" +
        "<label>Función</label>" +
        "<div class='da-form-item default'>" +
        "<input type='text' name='funcion' />" +
        "</div>" +
        "</div>" +
        "<div class='da-form-row'>" +
        "<label>Descripción</label>" +
        "<div class='da-form-item default'>" +
        "<input type='text' name='desc' />" +
        "</div>" +
        "</div>" +
        "</form>";

    MostrarDialog('Agregar Función', '600', html, 'add-form');
}


function EditFuncion(id, funcion, desc) {
    var html = "<form class='da-form' id='add-form' method='post' action='index.php'>" +
        "<input type='hidden' name='action' value='editFuncion'/>" +
        "<input type='hidden' name='item' value='" + id + "'/>" +
        "<div class='da-form-row'>" +
        "<label>Función</label>" +
        "<div class='da-form-item default'>" +
        "<input type='text' name='funcion' value='" + funcion + "' />" +
        "</div>" +
        "</div>" +
        "<div class='da-form-row'>" +
        "<label>Descripción</label>" +
        "<div class='da-form-item default'>" +
        "<input type='text' name='desc' value='" + desc + "' />" +
        "</div>" +
        "</div>" +
        "</form>";

    MostrarDialog('Editar Función', '600', html, 'add-form');
}


function MostrarDialog(title, width, html, form) {
    $("#dialog-ui").html(html);
    Validar();

    //Dialog Modal
    $("#dialog-ui").dialog({
        autoOpen: false,
        title: title,
        modal: true,
        width: width,
        buttons: [
            {
                text: "Aceptar",
                click: function () {
                    $("#" + form).submit();
                }
            },
            {
                text: "Cerrar",
                click: function () {
                    $(this).dialog("close");
                }
            }
        ]
    }).dialog("open");
}

function GraficarFuncEstudiante(func) {
    console.log(func)
    $(".button-funcion").attr('onclick', '');

    var x1 = $('#escx1').val();
    var x2 = $('#escx2').val();

    var html1 = "<div id='wait'> <img src='view/images/large-loading.gif'> </div>";
    $('.graph').append(html1);

    $.ajax({
        type: "POST",
        url: "index.php",
        dataType: "json",
        data: {action: 'procesar-paso-2', funcion: func, x1: x1, x2: x2},
        success: function (responce) {

            $('#wait').remove();
            $('#escala-row').remove();

            var h = $(".da-panel").html();
            $(".da-panel-title").html("Escriba la función a partir de su representación gráfica...");

            var html = "<label>Función <span class='required'>*</span></label>" +
                "<div class='da-form-item large'>" +
                "<input type='text' name='funcion' id='funcionEstudiante' class='required' />" +
                "</div>";

            $(".da-form-row").html(html);
            html = "<div class='da-button-row'>" +
                "<a class='da-button green small' id='Sig' item='normal'>Siguiente</a>" +
                "</div>";

            $(".da-form-row").after(html);

            $("#Sig").click(function () {
                if ($("#funcionEstudiante").val() == func) {
                    alert("La función es correcta.");
                    //$(".da-panel").html(h);
                    window.location.href = window.location.href.split('#')[0];
                }
                else {
                    MarcarError(1);
                    alert("Función incorrecta.");
                }
            });

            $("#func-form").submit(function () {
                if ($("#funcionEstudiante").val() == func) {
                    alert("La función es correcta.");
                    //$(".da-panel").html(h);
                    window.location.href = window.location.href.split('#')[0];
                }
                else {
                    MarcarError(1);
                    alert("Función incorrecta.");
                }
                return false;
            });

            //para el grafico
            grafico = responce['grafico'];

            var curvas = [];
            var col = [];
            //para graficar la funcion
            for (var i = 0; i < grafico.length; i++)
                col.push("#000000");
            options.colors = col;
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
                    points: {fillColor: "#ffffff", show: false}
                });
            }


            draw(curvas);

        }
    });
}

$(function () {
    var dates = $("#from, #to").datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 1,
        dateFormat: 'dd-mm-yy',
        onSelect: function (selectedDate) {
            var option = this.id == "from" ? "minDate" : "maxDate",
                instance = $(this).data("datepicker"),
                date = $.datepicker.parseDate(
                    instance.settings.dateFormat ||
                        $.datepicker._defaults.dateFormat,
                    selectedDate, instance.settings);
            dates.not(this).datepicker("option", option, date);
        }
    });
});

//para que no puedan apretar teclas en el from y to de las fechas
$(function () {
    $("#from,#to").bind('keypress', function () {
        return false;
    });
});


function MarcarError(paso) {
    $.ajax({
        type: "POST",
        url: "index.php",
        dataType: "json",
        data: {action: 'marcar-error', paso: paso},
        success: function () {

        }
    });
}

function ValidarX1() {
    var a = parseFloat($('#escx1').val());
    if (isNaN(a)) {
        $('#escx1').val("");
        alert('Debe ser un número.');
    }
    else {
        var b = parseFloat($('#escx2').val());
        if (!isNaN(b) && a <= b)
            $('#escx1').val(a);
        else {
            if (isNaN(b))
                $('#escx1').val(a);
            else {
                $('#escx1').val("");
                alert('Debe ser un número menor a x2.');
            }
        }
    }
}

function ValidarX2() {
    var a = parseFloat($('#escx2').val());
    if (isNaN(a)) {
        $('#escx2').val("");
        alert('Debe ser un número.');
    }
    else {
        var b = parseFloat($('#escx1').val());
        if (!isNaN(b) && a >= b)
            $('#escx2').val(a);
        else {
            if (isNaN(b))
                $('#escx2').val(a);
            else {
                $('#escx2').val("");
                alert('Debe ser un número mayor a x1.');
            }
        }
    }
}