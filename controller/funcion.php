<?php
function CalcularFuncion($func, $val)
{
    $func = preg_replace("/x/", $val, $func);
    return ReducirFuncion1($func);
}

function ReducirFuncion1($f)
{
    $f = RempFun($f);
    $f = ReducirFuncion($f);
    $f = UnRempFunc($f);
    return $f;
}

function ReducirFuncion($f)
{
    if (isSencilla($f))
        return $f;

    if (BuscarbySigno($f, '+') || BuscarbySigno($f, '-')) {
        $arr = DevolverPolinomio($f);
        $res = "";
        $i = 0;

        foreach ($arr['elementos'] as $elem) {
            if (!isSencilla($elem))
                $elem = ReducirFuncion($elem);

            if ($i != 0) {
                if ($i != 0 && $arr['signos'][$i - 1] == "-") {
                    $elem = CambiarSignos($elem);
                    $res .= $arr['signos'][$i - 1] . $elem;
                } else
                    $res .= $arr['signos'][$i - 1] . $elem;
            } else {
                $res .= $elem;
            }
            $i++;
        }
        $arr = DevolverPolinomio($res);
        $res = SumarFunc($arr);

        return $res;
    } elseif (BuscarbySigno($f, '*')) {
        $arr = MiembrosbySigno($f, "*");
        $mizq = Dentro($arr['mizq']);
        $mder = Dentro($arr['mder']);

        $polizq = DevolverPolinomio($mizq);
        $polder = DevolverPolinomio($mder);

        if (count($polizq['signos']) != 0) {
            $mizq = "";
            $i = 0;
            foreach ($polizq['elementos'] as $e) {
                if (!isSencilla($e))
                    $e = ReducirFuncion($e);

                if (count($polizq['signos']) != $i)
                    $mizq .= $e . $polizq['signos'][$i];
                else {
                    $mizq .= $e;
                }
                $i++;
            }
        } else {
            if (!isSencilla($mizq))
                $mizq = ReducirFuncion($mizq);
        }


        if (count($polder['signos']) != 0) {
            $mder = "";
            $i = 0;
            foreach ($polder['elementos'] as $e) {
                if (!isSencilla($e))
                    $e = ReducirFuncion($e);

                if (count($polder['signos']) != $i)
                    $mder .= $e . $polder['signos'][$i];
                else {
                    $mder .= $e;
                }
                $i++;
            }
        } else {
            if (!isSencilla($mder))
                $mder = ReducirFuncion($mder);
        }

        $mizq = DevolverPolinomio($mizq);
        $mder = DevolverPolinomio($mder);

        $res = "";
        $i = 0;
        foreach ($mizq['elementos'] as $elemizq) {
            $j = 0;
            foreach ($mder['elementos'] as $elemder) {
                $r = MultiplicarFunc($elemizq, $elemder);
                $s = "";
                if ($i == 0 && $j != 0)
                    $s = $mder['signos'][$j - 1];
                elseif ($i != 0 && $j == 0)
                    $s = $mizq['signos'][$i - 1];
                elseif ($i != 0 && $j != 0)
                    $s = ObtenerSigno($mizq['signos'][$i - 1], $mder['signos'][$j - 1]);


                if (is_numeric($r) && $r < 0) {
                    if ($s == "+")
                        $s = "";
                    elseif ($s == "-") {
                        $r *= -1;
                        $s = "+";
                    }
                }

                $res .= $s . $r;
                $j++;
            }
            $i++;
        }
        if ($f == $res)
            return $res;
        return ReducirFuncion($res);
    } elseif (BuscarbySigno($f, '/')) {
        $arr = MiembrosbySigno($f, "/");
        $mizq = Dentro($arr['mizq']);
        $mder = Dentro($arr['mder']);

        $polizq = DevolverPolinomio($mizq);
        $polder = DevolverPolinomio($mder);

        if (count($polizq['signos']) != 0) {
            $mizq = "";
            $i = 0;
            foreach ($polizq['elementos'] as $e) {
                if (!isSencilla($e))
                    $e = ReducirFuncion($e);

                if ($i != 0) {
                    if ($i != 0 && $polizq['signos'][$i - 1] == "-") {
                        $e = CambiarSignos($e);
                        $mizq .= $polizq['signos'][$i - 1] . $e;
                    } else
                        $mizq .= $polizq['signos'][$i - 1] . $e;
                } else {
                    $mizq .= $e;
                }

                $i++;
            }

            $mizq = ReducirFuncion($mizq);
        } else {
            if (!isSencilla($mizq))
                $mizq = ReducirFuncion($mizq);
        }

        if (count($polder['signos']) != 0) {
            $mder = "";
            $i = 0;
            foreach ($polder['elementos'] as $e) {
                if (!isSencilla($e))
                    $e = ReducirFuncion($e);

                if (count($polder['signos']) != $i)
                    $mder .= $e . $polder['signos'][$i];
                else {
                    $mder .= $e;
                }
                $i++;
            }

            $mder = ReducirFuncion($mder);

        } else {
            if (!isSencilla($mder))
                $mder = ReducirFuncion($mder);
        }


        if (isSencilla($mizq) && isSencilla($mder)) {
            return DividirFunc($mizq, $mder);
        }

        if (ReducirPolinomio($mizq, $mder))
            return "1";
        return "(" . $mizq . ")/(" . $mder . ")";

    } elseif (BuscarbySigno($f, "^")) {
        $arr = MiembrosbySigno($f, "^");
        $mizq = Dentro($arr['mizq']);
        $mder = Dentro($arr['mder']);
        $mizq = ReducirFuncion($mizq);
        $res = "(" . $mizq . ")^(" . $mder . ")";
        if (is_numeric($mder)) {
            if ($mder > 1) {
                $res = $mizq;
                for ($i = 1; $i < $mder; $i++) {
                    $res = "(" . $res . ")";
                    $res .= "*(" . $mizq . ")";
                }
                return ReducirFuncion($res);
            }
            if ($mder == 0)
                return "1";
            return $res;
        }
        $mder = ReducirFuncion($mder);
        $res = "(" . $mizq . ")^(" . $mder . ")";
        if (is_numeric($mder))
            return ReducirFuncion($res);
        return $res;
    }

    return $f;
}

function SumarFunc($arr)
{
    $i = 0;
    foreach ($arr['elementos'] as $elem1) {
        if ($arr['elementos'][$i] != "") {
            $j = 0;
            foreach ($arr['elementos'] as $elem2) {
                if ($j > $i && $arr['elementos'][$j] != "") {
                    $sige1 = "+";
                    if ($i != 0)
                        $sige1 = $arr['signos'][$i - 1];
                    $sige2 = $arr['signos'][$j - 1];
                    $s = SumarFunc1($elem1, $elem2, $sige1, $sige2);
                    if ($s != 'no') {
                        $arr['elementos'][$i] = $s['elem'];
                        if ($i != 0)
                            $arr['signos'][$i - 1] = $s['signo'];
                        elseif ($s['signo'] == "-") {
                            $aux = explode('*', $s['elem']);
                            $nu = preg_replace("/(\(|\))/", "", $aux[0]);
                            $nu = $nu * -1;
                            if (count($aux) > 1)
                                $s['elem'] = "(" . $nu . ")*" . $aux[1];
                            else
                                $s['elem'] = $nu;
                            $arr['elementos'][$i] = $s['elem'];

                        }
                        $arr['elementos'][$j] = "";
                        $arr['signos'][$j - 1] = "";
                        //$j--;
                        $elem1 = $arr['elementos'][$i];
                    }
                }
                $j++;
            }

        }

        $i++;
    }

    $res = "";
    $i = 0;

    foreach ($arr['elementos'] as $e) {
        if ($e !== "") {
            if ($i == 0)
                $res .= $e;
            else {
                $res .= $arr['signos'][$i - 1] . $e;
            }
        }
        $i++;
    }
    return $res;
}

function SumarFunc1($elem1, $elem2, $sige1, $sige2)
{
    if (isSencilla($elem1) && isSencilla($elem2)) {
        if (is_numeric($elem1) && is_numeric($elem2)) {
            $p = SumarNum($elem1, $elem2, $sige1, $sige2);
            $s = "-";
            if ($p >= 0)
                $s = "+";
            else
                $p *= -1;
            $res = array(
                "elem" => $p,
                "signo" => $s
            );
            return $res;
        } elseif (!is_numeric($elem1) && !is_numeric($elem2)) {

            $arr = explode('*', $elem1);
            $p1 = preg_replace("/(\(|\))/", "", $arr[0]);
            $arr = explode('^', $arr[1]);
            $e1 = preg_replace("/(\(|\))/", "", $arr[1]);

            $arr = explode('*', $elem2);
            $p2 = preg_replace("/(\(|\))/", "", $arr[0]);
            $arr = explode('^', $arr[1]);
            $e2 = preg_replace("/(\(|\))/", "", $arr[1]);

            if ($e1 == $e2) {
                $p = SumarNum($p1, $p2, $sige1, $sige2);
                $s = "+";
                if ($p < 0) {
                    $p = $p * -1;
                    $s = "-";
                }

                $n = "($p)*((x)^($e1))";

                $res = array(
                    "elem" => $n,
                    "signo" => $s
                );
                return $res;
            }
        }
        return 'no';
    }
    if ($elem1 == $elem2 && $sige1 != $sige2) {
        $res = array(
            "elem" => 0,
            "signo" => "+"
        );
        return $res;
    }
    return "no";
}

function SumarNum($p1, $p2, $sige1, $sige2)
{
    if (is_numeric($p1)) {
        $np1 = $p1;
        if ($sige1 == "-")
            $np1 *= -1;

        $dp1 = 1;
    } else {
        $arr = explode('/', $p1);
        $np1 = $arr[0];
        if ($sige1 == "-")
            $np1 *= -1;
        $dp1 = $arr[1];
    }

    if (is_numeric($p2)) {
        $np2 = $p2;
        if ($sige2 == "-")
            $np2 *= -1;
        $dp2 = 1;
    } else {
        $arr = explode('/', $p2);
        $np2 = $arr[0];
        if ($sige2 == "-")
            $np2 *= -1;
        $dp2 = $arr[1];
    }

    $n = $np1 * $dp2 + $np2 * $dp1;
    $d = $dp1 * $dp2;

    if ($n == $d)
        return "1";
    if ($n % $d == 0)
        return $n / $d;
    return $n . "/" . $d;
}

function MultiplicarFunc($elem1, $elem2)
{
    if (isSencilla($elem1) && isSencilla($elem2)) {
        if (is_numeric($elem1)) {
            $p1 = $elem1;
            $e1 = 0;
        } else {
            $arr = explode('*', $elem1);
            $p1 = preg_replace("/(\(|\))/", "", $arr[0]);
            $arr = explode('^', $arr[1]);
            $e1 = preg_replace("/(\(|\))/", "", $arr[1]);
        }

        if (is_numeric($elem2)) {
            $p2 = $elem2;
            $e2 = 0;
        } else {
            $arr = explode('*', $elem2);
            $p2 = preg_replace("/(\(|\))/", "", $arr[0]);
            $arr = explode('^', $arr[1]);
            $e2 = preg_replace("/(\(|\))/", "", $arr[1]);
        }

        $p = MultiplicarNum($p1, $p2);
        $e = $e1 + $e2;


        if (is_numeric($elem1) && is_numeric($elem2) || $e == 0)
            $res = $p;
        else {
            $res = "($p)*((x)^($e))";
        }
    } else {

        if (BuscarbySigno($elem1, '/')) {
            $arr = MiembrosbySigno($elem1, "/");
            $num1 = Dentro($arr['mizq']);
            $den1 = Dentro($arr['mder']);
        } else {
            $num1 = $elem1;
            $den1 = 1;
        }

        if (BuscarbySigno($elem2, '/')) {
            $arr = MiembrosbySigno($elem2, "/");
            $num2 = Dentro($arr['mizq']);
            $den2 = Dentro($arr['mder']);
        } else {
            $num2 = $elem2;
            $den2 = 1;
        }

        if (BuscarbySigno($elem1, '/') || BuscarbySigno($elem2, '/'))
            $res = "((" . $num1 . ")*(" . $num2 . "))/((" . $den1 . ")*(" . $den2 . "))";
        else $res = "(" . $num1 . ")*(" . $num2 . ")";
    }

    return $res;
}

function MultiplicarNum($p1, $p2)
{
    if (is_numeric($p1)) {
        $np1 = $p1;
        $dp1 = 1;
    } else {
        $arr = explode('/', $p1);
        $np1 = $arr[0];
        $dp1 = $arr[1];
    }

    if (is_numeric($p2)) {
        $np2 = $p2;
        $dp2 = 1;
    } else {
        $arr = explode('/', $p2);
        $np2 = $arr[0];
        $dp2 = $arr[1];
    }

    $n = $np1 * $np2;
    $d = $dp1 * $dp2;

    if ($n == $d)
        return "1";
    if ($n % $d == 0)
        return $n / $d;
    return $n . "/" . $d;
}

function DividirFunc($elem1, $elem2)
{
    if (is_numeric($elem1)) {
        $p1 = $elem1;
        $e1 = 0;
    } else {
        $arr = explode('*', $elem1);
        $p1 = preg_replace("/(\(|\))/", "", $arr[0]);
        $arr = explode('^', $arr[1]);
        $e1 = preg_replace("/(\(|\))/", "", $arr[1]);
    }

    if (is_numeric($elem2)) {
        $p2 = $elem2;
        $e2 = 0;
    } else {
        $arr = explode('*', $elem2);
        $p2 = preg_replace("/(\(|\))/", "", $arr[0]);
        $arr = explode('^', $arr[1]);
        $e2 = preg_replace("/(\(|\))/", "", $arr[1]);
    }

    $p = DividirNum($p1, $p2);
    $e = $e1 - $e2;

    if (is_numeric($elem1) && is_numeric($elem2) || $e == 0)
        $res = $p;
    else {
        $res = "($p)*((x)^($e))";
    }

    return $res;
}

function DividirNum($p1, $p2)
{
    if (is_numeric($p1)) {
        $np1 = $p1;
        $dp1 = 1;
    } else {
        $arr = explode('/', $p1);
        $np1 = $arr[0];
        $dp1 = $arr[1];
    }

    if (is_numeric($p2)) {
        $np2 = $p2;
        $dp2 = 1;
    } else {
        $arr = explode('/', $p2);
        $np2 = $arr[0];
        $dp2 = $arr[1];
    }

    $n = $np1 * $dp2;
    $d = $dp1 * $np2;

    if ($n == $d)
        return "1";
    return $n / $d;
}

