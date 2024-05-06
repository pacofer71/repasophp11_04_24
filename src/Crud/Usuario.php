<?php

namespace Src\Crud;

//use Src\Crud\Conexion;
use \Exception;
use Src\Datos;
use \PDO;

class Usuario extends Conexion
{
    private string $id;
    private string $nombre;
    private string $apellidos;
    private string $email;
    private string $provincia;

    //Metodo de crud
    public function create()
    {
        $q = "insert into usuarios(nombre, apellidos, email, provincia) values(:n, :a, :e, :p)";
        $stmt = parent::getConexion()->prepare($q);
        try {
            $stmt->execute([
                ':n' => $this->nombre,
                ':a' => $this->apellidos,
                ':e' => $this->email,
                ':p' => $this->provincia
            ]);
        } catch (Exception $ex) {
            throw new Exception("Error al crear: " . $ex->getMessage());
        } finally {
            parent::$conexion = null;
        }
    }

    public static function read(): array
    {
        $q = "select * from usuarios order by id desc";
        $stmt = parent::getConexion()->prepare($q);
        try {
            $stmt->execute();
        } catch (Exception $ex) {
            throw new Exception("Error en devolver usuarios: " . $ex->getMessage());
        } finally {
            parent::$conexion = null;
        }
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public function update()
    {
    }
    public function delete()
    {
    }
    //Otros métodos
    public static function generarUsuarios(int $cantidad)
    {
        if (self::hayUsuarios()) return;
        //Generaremos con faker los usuarios
        $faker = \Faker\Factory::create('es_ES');
        $provincias = Datos::getProvincias();

        for ($i = 0; $i < $cantidad; $i++) {
            $nombre = $faker->firstName();
            $apellidos = $faker->lastName() . " " . $faker->lastName();
            $email = $faker->unique()->email();
            $provincia = $faker->randomElement($provincias);


            (new Usuario)->setNombre($nombre)
                ->setApellidos($apellidos)
                ->setEmail($email)
                ->setProvincia($provincia)
                ->create();
        }
    }
    private static function hayUsuarios(): bool
    {
        $q = "select * from usuarios";
        $stmt = parent::getConexion()->prepare($q);
        try {
            $stmt->execute();
        } catch (Exception $ex) {
            throw new Exception("Error en hay usuarios: " . $ex->getMessage());
        } finally {
            parent::$conexion = null;
        }
        return $stmt->rowCount();
    }

    //--------------------Setters


    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Set the value of provincia
     *
     * @return  self
     */
    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * Set the value of apellidos
     *
     * @return  self
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }
}
