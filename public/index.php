<?php
require __DIR__ . "/../vendor/autoload.php";

use Src\Usuario;

Usuario::generarUsuarios(100);
$usuarios = Usuario::read();

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Cdn Tailwnd css -->
    <script src="https://cdn.tailwindcss.com"></script>

    <title>Document</title>
</head>

<body>


    <div class="relative overflow-x-auto">
        <div class="p-12">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            ID
                        </th>
                        <th scope="col" class="px-6 py-3">
                            NOMBRE
                        </th>
                        <th scope="col" class="px-6 py-3">
                            APPELLIDOS
                        </th>
                        <th scope="col" class="px-6 py-3">
                            EMAIL
                        </th>
                        <th scope="col" class="px-6 py-3">
                            PROVINCIA
                        </th>
                        <th scope="col" class="px-6 py-3">
                            ACCIONES
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($usuarios as $item) {
                        echo <<<TXT
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {$item->id}
                        </th>
                        <td class="px-6 py-4">
                            {$item->nombre}
                        </td>
                        <td class="px-6 py-4">
                        {$item->apellidos}
                        </td>
                        <td class="px-6 py-4">
                        {$item->email}
                        </td>
                        <td class="px-6 py-4">
                        {$item->provincia}
                        </td>
                        <td class="px-6 py-4">
                            Botones
                        </td>
                    </tr>
                    TXT;
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>

</body>

</html>