function ReducirPolinomio($mizq, $mder)
{
    $mizq = DevolverPolinomio($mizq);
    $cizq = count($mizq['elementos']);
    $mder = DevolverPolinomio($mder);
    $cder = count($mder['elementos']);
    $i = 0;
    foreach ($mizq['elementos'] as $elemizq) {
        $j = 0;
        foreach ($mder['elementos'] as $elemder) {
            if ($elemder != "") {
                if ($i != 0 && $j != 0) {
                    if ($elemizq == $elemder && $mizq['signos'][$i - 1] == $mder['signos'][$j - 1]) {
                        $cizq--;
                        $cder--;
                        $mder['elementos'][$j] = "";
                        break;
                    }
                } elseif ($i == 0 && $j == 0) {
                    if ($elemizq == $elemder) {
                        $cizq--;
                        $cder--;
                        $mder['elementos'][$j] = "";
                        break;
                    }
                } elseif ($i == 0 && $j != 0) {
                    if ($elemizq == $elemder && $mder['signos'][$j - 1] == "+") {
                        $cizq--;
                        $cder--;
                        $mder['elementos'][$j] = "";
                        break;
                    }
                } elseif ($i != 0 && $j == 0) {
                    if ($elemizq == $elemder && $mizq['signos'][$i - 1] == "+") {
                        $cizq--;
                        $cder--;
                        $mder['elementos'][$j] = "";
                        break;
                    }
                }
            }
            $j++;
        }
        $i++;
    }

    if ($cizq == 0 && $cder == 0) {
        return true;
    }
    return false;
}

function ObtenerSigno($s1, $s2)
{
    if (($s1 == '+' && $s2 == '+') || ($s1 == '-' && $s2 == '-'))
        return '+';
    return '-';
}

function CambiarSignos($pol)
{
    $pol = DevolverPolinomio($pol);
    $res = "";
    $i = 0;
    foreach ($pol['elementos'] as $elem) {
        if ($i != 0) {
            $s = "+";
            if ($pol['signos'][$i - 1] == "+")
                $s = "-";
            $res .= $s . $elem;
        } else
            $res .= $elem;
        $i++;
    }

    return $res;
}

function isSencilla($f)
{
    $b = preg_replace("/\([0-9]+\)\*\(\(x\)\^\([0-9]+\)\)/", "", $f, 1);
    $b1 = preg_replace("/\([0-9]+\)\*\(\(x\)\^\(\-[0-9]+\)\)/", "", $f, 1);
    $b2 = preg_replace("/\([0-9]+\/[0-9]+\)\*\(\(x\)\^\([0-9]+\)\)/", "", $f, 1);
    $b3 = preg_replace("/\([0-9]+\/[0-9]+\)\*\(\(x\)\^\(\-[0-9]+\)\)/", "", $f, 1);

    $b4 = preg_replace("/\(\-[0-9]+\)\*\(\(x\)\^\([0-9]+\)\)/", "", $f, 1);
    $b5 = preg_replace("/\(\-[0-9]+\)\*\(\(x\)\^\(\-[0-9]+\)\)/", "", $f, 1);
    $b6 = preg_replace("/\(\-[0-9]+\/[0-9]+\)\*\(\(x\)\^\([0-9]+\)\)/", "", $f, 1);
    $b7 = preg_replace("/\(\-[0-9]+\/[0-9]+\)\*\(\(x\)\^\(\-[0-9]+\)\)/", "", $f, 1);


    if ($b == "" || $b1 == "" || $b2 == "" || $b3 == "" || $b4 == "" || $b5 == "" || $b6 == "" || $b7 == "" || is_numeric($f))
        return true;
    return false;
}

function RempFun($f)
{
    // numero * x^numero
    $f = preg_replace("/\(([0-9]+)\)\*\(\(x\)\^\(([0-9]+)\)\)/", "($1)*((y)^($2))", $f);
    $f = preg_replace("/\(\(x\)\^\(([0-9]+)\)\)\*\(([0-9]+)\)/", "($2)*((y)^($1))", $f);
    $f = preg_replace("/\(-([0-9]+)\)\*\(\(x\)\^\(([0-9]+)\)\)/", "(-$1)*((y)^($2))", $f);

    // numero / x^numero
    $f = preg_replace("/\(([0-9]+)\)\\/\(\(x\)\^\(([0-9]+)\)\)/", "($1)*((y)^(-$2))", $f);
    $f = preg_replace("/\(\(x\)\^\(([0-9]+)\)\)\\/\(([0-9]+)\)/", "(1/$2)*((y)^($1))", $f);

    // numero * x
    $f = preg_replace("/\(([0-9]+)\)\*\(x\)/", "($1)*((y)^(1))", $f);
    $f = preg_replace("/\(x\)\*\(([0-9]+)\)/", "($1)*((y)^(1))", $f);

    // -numero * x
    $f = preg_replace("/\(\-([0-9]+)\)\*\(x\)/", "(-$1)*((y)^(1))", $f);
    $f = preg_replace("/\(x\)\*\(\-([0-9]+)\)/", "(-$1)*((y)^(1))", $f);

    // numero / x
    $f = preg_replace("/\(([0-9]+)\)\/\(x\)/", "($1)*((y)^(-1))", $f);
    $f = preg_replace("/\(x\)\/\(([0-9]+)\)/", "(1/$1)*((y)^(1))", $f);

    // -numero / x
    $f = preg_replace("/\(\-([0-9]+)\)\/\(x\)/", "(-$1)*((y)^(-1))", $f);
    $f = preg_replace("/\(x\)\/\(\-([0-9]+)\)/", "(-1/$1)*((y)^(1))", $f);

    $f = preg_replace("/\(x\)\^\(([0-9]+)\)/", "(1)*((y)^($1))", $f);

    $f = preg_replace("/x/", "(1)*((y)^(1))", $f);

    $f = preg_replace("/y/", "x", $f);

    return $f;
}

function UnRempFunc($f)
{
    $f = preg_replace("/\(0\)\*\(\(x\)\^\(([0-9]+)\)\)/", "0", $f);
    $f = preg_replace("/\(1\)\*\(\(x\)\^\(1\)\)/", "x", $f);
    $f = preg_replace("/\(1\)\*\(\(x\)\^\(([0-9]+)\)\)/", "(x)^($1)", $f);
    $f = preg_replace("/\(([0-9]+)\)\*\(\(x\)\^\(1\)\)/", "($1)*(x)", $f);
    $f = preg_replace("/\(([0-9]+)\/([0-9]+)\)\*\((.*)\)/", "(($1)*($3))/($2)", $f);

    $pol = DevolverPolinomio($f);
    $res = "";
    $i = 0;
    foreach ($pol['elementos'] as $elem) {
        $elem = MultiplicarBy0or1($elem);
        $elem = DividirBy0or1($elem);

        if ($i != 0) {
            $res .= $pol['signos'][$i - 1] . $elem;
        } else {
            $res .= $elem;
        }

        $i++;
    }

    $res = PotenciaBy0or1($res);

    $res = preg_replace("/\+0/", "", $res);
    $res = preg_replace("/\-0/", "", $res);
    $res = preg_replace("/\(x\)\^\(\-([0-9]+)\)/", "(1)/((x)^($1))", $res);

    return $res;
}

function MultiplicarBy0or1($elem)
{
    if (BuscarbySigno($elem, "*")) {
        $arr = MiembrosbySigno($elem, "*");
        $mizq = Dentro($arr['mizq']);
        $mder = Dentro($arr['mder']);

        if ($mizq == '0' || $mder == '0')
            return "0";
        if ($mizq == '1')
            return $mder;
        if ($mder == '1')
            return $mizq;
    }
    return $elem;
}

function DividirBy0or1($elem)
{
    if (BuscarbySigno($elem, "/")) {
        $arr = MiembrosbySigno($elem, "/");
        $mizq = Dentro($arr['mizq']);
        $mder = Dentro($arr['mder']);

        if ($mizq == '0')
            return "0";
        if ($mder == '1')
            return $mizq;
    }
    return $elem;
}

function PotenciaBy0or1($texto)
{
    for ($i = 0; $i < strlen($texto); $i++) {
        $tex1 = "";
        $tex2 = "";
        if ($texto[$i] == "^") {
            $ini = 0;
            $fin = 0;

            $finish = false;
            $j = $i;
            $cont1 = 0;
            while (!$finish) {
                if ($texto[$j - 1] == ")")
                    $cont1++;

                if ($texto[$j - 1] == "(") {
                    $cont1--;
                }
                $tex1 = $texto[$j - 1] . $tex1;
                $j--;
                if ($cont1 == 0 && $j - 1 < $i) {
                    $finish = true;
                    $ini = $j;
                }
            }

            $cont1 = 0;
            $finish = false;
            $j = $i + 1;
            while (!$finish) {
                if ($texto[$j] == ")")
                    $cont1--;

                if ($texto[$j] == "(") {
                    $cont1++;
                }
                $tex2 .= $texto[$j];
                $j++;
                if ($cont1 == 0 && $j > $i) {
                    $finish = true;
                    $fin = $j - 1;
                }
            }

            if ($tex2 == '(0)') {
                $texto = substr_replace($texto, "1", $ini, $fin - $ini + 1);
                return PotenciaBy0or1($texto);
            }
            if ($tex2 == '(1)') {
                $texto = substr_replace($texto, Dentro($tex1), $ini, $fin - $ini + 1);
                return PotenciaBy0or1($texto);
            }
        }
    }

    return $texto;
}

function Es_Deribable($texto)
{
    if (strstr($texto, "/"))
        return false;
    else
        return true;
}

function Transformar($texto, $x)
{
    $t = ObtenerFuncion($texto, $x);
    if (!is_a($t, "racional") || (is_a($t, "racional") && $t->tipo == "racionalM")) {
        $r = BuscarbySigno($texto, "^");
        if ($r) {
            $arr = MiembrosbySigno($texto, "^");
            $texto = substr_replace($texto, Limite($arr['func'], $x), $arr['ini'], $arr['fin'] - $arr['ini'] + 1);
            return Transformar($texto, $x);
        } else {
            $r = BuscarbySigno($texto, "*");
            $seguirparaabajo = false;
            if ($r) {
                $arr = MiembrosbySigno($texto, "*");
                $tex = CalcMultiplicacion($arr['mizq'], $arr['mder'], $x);
                if ($tex) {
                    $texto = substr_replace($texto, $tex, $arr['ini'], $arr['fin'] - $arr['ini'] + 1);
                    return Transformar($texto, $x);
                }
                $seguirparaabajo = true;
            }
            if ($seguirparaabajo || !$r) {
                $r = BuscarbySigno($texto, "+");
                if ($r) {
                    $arr = MiembrosbySignoMasMenos($texto, "+");
                    $tex = CalcSumaResta($arr['mizq'], $arr['mder'], "+");
                    $texto = substr_replace($texto, $tex, $arr['ini'], $arr['fin'] - $arr['ini'] + 1);

                    return Transformar($texto, $x);
                } else {
                    $r = BuscarbySigno($texto, "-");
                    if ($r) {
                        $arr = MiembrosbySignoMasMenos($texto, "-");
                        $tex = CalcSumaResta($arr['mizq'], $arr['mder'], "-");
                        $texto = substr_replace($texto, $tex, $arr['ini'], $arr['fin'] - $arr['ini'] + 1);

                        return Transformar($texto, $x);
                    }
                }
            }
        }
    }
    return $texto;
}

function BuscarbySigno($texto, $signo)
{
    $cont = 0;
    //$entro=false;
    for ($i = 0; $i < strlen($texto); $i++) {
        if ($texto[$i] == ")")
            $cont--;

        if ($texto[$i] == "(") {
            $cont++;
            //$entro=true;
        }

        if ($cont == 0 /*&& $entro==true*/) {
            if ($i + 1 < strlen($texto)) {

                if ($texto[$i + 1] == $signo) {
                    return true;
                }
            }
        }
    }
    return false;
}

function MiembrosbySigno($texto, $signo)
{
    $cont = 0;
    $entro = false;
    $tex1 = "";
    $tex2 = "";
    for ($i = 0; $i < strlen($texto); $i++) {
        if ($texto[$i] == ")")
            $cont--;

        if ($texto[$i] == "(") {
            $cont++;
            $entro = true;
        }

        if ($cont == 0 && $entro == true) {
            if ($i + 1 < strlen($texto)) {
                if ($texto[$i + 1] == $signo) {
                    $ini = 0;
                    $fin = 0;

                    $finish = false;
                    $j = $i;
                    $cont1 = 0;
                    while (!$finish) {
                        if ($texto[$j] == ")")
                            $cont1++;

                        if ($texto[$j] == "(") {
                            $cont1--;
                        }
                        $tex1 = $texto[$j] . $tex1;
                        $j--;
                        if ($cont1 == 0 && $j < $i) {
                            $finish = true;
                            $ini = $j + 1;
                        }

                    }

                    $cont1 = 0;
                    $finish = false;
                    $j = $i + 2;
                    while (!$finish) {
                        if ($texto[$j] == ")")
                            $cont1--;

                        if ($texto[$j] == "(") {
                            $cont1++;
                        }
                        $tex2 .= $texto[$j];
                        $j++;
                        if ($cont1 == 0 && $j > $i) {
                            $finish = true;
                            $fin = $j - 1;
                        }
                    }

                    return array("func" => $tex1 . $signo . $tex2, "mizq" => $tex1, "mder" => $tex2, "ini" => $ini, "fin" => $fin);
                }
            }
        }
    }

    return false;
}

function MiembrosbySignoMasMenos($texto, $signo)
{
    $cont = 0;
    $entro = false;
    $tex1 = "";
    $tex2 = "";
    for ($i = 0; $i < strlen($texto); $i++) {
        if ($texto[$i] == ")")
            $cont--;

        if ($texto[$i] == "(") {
            $cont++;
            $entro = true;
        }

        if ($cont == 0 && $entro == true) {
            if ($i + 1 < strlen($texto)) {
                if ($texto[$i + 1] == $signo) {
                    $ini = 0;
                    $fin = 0;

                    $finish = false;
                    $j = $i;
                    $cont1 = 0;
                    while (!$finish) {
                        if ($texto[$j] == ")")
                            $cont1++;

                        if ($texto[$j] == "(") {
                            $cont1--;
                        }
                        $tex1 = $texto[$j] . $tex1;
                        $j--;
                        if ($j < 0 || ($cont1 == 0 && ($texto[$j] == "+" || $texto[$j] == "-"))) {
                            $finish = true;
                            $ini = $j + 1;
                        }

                    }

                    $cont1 = 0;
                    $finish = false;
                    $j = $i + 2;
                    while (!$finish) {
                        if ($texto[$j] == ")")
                            $cont1--;

                        if ($texto[$j] == "(") {
                            $cont1++;
                        }
                        $tex2 .= $texto[$j];
                        $j++;
                        if ($j >= strlen($texto) || ($cont1 == 0 && ($texto[$j] == "+" || $texto[$j] == "-"))) {
                            $finish = true;
                            $fin = $j - 1;
                        }
                    }

                    return array("func" => $tex1 . $signo . $tex2, "mizq" => $tex1, "mder" => $tex2, "ini" => $ini, "fin" => $fin);
                }
            }
        }
    }

    return false;
}

