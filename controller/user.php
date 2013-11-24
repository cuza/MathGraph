<?php

function Login()
{
    $nick = $_POST['nick'];
    $pass = $_POST['pass'];
    $pass = md5($pass);
    $u = UserQuery::create()->filterByNick($nick)->filterByPass($pass)->findOne();
    if (!empty($u)) {

        $_SESSION["user"] = $u->getNick();
        $_SESSION["role"] = $u->getRole();

        Mostrar('home');
    } else {
        $men = array('tipo' => 'warning', 'texto' => 'Usuario o Contraseña Incorrectos.');
        ShowLogin($men);
    }
}

function LoadUsers()
{
    $users = array();
    foreach (UserQuery::create()->find() as $u) {
        $role = 'Administrador';
        if ($u->getRole() == 'P')
            $role = 'Profesor';

        if ($u->getRole() != 'E') {
            $users[] = array(
                "id" => $u->getId(),
                "nick" => $u->getNick(),
                "pass" => $u->getPass(),
                "name" => $u->getName(),
                "role" => $role
            );
        }
    }
    return $users;
}

function addUsuario()
{
    $u = UserQuery::create()->filterByNick($_POST['nick'])->findOne();
    $error = "no";
    if (empty($u)) {
        $u = new User();
        $u->setName($_POST['name']);
        $u->setNick($_POST['nick']);
        $u->setPass(md5($_POST['pass']));
        $u->setRole($_POST['role']);
        $u->save();
    } else {
        $error = "si";
    }

    Mostrar("usuarios", $error);
}

function editUsuario()
{
    $u = UserQuery::create()->filterById($_POST['item'])->findOne();
    $u->setName($_POST['name']);
    $u->setNick($_POST['nick']);

    if ($_POST['pass'] != $u->getPass())
        $u->setPass(md5($_POST['pass']));

    $u->setRole($_POST['role']);
    $u->save();

    Mostrar("usuarios");
}

function delUsuario()
{
    $u = UserQuery::create()->filterById($_POST['item'])->findOne();
    if (!empty($u))
        $u->delete();

    Mostrar("usuarios");
}

function delUsuarios()
{
    if (isset($_POST['check_item'])) {
        foreach ($_POST['check_item'] as $u) {
            $user = UserQuery::create()->filterById($u)->findOne();
            if (!empty($user))
                $user->delete();
        }
    }

    Mostrar("usuarios");
}