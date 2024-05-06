<?php
require_once __DIR__ . "/../vendor/autoload.php";

use Src\Crud\Usuario;
use Src\Utils\{Datos, Validate};

use const Src\Utils\MAY_IN;

session_start();

$provincias = Datos::getProvincias();
if (isset($_POST['btn'])) {
    $nombre = Validate::limpiarCadena($_POST['nombre'], MAY_IN);
    $apellidos = Validate::limpiarCadena($_POST['apellidos'], MAY_IN);
    $email = Validate::limpiarCadena($_POST['email']);
    $provincia = Validate::limpiarCadena($_POST['provincia']);

    $errores=false;
    if(!Validate::isProvinciaValida($provincia)){
            echo "Fallo prov<br>";
            $errores=true;
    }
    if(Validate::hayErrorEnCampo('nombre', $nombre, 3, 50)){
        echo "fallo nombre<br>";
        $errores=true;
    }
    if(Validate::hayErrorEnCampo('apellidos', $apellidos, 5, 50)){
        echo "fallo ape<br>";
        $errores=true;
    }
    if(!Validate::isEmailValido($email)){
        echo "error email<br>";
        $error=true;
    }
    
    if($errores){
         header("Location:{$_SERVER['PHP_SELF']}");
        die();
    }
    
    (new Usuario)->setNombre($nombre)
        ->setApellidos($apellidos)
        ->setEmail($email)
        ->setProvincia($provincia)
        ->create();
    $_SESSION['mensaje']="Se creo el usuario";
    header("Location:index.php");
}


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Cdn Tailwnd css -->
    <script src="https://cdn.tailwindcss.com"></script>

    <title>Inicio</title>
</head>

<body>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form name="" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="p-4 border-xl shadow-xl rounded-xl bg-gray-100">
                <div class="mb-5">
                    <label for="nombre" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your First Name</label>
                    <input type="text" name="nombre" id="nombre" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@flowbite.com"  />
                    <?php
                    Datos::mostrarError('err_nombre');
                    ?>
                </div>
                <div class="mb-5">
                    <label for="apellidos" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your Last Name</label>
                    <input type="text" name="apellidos" id="apellidos" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@flowbite.com"  />
                    <?php
                    Datos::mostrarError('err_apellidos');
                    ?>
                </div>
                <div class="mb-5">
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your Email</label>
                    <input type="email" id="email" name="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@flowbite.com"  />
                    <?php
                    Datos::mostrarError('err_email');
                    ?>
                </div>
                <div class="mb-5">
                    <label for="provincia" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your State</label>
                    <select name="provincia" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option>____ Elige una provincia ____</option>
                        <?php
                        foreach ($provincias as $item) {
                            echo "<option>$item</option>";
                        }
                        ?>
                    </select>
                    <?php
                    Datos::mostrarError('err_provincia');
                    ?>
                </div>
                <div class="flex flex-row-reverse">
                    <button name="btn" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        ENVIAR
                    </button>
                    <button name="btn" type="reset" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mr-1">
                        RESET
                    </button>
                    <a href="index.php" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mr-1">x CANCELAR</a>

                </div>
            </form>
        </div>
    </div>

</body>

</html>