function CalcMultiplicacion($t1, $t2, $x)
{
    $t1 = Dentro($t1);
    $t2 = Dentro($t2);
    $tex1 = ObtenerFuncion($t1);
    $tex2 = ObtenerFuncion($t2);

    if (is_a($tex1, "racional") && $tex1->tipo != "racionalM" || is_a($tex2, "racional") && $tex2->tipo != "racionalM") {
        $num1 = "";
        $num2 = "";
        $den1 = "";
        $den2 = "";
        if (!BuscarbySigno($t1, "/")) {
            $num1 = "(" . $t1 . ")";
            $den1 = "(1)";
        } else {
            $arr = MiembrosbySigno($t1, "/");
            $num1 = $arr["mizq"];
            $den1 = $arr["mder"];
        }
        if (!BuscarbySigno($t2, "/")) {
            $num2 = "(" . $t2 . ")";
            $den2 = "(1)";
        } else {
            $arr = MiembrosbySigno($t2, "/");
            $num2 = $arr["mizq"];
            $den2 = $arr["mder"];
        }

        $texto = "(" . $num1 . "*" . $num2 . ")/(" . $den1 . "*" . $den2 . ")";

        return $texto;
    } elseif (strstr($t1, "/") || strstr($t2, "/")) {

        if (strstr($t1, "/"))
            $t1 = Transformar($t1, $x);
        if (strstr($t2, "/"))
            $t2 = Transformar($t2, $x);

        $texto = "(" . $t1 . ")*(" . $t2 . ")";

        return $texto;
    }
    return false;
}

function CalcDivision($t1, $t2)
{
    $tex1 = ObtenerFuncion($t1);
    $tex2 = ObtenerFuncion($t2);
    if (is_a($tex1, "racional") && $tex1->tipo != "racionalM" || is_a($tex2, "racional") && $tex2->tipo != "racionalM") {
        $num1 = "";
        $num2 = "";
        $den1 = "";
        $den2 = "";
        if (!BuscarbySigno($t1, "/")) {
            $num1 = "(" . $t1 . ")";
            $den1 = "(1)";
        } else {
            $arr = MiembrosbySigno($t1, "/");
            $num1 = $arr["mizq"];
            $den1 = $arr["mder"];
        }
        if (!BuscarbySigno($t2, "/")) {
            $num2 = "(" . $t2 . ")";
            $den2 = "(1)";
        } else {
            $arr = MiembrosbySigno($t2, "/");
            $num2 = $arr["mizq"];
            $den2 = $arr["mder"];
        }
        $texto = "(" . $num1 . "*" . $den2 . ")/(" . $den1 . "*" . $num2 . ")";

        return $texto;
    }
    return false;
}

function CalcSumaResta($t1, $t2, $sig)
{
    $tex1 = ObtenerFuncion($t1);
    $tex2 = ObtenerFuncion($t2);
    if (is_a($tex1, "racional") && $tex1->tipo != "racionalM" || is_a($tex2, "racional") && $tex2->tipo != "racionalM") {
        $num1 = "";
        $num2 = "";
        $den1 = "";
        $den2 = "";
        if (!BuscarbySigno($t1, "/")) {
            $num1 = "(" . $t1 . ")";
            $den1 = "(1)";
        } else {
            $arr = MiembrosbySigno($t1, "/");
            $num1 = $arr["mizq"];
            $den1 = $arr["mder"];
        }
        if (!BuscarbySigno($t2, "/")) {
            $num2 = "(" . $t2 . ")";
            $den2 = "(1)";
        } else {
            $arr = MiembrosbySigno($t2, "/");
            $num2 = $arr["mizq"];
            $den2 = $arr["mder"];
        }

        $texto = "(" . $num1 . "*" . $den2 . $sig . $num2 . "*" . $den1 . ")/(" . $den1 . "*" . $den2 . ")";
        return $texto;
    }
    return false;
}

function Limite($texto, $x)
{
    $texto = RempFun($texto);
    $texto = ReducirFuncion($texto);
    $texto = UnRempFunc($texto);

    if (strstr($texto, "sen") && is_infinite($x) || strstr($texto, "cos") && is_infinite($x) || strstr($texto, "tan") && is_infinite($x))
        return false;

    $f = ObtenerFuncion($texto, $x);

    if (is_numeric($f->GetY()) && !is_nan($f->GetY())) {
        return $f->GetY();
    } else {
        if (is_a($f, "racional") && $f->tipo == "racional") {
            $elementos = SepararExponencialRacionalRadical($texto);
            $n = ObtenerFuncion($elementos["hijo"], $x);
            $d = ObtenerFuncion($elementos["argumento"], $x);

            if (is_infinite($n->GetY()) || is_infinite($d->GetY()) || ($n->GetY() == 0 && $d->GetY() == 0) || is_nan($n->GetY()) && is_nan($d->GetY())) {
                $entro = false;
                $texto_trans1 = $elementos["hijo"];
                $texto_trans2 = $elementos["argumento"];
                if (!Es_Deribable($elementos["hijo"])) {
                    $texto_trans1 = Transformar($elementos["hijo"], $x);
                    $entro = true;
                }
                if (!Es_Deribable($elementos["argumento"])) {
                    $texto_trans2 = Transformar($elementos["argumento"], $x);
                    $entro = true;
                }
                if (!$entro) {
                    $elementos = SepararExponencialRacionalRadical($texto);
                    $n = ObtenerFuncion($elementos["hijo"], $x);
                    $d = ObtenerFuncion($elementos["argumento"], $x);

                    $t = "(" . $n->derivada . ")/(" . $d->derivada . ")";
                    $t = RempFun($t);
                    $t = ReducirFuncion($t);
                    $t = UnRempFunc($t);
                    return Limite($t, $x);
                } else {
                    $tex = CalcDivision($texto_trans1, $texto_trans2);
                    $tex = RempFun($tex);
                    $tex = ReducirFuncion($tex);
                    $tex = UnRempFunc($tex);

                    return Limite($tex, $x);
                }
            } else {
                if (is_numeric($d->GetY()) && !is_nan($d->GetY())) {
                    return INF;
                }
            }
        } else {
            if (is_a($f, "polinomicas")) {
                $responce = DevolverPolinomio($texto);
                $t = false;
                foreach ($responce["elementos"] as $e) {
                    if (BuscarbySigno($e, "/")) {
                        $t = true;
                    }
                }
                if ($t) {
                    $res = ReducirFuncion1(Transformar($texto, $x));

                    return Limite($res, $x);
                } else {
                    $res = "";
                    $cont = 0;
                    $t = "";
                    foreach ($responce["elementos"] as $e) {
                        $signo = "";
                        if (count($responce["signos"]) > 0 && $cont < count($responce["signos"]))
                            $signo = $responce["signos"][$cont];
                        $cont++;
                        $t .= $e;
                        $resultado = ObtenerFuncion($t, $x)->resultadoY;
                        if ($signo == "-" || ($resultado) === (-INF) || is_nan($resultado)) {
                            $taux = "";
                            for ($i = $cont; $i < count($responce["elementos"]); $i++) {
                                $saux = "";
                                if (count($responce["signos"]) > 0 && $i < count($responce["signos"]))
                                    $saux = $responce["signos"][$i];
                                $taux .= $responce["elementos"][$i] . $saux;
                            }
                            if (is_infinite($resultado) && is_infinite(ObtenerFuncion($taux, $x)->resultadoY)) {
                                $res = "((" . $t . "-" . $taux . ")*(" . $t . "+" . $taux . "))/(" . $t . "+" . $taux . ")";
                                break;
                            } else
                                $t .= $signo;
                        } else {
                            $t .= $signo;
                        }
                    }
                    if ($res == "") {
                        $t = "";
                        $i = 0;
                        $taux = 0;
                        foreach ($responce["elementos"] as $e) {
                            if (is_infinite(ObtenerFuncion($e, $x)->resultadoY)) {
                                if ($i == 0) {
                                    $t .= $e;
                                    $taux = $e;
                                }
                                if (ObtenerFuncion($e, $x)->resultadoY === -INF && ObtenerFuncion($taux, $x)->resultadoY === INF || ObtenerFuncion($e, $x)->resultadoY === INF && ObtenerFuncion($taux, $x)->resultadoY === -INF) {
                                    if ($i > 0) {
                                        if ($responce["signos"][$i - 1] == "-")
                                            $res = "((" . $t . "-" . $e . ")*(" . $t . "+" . $e . "))/(" . $t . "+" . $e . ")";
                                        else
                                            $res = "((" . $t . "+" . $e . ")*(" . $t . "-" . $e . "))/(" . $t . "-" . $e . ")";
                                        if ($i > 0)
                                            $t .= $responce["signos"][$i - 1];
                                        else
                                            $t .= "+";
                                    } else {
                                        $res = "((" . $t . "+" . $e . ")*(" . $t . "-" . $e . "))/(" . $t . "-" . $e . ")";
                                        if ($i > 0)
                                            $t .= $responce["signos"][$i - 1];
                                        else
                                            $t .= "+";
                                    }
                                } else {
                                    $taux = $e;
                                }
                            }
                            if ($i != 0)
                                $t .= $e;
                            $i++;
                        }
                    }
                    $res = RempFun($res);
                    $res = ReducirFuncion($res);
                    $res = UnRempFunc($res);
                    if ($res != "")
                        return Limite($res, $x);
                    return false;
                }
            } else {
                if (is_a($f, "racional") && $f->tipo == "racionalM") {
                    $elementos = SepararExponencialRacionalRadical($texto);
                    $t = "(" . $elementos["argumento"] . ")/((1)/(" . $elementos["hijo"] . "))";
                    return Limite($t, $x);
                } else {
                    if (is_a($f, "Exponenciales")) {
                        $elementos = SepararExponencialRacionalRadical($texto);
                        $hijo = ObtenerFuncion($elementos["hijo"], $x);
                        $argumento = ObtenerFuncion($elementos["argumento"], $x);
                        if ($hijo->GetY() == 0 && $argumento->GetY() == 0 || is_infinite($hijo->GetY()) && $argumento->GetY() == 0) {
                            $l = ObtenerFuncion("(1)/(" . $elementos["argumento"] . ")", $x)->derivada;
                            $l1 = ObtenerFuncion("log(" . $elementos["hijo"] . ")", $x)->derivada;
                            $l3 = "(" . $l1 . ")/(" . $l . ")";
                            return pow(M_E, Limite($l3, $x));
                        }
                        if (is_nan($hijo->GetY()) && is_infinite($argumento->GetY())) {
                            $l = ObtenerFuncion("(1)/(" . $elementos["argumento"] . ")", $x)->derivada;
                            $l1 = ObtenerFuncion("log(" . $elementos["hijo"] . ")", $x)->derivada;
                            $l3 = "(" . $l1 . ")/(" . $l . ")";

                            $l3 = RempFun($l3);
                            $l3 = ReducirFuncion($l3);
                            $l3 = UnRempFunc($l3);

                            return pow(M_E, Limite($l3, $x));
                        }
                    }
                }
            }
        }
    }

    return false;
}

function HayarX($texto_funcion)
{
    $res = array();
    $responce = DevolverPolinomio($texto_funcion);
    $bo = false;

    if (is_numeric($texto_funcion))
        $res[] = "no";
    else {
        if (count($responce["elementos"]) > 1) {
            for ($i = 0; $i < count($responce["elementos"]); $i++) {
                if (preg_match("/^log/", $responce["elementos"][$i]) || preg_match("/^cos/", $responce["elementos"][$i]) || preg_match("/^sen/", $responce["elementos"][$i]) || preg_match("/^tan/", $responce["elementos"][$i])) {
                    $bo = true;
                }

                if (strstr($texto_funcion, '‍‍‍‍√') == true) {
                    $bo = true;
                }

            }
            $ruff = array();
            if ($bo == false)
                $ruff = Ruffini($texto_funcion);
            if (count($ruff) > 0 && $bo == false) {
                foreach (Ruffini($texto_funcion) as $r) {
                    $res[] = "x = " . $r;
                }
            } else
                $res[] = "no";
        } else {
            $temp = $texto_funcion;
            if (BuscarbySigno($texto_funcion, "*")) {
                $temp = MiembrosbySigno($texto_funcion, "*");
                $temp = Dentro($temp["mder"]);
            }
            $texto_funcion = $temp;
            $tipo = BuscarExponencialRacionalRadical($temp);
            if ($tipo != "") {
                if ($tipo = "racional")
                    $texto_funcion = Dentro($texto_funcion);

                while ($texto_funcion[0] == "(" && $texto_funcion[1] == "(") {
                    $texto_funcion = Dentro($texto_funcion);
                }
                $bo = false;
                if (strstr($texto_funcion, '‍‍‍‍√') == true) {
                    $bo = true;
                }
                $arr = array();
                if ($bo != true)
                    $arr = Ruffini($texto_funcion);
                if (count($arr) > 0) {
                    foreach ($arr as $r) {
                        $res[] = "x = " . $r;
                    }
                } else
                    $res[] = "no";
            } else {
                if (preg_match("/^log/", $texto_funcion)) {
                    $res[] = "no";
                }
                if (preg_match("/^cos/", $texto_funcion)) {
                    if (Dentro($texto_funcion) == "x")
                        $res[] = "x = " . acos(0);
                }
                if (preg_match("/^sen/", $texto_funcion)) {
                    if (Dentro($texto_funcion) == "x")
                        $res[] = "x = " . asin(0);
                }
                if (preg_match("/^tan/", $texto_funcion)) {
                    if (Dentro($texto_funcion) == "x")
                        $res[] = "x = " . atan(0);
                }
                if ($texto_funcion == "x") {
                    $res[] = "x = 0";
                }
            }
        }
    }
    return ($res);
}

