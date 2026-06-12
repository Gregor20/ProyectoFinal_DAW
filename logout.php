<?php
// 1. Reanudamos la sesión
session_start();

// 2. Vaciamos las variables
session_unset();

// 3. Destruimos la sesión en el servidor
session_destroy();

// 4. Redirigimos al inicio de la tienda
header("Location: index.php");
exit();
?>