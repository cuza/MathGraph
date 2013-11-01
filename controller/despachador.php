<?php

function Despachar()
{
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'login':
                Login();
                break;
            default:
                ShowLogin();
        }
    } else {
        ShowLogin();
    }
}


function DespacharUser()
{
    /*Control de casos*/
    if (isset($_POST['action'])) {

        switch ($_SESSION['role']) {

            case 'A':
                switch ($_POST['action']) {

                    case 'addUsuario':
                        addUsuario();
                        break;

                    case 'editUsuario':
                        editUsuario();
                        break;

                    case 'delUsuario':
                        delUsuario();
                        break;

                    case 'delUsuarios':
                        delUsuarios();
                        break;

                }
                break;

            case 'P':
                switch ($_POST['action']) {
                    //Alumnos
                    case 'addAlumno':
                        addAlumno();
                        break;

                    case 'editAlumno':
                        editAlumno();
                        break;

                    case 'delAlumno':
                        delAlumno();
                        break;

                    case 'delAlumnos':
                        delAlumnos();
                        break;

                    //Funciones
                    case 'addFuncion':
                        addFuncion();
                        break;

                    case 'editFuncion':
                        editFuncion();
                        break;

                    case 'delFuncion':
                        delFuncion();
                        break;

                    case 'delFunciones':
                        delFunciones();
                        break;
                    case 'procesar-paso-2':
                        ProcesarPaso2();
                        break;
                    //Errores
                    case 'buscar-errores':
                        Mostrar('errores');
                        break;
                }
                break;

            case 'E':
                switch ($_POST['action']) {

                    case 'procesar-paso-1':
                        ProcesarPaso1();
                        break;

                    case 'procesar-paso-2':
                        ProcesarPaso2();
                        break;

                    case 'func':
                        ProcesarPaso1();
                        break;

                    case 'marcar-error':
                        MarcarError();
                        break;

                }
                break;
        }
    } elseif (isset($_REQUEST['action'])) {
        switch ($_REQUEST['action']) {

            case 'logout':
                session_destroy();
                session_start();
                ShowLogin();
                break;

            default:
                Mostrar($_REQUEST['action']);
        }

    } else {
        Mostrar('home');
    }
}