function ObtenerFuncion($texto_funcion, $valor = 0)
{
    $funcion = null;
    $responce = DevolverPolinomio($texto_funcion);
    if (count($responce["elementos"]) > 1) {
        $funcion = new Polinomicas($responce["elementos"], $responce["signos"], $valor);
    } else {
        $tipo = BuscarExponencialRacionalRadical($texto_funcion);
        if ($tipo == "exponencial") {
            $elementos = SepararExponencialRacionalRadical($texto_funcion);
            $funcion = new Exponenciales($elementos["hijo"], $elementos["argumento"], $valor);
        } else {
            if ($tipo == "racional" || $tipo == "racionalM") {
                $elementos = SepararExponencialRacionalRadical($texto_funcion);
                if ($tipo == "racional") {
                    $funcion = new Racional($elementos["hijo"], $elementos["argumento"], $valor);
                } else {
                    $funcion = new Racional($elementos["hijo"], $elementos["argumento"], $valor, "racionalM");
                }
            } else {
                if ($tipo == "radical") {
                    $elementos = SepararExponencialRacionalRadical($texto_funcion);
                    $funcion = new Radical($elementos["hijo"], $elementos["argumento"], $valor);
                } else {
                    if (preg_match("/^log/", $texto_funcion)) {
                        $funcion = new Logaritmicas(Dentro($texto_funcion), $valor);
                    }
                    if (preg_match("/^cos/", $texto_funcion)) {
                        $funcion = new Trigonometricas(Dentro($texto_funcion), "cos", $valor);
                    }
                    if (preg_match("/^sen/", $texto_funcion)) {
                        $funcion = new Trigonometricas(Dentro($texto_funcion), "sen", $valor);
                    }
                    if (preg_match("/^tan/", $texto_funcion)) {
                        $funcion = new Trigonometricas(Dentro($texto_funcion), "tan", $valor);
                    } else {
                        if (is_numeric($texto_funcion) || $texto_funcion == "x") {
                            $funcion = new Numericas($texto_funcion, $valor);
                        }
                    }
                }
            }
        }
    }
    return $funcion;
}

function OrdenarPolinomio($polinomio, $signos)
{
    for ($i = 0; $i < count($polinomio); $i++) {
        for ($j = 0; $j < count($polinomio) - 1; $j++) {
            if (is_numeric($polinomio[$j])) {
                if ($j != 0)
                    $s = $signos[$j - 1];
                else
                    $s = "+";
                $signos[$j - 1] = $signos[$j];
                $signos[$j] = $s;

                $mayor = $polinomio[$j];
                $polinomio[$j] = $polinomio[$j + 1];
                $polinomio[$j + 1] = $mayor;
            } else {
                if (!is_numeric($polinomio[$j + 1])) {
                    $arr = explode('*', $polinomio[$j]);
                    $arr = explode('^', $arr[1]);
                    $e1 = preg_replace("/(\(|\))/", "", $arr[1]);

                    $arr = explode('*', $polinomio[$j + 1]);
                    $arr = explode('^', $arr[1]);
                    $e2 = preg_replace("/(\(|\))/", "", $arr[1]);
                    if ($e1 < $e2) {
                        if ($j != 0)
                            $s = $signos[$j - 1];
                        else
                            $s = "+";
                        if ($j != 0) {
                            $signos[$j - 1] = $signos[$j];
                            $signos[$j] = $s;
                        } else {
                            if ($signos[$j] == "-") {
                                $arr = explode('*', $polinomio[$j + 1]);
                                $arr[0] = Dentro($arr[0]) * -1;
                                $polinomio[$j + 1] = "(" . $arr[0] . ")*" . $arr[1] . "";
                            }
                            $signos[$j] = $s;
                        }

                        $mayor = $polinomio[$j];
                        $polinomio[$j] = $polinomio[$j + 1];
                        $polinomio[$j + 1] = $mayor;
                    }
                }
            }

        }

    }
    $res = array();
    foreach ($polinomio as $p) {
        if (UnRempFunc($p) != "0")
            $res[] = UnRempFunc($p);
    }
    $polinomio = $res;
    return $polinomio;
}

function OrdenarPolinomio1($polinomio, $signos)
{
    for ($i = 0; $i < count($polinomio); $i++) {
        for ($j = 0; $j < count($polinomio) - 1; $j++) {
            if (is_numeric($polinomio[$j])) {
                if ($j != 0)
                    $s = $signos[$j - 1];
                else
                    $s = "+";
                $signos[$j - 1] = $signos[$j];
                $signos[$j] = $s;

                $mayor = $polinomio[$j];
                $polinomio[$j] = $polinomio[$j + 1];
                $polinomio[$j + 1] = $mayor;
            } else {
                if (!is_numeric($polinomio[$j + 1])) {
                    $arr = explode('*', $polinomio[$j]);
                    $arr = explode('^', $arr[1]);
                    $e1 = preg_replace("/(\(|\))/", "", $arr[1]);

                    $arr = explode('*', $polinomio[$j + 1]);
                    $arr = explode('^', $arr[1]);
                    $e2 = preg_replace("/(\(|\))/", "", $arr[1]);
                    if ($e1 < $e2) {
                        if ($j != 0)
                            $s = $signos[$j - 1];
                        else
                            $s = "+";
                        if ($j != 0) {
                            $signos[$j - 1] = $signos[$j];
                            $signos[$j] = $s;
                        } else {
                            if ($signos[$j] == "-") {
                                $arr = explode('*', $polinomio[$j + 1]);
                                $arr[0] = Dentro($arr[0]) * -1;
                                $polinomio[$j + 1] = "(" . $arr[0] . ")*" . $arr[1] . "";
                            }
                            $signos[$j] = $s;
                        }

                        $mayor = $polinomio[$j];
                        $polinomio[$j] = $polinomio[$j + 1];
                        $polinomio[$j + 1] = $mayor;
                    }
                }
            }

        }

    }
    $res = array();
    foreach ($polinomio as $p) {
        if (UnRempFunc($p) != "0")
            $res[] = UnRempFunc($p);
    }
    $polinomio["pol"] = $res;
    $polinomio["sig"] = $signos;
    return $polinomio;
}

//busca si la funcion es Exponencial Racional Radical y devuelve un string con el tipo
function BuscarExponencialRacionalRadical($texto)
{
    $cont = 0;
    $entro = false;
    for ($i = 0; $i < strlen($texto); $i++) {
        if ($texto[$i] == ")")
            $cont--;

        if ($texto[$i] == "(") {
            $cont++;
            $entro = true;
        }

        if ($cont == 0 && $entro == true) {
            if ($i + 1 < strlen($texto)) {

                if ($texto[$i + 1] == "^") {
                    return "exponencial";
                }
                if ($texto[$i + 1] == "/") {
                    return "racional";
                }
                if ($texto[$i + 1] == "*") {
                    return "racionalM";
                }
                if ($texto[$i + 1] == "(") {
                    return "radical";
                }
            }
        }
    }
    return "";
}

function DevolverPolinomio($texto)
{
    $cont = 0;
    $entro = false;
    $text = "";
    $elemntos = array();
    $signos = array();
    for ($i = 0; $i < strlen($texto); $i++) {
        if ($texto[$i] == "(") {
            $cont++;
            $entro = true;
        }

        if ($texto[$i] == ")")
            $cont--;

        $text = $text . $texto[$i];
        if ($cont == 0) {
            if ($i + 1 < strlen($texto)) {
                if ($texto[$i + 1] == "+" || $texto[$i + 1] == "-" && $texto[$i + 1] != "*") {
                    $elemntos[] = $text;
                    $signos[] = $texto[$i + 1];
                    $entro = false;
                    $i += 1;
                    $text = "";
                }
            }
        }
    }
    $elemntos[] = $text;
    $responce = array(
        "elementos" => $elemntos,
        "signos" => $signos
    );

    return $responce;
}

//separa las funciones Exponencial Racional Radical y devuelve un arreglo con dos llaves, hijo y argumento
function SepararExponencialRacionalRadical($texto)
{
    $cont = 0;
    $entro = false;
    $text = "";
    $elemntos = array();
    for ($i = 0; $i < strlen($texto); $i++) {
        if ($texto[$i] == ")")
            $cont--;

        if ($entro == true && $cont != 0)
            $text = $text . $texto[$i];

        if ($texto[$i] == "(") {
            $cont++;
            $entro = true;
        }

        if ($cont == 0 && $entro == true) {
            if ($i + 1 < strlen($texto)) {
                if ($texto[$i + 1] == "^" || $texto[$i + 1] == "/" || $texto[$i + 1] == "*") {
                    $elemntos["hijo"] = $text;

                    $argumento = "";
                    for ($j = $i + 3; $j < strlen($texto) - 1; $j++) {
                        $argumento = $argumento . $texto[$j];
                    }
                    $elemntos["argumento"] = $argumento;
                }
                if ($texto[$i + 1] == "(") {
                    $elemntos["hijo"] = $text;

                    $argumento = "";
                    for ($j = $i + 2; $j < strlen($texto) - 1; $j++) {
                        $argumento = $argumento . $texto[$j];
                    }
                    $elemntos["argumento"] = $argumento;
                }
            }
        }
    }
    return $elemntos;
}

//devuelve cualquier cosa que este dentro de el primer parentesis que encuentre
function Dentro($texto)
{
    $cont = 0;
    $entro = false;
    $text = "";
    for ($i = 0; $i < strlen($texto); $i++) {
        if ($texto[$i] == ")")
            $cont--;

        if ($entro == true && $cont != 0)
            $text = $text . $texto[$i];

        if ($texto[$i] == "(") {
            $cont++;
            $entro = true;
        }

        if ($cont == 0 && $entro == true) {
            return $text;
        }
    }
    return $texto;
}

//une los dominios de todos los arreglos que recibe y devuelve un solo arreglo de dominios
function UnirDominio($dominio1, $dominio2 = array(), $dominio3 = array(), $dominio4 = array())
{
    $dominio = array();
    if (count($dominio1) != 0) {
        foreach ($dominio1 as $d) {
            $dominio[] = $d;
        }
    }
    if (count($dominio2) != 0) {
        foreach ($dominio2 as $d) {
            $dominio[] = $d;
        }
    }
    if (count($dominio3) != 0) {
        foreach ($dominio3 as $d) {
            $dominio[] = $d;
        }
    }
    if (count($dominio4) != 0) {
        foreach ($dominio4 as $d) {
            $dominio[] = $d;
        }
    }
    $dominio = array_unique($dominio);
    return $dominio;
}

//se supone que resuelva cualquier ecuacion polinomica
function Ruffini($texto_funcion)
{
    //devolver en cada posision los valores dq da ruffini
    $res = array();
    if (strstr($texto_funcion, '/') == true) {
        return $res;
    }
    if ($texto_funcion == "cos(x)") {
        $res[] = acos(0);
        return $res;
    } else {
        if ($texto_funcion == "sen(x)") {
            $res[] = asin(0);
            return $res;
        } else {
            if ($texto_funcion == "tan(x)") {
                $res[] = atan(0);
                return $res;
            } else {
                if ($texto_funcion == "log(x)") {
                    $res[] = 1;
                    return $res;
                }
            }

        }
    }
    if (strstr($texto_funcion, 'sen(') == true || strstr($texto_funcion, 'cos(') == true || strstr($texto_funcion, 'tan(') == true || strstr($texto_funcion, 'log(') == true)
        return $res;
    if (strlen($texto_funcion) == 1 && $texto_funcion == "x") {
        $res[] = 0;
        return $res;
    } else {
        if (strlen($texto_funcion) > 1 && strlen($texto_funcion) <= 9 && !BuscarbySigno($texto_funcion, "^")) {

            $r = RempFun($texto_funcion);
            $p = DevolverPolinomio($r);
            $polinomio = OrdenarPolinomio($p["elementos"], $p["signos"]);

            $tf = false;
            foreach ($polinomio as $h1) {
                if (BuscarbySigno($h1, "/"))
                    $tf = true;
            }
            if (count($polinomio) == 2 && $tf == true) {
                $elem = $polinomio[0];
                $b = ObtenerValor($polinomio[0], $p);
                $elem = $polinomio[1];
                $c = ObtenerValor($polinomio[1], $p);
                $res[] = -$c / $b;
            } elseif (count($polinomio) == 2 && $tf == false) {
                $elem = $polinomio[0];
                $b = ObtenerValor($polinomio[0], $p);
                $elem = $polinomio[1];
                $c = ObtenerValor($polinomio[1], $p);

                $res[] = ($c * -1) / $b;

            } elseif (count($polinomio) == 1) {
                if (BuscarbySigno($polinomio[0], "^"))
                    $res[] = 0;
            }
            return $res;
        } else {
            $r = RempFun($texto_funcion);
            $p = DevolverPolinomio($r);
            $polinomio = OrdenarPolinomio($p["elementos"], $p["signos"]);

            if (BuscarbySigno($polinomio[0], "*")) {
                $a = MiembrosbySigno($polinomio[0], "*");
                $a = Dentro($a["mder"]);
            } else
                $a = $polinomio[0];

            $elem = SepararExponencialRacionalRadical($a);

            if (count($elem) != 0) {
                if ($elem["argumento"] == "2") {
                    $a = ObtenerValor($polinomio[0], $p);

                    if (count($polinomio) == 3) {

                        $b = ObtenerValor($polinomio[1], $p);

                        $c = ObtenerValor($polinomio[2], $p);

                    } else {
                        if (count($polinomio) == 2) {
                            if (!is_numeric($polinomio[1])) {
                                $b = ObtenerValor($polinomio[1], $p);

                                $c = 0;
                            } else {
                                $c = ObtenerValor($polinomio[1], $p);

                                $b = 0;
                            }
                        } else {
                            $c = 0;
                            $b = 0;
                        }
                    }
                    $D = pow($b, 2) - (4 * $a * $c);

                    $x1 = (-$b + sqrt($D)) / (2 * $a);
                    $x2 = (-$b - sqrt($D)) / (2 * $a);

                    if (!is_nan($x1))
                        $sol[] = $x1;
                    if (!is_nan($x2)) {
                        $sol[] = $x2;
                        return $sol;
                    }
                } else {
                    $r = RempFun($texto_funcion);
                    $p = DevolverPolinomio($r);

                    $polinomio = OrdenarPolinomio($p["elementos"], $p["signos"]);
                    if (BuscarbySigno($polinomio[0], "*")) {
                        $arr = explode('*', $polinomio[0]);

                        $arr = explode('^', $arr[1]);

                        $e = preg_replace("/(\(|\))/", "", $arr[1]);
                    } else {
                        if (BuscarbySigno($polinomio[0], "^")) {
                            $arr = explode('^', $polinomio[0]);
                            $e = preg_replace("/(\(|\))/", "", $arr[1]);
                        }
                    }
                    $listaP = array();
                    if ($e > 2) {
                        $lista = array();
                        $temp = $e;
                        for ($i = 0; $i < count($polinomio); $i++) {
                            if (BuscarbySigno($polinomio[$i], "*")) {
                                $arr = explode('*', $polinomio[$i]);
                                $arr = explode('^', RempFun($arr[1]));
                                $v = preg_replace("/(\(|\))/", "", $arr[1]);
                            } else {
                                if (!is_numeric($polinomio[$i])) {
                                    $arr = explode('^', RempFun($polinomio[$i]));
                                    $v = preg_replace("/(\(|\))/", "", $arr[1]);
                                } else
                                    $v = 0;
                            }
                            if ($v == $temp) {
                                $lista[] = ObtenerValor($polinomio[$i], $p);
                                $temp--;
                            } else {
                                for ($j = 0; $j < $temp - $v; $j++) {
                                    $lista[] = 0;
                                }
                                $temp -= $v;
                                $lista[] = ObtenerValor($polinomio[$i], $p);
                                $temp--;
                            }
                        }
                        while (count($lista) != $e + 1) {
                            $lista[] = 0;
                        }
                        $divisor = array();
                        $divisor[] = 0;
                        $aux = $lista[count($lista) - 1];
                        if ($lista[count($lista) - 1] < 0) {
                            $aux *= -1;
                        }
                        for ($i = 1; $i <= $aux; $i++) {
                            if ($lista[count($lista) - 1] % $i == 0) {
                                $divisor[] = $i;
                                $divisor[] = $i * (-1);
                            }
                        }

                        foreach ($divisor as $d) {
                            $listaP[] = $lista[0];
                            for ($i = 0; $i < count($lista) - 1; $i++) {
                                $listaP[] = ($listaP[$i] * $d) + $lista[$i + 1];
                            }
                            if ($listaP[count($listaP) - 1] == 0) {
                                $sol = $d;
                                break;
                            } else {
                                $listaP = array();
                            }
                        }
                    }
                    if (count($listaP) > 0) {
                        $texto = ConvertirFuncion($listaP);
                        $res = Ruffini($texto);
                        $res[] = $sol;
                    }

                    return $res;
                }
            }


        }
    }
}


