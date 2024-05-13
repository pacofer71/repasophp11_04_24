<?php

namespace Src\Crud;

//use Src\Crud\Conexion;
use Exception;
use PDO;
use Src\Utils\Datos;

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

    /**
     * @throws Exception
     */
    public function update(string $id): void
    {
        $q = "update usuarios set nombre=:n, apellidos=:a, email=:e, provincia=:p where id=:i";
        $stmt = parent::getConexion()->prepare($q);
        try {
            $stmt->execute([
                ':n' => $this->nombre,
                ':a' => $this->apellidos,
                ':e' => $this->email,
                ':p' => $this->provincia,
                ':i' => $id
            ]);
        } catch (Exception $ex) {
            throw new Exception("Error en update: " . $ex->getMessage());
        } finally {
            parent::$conexion = null;
        }

    }

    public function delete($id): void
    {
        $q = "delete from usuarios where id=:i";
        $q = "update usuarios set nombre=:n, apellidos=:a, email=:e, provincia=:p where id=:i";
        $stmt = parent::getConexion()->prepare($q);
        try {
            $stmt->execute([
                ':i' => $id
            ]);
        } catch (Exception $ex) {
            throw new Exception("Error en update: " . $ex->getMessage());
        } finally {
            parent::$conexion = null;
        }
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

    public static function isEmailUnico($email): bool
    {
        $q = "select id from usuarios where email=:e";
        $stmt = parent::getConexion()->prepare($q);
        try {
            $stmt->execute([':e' => $email]);
            if ($stmt->rowCount() != 0) return false;
        } catch (Exception $ex) {
            throw new Exception("Error en email unico: " . $ex->getMessage());
        } finally {
            parent::$conexion = null;
        }
        return true;
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
