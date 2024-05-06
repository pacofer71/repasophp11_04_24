<?php

namespace Src\Utils;

use Src\Crud\Usuario;
use Src\Utils\Datos;

const MAY_IN = 1;
const MAY_OFF = 0;
class Validate
{
    public static function limpiarCadena(string $valor, int $modo = MAY_OFF): string
    {
        return ($modo) ?  ucwords(htmlspecialchars(trim($valor))) : htmlspecialchars(trim($valor));
    }
    public static function hayErrorEnCampo(string $nombre, string $valor, int $longMin, int $longMax)
    {
        if (strlen($valor) < $longMin || strlen($valor) > $longMax) {
            $_SESSION["err_$nombre"] = "*** Error el valor de $nombre debe estar entre $longMin y $longMax";
            return true;
        }
        return false;
    }
    public static function isEmailValido(string $email): bool
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['err_email'] = "*** Error el email NO es válido";
            return false;
        }
        if (Usuario::isEmailUnico($email)) return true;
        $_SESSION['err_email'] = "*** Error el email ya existe en nuestros registros";
        return false;
    }

    public static function isProvinciaValida(string $prov): bool
    {
        if (!in_array($prov, Datos::getProvincias())) {
            $_SESSION['err_provincia'] = "*** Error la provincia no es válida o no elegiste ninguna.";
            return false;
        }
        return true;
    }
}