function ProcesarPaso1()
{
    $monx = array();
    //Para hayar el dominio, poniendo x vale 0 para los interceptos
    //Para reducir funcion
    $func = ReducirFuncion1($_POST['funcion']);


    $f = ObtenerFuncion($func, 0);

    $responce = array();
    $responce['dominio'] = $f->getDominio();


    $responce['coment_dom'] = $f->texto;

    //halla y cuando x vale 0
    $y = $f->GetY();
    if (!is_nan($y) && !is_infinite($y))
        $responce['y'] = round($y, 2);
    else
        $responce['y'] = "no";
    $responce['coment_y'] = "y = " . preg_replace("/x/", "0", $func);

    //halla x cuando y vale 0
    $hallarX = array();
    foreach (HayarX($func) as $ha) {
        if ($ha != "no") {
            $aux = explode("x = ", $ha);
            $hallarX[] = "x = " . round($aux[1], 2);
        } else
            $hallarX[] = "no";
    }
    $responce['x'] = $hallarX;
    $responce['coment_x'] = "0=" . $func;

    //halla los signos de la funcion en los intervalos
    $signos = $responce['dominio'];
    foreach ($hallarX as $h)
        $signos[] = $h;
    $responce['signos'] = Signos($func, $signos);
    $responce['coment_signos'] = "";

    //Asintotas horizontales
    $asintotaIzquierda = "no";
    $asintotaDerecha = "no";

    $a1 = Limite($func, INF);
    $a2 = Limite($func, -INF);

    if (!is_infinite($a1) && $a1 !== false) {
        $asintotaDerecha = $a1;
    }
    if (!is_infinite($a2) && $a2 !== false)
        $asintotaIzquierda = $a2;

    //para redondear las sintotas
    if (is_numeric($asintotaIzquierda))
        $asintotaIzquierda = round($asintotaIzquierda, 2);

    if (is_numeric($asintotaDerecha))
        $asintotaDerecha = round($asintotaDerecha, 2);

    $responce['asintotaIzquierda'] = $asintotaIzquierda;
    $responce['asintotaDerecha'] = $asintotaDerecha;

    //Asintotas verticales
    $asintotasVertical = array();
    foreach ($responce['dominio'] as $d) {
        if ($d != "x Є R") {
            $v = explode("> ", $d);
            if (count($v) > 1) {
                $aux = Limite($func, $v[1]);
                if (is_infinite($aux))
                    $asintotasVertical[] = round($v[1], 2);
            }
            $v = explode("< ", $d);
            if (count($v) > 1) {
                $aux = Limite($func, $v[1]);
                if (is_infinite($aux))
                    $asintotasVertical[] = round($v[1], 2);
            }
            $v = explode("≠ ", $d);
            if (count($v) > 1) {
                $aux = Limite($func, $v[1]);
                if (is_infinite($aux))
                    $asintotasVertical[] = round($v[1], 2);

                $monx[] = $v[1];
            }
            $v = explode("≥ ", $d);
            if (count($v) > 1) {
                $aux = Limite($func, $v[1]);
                if (is_infinite($aux))
                    $asintotasVertical[] = round($v[1], 2);
            }
            $v = explode("≤ ", $d);
            if (count($v) > 1) {
                $aux = Limite($func, $v[1]);
                if (is_infinite($aux))
                    $asintotasVertical[] = round($v[1], 2);
            }
        }
    }
    $responce['asintotasVertical'] = $asintotasVertical;

    //asintotas oblicuas
    if ($asintotaDerecha == "no" && $asintotaIzquierda == "no") {
        $m = "(" . $func . ")/(x)";
        $m = Limite($m, INF);
        if (is_numeric($m))
            $m = round($m, 2);
        if (!is_infinite($m) && $m !== false) {
            $n = ReducirFuncion1($func . "-(" . $m . ")*(x)");
            $n = Limite($n, INF);
            if (is_numeric($n))
                $n = round($n, 2);
            if (is_numeric($n) && $n < 0)
                $y = "(" . $m . ")*(x)" . $n;
            else {
                if (is_numeric($n) && $n < 0)
                    $y = "(" . $m . ")*(x)+" . $n;
                else {
                    if (is_numeric($n) && $n == 0)
                        $y = "(" . $m . ")*(x)";
                }
            }
            $y = ReducirFuncion1($y);
            if (is_infinite($n) || $a1 !== Limite($y, INF) || $y == $func)
                $y = "no";
            $asintotaOblicua = $y;
        } else
            $asintotaOblicua = "no";
    } else {
        $asintotaOblicua = "no";
    }
    $responce['asintotaOblicua'] = $asintotaOblicua;

    //puntos para graficar asintota oblicua
    $responce['ptosasintotaOblicua'] = array();
    if ($asintotaOblicua != "no") {
        for ($i = -5; $i < 6; $i += 1) {
            $i = round($i, 1);
            $y = ObtenerFuncion($asintotaOblicua, $i)->GetY();
            $responce['ptosasintotaOblicua'][] = array($i, $y);
        }
    }


    //posibles extremos
    $d1 = $f->derivada;
    $d1 = ReducirFuncion1($d1);

    $d = ObtenerFuncion($d1);
    $d2 = $d->derivada;
    $d2 = ReducirFuncion1($d2);

    $segundaDerivada = $d2;

    $d1 = HayarX($d1);

    $arr = array();

    foreach ($d1 as $h) {
        $h = explode("x = ", $h);
        if (count($h) > 1) {
            $h = $h[1];
            $monx[] = $h;
            $h = round($h, 2);
            $num = ObtenerFuncion($d2, $h)->GetY();
            if (is_numeric($num) && !is_nan($num) && $num > 0) {
                $val = round(ObtenerFuncion($func, $h)->GetY(), 2);
                if (!is_infinite($h) && !is_infinite($val))
                    $arr[] = $h . "," . $val . " Mínimo";
            } elseif (is_numeric($num) && !is_nan($num) && $num < 0) {
                $val = round(ObtenerFuncion($func, $h)->GetY(), 2);
                if (!is_infinite($h) && !is_infinite($val))
                    $arr[] = $h . "," . $val . " Máximo";
            } else {
                //hay que resolver cuando la funcion es par
            }
        }
    }
    $responce['extremos'] = $arr;

    //monotonia

    $responce['monotonia'] = Monotonia($func, $monx);


    //ptos de inflexion

    $d2 = $segundaDerivada;
    $d1 = HayarX($d2);
    $xSegundaDerivada = $d1;

    $arr = array();
    $d3 = ObtenerFuncion($d2, 0)->derivada;
    $d3 = ReducirFuncion1($d3);
    if ($d3 != "0") {
        $d1 = array_unique($d1);
        foreach ($d1 as $h) {
            $h = explode("x = ", $h);
            if (count($h) > 1) {
                $h = $h[1];
                $y = ObtenerFuncion($func, $h)->GetY();
                if (!is_infinite($y) && !is_nan($y))
                    $arr[] = $h . "," . $y;
            }
        }
    }
    $responce['inflexion'] = $arr;

    //concavidad y convexidad
    $d2 = $segundaDerivada;

    $signos = $responce['dominio'];
    $r = $xSegundaDerivada;
    foreach ($r as $h)
        $signos[] = $h;

    $inter = Signos($d2, $signos);
    $res = array();
    if ($inter != "no") {
        foreach ($inter as $i) {
            $h = explode(" ", $i);
            $c = "Concava";
            if ($h[1] == "-")
                $c = "Convexa";
            $res[] = $h[0] . " " . $c;
        }
    }
    $responce['concavidadConvexidad'] = $res;


    //para enviar la funcion simplificada
    $responce['funcion'] = $func;


    echo json_encode($responce);
}

