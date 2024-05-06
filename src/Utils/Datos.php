<?php
namespace Src\Utils;

class Datos{
    public static function getProvincias(): array{
        return ['Almeria', 'Cadiz', 'Cordoba', 'Granada', 'Huelva', 'Jaen', 'Malaga', 'Sevilla'];
    }

    public static function mostrarError($nombre){
        if(isset($_SESSION[$nombre])){
            echo "<p class='text-sm italic text-red-500'>{$_SESSION[$nombre]}</p>";
            unset($_SESSION[$nombre]);
        }
    }
}