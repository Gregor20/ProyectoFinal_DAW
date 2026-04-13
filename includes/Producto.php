<?php
class Producto {

    // Atributos de la clase Producto. Los mismos que en la base de datos.
    private $conexion;
    private $id;
    private $nombre;
    private $precio;
    private $id_categoria;
    private $imagen;

    // El constructor recibe la conexion a la base de datos
    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function existe($nombre) {

        // Sentencia SQL para verificar si el producto ya existe en la base de datos
        $sql = "SELECT id FROM productos WHERE nombre = '$nombre'";

        // Ejecutamos la consulta y almacenamos el resultado
        $resultado = mysqli_query($this->conexion, $sql);

        return mysqli_num_rows($resultado) > 0; // Devuelve true si el producto existe, false si no existe
    }

    public function crear($nombre, $precio, $id_categoria, $imagen) {

        // Si el producto no existe, lo insertamos en la bd
        if(!$this->existe($nombre)) {

            $sql = "INSERT INTO productos (nombre, precio, id_categoria, imagen) 
            VALUES ('$nombre', '$precio', '$id_categoria', '$imagen')";

            $resultado = mysqli_query($this->conexion, $sql);

            if($resultado) {
                return true; // Producto creado exitosamente
            }else{
                return false; // Error al crear el producto
            }
        }else{
            return false; // El producto ya existe, no se puede crear
        }
    }

    public function borrar($id) {

        $sql = "DELETE FROM productos WHERE id = '$id'";

        $resultado = mysqli_query($this->conexion, $sql);

        if($resultado) {
            return true; // Producto eliminado exitosamente
        }else{
            return false; // Error al eliminar el producto
        }
    }

    public function actualizar($id, $nombre, $precio, $id_categoria, $imagen=NULL) {

        $sql = "UPDATE productos SET nombre='$nombre', precio='$precio', id_categoria='$id_categoria'";

        // Si se añade una imagen, se actualiza tambien el campo imagen
        if($imagen !== NULL) {
            $sql .= ", imagen='$imagen'";
        }

        // Actualiza la variable $sql con .= para concatenar la parte del WHERE
        // Importante añadir el WHERE para actualizar solo el producto con id especificado
        $sql .= "WHERE id='$id'";

        $resultado = mysqli_query($this->conexion, $sql);

        if($resultado) {
            return true; // Producto actualizado exitosamente
        }else{
            return false; // Error al actualizar el producto
        }

    }

}
?>