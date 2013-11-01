<?php

function ShowLogin($men = array())
{
    OpenPage();
    Cabecera();
    LoginTpl($men);
    ClosePage();
}

function Mostrar($show, $error = "no")
{
    OpenPage();
    Cabecera($show);
    WorkArea($show, $error);
    Dialog();
    ClosePage();
}


function Cabecera($show = "")
{
    $s = GeneraSmarty();

    $m = array();
    if (isset($_SESSION['role'])) {
        $m[] = array("texto" => "Portada", "select" => "home", "url" => "index.php");

        switch ($_SESSION['role']) {
            case 'A':
                $m[] = array("texto" => "Usuarios", "select" => "usuarios", "url" => "index.php?action=usuarios");
                break;

            case 'P':
                $m[] = array("texto" => "Alumnos", "select" => "alumnos", "url" => "index.php?action=alumnos");
                $m[] = array("texto" => "Funciones", "select" => "funciones", "url" => "index.php?action=funciones");
                $m[] = array("texto" => "Errores", "select" => "errores", "url" => "index.php?action=errores");
                break;

            case 'E':
                $m[] = array("texto" => "Graficar", "select" => "graficar", "url" => "index.php?action=graficar");
                $m[] = array("texto" => "Funciones", "select" => "funciones", "url" => "index.php?action=funciones");
                break;
        }

        $m[] = array("texto" => "Salir", "url" => "index.php?action=logout");
    }

    $s->assign("menu", $m);
    $s->assign("select", $show);
    $s->display('cabecera.tpl');
}

function WorkArea($show, $error)
{
    switch ($_SESSION['role']) {
        case 'A':
            WorkAdmin($show, $error);
            break;

        case 'P':
            WorkProfesor($show, $error);
            break;

        case 'E':
            WorkEstudiante($show);
            break;
    }
}

function WorkAdmin($show, $error)
{
    $s = GeneraSmarty();
    switch ($show) {
        case "home":
            $s->assign('user', strtoupper($_SESSION["user"]));
            $s->display('home.tpl');
            break;

        case "usuarios":
            $s->assign('users', LoadUsers());
            $s->assign('error', $error);
            $s->display('usuarios.tpl');
            break;
    }
}

function WorkProfesor($show, $error)
{
    $s = GeneraSmarty();
    switch ($show) {
        case "home":
            $s->assign('user', strtoupper($_SESSION["user"]));
            $s->display('home.tpl');
            break;

        case "alumnos":
            $s->assign('alumnos', LoadAlumnos());
            $s->assign('error', $error);
            $s->display('alumnos.tpl');
            break;

        case "funciones":
            $s->assign('funciones', LoadFunciones());
            $s->display('funciones.tpl');
            break;

        case "errores":
            $err = BuscarErrores();
            $s->assign('errores', $err);
            $from = BuscarFrom();
            $to = BuscarTo();
            $s->assign('from', $from);
            $s->assign('to', $to);
            $s->display('errores.tpl');
            break;
    }
}

function WorkEstudiante($show)
{
    $s = GeneraSmarty();
    switch ($show) {
        case "home":
            $s->assign('user', strtoupper($_SESSION["user"]));
            $s->display('home.tpl');
            break;

        case "graficar":
            $s->display('openarea.tpl');
            WorkPanel();
            WorkGraph();
            $s->display('openarea.tpl');
            break;

        case "funciones":
            $s->assign('funciones', LoadFuncionesEstudiante());
            $s->display('funcAlumno.tpl');
            $s->display('workgraph.tpl');
            break;

    }
}

function WorkGraph()
{
    $s = GeneraSmarty();
    $s->display('workgraph.tpl');
}

function WorkPanel()
{
    $s = GeneraSmarty();
    $s->display('workpanel.tpl');
}

function LoginTpl($men)
{
    $s = GeneraSmarty();

    if (!empty($men))
        $s->assign('men', $men);

    $s->display('login.tpl');
}


function OpenPage()
{
    $s = GeneraSmarty();
    $s->display('openpage.tpl');
}

function ClosePage()
{
    $s = GeneraSmarty();
    $s->display('closepage.tpl');
}

function Dialog()
{
    $s = GeneraSmarty();
    $s->display('dialog.tpl');
}