function ConvertirFuncion($lista)
{
    $texto = "";
    $exponente = count($lista) - 2;
    for ($i = 0; $i < count($lista) - 3; $i++) {
        if ($lista[$i] == 1) {
            if ($i != 0) {
                $texto .= "+";
            }
            $texto .= "(x)^(" . $exponente . ")";
            //if($i+1<count($lista))
            //$texto.="+";
            $exponente--;
        } else {
            if ($lista[$i] != 0) {
                if ($i != 0) {
                    $texto .= "+";
                }
                $texto .= "(" . $lista[$i] . ")*((x)^(" . $exponente . "))";
                //if($i+1<count($lista))
                //$texto.="+";
                $exponente--;
            } else {
                $exponente--;
            }
        }
    }
    if (count($lista) > 3) {
        if ($lista[count($lista) - 3] == 1 || $lista[count($lista) - 3] == -1) {
            if ($lista[count($lista) - 3] < 0)
                $texto .= "-";
            else {
                if ($lista[count($lista) - 3] > 0)
                    $texto .= "+";
            }
            $texto .= "x";
            //if(count($lista)-3<count($lista))
            //$texto.="+";
        } else {
            if ($lista[count($lista) - 3] != 0) {
                $texto .= "+";
                $texto .= "(x)*(" . $lista[count($lista) - 3] . ")";
            }
        }
    }
    if (count($lista) > 2) {
        if ($lista[count($lista) - 2] != 0) {
            if ($lista[count($lista) - 2] > 0)
                $texto .= "+";
            $texto .= $lista[count($lista) - 2];
        }
    }
    return $texto;
}

function ObtenerValor($elemento, $polinomio)
{
    $elemento = RempFun($elemento);
    $s = "";
    for ($i = 0; $i < count($polinomio["elementos"]); $i++) {
        if ($elemento == $polinomio["elementos"][$i]) {
            if ($i == 0)
                $s = "+";
            else
                $s = $polinomio["signos"][$i - 1];
        }
    }

    $arr = explode('*', $elemento);
    $p1 = preg_replace("/(\(|\))/", "", $arr[0]);
    if ($s == "-")
        $p1 *= -1;
    return $p1;
}

function Signos($func, $numeros)
{
    $valorIgual = array();
    $arrN = array();
    foreach ($numeros as $n) {
        if ($n != "x Є R" && is_numeric($n) && $n != "no") {
            $arrN[] = $n;
        } elseif ($n != "x Є R" && $n != "no") {
            $aux = explode(" ", $n);
            $arrN[] = $aux[count($aux) - 1];
            if ($aux[count($aux) - 2] == "≥")
                $valorIgual[] = $aux[count($aux) - 1];
        }
    }

    $arrN = array_unique($arrN);
    sort($arrN);

    if (count($arrN) > 0)
        $ult = $arrN[count($arrN) - 1];

    $res = array();
    $ant = null;
    foreach ($arrN as $n) {
        $sol = "";
        $f = ObtenerFuncion($func, $n - 0.000001);
        if ($f->GetY() != "no") {
            if (!is_nan($f->GetY())) {
                if ($f->GetY() >= 0)
                    $sol = "+";
                else
                    $sol = "-";

                if ($ant == null) {
                    $res[] = "(-oo," . round($n, 2) . ") " . $sol;
                } else {
                    $res[] = "(" . round($ant, 2) . "," . round($n, 2) . ") " . $sol;
                }
            }
        }
        $ant = $n;
    }
    $var = "";
    if (count($arrN) > 0)
        $var = $arrN[count($arrN) - 1];
    $f = ObtenerFuncion($func, $var + 1);
    if ($f->GetY() >= 0)
        $sol = "+";
    else
        $sol = "-";
    $res[] = "(" . round($var, 2) . ",+oo) " . $sol;

    if ($var == "")
        $res = "no";

    return $res;
}

function Monotonia($func, $extremos)
{
    $extremos = array_unique($extremos);
    sort($extremos);
    $res = array();
    $num1 = 0.0001;
    $num2 = 0.0002;
    $i = 0;
    foreach ($extremos as $e) {
        $f = ObtenerFuncion($func, $e - $num1);
        $y1 = $f->GetY();
        $f = ObtenerFuncion($func, $e - $num2);
        $y2 = $f->GetY();

        $mon = "cte";
        if ($y1 > $y2)
            $mon = "+";
        if ($y1 < $y2)
            $mon = "-";

        if ($i == 0)
            $res[] = "(-oo," . round($e, 2) . ") " . $mon;
        else {
            $res[] = "(" . round($extremos[$i - 1], 2) . "," . round($e, 2) . ") " . $mon;
        }
        if ($i == count($extremos) - 1) {
            $f = ObtenerFuncion($func, $e + $num1);
            $y1 = $f->GetY();
            $f = ObtenerFuncion($func, $e + $num2);
            $y2 = $f->GetY();
            $mon = "cte";
            if ($y1 > $y2)
                $mon = "-";
            if ($y1 < $y2)
                $mon = "+";
            $res[] = "(" . round($e, 2) . ",+oo) " . $mon;
        }
        $i++;
    }
    if (count($res) != 0)
        return $res;
    return "no";
}

class Funcion
{
    var $base;
    var $dominiobase = array();
    var $hijo;
    var $dominio;
    var $resultadoY;
    var $valorX = 0;
    var $derivada;
    var $texto;

    function Dominio()
    {
        $domaux = array();
        if ($this->hijo != null)
            $domaux = $this->hijo->dominio;
        $this->dominio = UnirDominio($this->dominiobase, $domaux);
    }

    function getDominio()
    {
        $dom = array();
        if ($this->dominio != null) {
            foreach ($this->dominio as $d) {
                $dom[] = $d;
            }
        }
        return $dom;
    }

    function GetY()
    {
        return $this->resultadoY;
    }

    function GetDerivada()
    {
        return $this->derivada;
    }
}

class Numericas extends Funcion
{
    function Numericas($texto_funcion, $valorX = 0)
    {
        $this->valorX = $valorX;
        $this->dominiobase[] = "x Є R";
        $this->Dominio();
        $this->HallarY($texto_funcion);
        $this->Derivar($texto_funcion);
    }

    function Dominio()
    {
        $this->dominio = UnirDominio($this->dominiobase);
    }

    function Derivar($x)
    {
        if ($x == "x")
            $this->derivada = 1;
        else
            $this->derivada = 0;
    }

    function HallarY($x)
    {
        if ($x == "x")
            $this->resultadoY = $this->valorX;
        else
            $this->resultadoY = $x;
    }
}

class Logaritmicas extends Funcion
{
    function Logaritmicas($texto_funcion, $valorX = 0)
    {
        $this->dominiobase[] = "x Є R";
        $this->texto .= $texto_funcion . ">0&nbsp;  &nbsp;  &nbsp;  &nbsp;";
        $this->valorX = $valorX;
        if ($texto_funcion != "x") {
            $this->texto .= ObtenerFuncion($texto_funcion)->texto . "";
            $this->hijo = ObtenerFuncion($texto_funcion);
        } else {
            //$this->texto=$texto_funcion." > 0";
            $this->hijo = null;
        }
        $this->base = "log(x)";

        $domOrdenado = array();
        if (strstr($texto_funcion, '‍‍‍‍√') == false)
            $domOrdenado = Ruffini($texto_funcion);


        for ($i = 0; $i < count($domOrdenado); $i++) {
            for ($j = 0; $j < count($domOrdenado) - 1; $j++) {
                if ($domOrdenado[$j] > $domOrdenado[$j + 1]) {
                    $aux = $domOrdenado[$j];
                    $domOrdenado[$j] = $domOrdenado[$j + 1];
                    $domOrdenado[$j + 1] = $aux;
                }
            }
        }
        $aux = 0;
        $entro = false;
        if (count($domOrdenado) > 1) {
            foreach ($domOrdenado as $r) {
                if ($aux == 0 && $entro == false) {
                    $this->dominiobase[] = "x < " . $r;
                    $aux = 1;
                    $entro = true;
                }
                if ($aux == 1 && $entro == false) {
                    $this->dominiobase[] = "x > " . $r;
                    $aux = 0;
                    $entro = true;
                }
                $entro = false;
            }
        } else {
            if (!empty($domOrdenado))
                $this->dominiobase[] = "x > " . $domOrdenado[0];
        }
        $this->Dominio();
        $this->HallarY($texto_funcion);
        $this->Derivar($texto_funcion);
    }

    function Derivar($x)
    {
        if ($x == "x") {
            $this->derivada = "(1)/(x)";
        } else {
            if (is_numeric($x)) {
                $this->derivada = 0;
            } else {
                $this->derivada = "(" . ObtenerFuncion($x)->derivada . ")/(" . $x . ")";
            }
        }
    }

    function HallarY($x)
    {
        if ($x != "x") {
            //echo ObtenerFuncion($x,$this->valorX)->resultadoY."<br>";
            $resul = ObtenerFuncion($x, $this->valorX)->resultadoY;
            if (!is_nan($resul)) {
                $this->resultadoY = log($resul);
            } else {
                $this->resultadoY = log(Limite($x, $this->valorX));
            }
        } else {
            $this->resultadoY = log($this->valorX);
        }
    }
}

class Trigonometricas extends Funcion
{
    function Trigonometricas($texto_funcion, $tipo, $valorX = 0)
    {
        $this->valorX = $valorX;
        if ($texto_funcion != "x") {
            $this->hijo = ObtenerFuncion($texto_funcion);
        } else {
            $this->hijo = null;
        }
        $this->base = $tipo . "(x)";
        $this->dominiobase[] = "x Є R";
        $this->Dominio();
        $this->HallarY($texto_funcion, $tipo);
        $this->Derivada($texto_funcion, $tipo);
    }

    function Derivada($x, $tipo)
    {
        $der = "";
        if ($tipo == "sen")
            $der = "cos(" . $x . ")";
        else {
            if ($tipo == "cos")
                $der = "(-1)*(sen(" . $x . "))";
            elseif ($tipo == "tan")
                $der = "(1)/((cos(" . $x . "))*(cos(" . $x . ")))";
        }
        if (is_numeric($x))
            $this->derivada = 0;
        else
            $this->derivada = $der;
    }

    function HallarY($x, $tipo)
    {
        if ($x != "x") {
            $resul = ObtenerFuncion($x, $this->valorX)->resultadoY;
            if ($tipo == "sen") {
                $this->resultadoY = sin($resul);
            } elseif ($tipo == "cos") {
                $this->resultadoY = cos($resul);
            } else
                $this->resultadoY = tan($resul);
        } else {
            if ($tipo == "sen")
                $this->resultadoY = sin($this->valorX);
            elseif ($tipo == "cos")
                $this->resultadoY = cos($this->valorX);
            else
                $this->resultadoY = tan($this->valorX);
        }
    }
}

class Exponenciales extends Funcion
{
    var $exponente;
    var $dominioargumento = array();

    function Exponenciales($hijo, $exponente, $valorX = 0)
    {
        if (is_numeric($exponente) && $exponente < 0) {
            $this->texto .= $hijo . "≠0&nbsp;  &nbsp;  &nbsp;  &nbsp;";
        }
        $this->valorX = $valorX;
        if ($hijo != "x") {
            $this->texto .= ObtenerFuncion($hijo)->texto . "";
            $this->hijo = ObtenerFuncion($hijo);
        } else {
            $this->hijo = null;
        }
        if (!is_numeric($exponente)) {
            $this->exponente = ObtenerFuncion($exponente);
            $this->texto .= ObtenerFuncion($exponente)->texto . "";
        } else {
            $this->exponente = null;
        }
        $this->HallarY($hijo, $exponente);
        $this->base = "(x)^y";
        $this->dominiobase[] = "x Є R";
        $this->dominioargumento[] = "x Є R";
        $this->Dominio();
        $this->Derivar($hijo, $exponente);
    }

