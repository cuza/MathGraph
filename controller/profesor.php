<?php

//Para alumnos
function LoadAlumnos()
{
    $p = UserQuery::create()->filterByNick($_SESSION['user'])->findOne();

    $users = array();
    foreach (UserQuery::create()->filterByRole('E')->find() as $u) {
        $e = AlumnoQuery::create()->filterByIduser($u->getId())->filterByIdprofesor($p->getId())->findOne();

        if (!empty($e)) {
            $users[] = array(
                "id" => $e->getId(),
                "nick" => $u->getNick(),
                "pass" => $u->getPass(),
                "name" => $u->getName()
            );
        }
    }
    return $users;
}

function addAlumno()
{
    $p = UserQuery::create()->filterByNick($_SESSION['user'])->findOne();

    $p1 = UserQuery::create()->filterByNick($_POST['nick'])->findOne();
    $error = "no";
    if (empty($p1)) {
        $u = new User();
        $u->setName($_POST['name']);
        $u->setNick($_POST['nick']);
        $u->setPass(md5($_POST['pass']));
        $u->setRole('E');
        $u->save();

        $e = new Alumno();
        $e->setIduser($u->getId());
        $e->setIdprofesor($p->getId());
        $e->save();
    } else {
        $error = "si";
    }
    Mostrar("alumnos", $error);
}

function editAlumno()
{
    $p = UserQuery::create()->filterByNick($_SESSION['user'])->findOne();
    $e = AlumnoQuery::create()->filterById($_POST['item'])->filterByIdprofesor($p->getId())->findOne();

    if (!empty($e)) {
        $u = UserQuery::create()->filterById($e->getIduser())->findOne();

        $u->setName($_POST['name']);
        $u->setNick($_POST['nick']);

        if ($_POST['pass'] != $u->getPass())
            $u->setPass(md5($_POST['pass']));

        $u->save();
    }

    Mostrar("alumnos");
}

function delAlumno()
{
    $p = UserQuery::create()->filterByNick($_SESSION['user'])->findOne();

    $e = AlumnoQuery::create()->filterById($_POST['item'])->filterByIdprofesor($p->getId())->findOne();
    if (!empty($e)) {
        $u = UserQuery::create()->filterById($e->getIduser())->findOne()->delete();
        $e->delete();
    }

    Mostrar("alumnos");
}

function delAlumnos()
{
    $p = UserQuery::create()->filterByNick($_SESSION['user'])->findOne();

    if (isset($_POST['check_item'])) {
        foreach ($_POST['check_item'] as $e) {
            $est = AlumnoQuery::create()->filterById($e)->filterByIdprofesor($p->getId())->findOne();
            if (!empty($est)) {
                $u = UserQuery::create()->filterById($est->getIduser())->findOne()->delete();
                $est->delete();
            }
        }
    }

    Mostrar("alumnos");
}


//Funciones
function LoadFunciones()
{
    $p = UserQuery::create()->filterByNick($_SESSION['user'])->findOne();

    $funciones = array();
    foreach (FuncQuery::create()->filterByIdprofesor($p->getId())->find() as $f) {
        $funciones[] = array(
            "id" => $f->getId(),
            "funcion" => $f->getFunc(),
            "desc" => $f->getDesc()
        );
    }
    return $funciones;
}

function LoadFuncionesEstudiante()
{
    $p = UserQuery::create()->filterByNick($_SESSION['user'])->findOne();
    if (!empty($p))
        $p = AlumnoQuery::create()->filterByIduser($p->getId())->findOne();

    $funciones = array();
    foreach (FuncQuery::create()->filterByIdprofesor($p->getIdprofesor())->find() as $f) {
        $funciones[] = array(
            "id" => $f->getId(),
            "funcion" => $f->getFunc(),
            "desc" => $f->getDesc()
        );
    }
    return $funciones;
}

function addFuncion()
{
    $p = UserQuery::create()->filterByNick($_SESSION['user'])->findOne();

    $f = new Func();
    $f->setFunc($_POST['funcion']);
    $f->setDesc($_POST['desc']);
    $f->setIdprofesor($p->getId());
    $f->save();

    Mostrar("funciones");
}

function editFuncion()
{
    $p = UserQuery::create()->filterByNick($_SESSION['user'])->findOne();
    $f = FuncQuery::create()->filterById($_POST['item'])->filterByIdprofesor($p->getId())->findOne();

    if (!empty($f)) {
        $f->setFunc($_POST['funcion']);
        $f->setDesc($_POST['desc']);
        $f->save();
    }

    Mostrar("funciones");
}

function delFuncion()
{
    $p = UserQuery::create()->filterByNick($_SESSION['user'])->findOne();
    $f = FuncQuery::create()->filterById($_POST['item'])->filterByIdprofesor($p->getId())->findOne();
    if (!empty($f)) {
        $f->delete();
    }

    Mostrar("funciones");
}

function delFunciones()
{
    $p = UserQuery::create()->filterByNick($_SESSION['user'])->findOne();

    if (isset($_POST['check_item'])) {
        foreach ($_POST['check_item'] as $f) {
            $func = FuncQuery::create()->filterById($f)->filterByIdprofesor($p->getId())->findOne();
            if (!empty($func)) {
                $func->delete();
            }
        }
    }

    Mostrar("funciones");
}


//Errores
function BuscarErrores()
{
    $p = UserQuery::create()->filterByNick($_SESSION['user'])->findOne();

    $from = date('Y-m-d');
    if (isset($_POST['from']) && $_POST['from'] != "") {
        $from = $_POST['from'];
        $arr = explode('-', $from);
        $from = date("Y-m-d", mktime(0, 0, 0, $arr[1], $arr[0], $arr[2]));
    }

    $to = date('Y-m-d');
    if (isset($_POST['to']) && $_POST['to'] != "") {
        $to = $_POST['to'];
        $arr = explode('-', $to);
        $to = date("Y-m-d", mktime(0, 0, 0, $arr[1], $arr[0], $arr[2]));
    }

    $errores = array();
    foreach (AlumnoQuery::create()->filterByIdprofesor($p->getId())->find() as $a) {
        foreach (ErrorQuery::create()->filterByIdalumno($a->getIduser())->filterByFecha($from, '>=')->filterByFecha($to, "<=")->find() as $e) {
            if (isset($errores[$e->getPaso()]))
                $errores[$e->getPaso()]['value']++;
            else
                $errores[$e->getPaso()] = array('ind' => $e->getPaso(), 'value' => 1);
        }
    }
    sort($errores);
    return $errores;
}

function BuscarFrom()
{
    $from = date('d-m-Y');
    if (isset($_POST['from']) && $_POST['from'] != "") {
        $from = $_POST['from'];
    }
    return $from;
}

function BuscarTo()
{
    $to = date('d-m-Y');
    if (isset($_POST['to']) && $_POST['to'] != "") {
        $to = $_POST['to'];
    }
    return $to;
}

function MarcarError()
{
    $a = UserQuery::create()->filterByNick($_SESSION['user'])->findOne();

    $e = new Error();
    $e->setIdalumno($a->getId());
    $e->setPaso($_POST['paso']);
    $e->setFecha(date('Y-m-d'));
    $e->save();
}