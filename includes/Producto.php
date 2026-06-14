<?php
class Producto {

    // Atributos de la clase Producto. Los mismos que en la base de datos.
    private $conexion;
    private $id;
    private $nombre;
    private $precio;
    private $descripcion;
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

    public function crear($nombre, $precio, $descripcion, $id_categoria, $imagen) {
        
        // 1. SANEAMIENTO DE DATOS (Protección contra Inyección SQL)
        $nombre = mysqli_real_escape_string($this->conexion, trim($nombre));
        $descripcion = mysqli_real_escape_string($this->conexion, trim($descripcion));
        $imagen = mysqli_real_escape_string($this->conexion, trim($imagen));
        
        // Forzamos que sean números (si alguien mete texto aquí, se convierte en 0)
        $precio = floatval($precio); 
        $id_categoria = intval($id_categoria);

        // Si el producto no existe, lo insertamos en la bd
        if(!$this->existe($nombre)) {

            $sql = "INSERT INTO productos (nombre, precio, descripcion, id_categoria, imagen_url) 
            VALUES ('$nombre', '$precio', '$descripcion', '$id_categoria', '$imagen')";
            
            $resultado = mysqli_query($this->conexion, $sql);

            if($resultado) {
                return true; // Producto creado exitosamente
            } else {
                return false; // Error al crear el producto
            }
        } else {
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

    public function actualizar($id, $nombre, $precio, $descripcion, $id_categoria, $imagen=NULL) {

        // 1. SANEAMIENTO DE DATOS (Protección contra Inyección SQL)
        $id = intval($id); // Muy importante proteger también el ID
        $nombre = mysqli_real_escape_string($this->conexion, trim($nombre));
        $descripcion = mysqli_real_escape_string($this->conexion, trim($descripcion));
        
        $precio = floatval($precio);
        $id_categoria = intval($id_categoria);

        $sql = "UPDATE productos SET nombre='$nombre', precio='$precio', descripcion='$descripcion', id_categoria='$id_categoria'";
        
        // Si se añade una imagen, se actualiza también el campo imagen_url
        if($imagen !== NULL) {
            $imagen = mysqli_real_escape_string($this->conexion, trim($imagen));
            // CORRECCIÓN DE BUG: Antes decía imagen='$imagen', lo correcto es imagen_url
            $sql .= ", imagen_url='$imagen'"; 
        }

        // Importante añadir el WHERE para actualizar solo el producto con id especificado
        $sql .= " WHERE id='$id'";
        
        $resultado = mysqli_query($this->conexion, $sql);

        if($resultado) {
            return true; // Producto actualizado exitosamente
        } else {
            return false; // Error al actualizar el producto
        }
    }

    public function listarTodos() {

        $sql = "SELECT p.*, c.nombre as categoria_nombre 
            FROM productos p 
            LEFT JOIN categorias c ON p.id_categoria = c.id";

        return mysqli_query($this->conexion, $sql);
    }

    public function obtenerPorId($id) {
        
        $sql = "SELECT * FROM productos WHERE id = '$id'";
        $resultado = mysqli_query($this->conexion, $sql);
    
        // Devuelve un array asociativo con los datos del producto (o false si no existe)
        return mysqli_fetch_assoc($resultado); 
    }

    // Método para buscar productos (Avanzado: busca en nombre y descripción)
    public function buscar($termino) {
        // Limpiamos el texto para evitar inyecciones SQL (Seguridad para tu TFG)
        $termino = mysqli_real_escape_string($this->conexion, $termino);
        
        // Buscamos si la palabra está contenida en el nombre o en la descripción
        $query = "SELECT p.*, c.nombre as categoria_nombre 
                  FROM productos p 
                  LEFT JOIN categorias c ON p.id_categoria = c.id 
                  WHERE p.nombre LIKE '%$termino%' OR p.descripcion LIKE '%$termino%'";
                  
        return mysqli_query($this->conexion, $query);
    }

}
?>