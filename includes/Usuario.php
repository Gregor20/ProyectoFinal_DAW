<?php
class Usuario {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // Método para registrar un nuevo cliente
    public function registrar($nombre, $email, $password) {
        // 1. Comprobar si el email ya existe
        $sql_check = "SELECT id FROM usuarios WHERE email = '$email'";
        $resultado_check = mysqli_query($this->conexion, $sql_check);
        
        if (mysqli_num_rows($resultado_check) > 0) {
            return "email_duplicado"; 
        }

        // 2. Encriptar la contraseña (MUY IMPORTANTE PARA EL TFG)
        $password_encriptada = password_hash($password, PASSWORD_DEFAULT);
        
        // 3. Insertar el usuario (Por defecto id_rol = 2, que es 'cliente')
        $sql = "INSERT INTO usuarios (nombre, email, contraseña, id_rol) 
                VALUES ('$nombre', '$email', '$password_encriptada', 2)";
        
        if (mysqli_query($this->conexion, $sql)) {
            return "exito";
        } else {
            return "error";
        }
    }

    // Método para iniciar sesión
    public function login($email, $password) {
        $sql = "SELECT * FROM usuarios WHERE email = '$email'";
        $resultado = mysqli_query($this->conexion, $sql);

        if (mysqli_num_rows($resultado) == 1) {
            $usuario = mysqli_fetch_assoc($resultado);
            
            // Verificamos si la contraseña coincide con el hash de la BD
            if (password_verify($password, $usuario['contraseña'])) {
                return $usuario; // Devuelve los datos del usuario si es correcto
            }
        }
        return false; // Credenciales incorrectas
    }
}
?>