function ProcesarPaso2()
{
    $x1 = -5;
    $x2 = 5;
    $cero = 0;
    if ($_POST['x1'] != "") {
        $x1 = $_POST['x1'];
    }
    if ($_POST['x2'] != "") {
        $x2 = $_POST['x2'];
    }
    if ($x1 < 0 && $x2 < 0)
        $cero = $x2;
    if ($x1 > 0 && $x2 > 0)
        $cero = $x1;


    $dif = abs($x2 - $x1);
    $dif = strlen($dif);
    $escala =  abs($x2 - $x1)/200;

    //funcion reducida
    $func = $_POST['funcion'];
    $func = ReducirFuncion1($_POST['funcion']);

    //Para hayar el dominio, poniendo x vale 0 para los interceptos
    $f = ObtenerFuncion($func, 0);
    $dominio = $f->getDominio();

    //Asintotas verticales
    $asintotasVertical = array();
    foreach ($dominio as $d) {
        if ($d != "x Є R") {
            $v = explode("> ", $d);
            if (count($v) > 1) {
                $aux = Limite($func, $v[1]);
                if (is_infinite($aux))
                    $asintotasVertical[] = $v[1];
            }
            $v = explode("< ", $d);
            if (count($v) > 1) {
                $aux = Limite($func, $v[1]);
                if (is_infinite($aux))
                    $asintotasVertical[] = $v[1];
            }
            $v = explode("≠ ", $d);
            if (count($v) > 1) {
                $aux = Limite($func, $v[1]);
                if (is_infinite($aux))
                    $asintotasVertical[] = $v[1];
            }
            $v = explode("≥ ", $d);
            if (count($v) > 1) {
                $aux = Limite($func, $v[1]);
                if (is_infinite($aux))
                    $asintotasVertical[] = $v[1];
            }
            $v = explode("≤ ", $d);
            if (count($v) > 1) {
                $aux = Limite($func, $v[1]);
                if (is_infinite($aux))
                    $asintotasVertical[] = $v[1];
            }
        }
    }
    //para cuando la func es tangente
    if ($func == "tan(x)" || $func == "(sen(x))/(cos(x))") {
        for ($i = 0; $i < $x2; $i++) {
            $asintotasVertical[] = ((2 * $i) + 1) * M_PI_2;
        }
        for ($i = 0; $i > $x1; $i--) {
            $asintotasVertical[] = ((2 * $i) + 1) * M_PI_2;
        }
    }

    //capturar los puntos para pintar
    $responce = array(array(array()));
    $j = 0;

    for ($i = $x1; $i < $cero; $i += $escala) {
        $i = round($i, 2);
        if (!in_array($i . "", $asintotasVertical)) {

            $e = 0;
            for ($k = 0; $k < count($asintotasVertical); $k++) {
                if ($i < $asintotasVertical[$k] && ($i + $escala) > $asintotasVertical[$k]) {
                    $e = 1;
                    break;
                }
            }
            if ($e) {
                $j++;
            } else {
                $g = ObtenerFuncion($func, $i)->GetY();
                if (!is_nan($g) && !is_infinite($g)) {
                    $responce[$j][] = array($i, round($g, 2));
                }
            }
        } else {
            if (!isset($responce[$j]))
                $responce[$j] = array();
            $j++;
        }
    }

    for ($i = $cero; $i < $x2; $i += $escala) {
        $i = round($i, 2);
        if (!in_array($i . "", $asintotasVertical)) {
            $e = 0;
            for ($k = 0; $k < count($asintotasVertical); $k++) {
                if ($i < $asintotasVertical[$k] && ($i + $escala) > $asintotasVertical[$k]) {
                    $e = 1;
                    break;
                }
            }
            if ($e) {
                $j++;
            } else {
                $g = ObtenerFuncion($func, $i)->GetY();
                if (!is_nan($g) && !is_infinite($g))
                    $responce[$j][] = array($i, round($g, 2));
            }
        } else {
            if (!isset($responce[$j]))
                $responce[$j] = array();
            $j++;
        }
    }


    $ptosasintotaOblicua = array();
    if (isset($_POST['asintotaOblicua']) && $_POST['asintotaOblicua'] != "no") {
        for ($i = $x1; $i < $x2; $i += 1) {
            $i = round($i, 1);
            $y = ObtenerFuncion($_POST['asintotaOblicua'], $i)->GetY();
            $ptosasintotaOblicua[] = array($i, round($y, 2));
        }
    }


    echo json_encode(array("grafico" => $responce, "ptosasintotaOblicua" => $ptosasintotaOblicua));
}


?>