    function Derivar($x, $y)
    {
        if (is_numeric($x)) {
            if (is_numeric($y))
                $this->derivada = 0;
            else {
                if ($y == "x") {
                    $this->derivada = "((" . $x . ")^(" . $y . "))*(" . log10($x) . ")";
                } else {
                    $this->derivada = "(((" . $x . ")^(" . $y . "))*(" . ObtenerFuncion($y, $this->valorX)->derivada . "))*(" . log10($x) . ")";

                }
            }
        } else {
            if ($x == "x") {
                if (is_numeric($y)) {
                    if ($y == 1) {
                        $this->derivada = 1;
                    } else {
                        if ($y == 2) {
                            $this->derivada = "(x)*(2)";
                        } else {
                            $this->derivada = "(" . $y . ")*((x)^(" . ($y - 1) . "))";
                        }
                    }
                } else {
                    if ($y == "x")
                        $this->derivada = "(" . $y . ")*((" . $x . ")^(" . ($y . -1) . "))+((" . $x . ")^(" . $y . "))*" . "(log(" . $x . "))";
                    else {
                        $this->derivada = "(" . $y . ")*((" . $x . ")^(" . ($y . -1) . "))+(((" . $x . ")^(" . $y . "))*(" . ObtenerFuncion($y)->derivada . "))*" . "(log(" . $x . "))";
                    }
                }
            } else {
                if (preg_match("/^x*[*]/", $x)) {
                    $cad = "";
                    for ($i = 0; $i < strlen($x); $i++) {
                        if ($x[$i] != "x" && $x[$i] != "*")
                            $cad .= $x[$i];
                    }
                    if (is_numeric($y)) {
                        if ($y == 1) {
                            $this->derivada = $cad;
                        } else {
                            if ($y == 2) {
                                $this->derivada = "(x)*(" . $cad * $y . ")";
                            } else {
                                $this->derivada = "(x*" . $cad * $y . ")^(" . ($y - 1) . ")";
                            }
                        }
                    } else {
                        if ($y == "x")
                            $this->derivada = "((" . $y . ")*(" . $cad . "))*((" . $x . ")^(" . ($y . -1) . "))+((" . $x . ")^(" . $y . "))*" . "(log(" . $x . "))";
                        else
                            $this->derivada = "((" . $y . ")*(" . $cad . "))*((" . $x . ")^(" . ($y . -1) . "))+(((" . $x . ")^(" . $y . "))*(" . ObtenerFuncion($y)->derivada . "))*" . "(log(" . $x . "))";
                    }
                } else {
                    if (is_numeric($y)) {
                        if ($y == 1) {
                            $this->derivada = ObtenerFuncion($x)->derivada;
                        } else {
                            if ($y == 2) {
                                $this->derivada = "(" . $y . ")*(" . $x . ")";
                            } else {
                                $this->derivada = "(" . $y . ")*((" . $x . ")^(" . ($y - 1) . "))";
                            }
                        }
                    } else {
                        if ($y == "x")
                            $this->derivada = "(" . $y . ")*((" . $x . ")^(" . ($y . -1) . "))+((" . $x . ")^(" . $y . "))*(" . "ln(" . $x . "))";
                        else {
                            $this->derivada = "((" . $y . ")*(" . ObtenerFuncion($x)->derivada . "))*((" . $x . ")^(" . ($y . -1) . "))+(((" . $x . ")^(" . $y . "))*(" . ObtenerFuncion($y)->derivada . "))*" . "(log(" . $x . "))";
                        }

                    }
                }
            }
        }
    }

    function Dominio()
    {
        $domaux1 = array();
        $domaux2 = array();
        if ($this->hijo != null) {
            $domaux1 = $this->hijo->dominio;
        }
        if ($this->exponente != null) {
            $domaux2 = $this->exponente->dominio;
        }

        $this->dominio = UnirDominio($this->dominiobase, $domaux1, $domaux2);
    }

