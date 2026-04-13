👗 Proyecto Final:

Tienda Online de Moda - DAW 2026Este proyecto consiste en el desarrollo de una aplicación web completa (E-commerce) para el Proyecto de Fin de Grado del ciclo de Grado Superior en Desarrollo de Aplicaciones Web.
Su finalidad es integrar y aplicar los conocimientos adquiridos durante el ciclo, basándose en el BOE núm. 299 de 2011.

👥 Equipo de Desarrollo

    Estudiante 1: [Grigoriy Kobyliakov] - Color asignado: [verde] 
    Estudiante 2: [Markiian Yakymiv] - Color asignado: [Su Color] 
    Tutor/a: [Montserrat]

🛠️ Stack Tecnológico

    Backend: PHP (Estructura modular/POO) 
    Base de Datos: MySQL/MariaDB (vía XAMPP)
    Frontend: HTML5, CSS3 y JavaScript
    Entorno: XAMPP, Visual Studio Code y Microsoft Teams para la gestión grupal

🚀 Funcionalidades Principales

    Siguiendo los requisitos generales del proyecto:

    -Usuarios: Registro, inicio de sesión y perfiles (Admin/Cliente).
    -Panel Admin: Gestión completa de productos y pedidos (CRUD) .

    -Catálogo: Visualización dinámica de productos por categorías.
    -Buscador: Sistema de búsqueda avanzada de productos.
    -Carrito: Gestión de productos antes de la compra.
    -Pasarela de Pago: Simulación de proceso de pago seguro.
    -Contacto: Formulario de atención al cliente.

📦 Instalación y Configuración

    -Descarga: Coloca la carpeta del proyecto en C:/xampp/htdocs/.
    -Base de Datos:Inicia Apache y MySQL en el Panel de Control de XAMPP.
    -Accede a http://localhost/phpmyadmin.Crea una base de datos llamada tienda_moda.
    -Importa el archivo database/estructura.sql incluido en este repositorio.
    -Configuración: Revisa el archivo config/db.php para asegurar que las credenciales coinciden con tu entorno local.
    -Acceso: Abre el navegador en http://localhost/nombre-de-tu-carpeta.

📅 Cronograma

    Inicio: 09/03/2026 
    Entrega y Exposición: 21/06/2026
    Notas de MetodologíaToda la coordinación, reuniones y toma de decisiones técnicas han sido registradas y grabadas a través de Microsoft Teams para la evaluación de la participación activa.

<-- ESTRUCTURA DE CARPETAS -->

Moda_shop/
├── admin/                # Panel de control (solo para el administrador)
│   ├── index.php         # Dashboard del admin                                     --en ello
│   ├── crear-producto.php
│   ├── editar-producto.php
│   └── eliminar-producto.php
├── assets/               # Recursos estáticos
│   ├── css/              # Archivos de estilos (estilo moderno y directo)
│   ├── js/               # Scripts de JavaScript (validaciones, carrito)
│   └── img/              # Imágenes de productos y logo
├── config/               # Configuración del sistema
│   └── db.php            # Conexión a la base de datos (PDO? /MySQL/mysqli)        --check
├── includes/             # Código reutilizable (Modularidad)
│   ├── header.php        # Menú de navegación común                                --check
│   ├── footer.php        # Pie de página común                                     --check
│   ├── funciones.php     # Lógica común (formatear precios, sesiones)
│   └── auth.php          # Control de acceso por roles 
├── vws/                  # Vistas o páginas principales
│   ├── catalogo.php      # Listado de productos
│   ├── producto.php      # Detalle de un producto
│   ├── login.php         # Acceso de usuarios
│   ├── registro.php      # Registro de nuevos clientes
│   ├── carrito.php       # Gestión del carrito
│   └── contacto.php      # Formulario de contacto
├── index.php             # Página de inicio (Punto de entrada)                     --en ello
├── .htaccess             # (Opcional) Para URLs amigables
└── README.md             # El archivo que creamos antes