    function HallarY($x, $y)
    {
        if (is_numeric($x)) {
            if (is_numeric($y)) {
                $this->resultadoY = pow($x, $y);
            } else {
                if (!preg_match("/^x/", $y)) {
                    $this->resultadoY = pow($x, ObtenerFuncion($y, $this->valorX)->resultadoY);
                } else {
                    if ($y == "x") {
                        if ($this->valorX != INF)
                            $this->resultadoY = pow($x, $this->valorX);
                        else
                            $this->resultadoY = NAN;
                    } else {
                        if (preg_match("/^x+[+]/", $y) || preg_match("/^x+[-]/", $y)) {
                            $this->resultadoY = pow($x, (ObtenerFuncion($y, $this->valorX)->resultadoY));
                        } else {
                            $cad = "";
                            for ($i = 0; $i < strlen($y); $i++) {
                                if ($y[$i] != "x" && $y[$i] != "*")
                                    $cad .= $y[$i];
                            }
                            $this->resultadoY = pow($x, ($cad * $this->valorX));
                        }
                    }
                }
            }
        } else {
            if (!preg_match("/^x/", $x)) {
                if (is_numeric($y)) {
                    $this->resultadoY = pow(ObtenerFuncion($x, $this->valorX)->resultadoY, $y);
                } else {
                    if (!preg_match("/^x/", $y)) {
                        $resul = ObtenerFuncion($y, $this->valorX)->resultadoY;
                        if (Limite($x, $this->valorX) != 1 && !is_infinite($resul))
                            $this->resultadoY = pow(ObtenerFuncion($x, $this->valorX)->resultadoY, $resul);
                        else
                            $this->resultadoY = NAN;
                    } else {
                        if ($y == "x") {
                            $resul = ObtenerFuncion($x, $this->valorX)->resultadoY;
                            if ($resul == 1 && is_infinite($this->valorX))
                                $this->resultadoY = NAN;
                            else
                                $this->resultadoY = pow($resul, $this->valorX);
                        } else {
                            if (preg_match("/^x+[+]/", $y) || preg_match("/^x+[-]/", $y)) {
                                $this->resultadoY = pow(ObtenerFuncion($x, $this->valorX)->resultadoY, (ObtenerFuncion($y, $this->valorX)->resultadoY));
                            } else {
                                $cad = "";
                                for ($i = 0; $i < strlen($y); $i++) {
                                    if ($y[$i] != "x" && $y[$i] != "*")
                                        $cad .= $y[$i];
                                }
                                $this->resultadoY = pow(ObtenerFuncion($x, $this->valorX)->resultadoY, ($cad * $this->valorX));
                            }
                        }
                    }
                }
            } else {
                if ($x == "x") {
                    if (is_numeric($y)) {
                        $this->resultadoY = pow($this->valorX, $y);
                    } else {
                        if (!preg_match("/^x/", $y)) {
                            $this->resultadoY = pow($this->valorX, ObtenerFuncion($y, $this->valorX)->resultadoY);
                        } else {
                            if ($y == "x") {
                                if ($this->valorX != 0)
                                    $this->resultadoY = pow($this->valorX, $this->valorX);
                                else
                                    $this->resultadoY = NAN;
                            } else {
                                if (preg_match("/^x+[+]/", $y) || preg_match("/^x+[-]/", $y)) {
                                    $this->resultadoY = pow($this->valorX, (ObtenerFuncion($y, $this->valorX)->resultadoY));
                                } else {
                                    $cad = "";
                                    for ($i = 0; $i < strlen($y); $i++) {
                                        if ($y[$i] != "x" && $y[$i] != "*")
                                            $cad .= $y[$i];
                                    }
                                    $this->resultadoY = pow($this->valorX, ($cad * $this->valorX));
                                }
                            }
                        }
                    }
                } else {
                    if (preg_match("/^x+[+]/", $x) || preg_match("/^x+[-]/", $x)) {
                        if (is_numeric($y)) {
                            $this->resultadoY = pow(ObtenerFuncion($x, $this->valorX)->resultadoY, $y);
                        } else {
                            if (!preg_match("/^x/", $y)) {
                                $this->resultadoY = pow(ObtenerFuncion($x, $this->valorX)->resultadoY, ObtenerFuncion($y, $this->valorX)->resultadoY);
                            } else {
                                if ($y == "x")
                                    $this->resultadoY = pow(ObtenerFuncion($x, $this->valorX)->resultadoY, $this->valorX);
                                else {
                                    if (preg_match("/^x+[+]/", $y) || preg_match("/^x+[-]/", $y)) {
                                        $this->resultadoY = pow(ObtenerFuncion($x, $this->valorX)->resultadoY, (ObtenerFuncion($y, $this->valorX)->resultadoY));
                                    } else {
                                        $cad = "";
                                        for ($i = 0; $i < strlen($y); $i++) {
                                            if ($y[$i] != "x" && $y[$i] != "*")
                                                $cad .= $y[$i];
                                        }
                                        $this->resultadoY = pow(ObtenerFuncion($x, $this->valorX)->resultadoY, ($cad * $this->valorX));
                                    }
                                }
                            }
                        }
                    } else {
                        $cadx = "";
                        for ($i = 0; $i < strlen($x); $i++) {
                            if ($x[$i] != "x" && $x[$i] != "*")
                                $cadx .= $x[$i];
                        }
                        if (is_numeric($y)) {
                            $this->resultadoY = pow(($this->valorX), $y) * $cadx;
                        } else {
                            if (!preg_match("/^x/", $y)) {
                                $this->resultadoY = $cadx * pow(($this->valorX), ObtenerFuncion($y, $this->valorX)->resultadoY);
                            } else {
                                if ($y == "x")
                                    $this->resultadoY = $cadx * pow(($this->valorX), $this->valorX);
                                else {
                                    if (preg_match("/^x+[+]/", $y) || preg_match("/^x+[-]/", $y)) {
                                        $this->resultadoY = pow(($this->valorX) * $cadx, (ObtenerFuncion($y, $this->valorX)->resultadoY));
                                    } else {
                                        $cad = "";
                                        for ($i = 0; $i < strlen($y); $i++) {
                                            if ($y[$i] != "x" && $y[$i] != "*")
                                                $cad .= $y[$i];
                                        }
                                        $this->resultadoY = pow($cadx * $this->valorX, $cad * $this->valorX);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}

class Racional extends Funcion
{
    var $divisor;
    var $dominiodivisor = array();
    var $tipo;

    function Racional($texto_funcion, $denominador, $valorX = 0, $tipo = "racional")
    {
        if ($tipo == "racional" && !is_numeric($denominador))
            $this->texto .= $denominador . "≠0&nbsp;  &nbsp;  &nbsp;  &nbsp;";
        $this->valorX = $valorX;
        $this->tipo = $tipo;
        if ($texto_funcion != "x") {
            if ($tipo == "racional") {
                $this->texto .= ObtenerFuncion($texto_funcion)->texto;
            }
            $this->hijo = ObtenerFuncion($texto_funcion);
        } else {

            $this->hijo = null;
        }
        if (!is_numeric($denominador)) {
            if ($tipo == "racional")
                $this->texto .= ObtenerFuncion($denominador)->texto;
            $this->divisor = ObtenerFuncion($denominador);
        } else {
            $this->divisor = null;
        }

        $this->base = "(x)/y";
        $this->dominiobase[] = "x Є R";
        $res = array();

        if ($this->tipo == "racional") {
            if (strstr($denominador, '‍‍‍‍√') == false)
                $res = (Ruffini($denominador));
        }

        if (count($res) > 0) {
            foreach ($res as $r) {
                $this->dominiodivisor[] = "x ≠ " . $r;
            }
        }
        $this->HallarY($texto_funcion, $denominador);
        $this->Dominio();
        $this->Derivada($texto_funcion, $denominador);
    }

    function Derivada($x, $y)
    {
        if ($this->tipo == "racional") {
            if (is_numeric($x)) {
                if (is_numeric($y) && $y != 0) {
                    $this->derivada = 0;
                } else {
                    if ($y == "x")
                        $this->derivada = "(" . (-1 * $x) . ")/((" . $y . ")*(" . $y . "))";
                    else
                        $this->derivada = "(((-1)*(" . $x . "))*(" . ObtenerFuncion($y)->derivada . "))/((" . $y . ")*(" . $y . "))";
                }
            } else {
                if ($x == "x") {
                    if (is_numeric($y)) {
                        $this->derivada = $y / pow($y, 2);
                    } else {
                        if ($y == "x")
                            $this->derivada = 0;
                        else
                            $this->derivada = "(" . $y . "-(" . $x . ")*(" . ObtenerFuncion($y)->derivada . "))/((" . $y . ")*(" . $y . "))";
                    }
                } else {
                    if (is_numeric($y)) {
                        $this->derivada = "((" . ObtenerFuncion($x)->derivada . ")*(" . $y . "))/(" . ($y * $y) . ")";
                    } else {
                        if ($y == "x") {
                            $this->derivada = "((" . ObtenerFuncion($x)->derivada . ")*(" . $y . ")-" . $x . ")/((" . $y . ")*(" . $y . "))";
                        } else
                            $this->derivada = "((" . ObtenerFuncion($x)->derivada . ")*(" . $y . ")-(" . $x . ")*(" . ObtenerFuncion($y)->derivada . "))/((" . $y . ")*(" . $y . "))";
                    }
                }
            }
        } else {
            if (is_numeric($x)) {
                if (is_numeric($y) && $y != 0) {
                    $this->derivada = 0;
                } else {
                    if ($y == "x") {
                        $this->derivada = $x;
                    } else {
                        $this->derivada = "(" . $x . ")*(" . ObtenerFuncion($y)->derivada . ")";
                    }
                }
            } else {
                if ($x == "x") {
                    if (is_numeric($y) && $y != 0) {
                        $this->derivada = $y;
                    } else {
                        if ($y == "x")
                            $this->derivada = "(x)*(2)";
                        else {
                            $this->derivada = $y . "+(x)*(" . ObtenerFuncion($y)->derivada . ")";
                        }
                    }
                } else {
                    if (is_numeric($y))
                        $this->derivada = "(" . ObtenerFuncion($x)->derivada . ")*(" . $y . ")";
                    else {
                        $this->derivada = "(" . ObtenerFuncion($x)->derivada . ")*(" . $y . ")+(" . $x . ")*(" . ObtenerFuncion($y)->derivada . ")";
                    }
                }
            }
        }
    }

    function HallarY($x, $y)
    {
        if ($this->tipo == "racional") {
            if (is_numeric($x)) {
                if (is_numeric($y)) {
                    $this->resultadoY = ($x / $y);
                } else {
                    if (!preg_match("/^x/", $y)) {
                        $resul = ObtenerFuncion($y, $this->valorX)->resultadoY;
                        if ($resul != 0) {
                            $this->resultadoY = ($x / $resul);
                        } else {
                            if ($x != 0)
                                $this->resultadoY = INF;
                            else
                                $this->resultadoY = NAN;
                        }
                    } else {
                        if ($y == "x") {
                            if ($this->valorX != 0) {
                                $this->resultadoY = ($x / $this->valorX);

                            } else {
                                if ($x != 0)
                                    $this->resultadoY = INF;
                                else
                                    $this->resultadoY = NAN;
                            }

                        } else {
                            if (preg_match("/^x+[+]/", $y) || preg_match("/^x+[-]/", $y)) {
                                $resul = ObtenerFuncion($y, $this->valorX)->resultadoY;
                                if ($resul == 0) {
                                    if ($x != 0)
                                        $this->resultadoY = INF;
                                    else
                                        $this->resultadoY = NAN;
                                } else
                                    $this->resultadoY = ($x / ($resul));
                            } else {
                                $cad = "";
                                for ($i = 0; $i < strlen($y); $i++) {
                                    if ($y[$i] != "x" && $y[$i] != "*")
                                        $cad .= $y[$i];
                                }
                                if ($this->valorX == 0) {
                                    if ($x != 0)
                                        $this->resultadoY = INF;
                                    else
                                        $this->resultadoY = NAN;
                                } else
                                    $this->resultadoY = ($x / ($cad * $this->valorX));
                            }
                        }
                    }
                }
            } else {
                if (!preg_match("/^x/", $x)) {
                    if (is_numeric($y)) {
                        if (is_infinite($this->valorX)) {
                            $responce = DevolverPolinomio($x);
                            if (!is_numeric($responce["elementos"][0]))
                                $x = $responce["elementos"][0];
                            $this->resultadoY = ObtenerFuncion($x, $this->valorX)->resultadoY;
                        } else {
                            $this->resultadoY = ObtenerFuncion($x, $this->valorX)->resultadoY / $y;
                        }
                    } else {
                        if (!preg_match("/^x/", $y)) {
                            if (is_infinite($this->valorX)) {
                                $responce = DevolverPolinomio($x);
                                if (!is_numeric($responce["elementos"][0]))
                                    $x = $responce["elementos"][0];
                                $responce = DevolverPolinomio($y);
                                if (!is_numeric($responce["elementos"][0]))
                                    $y = $responce["elementos"][0];
                            }

                            $x11 = ObtenerFuncion($x, $this->valorX)->resultadoY;
                            $y11 = ObtenerFuncion($y, $this->valorX)->resultadoY;

                            if ($x11 == 0 && $y11 == 0) {
                                $this->resultadoY = INF / INF;
                            } else {
                                if (is_numeric($x11) && $y11 == 0) {
                                    if ($x11 != 0)
                                        $this->resultadoY = INF;
                                    else
                                        $this->resultadoY = NAN;
                                } else {
                                    $this->resultadoY = ($x11 / $y11);
                                }
                            }

                        } else {
                            if ($y == "x") {
                                if ($this->valorX != 0)
                                    $this->resultadoY = (ObtenerFuncion($x, $this->valorX)->resultadoY / $this->valorX);
                                else {
                                    if (ObtenerFuncion($x, $this->valorX)->resultadoY != 0)
                                        $this->resultadoY = INF;
                                    else
                                        $this->resultadoY = NAN;
                                }
                            } else {
                                if (preg_match("/^x+[+]/", $y) || preg_match("/^x+[-]/", $y)) {
                                    $resul = ObtenerFuncion($y, $this->valorX)->resultadoY;
                                    if (($resul) != 0)
                                        $this->resultadoY = (ObtenerFuncion($x, $this->valorX)->resultadoY / ($resul));
                                    else {
                                        if (ObtenerFuncion($x, $this->valorX)->resultadoY != 0)
                                            $this->resultadoY = INF;
                                        else
                                            $this->resultadoY = NAN;
                                    }
                                } else {
                                    $cad = "";
                                    for ($i = 0; $i < strlen($y); $i++) {
                                        if ($y[$i] != "x" && $y[$i] != "*")
                                            $cad .= $y[$i];
                                    }
                                    if ($this->valorX != 0)
                                        $this->resultadoY = (ObtenerFuncion($x, $this->valorX)->resultadoY / ($cad * $this->valorX));
                                    else {
                                        if (ObtenerFuncion($x, $this->valorX)->resultadoY != 0)
                                            $this->resultadoY = INF;
                                        else
                                            $this->resultadoY = NAN;
                                    }
                                }
                            }
                        }
                    }
                } else {
                    if ($x == "x") {
                        if (is_numeric($y)) {
                            $this->resultadoY = ($this->valorX / $y);
                        } else {
                            if (!preg_match("/^x/", $y)) {
                                $resul = ObtenerFuncion($y, $this->valorX)->resultadoY;
                                if ($resul != 0)
                                    $this->resultadoY = ($this->valorX / $resul);
                                else {
                                    if ($this->valorX != 0)
                                        $this->resultadoY = INF;
                                    else
                                        $this->resultadoY = NAN;
                                }
                            } else {
                                if ($y == "x") {
                                    if ($this->valorX != 0)
                                        $this->resultadoY = ($this->valorX / $this->valorX);
                                    else
                                        $this->resultadoY = NAN;
                                } else {
                                    if (preg_match("/^x+[+]/", $y) || preg_match("/^x+[-]/", $y)) {
                                        $resul = ObtenerFuncion($y, $this->valorX)->resultadoY;
                                        if (($resul) != 0)
                                            $this->resultadoY = ($this->valorX / ($resul));
                                        else {
                                            if ($this->valorX != 0)
                                                $this->resultadoY = INF;
                                            else
                                                $this->resultadoY = NAN;
                                        }
                                    } else {
                                        $cad = "";
                                        for ($i = 0; $i < strlen($y); $i++) {
                                            if ($y[$i] != "x" && $y[$i] != "*")
                                                $cad .= $y[$i];
                                        }
                                        if ($this->valorX != 0)
                                            $this->resultadoY = ($this->valorX / ($cad * $this->valorX));
                                        else {
                                            if ($this->valorX != 0)
                                                $this->resultadoY = INF;
                                            else
                                                $this->resultadoY = NAN;
                                        }
                                    }
                                }
                            }
                        }
                    } else {
                        if (preg_match("/^x+[+]/", $x) || preg_match("/^x+[-]/", $x)) {
                            if (is_numeric($y)) {
                                $this->resultadoY = (ObtenerFuncion($x, $this->valorX)->resultadoY) / $y;
                            } else {
                                if (!preg_match("/^x/", $y)) {
                                    $resul = ObtenerFuncion($y, $this->valorX)->resultadoY;
                                    if ($resul != 0)
                                        $this->resultadoY = (ObtenerFuncion($x, $this->valorX)->resultadoY / $resul);
                                    else {
                                        if (ObtenerFuncion($x, $this->valorX)->resultadoY != 0)
                                            $this->resultadoY = INF;
                                        else
                                            $this->resultadoY = NAN;
                                    }
                                } else {
                                    if ($y == "x") {
                                        if ($this->valorX != 0)
                                            $this->resultadoY = (ObtenerFuncion($x, $this->valorX)->resultadoY / $this->valorX);
                                        else {
                                            if (ObtenerFuncion($x, $this->valorX)->resultadoY != 0)
                                                $this->resultadoY = INF;
                                            else
                                                $this->resultadoY = NAN;
                                        }
                                    } else {
                                        if (preg_match("/^x+[+]/", $y) || preg_match("/^x+[-]/", $y)) {
                                            $resulX = ObtenerFuncion($x, $this->valorX)->resultadoY;
                                            $resulY = ObtenerFuncion($y, $this->valorX)->resultadoY;
                                            if (is_numeric($resulX) && $resulY == 0) {
                                                if ($resulX != 0)
                                                    $this->resultadoY = INF;
                                                else
                                                    $this->resultadoY = NAN;
                                            } else
                                                $this->resultadoY = ($resulX / $resulY);
                                        } else {
                                            $cad = "";
                                            for ($i = 0; $i < strlen($y); $i++) {
                                                if ($y[$i] != "x" && $y[$i] != "*")
                                                    $cad .= $y[$i];
                                            }
                                            if ($this->valorX != 0)
                                                $this->resultadoY = ObtenerFuncion($x, $this->valorX)->resultadoY / ($cad * $this->valorX);
                                            else {
                                                if (ObtenerFuncion($x, $this->valorX)->resultadoY != 0)
                                                    $this->resultadoY = INF;
                                                else
                                                    $this->resultadoY = NAN;
                                            }
                                        }
                                    }
                                }
                            }
                        } else {
                            $cadx = "";
                            for ($i = 0; $i < strlen($x); $i++) {
                                if ($x[$i] != "x" && $x[$i] != "*")
                                    $cadx .= $x[$i];
                            }
                            if (is_numeric($y)) {
                                $this->resultadoY = ($cadx * $this->valorX) / $y;
                            } else {
                                if (!preg_match("/^x/", $y)) {
                                    $resul = ObtenerFuncion($y, $this->valorX)->resultadoY;
                                    if ($resul != 0)
                                        $this->resultadoY = (($cadx * $this->valorX) / $resul);
                                    else {
                                        if ($cadx * $this->valorX != 0)
                                            $this->resultadoY = INF;
                                        else
                                            $this->resultadoY = NAN;
                                    }
                                } else {
                                    if ($y == "x") {
                                        if ($this->valorX != 0)
                                            $this->resultadoY = (($cadx * $this->valorX) / $this->valorX);
                                        else {
                                            if ($cadx * $this->valorX != 0)
                                                $this->resultadoY = INF;
                                            else
                                                $this->resultadoY = NAN;
                                        }
                                    } else {
                                        if (preg_match("/^x+[+]/", $y) || preg_match("/^x+[-]/", $y)) {
                                            $resul = ObtenerFuncion($y, $this->valorX)->resultadoY;
                                            if (($resul) != 0)
                                                $this->resultadoY = (($cadx * $this->valorX) / ($resul));
                                            else {
                                                if ($cadx * $this->valorX != 0)
                                                    $this->resultadoY = INF;
                                                else
                                                    $this->resultadoY = NAN;
                                            }
                                        } else {
                                            $cad = "";
                                            for ($i = 0; $i < strlen($y); $i++) {
                                                if ($y[$i] != "x" && $y[$i] != "*")
                                                    $cad .= $y[$i];
                                            }
                                            if ($this->valorX != 0)
                                                $this->resultadoY = (($cadx * $this->valorX) / $cad * $this->valorX);
                                            else {
                                                if ($cadx * $this->valorX != 0)
                                                    $this->resultadoY = INF;
                                                else
                                                    $this->resultadoY = NAN;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else {
            if (is_numeric($x)) {
                if (is_numeric($y)) {
                    $this->resultadoY = ($x * $y);
                } else {
                    if (!preg_match("/^x/", $y)) {
                        $resul = ObtenerFuncion($y, $this->valorX)->resultadoY;
                        if (!is_nan($resul)) {
                            $this->resultadoY = ($x * $resul);
                        } else
                            $this->resultadoY = NAN;
                    } else {
                        if ($y == "x")
                            $this->resultadoY = ($x * $this->valorX);
                        else {
                            if (preg_match("/^x+[+]/", $y) || preg_match("/^x+[-]/", $y)) {
                                $this->resultadoY = ($x * (ObtenerFuncion($y, $this->valorX)->resultadoY));
                            } else {
                                $cad = "";
                                for ($i = 0; $i < strlen($y); $i++) {
                                    if ($y[$i] != "x" && $y[$i] != "*")
                                        $cad .= $y[$i];
                                }
                                $this->resultadoY = ($x * ($cad * $this->valorX));
                            }
                        }
                    }
                }
            } else {
                if (!preg_match("/^x/", $x)) {
                    if (is_numeric($y)) {
                        $this->resultadoY = (ObtenerFuncion($x, $this->valorX)->resultadoY * $y);
                    } else {
                        if (!preg_match("/^x/", $y)) {
                            $resul = ObtenerFuncion($y, $this->valorX)->resultadoY;
                            if ($resul != 0) {
                                $this->resultadoY = (ObtenerFuncion($x, $this->valorX)->resultadoY * $resul);
                            } else
                                $this->resultadoY = NAN;
                        } else {
                            if ($y == "x") {
                                if ($this->valorX != 0)
                                    $this->resultadoY = (ObtenerFuncion($x, $this->valorX)->resultadoY * $this->valorX);
                                else
                                    $this->resultadoY = NAN;
                            } else {
                                if (preg_match("/^x+[+]/", $y) || preg_match("/^x+[-]/", $y)) {
                                    $this->resultadoY = (ObtenerFuncion($x, $this->valorX)->resultadoY * (ObtenerFuncion($y, $this->valorX)->resultadoY));
                                } else {
                                    $cad = "";
                                    for ($i = 0; $i < strlen($y); $i++) {
                                        if ($y[$i] != "x" && $y[$i] != "*")
                                            $cad .= $y[$i];
                                    }
                                    $this->resultadoY = (ObtenerFuncion($x, $this->valorX)->resultadoY * ($cad * $this->valorX));
                                }
                            }
                        }
                    }
                } else {
                    if ($x == "x") {
                        if (is_numeric($y)) {
                            $this->resultadoY = ($this->valorX * $y);
                        } else {
                            if (!preg_match("/^x/", $y)) {
                                $this->resultadoY = ($this->valorX * ObtenerFuncion($y, $this->valorX)->resultadoY);
                            } else {
                                if ($y == "x")
                                    $this->resultadoY = ($this->valorX * $this->valorX);
                                else {
                                    if (preg_match("/^x+[+]/", $y) || preg_match("/^x+[-]/", $y)) {
                                        $this->resultadoY = ($this->valorX * (ObtenerFuncion($y, $this->valorX)->resultadoY));
                                    } else {
                                        $cad = "";
                                        for ($i = 0; $i < strlen($y); $i++) {
                                            if ($y[$i] != "x" && $y[$i] != "*")
                                                $cad .= $y[$i];
                                        }
                                        $this->resultadoY = ($this->valorX * ($cad * $this->valorX));
                                    }
                                }
                            }
                        }
                    } else {
                        if (preg_match("/^x+[+]/", $x) || preg_match("/^x+[-]/", $x)) {
                            if (is_numeric($y)) {
                                $this->resultadoY = (ObtenerFuncion($x, $this->valorX)->resultadoY) * $y;
                            } else {
                                if (!preg_match("/^x/", $y)) {
                                    $this->resultadoY = (ObtenerFuncion($x, $this->valorX)->resultadoY * ObtenerFuncion($y, $this->valorX)->resultadoY);
                                } else {
                                    if ($y == "x")
                                        $this->resultadoY = (ObtenerFuncion($x, $this->valorX)->resultadoY * $this->valorX);
                                    else {
                                        if (preg_match("/^x+[+]/", $y) || preg_match("/^x+[-]/", $y)) {
                                            $this->resultadoY = (ObtenerFuncion($x, $this->valorX)->resultadoY * (ObtenerFuncion($y, $this->valorX)->resultadoY));
                                        } else {
                                            $cad = "";
                                            for ($i = 0; $i < strlen($y); $i++) {
                                                if ($y[$i] != "x" && $y[$i] != "*")
                                                    $cad .= $y[$i];
                                            }
                                            $this->resultadoY = ObtenerFuncion($x, $this->valorX)->resultadoY * ($cad * $this->valorX);
                                        }
                                    }
                                }
                            }
                        } else {
                            $cadx = "";
                            for ($i = 0; $i < strlen($x); $i++) {
                                if ($x[$i] != "x" && $x[$i] != "*")
                                    $cadx .= $x[$i];
                            }
                            if (is_numeric($y)) {
                                $this->resultadoY = ($cadx * $this->valorX) * $y;
                            } else {
                                if (!preg_match("/^x/", $y)) {
                                    $this->resultadoY = (($cadx * $this->valorX) * ObtenerFuncion($y, $this->valorX)->resultadoY);
                                } else {
                                    if ($y == "x")
                                        $this->resultadoY = (($cadx * $this->valorX) * $this->valorX);
                                    else {
                                        if (preg_match("/^x+[+]/", $y) || preg_match("/^x+[-]/", $y)) {
                                            $this->resultadoY = (($cadx * $this->valorX) * (ObtenerFuncion($y, $this->valorX)->resultadoY));
                                        } else {
                                            $cad = "";
                                            for ($i = 0; $i < strlen($y); $i++) {
                                                if ($y[$i] != "x" && $y[$i] != "*")
                                                    $cad .= $y[$i];
                                            }
                                            $this->resultadoY = (($cadx * $this->valorX) * $cad * $this->valorX);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    function Dominio()
    {
        $domaux1 = array();
        $domaux2 = array();
        if ($this->hijo != null) {
            $domaux1 = $this->hijo->dominio;
        }
        if ($this->divisor != null) {
            $domaux2 = $this->divisor->dominio;
        }
        $this->dominio = UnirDominio($this->dominiobase, $domaux1, $domaux2, $this->dominiodivisor);

    }
}

class Radical extends Funcion
{
    var $divisor;
    var $dominiodivisor = array();

    function Radical($texto_funcion, $denominador, $valorX = 0)
    {
        $this->texto .= $denominador . "≥0&nbsp;  &nbsp;  &nbsp;  &nbsp;";
        $this->valorX = $valorX;
        if ($texto_funcion != "x") {
            $this->texto .= ObtenerFuncion($texto_funcion)->texto;
            $this->hijo = ObtenerFuncion($texto_funcion);
        } else {
            $this->hijo = null;
        }
        if (!is_numeric($denominador)) {
            $this->texto .= ObtenerFuncion($denominador)->texto;
            $this->divisor = ObtenerFuncion($denominador);
        } else {
            $this->divisor = null;
        }
        $this->base = "y‍‍‍‍√(x)";

        $arr = array();
        if (strstr($denominador, '‍‍‍‍√') == false)
            $arr = Ruffini($denominador);

        for ($i = 0; $i < count($arr); $i++) {
            for ($j = 0; $j < count($arr) - 1; $j++) {
                if ($arr[$j] > $arr[$j + 1]) {
                    $aux = $arr[$j];
                    $arr[$j] = $arr[$j + 1];
                    $arr[$j + 1] = $aux;
                }
            }
        }
        $aux = 0;
        $entro = false;
        if (count($arr) > 1) {
            foreach ($arr as $r) {
                if ($aux == 0 && $entro == false) {
                    $this->dominiobase[] = "x ≤ " . $r;
                    $aux = 1;
                    $entro = true;
                }
                if ($aux == 1 && $entro == false) {
                    $this->dominiobase[] = "x ≥ " . $r;
                    $aux = 0;
                    $entro = true;
                }
                $entro = false;
            }
        } else {
            if (!empty($arr))
                $this->dominiobase[] = "x ≥ " . $arr[0];
            else
                $this->dominiobase[] = "x ≥ 0";
        }


        $this->HallarY($denominador, $texto_funcion);
        $this->Dominio();
        $this->Derivada($denominador, $texto_funcion);
    }

    function Derivada($x, $y)
    {
        if (is_numeric($x)) {
            $this->derivada = 0;
        } else {
            if ($x == "x") {
                $this->derivada = "(1)/((" . $y . ")*((" . $y . ")‍‍‍‍√(" . $x . ")))";
            } else {
                $this->derivada = "(" . ObtenerFuncion($x)->derivada . ")/((" . $y . ")*((" . $y . ")‍‍‍‍√(" . $x . ")))";
            }
        }
    }

    function HallarY($x, $y)
    {
        if (is_numeric($x)) {
            if (is_numeric($y)) {
                $this->resultadoY = pow($x, 1 / $y);
            } else {
                if (!preg_match("/^x/", $y)) {
                    $this->resultadoY = pow($x, 1 / ObtenerFuncion($y, $this->valorX)->resultadoY);
                } else {
                    if ($y == "x") {
                        $this->resultadoY = pow($x, 1 / $this->valorX);
                    } else {
                        if (preg_match("/^x+[+]/", $y) || preg_match("/^x+[-]/", $y)) {
                            $this->resultadoY = pow($x, 1 / ObtenerFuncion($y, $this->valorX)->resultadoY);
                        } else {
                            $cad = "";
                            for ($i = 0; $i < strlen($y); $i++) {
                                if ($y[$i] != "x" && $y[$i] != "*")
                                    $cad .= $y[$i];
                            }
                            $this->resultadoY = pow($x, 1 / ($cad * $this->valorX));
                        }
                    }
                }
            }
        } else {
            if (!preg_match("/^x/", $x)) {
                if (is_numeric($y)) {
                    $this->resultadoY = pow(ObtenerFuncion($x, $this->valorX)->resultadoY, 1 / $y);
                } else {
                    if (!preg_match("/^x/", $y)) {
                        $this->resultadoY = pow(ObtenerFuncion($x, $this->valorX)->resultadoY, 1 / ObtenerFuncion($y, $this->valorX)->resultadoY);
                    } else {
                        if ($y == "x") {
                            $this->resultadoY = pow(ObtenerFuncion($x, $this->valorX)->resultadoY, 1 / $this->valorX);
                        } else {
                            if (preg_match("/^x+[+]/", $y) || preg_match("/^x+[-]/", $y)) {
                                $this->resultadoY = pow(ObtenerFuncion($x, $this->valorX)->resultadoY, 1 / ObtenerFuncion($y, $this->valorX)->resultadoY);
                            } else {
                                $cad = "";
                                for ($i = 0; $i < strlen($y); $i++) {
                                    if ($y[$i] != "x" && $y[$i] != "*")
                                        $cad .= $y[$i];
                                }
                                $this->resultadoY = pow(ObtenerFuncion($x, $this->valorX)->resultadoY, 1 / ($cad * $this->valorX));
                            }
                        }
                    }
                }
            } else {
                if ($x == "x") {
                    if (is_numeric($y)) {
                        $this->resultadoY = pow($this->valorX, 1 / $y);
                    } else {
                        if (!preg_match("/^x/", $y)) {
                            $this->resultadoY = pow($this->valorX, 1 / ObtenerFuncion($y, $this->valorX)->resultadoY);
                        } else {
                            if ($y == "x") {
                                $this->resultadoY = pow($this->valorX, 1 / $this->valorX);
                            } else {
                                if (preg_match("/^x+[+]/", $y) || preg_match("/^x+[-]/", $y)) {
                                    $this->resultadoY = pow($this->valorX, 1 / ObtenerFuncion($y, $this->valorX)->resultadoY);
                                } else {
                                    $cad = "";
                                    for ($i = 0; $i < strlen($y); $i++) {
                                        if ($y[$i] != "x" && $y[$i] != "*")
                                            $cad .= $y[$i];
                                    }
                                    $this->resultadoY = pow($this->valorX, 1 / ($cad * $this->valorX));
                                }
                            }
                        }
                    }
                } else {
                    if (preg_match("/^x+[+]/", $x) || preg_match("/^x+[-]/", $x)) {
                        if (is_numeric($y)) {
                            $this->resultadoY = pow(ObtenerFuncion($x, $this->valorX)->resultadoY, 1 / $y);
                        } else {
                            if (!preg_match("/^x/", $y)) {
                                $resul = ObtenerFuncion($y, $this->valorX)->resultadoY;
                                if ($resul != 0)
                                    $this->resultadoY = pow(ObtenerFuncion($x, $this->valorX)->resultadoY, 1 / $resul);
                                else
                                    $this->resultadoY = pow(ObtenerFuncion($x, $this->valorX)->resultadoY, INF);
                            } else {
                                if ($y == "x")
                                    if ($this->valorX != 0)
                                        $this->resultadoY = pow(ObtenerFuncion($x, $this->valorX)->resultadoY, 1 / $this->valorX);
                                    else
                                        $this->resultadoY = pow(ObtenerFuncion($x, $this->valorX)->resultadoY, INF);
                                else {
                                    if (preg_match("/^x+[+]/", $y) || preg_match("/^x+[-]/", $y)) {
                                        $this->resultadoY = pow(ObtenerFuncion($x, $this->valorX)->resultadoY, 1 / ObtenerFuncion($y, $this->valorX)->resultadoY);
                                    } else {
                                        $cad = "";
                                        for ($i = 0; $i < strlen($y); $i++) {
                                            if ($y[$i] != "x" && $y[$i] != "*")
                                                $cad .= $y[$i];
                                        }
                                        $this->resultadoY = pow(ObtenerFuncion($x, $this->valorX)->resultadoY, 1 / ($cad * $this->valorX));
                                    }
                                }
                            }
                        }
                    } else {
                        $cadx = "";
                        for ($i = 0; $i < strlen($x); $i++) {
                            if ($x[$i] != "x" && $x[$i] != "*")
                                $cadx .= $x[$i];
                        }
                        if (is_numeric($y)) {
                            $this->resultadoY = pow(($cadx * $this->valorX), 1 / $y);
                        } else {
                            if (!preg_match("/^x/", $y)) {
                                $this->resultadoY = pow(($cadx * $this->valorX), 1 / ObtenerFuncion($y, $this->valorX)->resultadoY);
                            } else {
                                if ($y == "x")
                                    $this->resultadoY = pow(($cadx * $this->valorX), 1 / $this->valorX);
                                else {
                                    if (preg_match("/^x+[+]/", $y) || preg_match("/^x+[-]/", $y)) {
                                        $this->resultadoY = pow(($cadx * $this->valorX), 1 / ObtenerFuncion($y, $this->valorX)->resultadoY);
                                    } else {
                                        $cad = "";
                                        for ($i = 0; $i < strlen($y); $i++) {
                                            if ($y[$i] != "x" && $y[$i] != "*")
                                                $cad .= $y[$i];
                                        }
                                        $this->resultadoY = pow($cad * $this->valorX, 1 / ($cadx * $this->valorX));
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    function Dominio()
    {
        $domaux1 = array();
        $domaux2 = array();
        if ($this->hijo != null) {
            $domaux1 = $this->hijo->dominio;
        }
        if ($this->divisor != null) {
            $domaux2 = $this->divisor->dominio;
        }
        $this->dominio = UnirDominio($this->dominiobase, $domaux1, $domaux2, $this->dominiodivisor);
    }
}

class Polinomicas extends Funcion
{
    var $elementos = array();

    function Polinomicas($elemt, $signos, $valorX = 0)
    {
        $this->valorX = $valorX;
        $cont = 0;
        $primera = true;
        $ele = 0;
        foreach ($elemt as $e) {
            if (is_numeric($e) || $e == "x") {
                $this->elementos[] = null;
            } else {
                $this->elementos[] = ObtenerFuncion($e);
                $this->texto .= ObtenerFuncion($e)->texto . "  ";
            }
            if (isset($signos[$cont])) {
                if ($primera == false) {
                    $this->HallarY($e, $signos[$cont]);
                    $cont++;
                } else {
                    $this->HallarY($e);
                    $primera = false;
                }
            } else {
                $this->HallarY($e);
                $cont++;
            }
            if (isset($signos[$ele]))
                $this->Derivada($e, $signos[$ele]);
            else
                $this->Derivada($e, "");
            $ele++;
        }
        $this->base = "x";
        $this->dominiobase[] = "x Є R";
        $this->Dominio();
    }


    function Derivada($x, $signo)
    {
        if (!preg_match("/^x/", $x) && !is_numeric($x)) {
            if ($this->derivada[strlen($this->derivada) - 1] == "-") {
                $this->derivada[strlen($this->derivada) - 1] = "+";
                $this->derivada .= "(-1)*(" . ObtenerFuncion($x, $this->valorX)->derivada . ")" . $signo;
            } else {
                $resul = ObtenerFuncion($x, $this->valorX)->derivada;
                if (is_numeric($resul) && $resul < 0) {
                    if ($this->derivada[strlen($this->derivada) - 1] == "+") {
                        $this->derivada[strlen($this->derivada) - 1] = "-";
                    } elseif ($this->derivada[strlen($this->derivada) - 1] == "-")
                        $this->derivada[strlen($this->derivada) - 1] = "+";
                    $this->derivada .= (-1) * ($resul) . $signo;
                } else
                    $this->derivada .= $resul . $signo;
            }
        } else {
            if (is_numeric($x)) {
                if ($this->derivada[strlen($this->derivada) - 1] == "-") {
                    $this->derivada[strlen($this->derivada) - 1] = "+";
                    $this->derivada .= "(-1)*(" . (0) . ")" . $signo;
                } else
                    $this->derivada .= (0) . $signo;
            } else {
                if ($x == "x") {
                    if ($this->derivada[strlen($this->derivada) - 1] == "-") {
                        $this->derivada[strlen($this->derivada) - 1] = "+";
                        $this->derivada .= "(-1)*(" . (1) . ")" . $signo;
                    } else
                        $this->derivada .= (1) . $signo;
                } else {
                    $cad = "";
                    for ($i = 0; $i < strlen($x); $i++) {
                        if ($x[$i] != "x" && $x[$i] != "*")
                            $cad .= $x[$i];
                    }
                    if ($this->derivada[strlen($this->derivada) - 1] == "-") {
                        $this->derivada[strlen($this->derivada) - 1] = "+";
                        $this->derivada .= "(-1)*(" . $cad . ")" . $signo;
                    } else
                        $this->derivada .= $cad . $signo;
                }
            }
        }
    }

    function Dominio()
    {
        $domaux = array();
        foreach ($this->elementos as $i) {
            if ($i != null) {
                foreach ($i->dominio as $d)
                    $domaux[] = $d;
            }
        }
        $this->dominio = UnirDominio($this->dominiobase, $domaux);
    }

    function HallarY($x, $signo = "+")
    {
        if (!preg_match("/^x/", $x) && !is_numeric($x)) {
            if ($signo == "+") {
                $this->resultadoY += ObtenerFuncion($x, $this->valorX)->resultadoY;
            } else {
                $this->resultadoY -= ObtenerFuncion($x, $this->valorX)->resultadoY;
            }


        } else {
            if (is_numeric($x)) {
                if ($signo == "+") {
                    $this->resultadoY += $x;
                } else {
                    $this->resultadoY -= $x;
                }

            } else {
                if ($x == "x") {
                    if ($signo == "+")
                        $this->resultadoY += $this->valorX;
                    else {
                        $this->resultadoY -= $this->valorX;
                    }
                } else {
                    $cad = "";
                    for ($i = 0; $i < strlen($x); $i++) {
                        if ($x[$i] != "x" && $x[$i] != "*")
                            $cad .= $x[$i];
                    }
                    if ($signo == "+")
                        $this->resultadoY += $cad * $this->valorX;
                    else {
                        $this->resultadoY -= $cad * $this->valorX;
                    }
                }
            }
        }
    }
}